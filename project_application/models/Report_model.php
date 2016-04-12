<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model{

	public function __construct()
    {
        parent::__construct();
		$this->load->database();
    }	
	
	public function create_report($id_post, $id_user, $pesan_report=NULL, $is_read=0)
	{
		/**
		 * Check if user already report the post
		 */
		$this->db->select('post_report.ID_REPORT');
		$this->db->from('post_report');
		$this->db->where('post_report.ID_POST',$id_post);
		$this->db->where('post_report.ID_USER',$id_user);
		$result_check = $this->db->get();
		$return = NULL;
		
		/**
		 * Process insert report only when user not already report it
		 */
		if(empty($result_check->result())){
			$date = date("Y-m-d H:i:s");
			$data = array('ID_POST' => $id_post, 
						  'ID_USER' => $id_user,
						  'IS_READ' => $is_read,
						  'DATE_REPORT' =>$date,
						  'PESAN_REPORT'=>$pesan_report	
							);
			$this->db->set('ID_REPORT','GENERATEID()',FALSE);
			$return = $this->db->insert('post_report',$data);
		}
		return $return;
	}

	public function get_report($id_report=NULL, $is_read=NULL, $page=NULL)
	{
		$query = '	post_report.ID_REPORT,
					post_report.ID_POST,
					post_report.ID_USER,
					post_report.DATE_REPORT,
					post_report.PESAN_REPORT,
					post_report.IS_READ,
					user_report.USERNAME as USERNAME_REPORT';
		if (!empty($id_report)) {
			$query .= '	,post.IS_AKTIF,
						`user`.USERNAME,
						user_report.FULL_NAME as FULL_NAME_REPORT,
						user_report.USER_PICTURE as USER_PICTURE_REPORT,
						user_report.LEVEL as LEVEL_REPORT,
						`user`.FULL_NAME,
						`user`.USER_PICTURE,
						`user`.LEVEL';
			$this->db->join('post','post_report.ID_POST = post.ID_POST');
			$this->db->join('`user`','post.ID_USER = `user`.ID_USER');
			$this->db->where('post_report.ID_REPORT',$id_report);
		}
		$this->db->join('`user` user_report','post_report.ID_USER = user_report.ID_USER');
		$this->db->select($query);
		$this->db->from('post_report');
		if(!is_null($is_read)){
			$this->db->where('post_report.IS_READ',$is_read);
		}
		if (!empty($page)) {
			$per_post = $this->config->item('list_show');
			$page_now = ($page - 1) * $per_post;
			$this->db->offset($page_now);
			$this->db->limit($per_post);
		}
		$return = $this->db->get();
		return $return;
	}
	
	public function get_report_count($id_report=NULL, $is_read=NULL)
	{
		$query = '	count(post_report.ID_REPORT) as COUNT';
		if (!empty($id_report)) {
			$this->db->where('post_report.ID_REPORT',$id_report);
		}
		$this->db->select($query);
		$this->db->from('post_report');
		if(!is_null($is_read)){
			$this->db->where('post_report.IS_READ',$is_read);
		}
		$return = $this->db->get();
		return $return;
	}

	public function read_report($id_report)
	{
		$this->db->set('is_read',1);
		$this->db->where('id_report',$id_report);
		$this->db->update('post_report');
		return $this->get_report($id_report);
	}
}
