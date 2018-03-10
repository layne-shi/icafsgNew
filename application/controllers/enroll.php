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
            $data = $post['enroll'];

            if (false === $this->check_data($data,$errorMsg))
            {
                show_error($errorMsg);
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

    public function complete()
    {
        $this->init_view('complete');
    }

    /**
     *  数据安全检测
     */
    protected function check_data($data,&$msg)
    {
        if (!$data['name'] || !$data['py_name'] || !$data['birthday'] || !$data['nationality'] || !$data['age'] || !$data['national'] || !$data['mobile'] || !$data['identity'] || !$data['address'] || !$data['email'])
        {
            $msg = '红星为必填项';
            return false;
        }

        return true;
    }

}