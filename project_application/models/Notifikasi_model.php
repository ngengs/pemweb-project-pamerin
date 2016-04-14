<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifikasi_model extends CI_Model{

	public function __construct()
    {
        parent::__construct();
		$this->load->database();
    }	
	
	public function count_notif($id_user=NULL, $read=NULL)
	{
		$this->db->select('count(user_notifikasi.ID_NOTIFIKASI) as COUNT');
		$this->db->from('user_notifikasi');
		$this->db->join('notifikasi','user_notifikasi.ID_NOTIFIKASI = notifikasi.ID_NOTIFIKASI');
		$this->db->where('user_notifikasi.ID_USER',$id_user);
		if(!is_null($read)){
			$this->db->where('user_notifikasi.IS_READ',$read);
		}
		$result = $this->db->get();
		return $result;
	}
	
	public function get_notif($id_user=NULL,$id_notif=NULL,$page=NULL)
	{
		$query='user_notifikasi.ID_USER,
				user_notifikasi.ID_NOTIFIKASI,
				user_notifikasi.IS_READ,
				notifikasi.JUDUL,
				notifikasi.DATE_NOTIFIKASI';
		if(!empty($id_notif)){
			$query.=",notifikasi.PESAN";
			$this->db->where('user_notifikasi.ID_NOTIFIKASI',$id_notif);
		}
		if(!empty($id_user)){
			$this->db->where('user_notifikasi.ID_USER',$id_user);
		}
		if(!empty($page)){
			$per_post = $this->config->item('list_show');
			$page_now = ($page - 1) * $per_post;
			$this->db->offset($page_now);
			$this->db->limit($per_post);
		}
		$this->db->select($query);
		$this->db->join('notifikasi','user_notifikasi.ID_NOTIFIKASI = notifikasi.ID_NOTIFIKASI');
		$this->db->from('user_notifikasi');
		$this->db->order_by('notifikasi.DATE_NOTIFIKASI','DESC');
		$return = $this->db->get();
		return $return;
	}
	
	public function insert_notif($data, $user=array())
	{
		$this->db->insert('notifikasi',$data);
		if(!empty($user)){
			$this->db->insert_batch('user_notifikasi',$user);
		}
	}
	
	public function update_notif_user($data,$id_notif,$id_user)
	{
		$this->db->where('id_notifikasi',$id_notif);
		$this->db->where('id_user',$id_user);
		$this->db->update('user_notifikasi',$data);
	}
	
	public function read_notif($id_notif,$id_user)
	{
		$data = array('is_read'=>1);
		$this->update_notif_user($data, $id_notif, $id_user);
		return $this->get_notif($id_user,$id_notif);
	}
}
