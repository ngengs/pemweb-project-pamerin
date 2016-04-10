<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends PRJCT_Controller {
	
	public function __construct(){
		parent::__construct();
	}

	public function index()
	{
		$this->page();
	}
	
	public function page($page=1)
	{
		$this->data['title'] = 'Timeline';
		$this->data['menu'] = 1;
		
		if(!empty($this->session->flashdata('error_message')))
			$this->data["error"]=$this->session->flashdata('error_message');
		
		$this->load->model('user_model');
		$following_temp = $this->user_model->get_following($this->session->prjct_user->ID_USER,TRUE);
		$following = array();
		if(!empty($following_temp) && $this->session->prjct_user->LEVEL != 1){
			$following[]=$this->session->prjct_user->ID_USER;	
			$temp = $following_temp->result();
			foreach ($temp as $key => $value) {
				$following[]=$value->FOLLOWING_ID;
			}
		}
		$this->data['page_now']=$page;
		$this->load->model('post_model');
		$page_total=0;
		$this->	data['post'] = $this->post_model->get_timeline($this->session->prjct_user->ID_USER, $following, $page);
		if(!empty($this->data['post'])){
			$total_post = $this->post_model->get_timeline_count($this->session->prjct_user->ID_USER, $following);
			$page_total=ceil($total_post/$this->config->item('timeline_post'));
		}
		$this->data['page_total'] = $page_total;
		$this->load->view('global/header',$this->data);
		$this->load->view('timeline/home',$this->data);
		$this->load->view('global/footer',$this->data);
	}
}
