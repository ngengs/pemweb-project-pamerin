<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends PRJCT_Controller {
	
	public function __construct(){
		parent::__construct();
	}

	public function index()
	{
		$this->page();
	}
	
	public function view($username=NULL, $id_post=NULL){
		if(empty($id_post) && !empty($username)){
			show_404();
		}else{			
			if(!empty($this->session->flashdata('error_message')))
				$this->data["error"]=$this->session->flashdata('error_message');
			
			$this->load->model('post_model');
			$id_user = $this->session->prjct_user->ID_USER;
			$post = $this->post_model->get_single_post($username,$id_post,$id_user);
			if(!empty($post)){
				$this->data['post']=$post[0];
				$this->data['title']='Post by @'.$post[0]->USERNAME;
				$this->load->view('global/header',$this->data);
				$this->load->view('post/single',$this->data);
				$this->load->view('global/footer',$this->data);
			}else{
				show_404();
			}
		}
	}
	
	public function like($username=NULL,$id=NULL)
	{
		if(!empty($id) && !empty($username)){
			$this->load->model('post_model');
			$result = $this->post_model->like_post($id,$this->session->prjct_user->ID_USER);
			if(empty($result)){
				$this->session->set_flashdata('error_message', 'Failed Like Post');
			}
			redirect('post/view/'.$username.'/'.$id);
		}else{
			show_404();
		}
	}
	
	public function unlike($username=NULL,$id=NULL)
	{
		if(!empty($id) && !empty($username)){
			$this->load->model('post_model');
			$result = $this->post_model->unlike_post($id,$this->session->prjct_user->ID_USER);
			if(empty($result)){
				$this->session->set_flashdata('error_message', 'Failed Unlike Post');
			}
			redirect('post/view/'.$username.'/'.$id);
		}else{
			show_404();
		}
	}
	
	public function submit_edit()
	{
		$caption = $this->input->post('caption');
		$id_post = $this->input->post('id_post');
		$username = $this->input->post('username');
		if(!empty($id_post)){
			$id_user = $this->session->prjct_user->ID_USER;
			if($this->session->prjct_user->LEVEL==1){
				$id_user=NULL;
			}
			if($caption==''){
				$caption=NULL;
			}
			$this->load->model('post_model');
			$result = $this->post_model->edit_post($id_post,$caption,$id_user);
			if(empty($result)){
				$this->session->set_flashdata('error_message', 'Failed Edit Post');
			}
		}else{
			$this->session->set_flashdata('error_message', 'Failed Edit Post');
		}
		redirect('post/view/'.$username.'/'.$id_post);
	}
	
	public function submit_comment()
	{
		$id_post = $this->input->post('id_post');
		$comment = $this->input->post('comment');
		$username = $this->input->post('username');
		if(empty($id_post)&&empty($comment)&&empty($username)){
			$this->session->set_flashdata('error_message', 'Failed Commenting This Post');
		}
		else{
			$this->load->model('post_model');
			$id_user = $this->session->prjct_user->ID_USER;
			$result=$this->post_model->create_comment($id_post,$id_user,$comment);
			if(empty($result)){
				$this->session->set_flashdata('error_message', 'Failed Commenting This Post');
			}
		}
		
		redirect('post/view/'.$username.'/'.$id_post);
	}
	
	public function submit_comment_edit(){
		$id_comment = $this->input->post('id_comment');
		$id_post = $this->input->post('id_post');
		$username_post = $this->input->post('username_post');
		$comment = $this->input->post('comment');
		if(!empty($id_comment) && !empty($comment)){
			$this->load->model('post_model');
			$result = $this->post_model->edit_comment($id_comment,$comment);
			if(empty($result)){
				$this->session->set_flashdata('error_message', 'Cant Edit Comment');	
			}
		}else{
			$this->session->set_flashdata('error_message', 'Cant Edit Comment');
		}
		redirect('post/view/'.$username_post.'/'.$id_post);
	}


	
	public function comment_delete($username=NULL,$id_post=NULL,$id_comment=NULL){
		if(!empty($id_comment)){
			$this->load->model('post_model');
			$id_user = $this->session->prjct_user->ID_USER;
			$result = $this->post_model->delete_comment($id_comment,$id_user);
			if(empty($result)){
				$this->session->set_flashdata('error_message', 'Failed Delete Comment');
			}
		}
		redirect('post/view/'.$username.'/'.$id_post);
	}
	
	public function delete($id_post=NULL){
		if(!empty($id_post)){
			$this->load->model('post_model');
			$id_user = $this->session->prjct_user->ID_USER;
			if($this->session->prjct_user->LEVEL==1){
				$id_user=NULL;
			}
			$result = $this->post_model->delete_post($id_post,$id_user);
			if(empty($result)){
				$this->session->set_flashdata('error_message', 'Failed Delete Post');
			}
		}
		redirect('');
	}

	public function submit_report()
	{
		if($this->session->prjct_user->LEVEL!=1){
			$id_post = $this->input->post('id_post');
			$username_creator = $this->input->post('username_creator');
			$pesan_report = $this->input->post('pesan_report');
			if(!empty($id_post) && !empty($pesan_report)){
				$id_user = $this->session->prjct_user->ID_USER;
				$this->load->model('report_model');
				$result = $this->report_model->create_report($id_post, $id_user, $pesan_report);
				if(empty($result)){
					$this->session->set_flashdata('error_message', 'Failed Report Post, Maybe you already report this before');
				}
			}
			redirect('post/view/'.$username_creator.'/'.$id_post);
		}else{
			show_404();
		}
	}
	
	public function submit_post()
	{
		$images = array();
		$files = $_FILES;
		$dirname = $this->config->item('media_path');
		$return = array();
		if(!empty($files)){
			
			$error = '';
			$this->load->helper('string');
			$this->load->library('upload');
			$count = count($files['image_upload']['name']);
			$dir=realpath(APPPATH.'../'.$dirname);
			if (!file_exists($dir))mkdir($dir);
			$dir .= '/'.$this->session->prjct_user->USERNAME;
			if (!file_exists($dir))mkdir($dir);
			$dir .= '/'.$this->config->item('media_upload');;
			if (!file_exists($dir))mkdir($dir);
			for($i = 0; $i<$count;$i++){				
				$_FILES['image_upload']['name'] = $files['image_upload']['name'][$i];
                $_FILES['image_upload']['type'] = $files['image_upload']['type'][$i];
                $_FILES['image_upload']['tmp_name'] = $files['image_upload']['tmp_name'][$i];
                $_FILES['image_upload']['error'] = $files['image_upload']['error'][$i];
                $_FILES['image_upload']['size'] = $files['image_upload']['size'][$i];
				
				$config['upload_path'] = $dir."/";
		        $config['allowed_types'] = 'jpg|png';
				$config['file_ext_tolower'] = TRUE;
				$filename = date('YmdHis_').random_string('alpha', 8);
				$config['file_name'] = $filename;
				$this->upload->initialize($config);
				if ($this->upload->do_upload('image_upload')) {
                    $data = $this->upload->data();
					$images[] = $data['orig_name'];
					
					//Resize Image
					$configi['image_library'] = 'gd2';
					$configi['source_image'] = $data['full_path'];
					if(!empty($data['image_width'])){
						$configi['width']=$data['image_width'] - $this->config->item('web_image_size_minus');
					}
					if(!empty($return['data']['image_height'])){
						$configi['height']=$data['image_height'] - $this->config->item('web_image_size_minus');
					}
					$configi['quality'] = $this->config->item('web_image_quality');
					$this->load->library('image_lib', $configi);
					$this->image_lib->resize();
                } else {
                    $error .= $this->upload->display_errors('', '') . "\r";
                }
			}
			if(!empty($error) || empty($images)){
				$this->session->set_flashdata('error_message', $error);
				redirect('');
			}else{
				$id = $this->global_model->generateid();
				$caption = $this->input->post('caption');
				
				if(empty($caption))$caption=NULL;
				else $caption=strip_tags($caption);
				
				$this->load->model('post_model');
				$id_user=$this->session->prjct_user->ID_USER;
				$result = $this->post_model->create($id_user,$id,$caption,$images);
				redirect('');
			}
			
		}
	}
}
