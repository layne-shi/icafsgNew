<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Enrollgroup extends CI_Controller
{
	protected $tablefunc = 'enroll_group';
    protected $classname = 'enrollgroup';

	protected $fields = array('name','parent','listorder');

	protected $funcarr = array('add','order');

	protected $typearr,$editlang;

    protected $_groups;

	public function __construct()
    {
		parent::__construct();
		$this->Lang_model->loadLang('admin');
		$this->load->helper('array');
		$this->load->model('Purview_model');
		$this->Data_model->setTable($this->tablefunc);
        $this->groups = $this->Data_model->getData(NULL);
        $this->load->model('Tool_model');

        $this->_groups = $this->get_group();
	}

	public function index()
    {
        $this->get_group();
		$this->Purview_model->checkPurview($this->classname);
		$post = $this->input->post(NULL,TRUE);

		$getwhere = array();

		$data = $this->Data_model->getData($getwhere,'listorder');

        $newarr = array();
        foreach ($data as $item)
        {
            $newarr[$item['id']] = $item;
        }

        $newdata = $this->Tool_model->genTree9($newarr);

		$res = array(
				'tpl'=>'list',
				'tablefunc'=>$this->tablefunc,
                'classname' => $this->classname,
				'liststr'=> $this->_setlist($newdata,true),
				'funcstr'=>$this->Purview_model->getFunc($this->classname,$this->funcarr),
		);
		$this->load->view($this->tablefunc,$res);
	}

	public function add()
    {
		$this->Purview_model->checkPurviewAjax($this->classname,'add');
		$post = $this->input->post(NULL,TRUE);
		if($post['action']==site_aurl($this->classname)){
			$data = elements($this->fields,$post);
			$id=$this->Data_model->addData($data);
			show_jsonmsg(array('status'=>205));
		}else{
			$res = array(
					'tpl'=>'view',
					'tablefunc'=> $this->tablefunc,
                    'classname'=> $this->classname,
                    'groups' => $this->_groups,
			);
			show_jsonmsg(array('status'=>200,'remsg'=>$this->load->view($this->tablefunc,$res,true)));
		}
	}

	public function edit(){
		$this->Purview_model->checkPurviewAjax($this->classname,'edit');
		$post = $this->input->post(NULL,TRUE);
		if($post['id']&&$post['action']==site_aurl($this->classname)){
			$data = elements($this->fields,$post);
			$this->Data_model->editData(array('id'=>$post['id']),$data);
			show_jsonmsg(array('status'=>205));
		}else{
			$id = $this->uri->segment(4);
			if($id>0&&$view = $this->Data_model->getSingle(array('id'=>$id))){
                $res = array(
                        'tpl'=>'view',
                        'tablefunc'=> $this->tablefunc,
                        'classname'=> $this->classname,
                        'groups' => $this->_groups,
                        'view'=>$view,
                );

				show_jsonmsg(array('status'=>200,'remsg'=>$this->load->view($this->tablefunc,$res,true)));
			}else{
				show_jsonmsg(array('status'=>203));
			}
		}
	}

	public function order(){
		$this->Purview_model->checkPurviewAjax($this->classname,'order');
		$data = $this->Data_model->listorder($this->input->post('ids',true),$this->input->post('listorder',true),'listorder');
		$this->Cache_model->deleteSome($this->tablefunc.'_'.$this->editlang);
		show_jsonmsg(array('status'=>205));
	}

	public function del(){
		$this->Purview_model->checkPurviewAjax($this->classname,'del');
		$ids = $this->input->post('optid',true);
		if($ids){
			$this->Data_model->delData($ids);
			$this->Cache_model->deleteSome($this->tablefunc.'_'.$this->editlang);
			show_jsonmsg(array('status'=>205));
		}else{
			show_jsonmsg(array('status'=>203));
		}
	}

    public function get_group()
    {
        $newarr = array();
        foreach ($this->groups as $group)
        {
            $newarr[$group['id']] = $group;
        }
        $data = $this->Tool_model->genTree9($newarr);
        $this->get_format_group($data);

        return $this->_groups;
    }

    public function get_format_group($data,$count=1)
    {
		foreach($data as $key => $item)
        {
			$this->_groups[] = array(
                'id' => $item['id'],
                'parent' => $item['parent'],
                'name' => $item['name'],
                'count' => $count,
            );
            if (isset($item['son']) && !empty($item['son']))
            {
                $this->get_format_group($item['son'],$count+1);
            }
		}
    }

	public function _setlist($data,$ismultiple=true,$count=1)
    {
		$newdata = $ismultiple?$data:($newdata[0]=$data);
		if($ismultiple){
			$newdata = $data;
		}else{
			$newdata = array(0=>$data);
		}
		$newstr = '';
		foreach($newdata as $key => $item)
        {
			$item['func'] = '';
			if($this->Purview_model->checkPurviewFunc($this->classname,'edit')){
				$item['func'] .= $this->Purview_model->getSingleFunc(site_aurl($this->classname.'/edit/'.$item['id']),'edit');
			}
			if($this->Purview_model->checkPurviewFunc($this->classname,'order')){
				$item['func'] .= $this->Purview_model->getSingleFunc(site_aurl($this->classname.'/order'),'order');
			}
			if($this->Purview_model->checkPurviewFunc($this->classname,'del')){
				$item['func'] .=  $this->Purview_model->getSingleFunc(site_aurl($this->classname.'/del/'.$item['id']),'sdel',$item['id']);
			}

			$newstr.='<tr id="tid_'.$item['id'].'">
			<td width=40>'.$item['id'].'</td>
			<td align="left">'.str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',$count-1).'<input type="hidden" name="ids[]" value="'.$item['id'].'"> <input type="text" name="listorder[]" class="input-order" size="3" value="'.$item['listorder'].'"> '.$item['name'].' </td>
			<td width=50>'.$item['func'].'</td></tr>';

            if (isset($item['son']) && !empty($item['son']))
            {
                $newstr .= $this->_setlist($item['son'],true,$count+1);
            }
		}
		return $newstr;
	}
}