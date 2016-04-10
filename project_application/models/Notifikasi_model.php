<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifikasi_model extends CI_Model{

	public function __construct()
    {
        parent::__construct();
		$this->load->database();
    }	
	
	public function count_notif($id_user=NULL, $read=0)
	{
		$this->db->select('user_notifikasi.ID_NOTIFIKASI,
							user_notifikasi.IS_READ,
							notifikasi.JUDUL,
							notifikasi.PESAN,
							user_notifikasi.ID_USER');
		$this->db->from('user_notifikasi');
		$this->db->join('notifikasi','user_notifikasi.ID_NOTIFIKASI = notifikasi.ID_NOTIFIKASI');
		$this->db->where('user_notifikasi.ID_USER',$id_user);
		$this->db->where('user_notifikasi.IS_READ',$read);
		$result = $this->db->get();
		return $result;
	}
}
