<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Enroll extends CI_Controller
{
	protected $tablefunc = 'enroll';

	protected $fields = array('title','host_id','begin_time','end_time','listorder','status');

	protected $funcarr = array('add','order','del');

	protected $typearr,$editlang;

	public function __construct()
    {
		parent::__construct();
		$this->Lang_model->loadLang('admin');
		$this->load->helper('array');
		$this->load->model('Purview_model');
		$this->Data_model->setTable($this->tablefunc);
		$this->editlang=$this->Lang_model->getEditLang();
        $this->hostarr = $this->Data_model->getData(null,null,null,null,'enroll_host');

        $this->load->model('Enroll_model');
    }

	public function index()
    {
		$this->Purview_model->checkPurview($this->tablefunc);
		$post = $this->input->post(NULL,TRUE);

		$getwhere = $search = array();

        if (isset($post['begin_time']) && !empty($post['begin_time']))
        {
            $search['begin_time'] = trim($post['begin_time']);
            $getwhere['begin_time >='] = strtotime($search['begin_time']);
        }

        if (isset($post['end_time']) && !empty($post['end_time']))
        {
            $search['end_time'] = trim($post['end_time']);
            $getwhere['end_time <='] = strtotime($search['end_time']);
        }

        if (isset($post['host_id']) && !empty($post['host_id']))
        {
            $search['host_id'] = trim($post['host_id']);
            $getwhere['host_id'] = $search['host_id'];
        }

		$pagearr=array(
			'currentpage'=>	isset($post['currentpage'])&&$post['currentpage']>0?$post['currentpage']:1,
			'totalnum'=>$this->Data_model->getDataNum($getwhere),
			'pagenum'=>20
		);
		$data = $this->Data_model->getData($getwhere,'begin_time,listorder,id desc',$pagearr['pagenum'],($pagearr['currentpage']-1)*$pagearr['pagenum']);
		$res = array(
				'tpl'=>'list',
				'tablefunc'=>$this->tablefunc,
				'search'=>$search,
				'hostarr'=>$this->hostarr,
				'liststr'=>$this->_setlist($data,true),
				'pagestr'=>show_page($pagearr,$search),
				'funcstr'=>$this->Purview_model->getFunc($this->tablefunc,$this->funcarr),
		);
		$this->load->view($this->tablefunc,$res);
	}

	public function add(){
		$this->Purview_model->checkPurviewAjax($this->tablefunc,'add');
		$post = $this->input->post(NULL,TRUE);
		if($post['action']==site_aurl($this->tablefunc)){
			$data = elements($this->fields,$post['enroll']);
			$time = time();
			$data['create_time'] = $time;
            $data['begin_time'] = strtotime($data['begin_time']);
            $data['end_time'] = strtotime($data['end_time']);
			$id=$this->Data_model->addData($data);

            if ($id)
            {
                $this->Enroll_model->saveEnroll($id,$post['enroll']);
            }

			show_jsonmsg(array('status'=>200,'remsg'=>$this->_setlist($this->Data_model->getSingle(array('id'=>$id)),false)));
		}else{
			$res = array(
					'tpl'=>'view',
					'tablefunc'=>$this->tablefunc,
                    'hostarr'=>$this->hostarr,
                    'directarr' => $this->get_directarr(),
			);
			show_jsonmsg(array('status'=>200,'remsg'=>$this->load->view($this->tablefunc,$res,true)));
		}
	}

    // 获取参赛方向数组
    public function get_directarr()
    {
        $where = array(
            'isdisabled' => 0,
        );

        $rows = $this->Data_model->getData($where,null,null,null,'enroll_direct');

        return $rows;
    }

	public function edit(){
		$this->Purview_model->checkPurviewAjax($this->tablefunc,'edit');
		$post = $this->input->post(NULL,TRUE);
		if($post['id']&&$post['action']==site_aurl($this->tablefunc)){
			$data = elements($this->fields,$post['enroll']);
            $data['begin_time'] = strtotime($data['begin_time']);
            $data['end_time'] = strtotime($data['end_time']);

			$this->Data_model->editData(array('id'=>$post['id']),$data);

            $this->Enroll_model->saveEnroll($post['id'],$post['enroll']);

			show_jsonmsg(array('status'=>200,'id'=>$post['id'],'remsg'=>$this->_setlist($this->Data_model->getSingle(array('id'=>$post['id'])),false)));
		}else{
			$id = $this->uri->segment(4);
			if($id>0&&$view = $this->Enroll_model->getSingleEnroll(array('id'=>$id))){
				$res = array(
						'tpl'=>'view',
						'tablefunc'=>$this->tablefunc,
						'view'=>$view,
                        'hostarr'=>$this->hostarr,
                        'directarr' => $this->get_directarr(),
				);

				show_jsonmsg(array('status'=>200,'remsg'=>$this->load->view($this->tablefunc,$res,true)));
			}else{
				show_jsonmsg(array('status'=>203));
			}
		}
	}

	public function order(){
		$this->Purview_model->checkPurviewAjax($this->tablefunc,'order');
		$data = $this->Data_model->listorder($this->input->post('ids',true),$this->input->post('listorder',true),'listorder');
		$this->Cache_model->deleteSome($this->tablefunc.'_'.$this->editlang);
		show_jsonmsg(array('status'=>200,'remsg'=>$this->_setlist($data,true)));
	}

	public function del(){
		$this->Purview_model->checkPurviewAjax($this->tablefunc,'del');
		$ids = $this->input->post('optid',true);
		if($ids){
			$this->Data_model->delData($ids);
			$this->Cache_model->deleteSome($this->tablefunc.'_'.$this->editlang);
			show_jsonmsg(array('status'=>200,'remsg'=>lang('delok'),'ids'=>$ids));
		}else{
			show_jsonmsg(array('status'=>203));
		}
	}

    // 报名详情
    public function details()
    {
        // enroll ID
        $id = $this->uri->segment(4);
        if (!$id)
        {
            echo '非法操作';
            exit;
        }

        $getwhere = $search = array();
        $getwhere['id'] = $id;

		$post = $this->input->post(NULL,TRUE);
        if (isset($post['action']) && $post['action'] == 'search')
        {
            if (isset($post['start_time']) && !empty($post['start_time']))
            {
                $search['start_time'] = trim($post['start_time']);
                $getwhere['start_time'] = $search['start_time'];
            }

            if (isset($post['end_time']) && !empty($post['end_time']))
            {
                $search['end_time'] = trim($post['end_time']);
                $getwhere['end_time'] = $search['end_time'];
            }

            if (isset($post['type']) && !empty($post['type']))
            {
                $search['type'] = $post['type'];
                $getwhere['type'] = $post['type'];
            }
        }

		$pagearr = array(
			'currentpage'=>	isset($post['currentpage'])&&$post['currentpage']>0?$post['currentpage']:1,
			//'totalnum'=>$this->Enroll_model->getEnrollNum($getwhere),
			//'pagenum'=>20
		);

        //$data = $this->Enroll_model->getEnrollList($getwhere,$pagearr['pagenum'],($pagearr['currentpage']-1)*$pagearr['pagenum']);
        $data = $this->Enroll_model->getEnrollList($getwhere);

        $view = $this->Enroll_model->getSingleEnroll(array('id' => $id),'enroll');

        $res = array(
            'tpl'       =>  'list',
            'data'      =>  $data,
            'tablefunc' =>  $this->tablefunc,
            'view'      =>  $view,
            'search'    =>  $search,
            'typearr'   =>  $this->Enroll_model->user_type,
          //  'pagestr'   =>  show_page($pagearr,$search),
        );

        $this->load->view('enroll_details',$res);
    }

    // 查看报名用户的头像和证件
    public function profile()
    {
        // match_signup ID
        $id = $this->uri->segment(4);
        if (!$id)
        {
            echo '非法操作';
            exit;
        }

        $view = $this->Data_model->getSingle(array('id' => $id),'match_signup');

        $res = array(
            'tpl'       =>  'profile',
            'tablefunc' =>  $this->tablefunc,
            'view'      =>  $view,
        );
        show_jsonmsg(array('status'=>200,'remsg'=>$this->load->view('enroll_details',$res,true)));
    }

    // 下载报名数据
	public function export()
    {
        // enroll ID
        $id = $this->uri->segment(4);
        if (!$id)
        {
            show_error('非法操作!禁止访问!');
            exit;
        }

        $enroll = $this->Enroll_model->getSingleEnroll(array('id' => $id),'enroll');

        $getwhere = array();
        $getwhere['id'] = $id;

        $begin = $this->uri->segment(5);
        $end = $this->uri->segment(6);
        $user_type = $this->uri->segment(7);

        if ($begin && $begin > 0)
        {
            $getwhere['start_time'] = $begin;
        }

        if ($end && $end > 0)
        {
            $getwhere['end_time'] = $end;
        }

        if ($user_type  && $user_type > 0)
        {
            $getwhere['type'] = $user_type;
        }

        // 要导出的数据
        $data = $this->Enroll_model->getEnrollList($getwhere);

        // 要导出的文件名
        $filename = $enroll['title'];

        $this->load->library('Export');

        // $data 中数组的 key
        $indexKey = array('referee','name','py_name','gender',
            'birthday','age','passport','type','identity','dir_name',
            'major','form','group','song','composer','author','guide','nationality',
            'national','mobile','tel','email','other_contact','address','guardian_name','guardian_mobile',
        );

        // 表格头部字段
        $header = array(
            '推荐教师','姓名','拼音','性别','生日','年龄','护照','性质','身份證','参赛方向','参赛专业','参赛形式','参赛组别','比赛曲目','曲作者','词作者','指导教师','国籍','民族','手机号','家庭电话','邮箱','其他联系方式','邮寄地址','家长姓名','家长联系方式',
        );

//echo '<pre>';print_r($data);die;

        // 导出数据处理
        foreach ($data as $k => $v)
        {
            $tmp = explode(' | ',$v['group']);
            $tmp = array_reverse($tmp);
            $new_group = $tmp[0];

            $data[$k]['group'] = $new_group;
        }

        // 导出csv
       $this->export->createtable($data,$filename,$header,$indexKey,'csv');

        // 模板文件名(完整路径)
       // $template = FCPATH . 'data/attachment/file/excel/tpl1.xls';
        // 导出excel
       // $this->export->exportExcel2($data,$filename.'.xls',$template,$indexKey);

        exit;
	}

	function _setlist($data,$ismultiple=true){
		$newdata = $ismultiple?$data:($newdata[0]=$data);
		if($ismultiple){
			$newdata = $data;
		}else{
			$newdata = array(0=>$data);
		}

        $hostArr = array();
        foreach ($this->hostarr as $val)
        {
            $hostArr[$val['id']] = $val['title'];
        }

		$newstr = '';
		foreach($newdata as $key=>$item){
			$item['func'] = '';

			if($this->Purview_model->checkPurviewFunc($this->tablefunc,'edit')){
                $item['func'] .= '<input type="button" class="btn" onclick="submitTo(\''.site_aurl($this->tablefunc.'/edit/'.$item['id']).'\',\'edit\')" value="'.lang('btn_edit').'">';
			}

			if($this->Purview_model->checkPurviewFunc($this->tablefunc,'del')){
                $item['func'] .= '<input type="button" class="btn" onclick="submitTo(\''.site_aurl($this->tablefunc.'/del/'.$item['id']).'\',\'sdel\',\''.$item['id'].'\')" value="'.lang('btn_del').'">';
			}

            // 查看报名详情
            $item['func'] .= '<input type="button" onclick="window.location.href=\''.site_aurl($this->tablefunc.'/details/'.$item['id']).'\'" class="btn" value="报名详情"/>';

			$newstr.='<tr id="tid_'.$item['id'].'">
			<td width=30><input type=checkbox name="optid[]" value='.$item['id'].'></td>
			<td width=40>'.$item['id'].'</td>
            <td width=50><input type="hidden" name="ids[]" value="'.$item['id'].'"><input type="text" name="listorder[]" class="input-order" size="3" value="'.$item['listorder'].'"></td>
			<td align="left">'.$item['title'].'</td>
			<td width=100>'.(isset($hostArr[$item['host_id']])?$hostArr[$item['host_id']]:'').'</td>
            <td width=100>'.date('Y-m-d',$item['begin_time']).'</td>
            <td width=100>'.date('Y-m-d',$item['end_time']).'</td>
			<td width=50 >'.lang('status'.$item['status']).'</td>
			<td width=200 align="center">'.$item['func'].'</td></tr>';
		}
		return $newstr;
	}
}