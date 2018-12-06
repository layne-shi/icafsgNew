<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Enroll_model extends CI_Model
{

    // 报名人员类型
    public $user_type = array(
        1 => '选手',
        2 => '老师',
        3 => '陪同',
    );

	public function __construct()
    {
  		parent::__construct();
	}

    // 保存 参赛专业、参赛形式、参赛组别
    public function saveItems($id,$data)
    {
        //参赛专业
        if ($data['special_type'] == '0' && !empty($data['major']))
        {
            $majorArr = $data['major'];
            $specialData = array();

            foreach ($majorArr as $major)
            {
                $specialData[] = array(
                    'direct_id' => $id,
                    'title' => $major,
                );
            }

            $this->delItems($id,'enroll_direct_major');

            if (!empty($specialData))
            {
                $this->Data_model->batchAddData($specialData,'enroll_direct_major');
            }
        }

        //参赛形式
        if (!empty($data['form']))
        {
            $formArr = $data['form'];
            $formData = array();

            foreach ($formArr as $key => $form)
            {
                $tmp = array(
                    'direct_id' => $id,
                    'title' => $form,
                    'need_input' => 0,
                );

                foreach ($data['need_input'] as $val)
                {
                    if (($val - 1) == $key)
                    {
                        $tmp['need_input'] = 1;
                    }
                }

                $formData[] = $tmp;
            }

            $this->delItems($id,'enroll_direct_form');

            if (!empty($formData))
            {
                $this->Data_model->batchAddData($formData,'enroll_direct_form');
            }
        }

        // 参赛组别
        if (!empty($data['group']))
        {
            $groupData = array();

            foreach ($data['group'] as $group)
            {
                $groupData[] = array(
                    'direct_id' => $id,
                    'group_id' => $group,
                );
            }

            $this->delItems($id,'enroll_direct_group');

            if (!empty($groupData))
            {
                $this->Data_model->batchAddData($groupData,'enroll_direct_group');
            }

        }

        return;
    }

    public function delItems($ids,$table)
    {
        if (empty($ids) || empty($table))
        {
            return false;
        }

		if(is_array($ids)){
			$this->db->where_in('direct_id',$ids);
		}else{
			$this->db->where('direct_id',$ids);
		}
        $this->db->delete($table);
    }

    // 获取单条参赛方向数据
	public function getSingle($getwhere="",$table='')
    {
        $row = $this->Data_model->getSingle($getwhere,$table);

        $where = array(
            'direct_id' => $row['id'],
            'isdisabled' => 0,
        );

        // 参赛专业
        $majorData = $this->Data_model->getData($where,null,null,null,'enroll_direct_major');

        // 参赛形式
        $formData = $this->Data_model->getData($where,'id ASC',null,null,'enroll_direct_form');

        // 参赛组别
        $groupData = $this->Data_model->getData($where,'id ASC',null,null,'enroll_direct_group');
        $groups = array();
        foreach ($groupData as $item)
        {
            $groups[] = $item['group_id'];
        }

        $row['majorData'] = $majorData;
        $row['formData'] = $formData;
        $row['groups'] = $groups;

        return $row;
	}

    // 获取单条报名表数据
    public function getSingleEnroll($getwhere="",$table='enroll')
    {
        $row = $this->Data_model->getSingle($getwhere,$table);

        $where = array(
            'enroll_id' => $row['id'],
        );

        $arr = $this->Data_model->getData($where,'id ASC',null,null,'enroll_direct_bind');

        $ids = array();
        foreach ($arr as $item)
        {
            $ids[] = $item['direct_id'];
        }
        $ids = array_unique($ids);

        if (!empty($ids))
        {
            $directData = $this->Data_model->getData(array('id' => $ids),null,null,null,'enroll_direct');

            $row['directData'] = $directData;
        }

        return $row;
    }

    // 保存报名表
    public function saveEnroll($id,$data)
    {
        if (!empty($data['direct']))
        {
            $directData = array();
            foreach ($data['direct'] as $direct)
            {
                $directData[] = array(
                    'direct_id' => $direct,
                    'enroll_id' => $id,
                );
            }

            $this->delBind($id);

            if (!empty($directData))
            {
                $this->Data_model->batchAddData($directData,'enroll_direct_bind');
            }
        }

        return;
    }

    public function delBind($ids,$table='enroll_direct_bind')
    {
        if (empty($ids) || empty($table))
        {
            return false;
        }

		if(is_array($ids)){
			$this->db->where_in('enroll_id',$ids);
		}else{
			$this->db->where('enroll_id',$ids);
		}
        $this->db->delete($table);
    }

    /**
     * 根据 group_id 获取三级分类
     */
    public function get_groups_cates($ids,$table='enroll_group')
    {
        if (empty($ids))
        {
            return false;
        }

        $level1 = $this->Data_model->getData(array('id'=>$ids),'listorder ASC','','',$table);

        foreach ($level1 as &$item)
        {
            $item['level2'] = $this->_getChildGroup($item['id'],'listorder ASC');

            foreach ($item['level2'] as &$val)
            {
                $val['level3'] = $this->_getChildGroup($val['id'],'listorder ASC');
            }
        }

        return $level1;
    }

    /**
     * 根据父id获取子分类
     */
    public function _getChildGroup($pid,$order='',$table='enroll_group')
    {
        $data = $this->Data_model->getData(array('parent'=>$pid),$order,'','',$table);

        return $data;
    }

    /**
     * 前台用户参赛报名
     */
    public function signup($post)
    {
        $data = $post['enroll'];
        $data['birthday'] = strtotime($data['birthday']);
        $data['issue_date'] = $data['issue_date'] ? intval($data['issue_date']) : 0;
        $data['expiry_date'] = $data['expiry_date'] ? intval($data['expiry_date']) : 0;
        $data['create_time'] = time();

        $id = $this->Data_model->addData($data,'match_signup');
        if ($id && $id > 0)
        {
            if ($data['type'] != '1')
            {
                return true;
            }

            $saveData = array();
            $directarr = $post['direct'];

            // 参赛组别
            $groupArr = $this->Data_model->getData(array('isdisabled' => 0),'','','','enroll_group');

            foreach ($directarr as $k1 => $direct)
            {
                foreach ($direct as $direct_id => $item)
                {
                    $group_id = $item['group_id']?$item['group_id']:0;

                    if ($group_id)
                    {
                        $tmp = $this->_groupname($groupArr,$group_id);
                        $group_name = $tmp;
                        $tmp = explode('|',$tmp);
                        $tmp = array_reverse($tmp);

                        // 如果是3级分类
                        if (count($tmp) == 3)
                        {
                            $tmp2 = explode(' ',$tmp[1]);
                            $tmp2 = $tmp2[0];
                            $group_name = $tmp[0].'('.$tmp2.')'.'('.$tmp[2].')';
                        }
                        else // 否则按2级分类处理 2018/10/25
                        {
                            $group_name = implode(' | ',$tmp);
                        }
                    }
                    else
                    {
                        $group_name = '';
                    }

                    $saveData[] = array(
                        'match_id' => $id,
                        'direct_id' => $direct_id,
                        'major' => $item['major'],
                        'form'  => $item['form']['form_title'],
                        'group' => $group_name,
                        'form_id' => $item['form']['form_id'],
                        'form_number' => isset($item['form']['form_number'])?$item['form']['form_number']:'',
                        'group_id ' => $group_id,
                        'song' => isset($item['song'])?$item['song']:'',
                        'composer' => isset($item['composer'])?$item['composer']:'',
                        'author' => isset($item['author'])?$item['author']:'',
                        'guide' => isset($item['guide'])?$item['guide']:'',
                        'referee' => isset($item['referee'])?$item['referee']:'',
                    );
                }
            }

            if (!empty($saveData))
            {
                return $this->Data_model->batchAddData($saveData,'match_direct');
            }
        }

        return false;
    }

    /**
     * 获取用户参与的报名表数量
     */
    public function getEnrollNum($getwhere = array())
    {
        $enroll_id = $getwhere['id'];
        $_table1 = $this->db->dbprefix('match_signup');
        $_table2 = $this->db->dbprefix('match_direct');

        $sql = "SELECT count(d.id) AS count
        FROM {$_table1} AS s
        LEFT JOIN {$_table2} AS d
        ON d.match_id=s.id
        WHERE s.enroll_id={$enroll_id} AND s.isdisabled=0 ";

        if (isset($getwhere['start_time']))
        {
            $start_time = strtotime(sprintf('%s 00:00:00', $getwhere['start_time']));
            $sql .= " AND s.create_time >= {$start_time}";
        }

        if (isset($getwhere['end_time']))
        {
            $end_time = strtotime(sprintf('%s 23:59:59', $getwhere['end_time']));
            $sql .= " AND s.create_time <= {$end_time}";
        }

        if (isset($getwhere['type']))
        {
            $sql .= " AND s.type = {$getwhere['type']} ";
        }

        $row = $this->db->query($sql)->row_array();
        return $row['count'];
    }

    /**
     * 获取报名表的报名情况
     */
    public function getEnrollList($getwhere = array(),$pagenum = "0",$exnum = "0")
    {
        $enroll_id = $getwhere['id'];

        $_table1 = $this->db->dbprefix('match_signup');
        $_table2 = $this->db->dbprefix('match_direct');
        $_table3 = $this->db->dbprefix('enroll_direct');

        $sql = "SELECT s.id AS sign_id, s.name AS name,
        s.py_name AS py_name, s.gender AS gender,
        s.birthday AS birthday, s.age AS age,
        s.passport AS passport, s.type AS type,
        s.identity AS identity, s.nationality AS nationality,
        s.national AS national, s.mobile AS mobile ,s.tel AS tel,
        s.email AS email, s.other_contact AS other_contact,
        s.address AS address,s.guardian_name AS guardian_name,
        s.guardian_mobile AS guardian_mobile,
        s.entourage AS entourage,
        s.creation_pize AS creation_pize,
        s.guidance_teacher_pize AS guidance_teacher_pize,
        s.guidance_art_pize AS guidance_art_pize,
        s.create_time AS create_time, d.song AS song,
        s.school_radios AS school_radios,
        s.school_company AS school_company,
        s.grade_duty AS grade_duty,
        s.university_grade AS university_grade,
        d.composer AS composer,d.author AS author,
        d.id AS list_id, d.referee AS referee, d.guide AS guide,
        d.major AS major, d.form_id AS form_id,
        d.form AS form,d.group AS group_name,
        d.form_number AS form_number, d.group_id AS group_id,
        dir.title AS dir_name,dir.special_type AS special_type
        ";

        $sql .= " FROM {$_table1} AS s
        LEFT JOIN {$_table2} AS d
        ON d.match_id=s.id
        LEFT JOIN {$_table3} AS dir
        ON d.direct_id=dir.id
        WHERE s.enroll_id={$enroll_id} AND s.isdisabled=0 ";

        if (isset($getwhere['start_time']))
        {
            $start_time = strtotime(sprintf('%s 00:00:00', $getwhere['start_time']));
            $sql .= " AND s.create_time >= {$start_time}";
        }

        if (isset($getwhere['end_time']))
        {
            $end_time = strtotime(sprintf('%s 23:59:59', $getwhere['end_time']));
            $sql .= " AND s.create_time <= {$end_time}";
        }

        if (isset($getwhere['type']))
        {
            $sql .= " AND s.type = {$getwhere['type']} ";
        }

        $sql .= " ORDER BY s.create_time ASC ";

		if ($pagenum > 0)
        {
            $sql .= " LIMIT {$exnum}, {$pagenum}";
		}

        $data = $this->db->query($sql)->result_array();

        $where = array('isdisabled' => 0);

        // 参赛专业
        $majorArr = $this->Data_model->getData($where,'','','','enroll_direct_major');

        // 参赛形式
        $formArr = $this->Data_model->getData($where,'','','','enroll_direct_form');

        // 参赛组别
        $groupArr = $this->Data_model->getData($where,'','','','enroll_group');

        foreach ($data as $key => $item)
        {
            // 参赛人数
            if (!empty($item['form_number']))
            {
                $data[$key]['form'] .= "(".$item['form_number']."人)";
            }

            $data[$key]['group'] = $data[$key]['group_name'];

            /*
            if ($item['special_type'] == 0)
            {
                foreach ($majorArr as $major)
                {
                    if ($major['id'] == $item['major'])
                    {
                        $data[$key]['major'] = $major['title'];
                        break;
                    }
                }
            }

            foreach ($formArr as $form)
            {
                if ($form['id'] == $item['form_id'])
                {
                    $data[$key]['form'] = $form['title'];
                    if (!empty($item['form_number']))
                    {
                        $data[$key]['form'] .= "(".$item['form_number']."人)";
                    }
                    break;
                }
            }*/
/*
            // 参赛组别
            if (!empty($item['group_id']))
            {
                $tmp = $this->_groupname($groupArr,$item['group_id']);
                $tmp = explode('|',$tmp);
                $tmp = array_reverse($tmp);
                $tmp2 = explode(' ',$tmp[1]);
                $tmp2 = $tmp2[0];
                $data[$key]['group'] = $tmp[0].'('.$tmp2.')'.'('.$tmp[2].')';
            }
            else
            {
                $data[$key]['group'] = '';
            }*/


            $data[$key]['gender'] = ($item['gender']==0?'女':'男');
            $data[$key]['birthday'] = date('Y-m-d',$item['birthday']);
            $data[$key]['type'] = $this->user_type[$item['type']];

            $data[$key]['create_time'] = date('Y-m-d',$item['create_time']);

        }

        return $data;
    }

    /**
     * 递归获取分组名称
     */
    protected function _groupname($groupArr,$g_id)
    {
        $group_name = '';
        foreach ($groupArr as $group)
        {
            if ($group['id'] == $g_id)
            {
                $group_name .= $group['name'];
                if ($group['parent'] > 0)
                {
                    $group_name .= '|' . $this->_groupname($groupArr,$group['parent']);
                }
                break;
            }
        }

        return $group_name;
    }

}