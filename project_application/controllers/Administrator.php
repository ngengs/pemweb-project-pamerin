<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends PRJCT_Controller {
	
	public function __construct(){
		parent::__construct();
		if($this->session->prjct_user->LEVEL!=1){
			show_404();exit;
		}
	}
	
	public function manage_user($page=1)
	{
		$this->load->model('user_model');
		$this->data['title'] = 'List User';
		$list_user=$this->user_model->get_user(NULL,FALSE,$page);
		$temp_total_user=$this->user_model->get_user_count()->result();
		$total_user=0;
		if(!empty($temp_total_user))
			$total_user=$temp_total_user[0]->COUNT;
		$page_total=$page;
		if(!empty($list_user->result())){
			$page_total=ceil($total_user/$this->config->item('user_show'));
		}
		$this->data['page_now']=$page;
		$this->data['user'] = $list_user->result();
		$this->data['url_pagination'] = $this->config->item('url_admin_user');
		$this->data['page_total'] = $page_total;
		$this->data['menu']=98;
		$this->load->view('global/header',$this->data);
		$this->load->view('administrator/list_user',$this->data);
		$this->load->view('global/footer',$this->data);
	}
}
