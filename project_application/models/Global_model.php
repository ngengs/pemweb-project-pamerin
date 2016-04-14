<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Global_model extends CI_Model{

	public function __construct()
    {
        parent::__construct();
		$this->load->database();
    }
	
	public function generateid()
	{
		$id = NULL;
		$this->db->select('GENERATEID() as ID',FALSE);
		$result = $this->db->get();
		if(!empty($result->result())){
			$temp = $result->result();
			$id = $temp[0]->ID;
		}
		return $id;
	}
	
	public function count_notif($id_user=NULL, $read=0)
	{
		$this->db->select('count(user_notifikasi.ID_NOTIFIKASI) as COUNT');
		$this->db->from('user_notifikasi');
		$this->db->join('notifikasi','user_notifikasi.ID_NOTIFIKASI = notifikasi.ID_NOTIFIKASI');
		$this->db->where('user_notifikasi.ID_USER',$id_user);
		$this->db->where('user_notifikasi.IS_READ',$read);
		$result = $this->db->get();
		return $result;
	}
	
	public function count_report($read=0)
	{
		$this->db->select('count(ID_REPORT) as COUNT');
		$this->db->from('post_report');
		$this->db->where('post_report.IS_READ',$read);
		$result = $this->db->get();
		return $result;
	}
	
}
