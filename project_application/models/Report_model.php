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
}
