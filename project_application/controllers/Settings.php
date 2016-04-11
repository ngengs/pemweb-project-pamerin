<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends PRJCT_Controller {
	
	public function __construct(){
		parent::__construct();
	}

	public function profile($username=NULL)
	{
		if(!empty($username)) {
			if($this->session->prjct_user->USERNAME==$username || $this->session->prjct_user->LEVEL==1){
				if(!empty($this->session->flashdata('error_message')))
					$this->data["error"]=$this->session->flashdata('error_message');
				$this->load->model('user_model');
				$user = $this->user_model->get_user($username);
				if(!empty($user->result())){
					$user = $user->result();
					$user = $user[0];
					$this->data['title'] = "Setting Profile @".$username;
					$this->data['user'] = $user;
					$this->load->view('global/header',$this->data);
					$this->load->view('settings/profile',$this->data);
					$this->load->view('global/footer',$this->data);
				}else{
					show_404();
				}
			}else{
				show_404();
			}
		} else {
			show_404();
		}
	}
	
	public function profile_submit()
	{
		$full_name = $this->input->post('full_name');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$password_retype = $this->input->post('password_retype');
		$id = $this->input->post('id');
		$username = $this->input->post('username');
		$is_admin = $this->input->post('is_admin');
		if(empty($full_name)){
			$this->session->set_flashdata('error_message','Fullname cant empty');
		}elseif (empty($email)) {
			$this->session->set_flashdata('error_message','Email cant empty');
		}elseif (!empty($password)) {
			$regex_password = $this->config->item('regex_password');
			if(!preg_match($regex_password, $password)){
				$this->session->set_flashdata('error_message',"Passoword length minimal 8, contain lowercase, uppercase and number");
			}
			if($password != $password_retype){
				$error=true;
				$this->session->set_flashdata('error_message',"Password and password retype not match, please check again");
			}
		}
		
		if(!empty($id)){
			$data = array(	
							'full_name' => $full_name,
							'email' => $email
							 );
			if(!empty($password)){
				$data['password'] = md5($password);
			}
			$files = $_FILES;
			$dirname = $this->config->item('media_path');
			if(!empty($files['image_upload']['name'])){
				$this->load->helper('string');
				$this->load->library('upload');
				$count = count($files['image_upload']['name']);
				$dir=realpath(APPPATH.'../'.$dirname);
				if (!file_exists($dir))mkdir($dirname);
				$dir .= '/'.$this->session->prjct_user->USERNAME;
				if (!file_exists($dir))mkdir($dir);
				$dir .= '/'.$this->config->item('media_avatar');;
				if (!file_exists($dir))mkdir($dir);
				else{
					$this->load->helper('file');
					delete_files($dir);
				}
				$config['upload_path'] = $dir."/";
		        $config['allowed_types'] = 'jpg|png';
				$config['file_ext_tolower'] = TRUE;
				$filename = date('YmdHis_').random_string('alpha', 8);
				$config['file_name'] = $filename;
				$this->upload->initialize($config);
				if ($this->upload->do_upload('image_upload')) {
                    $data_img = $this->upload->data();
					$images[] = $data_img['orig_name'];
					
					//Resize Image
					$configi['image_library'] = 'gd2';
					$configi['source_image'] = $data_img['full_path'];
					if(!empty($data['image_width'])){
						$configi['width']=$data_img['image_width'] - $this->config->item('web_image_size_minus');
					}
					if(!empty($return['data']['image_height'])){
						$configi['height']=$data_img['image_height'] - $this->config->item('web_image_size_minus');
					}
					$configi['quality'] = $this->config->item('web_image_quality');
					$this->load->library('image_lib', $configi);
					$this->image_lib->resize();
					$data['user_picture'] = $data_img['file_name'];
                }
			}
			if($this->session->prjct_user->LEVEL==1){
				$level = 2;
				if(!empty($is_admin)) $level = 1;
				$data['level']=$level;
			}
			$this->load->model('user_model');
			$result = $this->user_model->update_user($id,$data);
			if($result && $this->session->prjct_user->ID_USER == $id){
				$result_user = $this->user_model->check($this->session->prjct_user->USERNAME);
				if(!empty($result_user->result())){
					$value = $result_user->result();
					$this->session->set_userdata(array('prjct_user'=>$value[0]));
				}
			}
		}
		redirect($this->config->item('url_settings_profile').$username);
	}

	public function user_delete($id=NULL,$username=NULL)
	{
		if(!empty($id) && !empty($username)){
			$this->load->model('user_model');
			$data=array('is_aktif'=>0);
			$this->user_model->update_user($id,$data,$username);
			if($this->session->prjct_user->ID_USER == $id){
				redirect('auth/signout');
			}
		}
		redirect('');
	}
	
	public function user_activate($id=NULL,$username=NULL)
	{
		if(!empty($id) && !empty($username) && $this->session->prjct_user->LEVEL==1){
			$this->load->model('user_model');
			$data=array('is_aktif'=>1);
			$this->user_model->update_user($id,$data,$username);
		}
		redirect('');
	}
}
