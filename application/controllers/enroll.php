<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 在线报名前台控制器
 */

class Enroll extends CI_Controller
{
    protected $tablename = 'enroll';

    public function __construct()
    {
		parent::__construct();
		$this->Cache_model->setLang($this->input->get());
		$this->Lang_model->loadLang('front',$this->Cache_model->currentLang);
		$this->load->helper('tags');

		$this->Data_model->setTable($this->tablename);
        $this->hostarr = $this->Data_model->getData(null,null,null,null,'enroll_host');
        $this->load->model('Enroll_model');
	}

    /**
     * 加载前台视图
     *
     * @parames     string      $tpl    前台视图
     * @parames     array       $arr    视图数据
     * @return      void
     */
    protected function init_view($tpl = '',$arr = array())
    {
        // 加载前台视图
        $this->load->setPath();

        $config = $this->Cache_model->loadConfig();
		$res = array(
            'config'    =>  $config,
            'langurl'   =>  $this->Cache_model->langurl,
		);
        $res = array_merge($res,$arr);

        $this->load->view($config['site_template'].'/'.$tpl,$res);
    }

	public function index()
    {
        $time = time();
        $getwhere = array(
            'status'        =>  1,
            'begin_time <=' =>  $time,
            'end_time >='   =>  $time,
            'status'        =>  1,
        );

		$data = $this->Data_model->getData($getwhere,'begin_time,listorder,id desc',null,null);

        $hostarr = array();
        foreach ($this->hostarr as $val)
        {
            $hostarr[$val['id']] = $val['title'];
        }

        foreach ($data as $key => &$item)
        {
            $funcstr = '<a href="'.site_url('enroll/entryInformation/'.$item['id']).'" class="btn btn-primary">报名</a>';

            $item['host'] = array_key_exists($item['host_id'],$hostarr) ? $hostarr[$item['host_id']] :'';
            $item['btn'] = $funcstr;
        }

		$res = array(
            'list'      =>  $data,
		);

        // 报名列表
        $this->init_view('enrollList',$res);
	}

    /**
     *  参赛须知
     */
    public function entryInformation()
    {
        $id = $this->uri->segment(3);
        if (!$id || !is_numeric($id))
        {
            show_404();
        }

        # 预留处理“参赛须知”

        $res = array(
            'id'    =>  $id,
            'url'   =>  site_url('enroll/registrationForm/' . $id),
        );

        $this->init_view('entryInformation',$res);
    }

    /**
     *  參賽報名表
     */
    public function registrationForm()
    {
        $id = $this->uri->segment(3);
        if (!$id || !is_numeric($id))
        {
            show_404();
        }

        $view = $this->Enroll_model->getSingleEnroll(array('id'=>$id),'enroll');

        $view['host'] = '';
        foreach ($this->hostarr as $host)
        {
            if ($host['id'] == $view['host_id'])
            {
                $view['host'] = $host['title'];
                break;
            }
        }

        foreach ($view['directData'] as &$dir)
        {
            $dir['items'] = $this->Enroll_model->getSingle(array('id'=>$dir['id']),'enroll_direct');

            if (!empty($dir['items']['groups']))
            {
                $dir['items']['groupData'] = $this->Enroll_model->get_groups_cates($dir['items']['groups']);
            }
            else
            {
                $dir['items']['groupData'] = array();
            }
        }

        $res = array(
            'id'        =>  $id,
            'view'      =>  $view,
            'hostarr'   =>  $this->hostarr,
            'action'    =>  site_url('enroll/signup/'),
        );

        $this->init_view('registrationForm',$res);
    }

    /**
     * 报名登记
     */
    public function signup()
    {
        $post = $this->input->post(NULL,TRUE);

        if ($post['action']==site_url('enroll/signup'))
        {
            if (false === $this->check_data($post,$errorMsg))
            {
                show_error('<a href="javascript:history.back()">返回上一级</a>',500,$errorMsg);
                exit;
            }

            if ($this->Enroll_model->signup($post))
            {
                $url = site_url('enroll/complete');
                header("Location:$url");
            }
            else
            {
                show_error('报名失败');
            }
        }
        else
        {
        }
    }

    // 报名完成
    public function complete()
    {
        $this->init_view('complete');
    }

    /**
     * 检查报名表时间有效性
     *
     * @parames     int      $id    报名表id
     * @return      boolean
     */
    protected function check_time_validity($id,&$msg)
    {
        $row = $this->Data_model->getSingle(array('id'=>$id),'enroll');
        $time = time();

        if ($row['begin_time'] > $time)
        {
            $msg = '活动尚未开始';
            return false;
        }

        if ($row['end_time'] < $time)
        {
            $msg = '报名活动已结束';
            return false;
        }

        return true;
    }

    /**
     *  数据安全检测
     */
    protected function check_data($post,&$msg)
    {
        $data = $post['enroll'];

        if (!$data['name'] || !$data['py_name'] || !$data['birthday'] || !$data['nationality'] || !$data['age'] || !$data['national'] || !$data['mobile'] || !$data['identity'] || !$data['address'] || !$data['email'] || !$data['portrait'])
        {
            $msg = '红星为必填项';
            return false;
        }

      /*  if (!$data['certificate1'] && !$data['certificate2'] && !$data['certificate3'] && !$data['certificate4'])
        {
            $msg = '必须上传电子版证件';
            return false;
        }*/

        if (false == $this->check_time_validity($data['enroll_id'],$err))
        {
            $msg = $err;
            return false;
        }

        // 如果是选手，判断是否选择了参赛方向
        if ($data['type'] == '1')
        {
            if (!isset($post['direct']) || empty($post['direct']))
            {
                $msg = '请选择参赛方向';
                return false;
            }
        }


        return true;
    }

}