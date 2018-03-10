<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Enrollhost extends CI_Controller
{
	protected $tablefunc = 'enroll_host';
    protected $classname = 'enrollhost';

	protected $fields = array('title');

	protected $funcarr = array('add','del');

	protected $typearr,$editlang;

	public function __construct()
    {
		parent::__construct();
		$this->Lang_model->loadLang('admin');
		$this->load->helper('array');
		$this->load->model('Purview_model');
		$this->Data_model->setTable($this->tablefunc);
	}

	public function index()
    {
		$this->Purview_model->checkPurview($this->tablefunc);
		$post = $this->input->post(NULL,TRUE);

		$getwhere = array();

		$pagearr=array(
			'currentpage'=>	isset($post['currentpage'])&&$post['currentpage']>0?$post['currentpage']:1,
			'totalnum'=>$this->Data_model->getDataNum($getwhere),
			'pagenum'=>20
		);
		$data = $this->Data_model->getData($getwhere,'',$pagearr['pagenum'],($pagearr['currentpage']-1)*$pagearr['pagenum']);
		$res = array(
				'tpl'=>'list',
				'tablefunc'=>$this->tablefunc,
                'classname' => $this->classname,
				'liststr'=>$this->_setlist($data,true),
				'pagestr'=>show_page($pagearr,$search),
				'funcstr'=>$this->Purview_model->getFunc($this->classname,$this->funcarr),
		);
		$this->load->view($this->tablefunc,$res);
	}

	public function add(){
		$this->Purview_model->checkPurviewAjax($this->classname,'add');
		$post = $this->input->post(NULL,TRUE);
		if($post['action']==site_aurl($this->classname)){
			$data = elements($this->fields,$post);
			$id=$this->Data_model->addData($data);
			show_jsonmsg(array('status'=>200,'remsg'=>$this->_setlist($this->Data_model->getSingle(array('id'=>$id)),false)));
		}else{
			$res = array(
					'tpl'=>'view',
					'tablefunc'=> $this->tablefunc,
                    'classname'=> $this->classname,
			);
			show_jsonmsg(array('status'=>200,'remsg'=>$this->load->view($this->tablefunc,$res,true)));
		}
	}

	public function edit(){
		$this->Purview_model->checkPurviewAjax($this->tablefunc,'edit');
		$post = $this->input->post(NULL,TRUE);
		if($post['id']&&$post['action']==site_aurl($this->classname)){
			$data = elements($this->fields,$post);
			$this->Data_model->editData(array('id'=>$post['id']),$data);
			show_jsonmsg(array('status'=>200,'id'=>$post['id'],'remsg'=>$this->_setlist($this->Data_model->getSingle(array('id'=>$post['id'])),false)));
		}else{
			$id = $this->uri->segment(4);
			if($id>0&&$view = $this->Data_model->getSingle(array('id'=>$id))){
				$res = array(
						'tpl'=>'view',
						'tablefunc'=>$this->tablefunc,
						'view'=>$view,
						'classname'=>$this->classname
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

	function _setlist($data,$ismultiple=true){
		$newdata = $ismultiple?$data:($newdata[0]=$data);
		if($ismultiple){
			$newdata = $data;
		}else{
			$newdata = array(0=>$data);
		}
		$newstr = '';
		foreach($newdata as $key=>$item){
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
			<td width=30><input type=checkbox name="optid[]" value='.$item['id'].'></td>
			<td width=40><input type="hidden" name="ids[]" value="'.$item['id'].'">'.$item['id'].'</td>
			<td align="left">'.$item['title'].'</td>
			<td width=50>'.$item['func'].'</td></tr>';
		}
		return $newstr;
	}
}