<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
	}

	public function index()
	{
		if($this->session->has_userdata('prjct_user')){
			redirect('');
		}
		redirect('auth/signin');
	}
	
	public function signin()
	{
		if($this->session->has_userdata('prjct_user')){
			redirect('');
		}
		if(!empty($this->session->flashdata('error_message')))
			$data["error"]=$this->session->flashdata('error_message');
		$data['title']="Sign In";
		$this->load->view('auth/header',$data);
		$this->load->view('auth/signin',$data);
		$this->load->view('auth/footer',$data);
	}
	
	public function signup()
	{
		if($this->session->has_userdata('prjct_user')){
			redirect('');
		}
		if(!empty($this->session->flashdata('error_message')))
			$data["error"]=$this->session->flashdata('error_message');
		$data['title']="Sign Up";
		$this->load->view('auth/header',$data);
		$this->load->view('auth/signup',$data);
		$this->load->view('auth/footer',$data);
	}
	
	public function signin_submit(){
		if($this->session->has_userdata('prjct_user')){
			redirect('');
		}
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		if(empty($username) || empty($password)){
			$this->session->set_flashdata('error_message', 'Empty Data Input SignIn');
			redirect('auth/signin');
		}else{
			$this->load->model('user_model');
			$result = $this->user_model->check($username,$password);
			if(!empty($result->result())){
				$value = $result->result();
				if($value[0]->IS_AKTIF==1){
					$this->session->set_userdata(array('prjct_user'=>$value[0]));
					redirect('');
				}else{
					$this->session->set_flashdata('error_message', 'User not active');
					redirect('auth/signin');
				}
			}else{
				$this->session->set_flashdata('error_message', 'Wrong Username or Password');
				redirect('auth/signin');
			}
		}
	}
	
	public function signup_submit()
	{
		$username = $this->input->post('username');
		$email = $this->input->post('email');
		$full_name = $this->input->post('full_name');
		$password = $this->input->post('password');
		$password_retype = $this->input->post('password_retype');
		if(!empty($username) &&!empty($email) && !empty($full_name) && !empty($password) && !empty($password_retype)){
			$regex_username = $this->config->item('regex_username');
			$regex_password = $this->config->item('regex_password');
			$error = false;
			$error_message = "";
			if(!preg_match($regex_username, $username)){
				$error = true;
				$error_message .='Username cant accept, min length 4 max length 15, allowed char a-z A-Z 0-9 _<br>';
			}
			if(!preg_match($regex_password, $password)){
				$error = true;
				$error_message .= "Passoword length minimal 8, contain lowercase, uppercase and number<br>";
			}
			if($password != $password_retype){
				$error=true;
				$error_message .= "Password and password retype not match, please check again";
			}
			if($error){
				$this->session->set_flashdata('error_message', $error_message);
				redirect('auth/signup');
			}else{
				$this->load->model('user_model');
				$result = $this->user_model->register($username,$password,$email,$full_name);
				if($result){
					redirect('auth/signin');
				}else{
					$this->session->set_flashdata('error_message', 'Cant register user');
					redirect('auth/signup');
				}
			}
			
		}else{
			$this->session->set_flashdata('error_message', 'Data cant empty or blank');
			redirect('auth/signup');
		}
	}
	
	
	
	
	public function signout(){
		if($this->session->has_userdata('prjct_user'))
			$this->session->unset_userdata('prjct_user');
		redirect('');
	}
}
