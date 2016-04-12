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
	
	public function manage_report($type='noread',$page=1)
	{
		$this->load->model('report_model');
		$is_read=0;
		if($type=='all')$is_read=NULL;
		elseif($type=='read')$is_read=1;
		$report = $this->report_model->get_report(NULL,$is_read,$page)->result();
		$report_count = $this->report_model->get_report_count(NULL,$is_read)->result();
		$report_count = $report_count[0]->COUNT;
		$page_total=$page;
		if(!empty($report)){
			$page_total=ceil($report_count/$this->config->item('list_show'));
		}
		$this->data['title'] = "User Report";
		$this->data['type_page']=$type;
		$this->data['page_now']=$page;
		$this->data['page_total'] = $page_total;
		$this->data['url_pagination'] = $this->config->item('url_admin_report').$type.'/';
		$this->data['report'] = $report;
		$this->load->view('global/header',$this->data);
		$this->load->view('administrator/list_report',$this->data);
		$this->load->view('global/footer',$this->data);
	}

	public function view_report($id_report=NULL)
	{
		if(!empty($id_report)){
			$this->load->model('report_model');
			$report = $this->report_model->read_report($id_report);
			if(!empty($report->result())){
				$report = $report->result();
				$report_count = $this->report_model->get_report_count(NULL,0)->result();
				$report_count = $report_count[0]->COUNT;
				$this->data['report_count'] = $report_count;
				$this->data['title'] = "Report by".$report[0]->USERNAME_REPORT;
				$this->data['report'] = $report[0];
				$this->load->view('global/header',$this->data);
				$this->load->view('administrator/view_report',$this->data);
				$this->load->view('global/footer',$this->data);
			}else{
				show_404();
			}
		}
	}
}
