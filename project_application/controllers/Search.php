<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends PRJCT_Controller {
	
	public function __construct(){
		parent::__construct();
	}

	public function index()
	{
		redirect('');
	}
	
	public function search_submit(){
		$search = $this->input->post('search_query');
		if(!empty($search)){
			redirect($this->config->item('url_search_user').strtolower($search));
		}else{
			redirect('');
		}
	}
	
	public function hashtags($hashtags=NULL,$page=1)
	{
		if(!empty($hashtags)){
			$pure_search=$hashtags;
			$hashtags = "#".$hashtags;
			$this->data['title'] = 'Search '.$hashtags;
			
			if(!empty($this->session->flashdata('error_message')))
				$this->data["error"]=$this->session->flashdata('error_message');
			
			$this->load->model('user_model');
			$following = array();
			$this->data['page_now']=$page;
			$this->load->model('post_model');
			$page_total=0;
			$this->	data['post'] = $this->post_model->get_timeline($this->session->prjct_user->ID_USER, $following, $page, $hashtags);
			if(!empty($this->data['post'])){
				$total_post = $this->post_model->get_timeline_count($this->session->prjct_user->ID_USER, $following, $hashtags);
				$page_total=ceil($total_post/$this->config->item('timeline_post'));
			}
			$this->data['page_total'] = $page_total;
			$this->data['url_pagination'] = $this->config->item('url_search_hashtags').$pure_search.'/';
			$this->data['search']=$pure_search;
			$this->load->view('global/header',$this->data);
			$this->load->view('search/hashtags',$this->data);
			$this->load->view('global/footer',$this->data);
		}else{
			show_404();
		}
	}
	
	public function users($username=NULL,$page=1)
	{
		if(!empty($username)){
			$this->load->model('user_model');
			$user = $this->user_model->get_user($username,TRUE,$page);
			$this->data['title'] = 'Search User '.$username;
			$user=$user->result();
			$temp_total=$this->user_model->get_user_count($username,TRUE)->result();
			$total=0;
			$my_following = $this->user_model->get_following($this->session->prjct_user->ID_USER,TRUE);
			if(!empty($temp_total))
				$total=$temp_total[0]->COUNT;
			$page_total=$page;
			if(!empty($user)){
				$page_total=ceil($total/$this->config->item('user_show'));
			}
			$this->data['page_now']=$page;
			$this->data['user'] = $user;
			$this->data['url_pagination'] = $this->config->item('url_search_user').$username.'/';
			$this->data['search']=$username;
			$this->data['page_total'] = $page_total;
			$this->data['my_following'] = $my_following;
			$this->load->view('global/header',$this->data);
			$this->load->view('search/user',$this->data);
			$this->load->view('global/footer',$this->data);
		}else{
			show_404();
		}
	}
}
