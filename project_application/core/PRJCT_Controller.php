<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PRJCT_Controller extends CI_Controller {
	public $data = array();
	public function __construct(){
		parent::__construct();
		if(!$this->session->has_userdata('prjct_user')){
			redirect('auth/signin');
		}
		else{
			$this->load->model('global_model');
			$this->__generate_notif_count();
			$this->__generate_report_count();	
		}
	}
	
	private function __generate_notif_count(){
		$temp_notif = $this->global_model->count_notif($this->session->prjct_user->ID_USER);
		$notif = 0;
		if(!empty($temp_notif->result())){
			$res = $temp_notif->result();
			$notif = $res[0]->COUNT;
		}
		$this->data['notif_count']=$notif;
	}
	
	private function __generate_report_count(){
		if($this->session->prjct_user->LEVEL==1){
			$temp_report = $this->global_model->count_report();
			$report = 0;
			if(!empty($temp_report->result())){
				$res = $temp_report->result();
				$report= $res[0]->COUNT;
			}
			$this->data['report_count']=$report;
		}	
	}
}
