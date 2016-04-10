<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends PRJCT_Controller {
	
	public function __construct(){
		parent::__construct();
	}
	
	public function user($username=NULL,$page=1)
	{
		if(!empty($username)){
			if(!empty($this->session->flashdata('error_message')))
				$this->data["error"]=$this->session->flashdata('error_message');
			$this->load->model('user_model');
			$user = $this->user_model->check($username);
			if(!empty($user->result())){
				$user = $user->result();
				$this->data['title'] = 'Profile @'.$username;
				$user_for_timeline = array($user[0]->ID_USER);
				$this->load->model('post_model');
				$this->data['page_now']=$page;
				$this->	data['post'] = $this->post_model->get_timeline($this->session->prjct_user->ID_USER, $user_for_timeline, $page);
				$page_total = 0;
				$total_post = 0;
				if($user[0]->ID_USER==$this->session->prjct_user->ID_USER){
					$this->data['menu']=2;
				}
				if(!empty($this->data['post'])){
					$total_post = $this->post_model->get_timeline_count($this->session->prjct_user->ID_USER, $user_for_timeline);
					$page_total=ceil($total_post/$this->config->item('timeline_post'));
				}
				$temp=$this->user_model->get_following_count($user[0]->ID_USER)->result();
				$total_following=0;
				if(!empty($temp))
					$total_following=$temp[0]->COUNT;
				$temp=$this->user_model->get_follower_count($user[0]->ID_USER)->result();
				$total_follower=0;
				if(!empty($temp))
					$total_follower=$temp[0]->COUNT;
				if($user[0]->ID_USER != $this->session->prjct_user->ID_USER){
					$my_following = $this->user_model->get_following($this->session->prjct_user->ID_USER,TRUE);
					$is_followed = FALSE;
					if(!empty($my_following->result())){
						foreach ($my_following->result() as $key => $value) {
							if($value->FOLLOWING_ID == $user[0]->ID_USER){
								$is_followed=TRUE;break;
							}
						}
					}
					$this->data['is_followed']=$is_followed;
				}
				$this->data['total_following']=$total_following;
				$this->data['total_follower']=$total_follower;
				$this->data['total_post']=$total_post;
				$this->data['user']=$user[0];
				$this->data['page_total'] = $page_total;
				$this->load->view('global/header',$this->data);
				$this->load->view('profile/user',$this->data);
				$this->load->view('global/footer',$this->data);
			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}

	public function follow_user($username=NULL,$id_user=NULL)
	{
		if(!empty($id_user)&&!empty($username)){
			$this->load->model('user_model');
			$id_me = $this->session->prjct_user->ID_USER;
			$result = $this->user_model->follow_user($id_me,$id_user);
			if(empty($result)){
				$this->session->set_flashdata('error_message', 'Failed Follow '.$username);
			}
			redirect('profile/user/'.$username);
		}else{
			show_404();
		}
	}
	
	public function unfollow_user($username=NULL,$id_user=NULL)
	{
		if(!empty($id_user)&&!empty($username)){
			$this->load->model('user_model');
			$id_me = $this->session->prjct_user->ID_USER;
			$result = $this->user_model->unfollow_user($id_me,$id_user);
			if(empty($result)){
				$this->session->set_flashdata('error_message', 'Failed Unfollow '.$username);
			}
			redirect('profile/user/'.$username);
		}else{
			show_404();
		}
	}
	
	public function following($username=NULL,$page=1)
	{
		if(!empty($username)){
			$this->load->model('user_model');
			$user = $this->user_model->get_user($username);
			if(!empty($user->result())){
				$this->data['title'] = 'Following of @'.$username;
				$user=$user->result();
				$following=$this->user_model->get_following($user[0]->ID_USER,FALSE,1,$page);
				$temp_total_following=$this->user_model->get_following_count($user[0]->ID_USER)->result();
				$total_following=0;
				$my_following = $this->user_model->get_following($this->session->prjct_user->ID_USER,TRUE);
				if(!empty($temp_total_following))
					$total_following=$temp_total_following[0]->COUNT;
				$page_total=$page;
				if(!empty($following->result())){
					$page_total=ceil($total_following/$this->config->item('user_show'));
				}
				$this->data['page_now']=$page;
				$this->data['user'] = $following->result();
				$this->data['page_total'] = $page_total;
				$this->data['my_following'] = $my_following;
				$this->load->view('global/header',$this->data);
				$this->load->view('profile/list_user',$this->data);
				$this->load->view('global/footer',$this->data);
			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}

	public function followers($username=NULL,$page=1)
	{
		if(!empty($username)){
			$this->load->model('user_model');
			$user = $this->user_model->get_user($username);
			if(!empty($user->result())){
				$this->data['title'] = 'Followers of @'.$username;
				$user=$user->result();
				$following=$this->user_model->get_follower($user[0]->ID_USER,FALSE,1,$page);
				$temp_total_following=$this->user_model->get_follower_count($user[0]->ID_USER)->result();
				$total_following=0;
				$my_following = $this->user_model->get_following($this->session->prjct_user->ID_USER,TRUE);
				if(!empty($temp_total_following))
					$total_following=$temp_total_following[0]->COUNT;
				$page_total=$page;
				if(!empty($following->result())){
					$page_total=ceil($total_following/$this->config->item('user_show'));
				}
				$this->data['page_now']=$page;
				$this->data['user'] = $following->result();
				$this->data['page_total'] = $page_total;
				$this->data['my_following'] = $my_following;
				$this->load->view('global/header',$this->data);
				$this->load->view('profile/list_user',$this->data);
				$this->load->view('global/footer',$this->data);
			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}
}
