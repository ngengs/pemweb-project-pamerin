<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model{

	public function __construct()
    {
        parent::__construct();
		$this->load->database();
    }
	
	public function check($username=NULL, $password=NULL)
	{
		$this->db->select('`user`.ID_USER,
							`user`.USERNAME,
							`user`.EMAIL,
							`user`.FULL_NAME,
							`user`.USER_PICTURE,
							`user`.DESCRIPTION,
							`user`.`LEVEL`,
							`user`.IS_AKTIF');
		$this->db->from('`user`');
		$this->db->where('USERNAME',$username);
		if(!empty($password))
		{
			$this->db->where('PASSWORD',md5($password));
		}
		$result = $this->db->get();
		return $result;
	}
	
	public function register($username,$password,$email,$full_name,$level=2){
		$data = array(
			'username'=>$username,
			'email'=>$email,
			'password'=>md5($password),
			'full_name'=>$full_name,
			'level'=>$level,
			'is_aktif'=>1
		);
		$this->db->set('id_user', 'GENERATEID()', FALSE);
		$result = $this->db->insert('`user`',$data);
		return $result;
	}
	
	public function get_following($id_user,$just_id=FALSE, $is_aktif=1, $page=NULL)
	{
		$query = "";
		if(!$just_id){
			$query = "	user_follow.ID_USER,
						user_follow.ID_USER_FOLLOW as FOLLOWING_ID,
						user_follow.FOLLOW_DATE,
						`user`.ID_USER,
						`user`.USERNAME,
						`user`.FULL_NAME,
						`user`.USER_PICTURE,
						`user`.`LEVEL`,
						`user`.IS_AKTIF as USER_IS_AKTIF";
		}
		else{
			$query = "	user_follow.ID_USER_FOLLOW as FOLLOWING_ID";
		}
		$this->db->select($query);
		$this->db->from('user_follow');
		$this->db->join('`user`','user_follow.ID_USER_FOLLOW = `user`.ID_USER');
		$this->db->where('user_follow.ID_USER',$id_user);
		$this->db->where('`user`.IS_AKTIF',$is_aktif);
		$this->db->order_by('user_follow.FOLLOW_DATE','DESC');
		if(!empty($page)){
			$per_post = $this->config->item('user_show');
			$page_now = ($page - 1) * $per_post;
			$this->db->offset($page_now);
			$this->db->limit($per_post);
		}
		$result = $this->db->get();
		return $result;
	}
	
	public function get_following_count($id_user,$is_aktif=1)
	{
		$query = "count(user_follow.ID_USER) as COUNT";
		$this->db->select($query);
		$this->db->from('user_follow');
		$this->db->join('`user`','user_follow.ID_USER_FOLLOW = `user`.ID_USER');
		$this->db->where('user_follow.ID_USER',$id_user);
		$this->db->where('`user`.IS_AKTIF',$is_aktif);
		$result = $this->db->get();
		return $result;
	}
	
	public function get_follower($id_user,$just_id=FALSE, $is_aktif=1, $page=NULL)
	{
		$query = "";
		if(!$just_id){
			$query = "	user_follow.ID_USER,
						user_follow.ID_USER_FOLLOW as FOLLOWER_ID,
						user_follow.FOLLOW_DATE,
						`user`.ID_USER,
						`user`.USERNAME,
						`user`.FULL_NAME,
						`user`.USER_PICTURE,
						`user`.`LEVEL`,
						`user`.IS_AKTIF as USER_IS_AKTIF";
		}
		else{
			$query = "	user_follow.ID_USER_FOLLOW as FOLLOWER_ID";
		}
		$this->db->select($query);
		$this->db->from('user_follow');
		$this->db->join('`user`','user_follow.ID_USER = `user`.ID_USER');
		$this->db->where('user_follow.ID_USER_FOLLOW',$id_user);
		$this->db->where('`user`.IS_AKTIF',$is_aktif);
		$this->db->order_by('user_follow.FOLLOW_DATE','DESC');
		if(!empty($page)){
			$per_post = $this->config->item('user_show');
			$page_now = ($page - 1) * $per_post;
			$this->db->offset($page_now);
			$this->db->limit($per_post);
		}
		$result = $this->db->get();
		return $result;
	}
	
	public function get_follower_count($id_user,$is_aktif=1)
	{
		$query = "count(user_follow.ID_USER) as COUNT";
		$this->db->select($query);
		$this->db->from('user_follow');
		$this->db->join('`user`','user_follow.ID_USER = `user`.ID_USER');
		$this->db->where('user_follow.ID_USER_FOLLOW',$id_user);
		$this->db->where('`user`.IS_AKTIF',$is_aktif);
		$result = $this->db->get();
		return $result;
	}

	public function follow_user($id_user,$id_to_follow){
		$date = date("Y-m-d H:i:s");	
		$data = array('ID_USER' => $id_user,
					  'ID_USER_FOLLOW'=>$id_to_follow,
					  'FOLLOW_DATE'=>$date
					   );
		$return = $this->db->insert('user_follow',$data);
		return $return;
	}
	
	public function unfollow_user($id_user,$id_to_follow)
	{
		$this->db->where('ID_USER', $id_user);
		$this->db->where('ID_USER_FOLLOW', $id_to_follow);
		
		$result = $this->db->delete('user_follow');	
		return $result;
	}
}