<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends PRJCT_Controller {
	
	public function __construct(){
		parent::__construct();
	}
	
	public function index()
	{
		$this->page(1);
	}
	
	public function page($page=1)
	{
		$this->load->model('notifikasi_model');
		$this->data['title'] = 'List Notifikasi';
		$list_notifikasi=$this->notifikasi_model->get_notif($this->session->prjct_user->ID_USER,NULL,$page);
		$temp_total_notifikasi=$this->notifikasi_model->count_notif($this->session->prjct_user->ID_USER)->result();
		$total_notifikasi=0;
		if(!empty($temp_total_notifikasi))
			$total_notifikasi=$temp_total_notifikasi[0]->COUNT;
		$page_total=$page;
		if(!empty($list_notifikasi->result())){
			$page_total=ceil($total_notifikasi/$this->config->item('list_show'));
		}
		$this->data['page_now']=$page;
		$this->data['notification'] = $list_notifikasi->result();
		$this->data['url_pagination'] = $this->config->item('url_notification_page');
		$this->data['page_total'] = $page_total;
		$this->load->view('global/header',$this->data);
		$this->load->view('notification/list_notification',$this->data);
		$this->load->view('global/footer',$this->data);
	}
	
	public function read($id_notif=NULL)
	{
		if(!empty($id_notif)){
			$this->load->model('notifikasi_model');
			$notif = $this->notifikasi_model->read_notif($id_notif,$this->session->prjct_user->ID_USER);
			if(!empty($notif->result())){
				$notif = $notif->result();
				$notif_count = $this->notifikasi_model->count_notif($this->session->prjct_user->ID_USER,1)->result();
				$notif_count = $notif_count[0]->COUNT;
				$this->data['notif_count'] = $notif_count;
				$this->data['title'] = "Notification ".$notif[0]->JUDUL;
				$this->data['notification'] = $notif[0];
				$this->load->view('global/header',$this->data);
				$this->load->view('notification/view_notification',$this->data);
				$this->load->view('global/footer',$this->data);
			}else{
				show_404();
			}
		}
	}
}
