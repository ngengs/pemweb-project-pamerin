<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post_model extends CI_Model{

	public function __construct()
    {
        parent::__construct();
		$this->load->database();
    }
	
	public function create($id_user=NULL,$id_post=NULL,$description=NULL,$images = array(), $is_aktif=1)
	{
		/**
		 * Insert into table post
		 */
		$date = date("Y-m-d H:i:s");
		$data = array(
			'id_post'=>$id_post,
			'date_post'=>$date,
			'id_user'=>$id_user,
			'description'=>$description,
			'is_aktif'=>$is_aktif
		);
		$result = $this->db->insert('POST', $data);
		/**
		 * Insert into table picture if table post success
		 */
		if($result && !empty($images)){
			$data_image = array();
			foreach ($images as $key => $value) {
				$data_image[]= array(
					'id_post'=>$id_post,
					'path'=>$value
				);	
			}
			$result = $this->db->insert_batch('POST_PICTURE', $data_image);
		}
		return $result;
	}
	
	private function generate_get_timeline_query($id_user,$id_following = array() ){
		$query = "	post.ID_POST,
			post.DATE_POST,
			post.ID_USER,
			post.DESCRIPTION,
			post.IS_AKTIF AS POST_IS_AKTIF,
			`user`.ID_USER,
			`user`.USERNAME,
			`user`.USER_PICTURE,
			`user`.IS_AKTIF AS USER_IS_AKTIF,
			`user`.LEVEL,
			post_like.IS_LIKE as MY_LIKE";
		$this->db->select($query);
		$this->db->join('`user`','`user` ON post.ID_USER = `user`.ID_USER');
		$this->db->join('`post_like`','post_like.ID_POST = post.ID_POST AND post_like.ID_USER = '.$this->db->escape($id_user),'left outer');
		$this->db->from('post');
		if(!empty($id_following)){
			$this->db->where_in('post.ID_USER', $id_following);
		}
		$this->db->where('`user`.IS_AKTIF',1);
		$this->db->where('post.IS_AKTIF',1);
		$this->db->order_by('post.DATE_POST','DESC');
	}
	
	public function get_timeline($id_user,$id_following = array() , $page=1, $search=NULL){
		
		$this->generate_get_timeline_query($id_user,$id_following);
		$per_post = $this->config->item('timeline_post');
		$page_now = ($page - 1) * $per_post;
		$this->db->offset($page_now);
		if(!empty($search)){
			$this->db->like('LOWER(post.DESCRIPTION)',strtolower($search));
		}
		$this->db->limit($per_post);
		$post = $this->db->get();
		$return=array();
		if(!empty($post->result())){
			$temp = $post->result();
			foreach ($temp as $key => $value) {
				$temp_photos = $this->get_photos_timeline($value->ID_POST);
				$photos = array();
				foreach ($temp_photos as $key_photos => $value_photos) {
					$photos[]=$value_photos->PATH;
				}
				$comment = 0;
				$temp_comment = $this->count_comment($value->ID_POST);
				if(!empty($temp_comment)){
					$comment = $temp_comment[0]->COUNT;
				}
				$like = 0;
				$temp_like = $this->count_like($value->ID_POST);
				if(!empty($temp_like)){
					$like = $temp_like[0]->COUNT;
				}
				$value->LIKE_COUNT = $like;
				$value->COMMENT_COUNT = $comment;
				$value->PHOTOS = $photos;
				$return[]=$value;
			}
		}
		return $return;
	}
	
	public function get_timeline_count($id_user,$id_following=array(), $search=NULL){
		$this->generate_get_timeline_query($id_user,$id_following);
		if(!empty($search)){
			$this->db->like('LOWER(post.DESCRIPTION)',strtolower($search));
		}
		return $this->db->count_all_results();
	}
	
	public function get_single_post($username,$id_post,$id_user){
		$this->generate_get_timeline_query($id_user);
		$this->db->where('post.ID_POST',$id_post);
		$this->db->where('`user`.USERNAME',$username);
		$post = $this->db->get();
		$return=array();
		if(!empty($post->result())){
			$temp = $post->result();
			foreach ($temp as $key => $value) {
				$temp_photos = $this->get_photos_timeline($value->ID_POST);
				$photos = array();
				foreach ($temp_photos as $key_photos => $value_photos) {
					$photos[]=$value_photos->PATH;
				}
				$comment = 0;
				$temp_comment = $this->count_comment($value->ID_POST);
				if(!empty($temp_comment)){
					$comment = $temp_comment[0]->COUNT;
				}
				$like = 0;
				$temp_like = $this->count_like($value->ID_POST);
				if(!empty($temp_like)){
					$like = $temp_like[0]->COUNT;
				}
				$temp_list_comment = $this->get_comment($value->ID_POST);
				$list_comment = array();
				if(!empty($temp_list_comment->result())){
					$temp_list = $temp_list_comment->result();
					foreach($temp_list as $key_com => $val_com){
						$list_comment[] = $val_com;
					}
				}
				$value->COMMENT_LIST = $list_comment;
				$value->LIKE_COUNT = $like;
				$value->COMMENT_COUNT = $comment;
				$value->PHOTOS = $photos;
				$return[]=$value;
			}
		}
		return $return;
	}
	
	public function get_comment($id_post,$is_aktif=1){
		$this->db->select('post_comment.ID_COMMENT,
							post_comment.ID_USER,
							post_comment.DATE_COMMENT,
							post_comment.`COMMENT`,
							post_comment.IS_AKTIF,
							`user`.USERNAME,
							`user`.USER_PICTURE,
							`user`.LEVEL');
		$this->db->from('post_comment');
		$this->db->join('`user`','post_comment.ID_USER = `user`.ID_USER');
		$this->db->where('post_comment.ID_POST',$id_post);
		$this->db->where('post_comment.IS_AKTIF',$is_aktif);
		$this->db->where('`user`.IS_AKTIF',$is_aktif);
		$this->db->order_by('post_comment.DATE_COMMENT','ASC');
		$result = $this->db->get();
		return $result;
	}
	
	public function get_photos_timeline($id_post){
		$query = "PATH";
		$this->db->select($query);
		$this->db->from('post_picture');
		$this->db->where('id_post',$id_post);
		$result = $this->db->get();
		return $result->result();
	}
	
	public function count_comment($id_post, $is_aktif=1){
		$this->db->select('count(ID_POST) as COUNT');
		$this->db->from('post_comment');
		$this->db->where('ID_POST',$id_post);
		$this->db->where('IS_AKTIF',$is_aktif);
		$result = $this->db->get();
		return $result->result();
	}
	
	public function count_like($id_post, $is_like=1){
		$this->db->select('count(ID_POST) as COUNT');
		$this->db->from('post_like');
		$this->db->where('ID_POST',$id_post);
		$this->db->where('IS_LIKE',$is_like);
		$result = $this->db->get();
		return $result->result();
	}
	
	public function like_post($id_post,$id_user){
		$this->db->select('ID_POST');
		$this->db->from('post_like');
		$this->db->where('ID_POST',$id_post);
		$this->db->where('ID_USER',$id_user);
		$check = $this->db->get();
		if(empty($check->result())){
			$data = array(
				'ID_POST'=>$id_post,
				'ID_USER'=>$id_user,
				'IS_LIKE'=>1
			);
			$result = $this->db->insert('post_like', $data);
		}else{
			$result = false;
		}
		return $result;
	}
	
	public function unlike_post($id_post,$id_user){
		$this->db->where('ID_POST', $id_post);
		$this->db->where('ID_USER', $id_user);
		$result = $this->db->delete('post_like');
		return $result;
	}

	public function edit_post($id_post,$caption,$id_user=NULL){
		$data = array('DESCRIPTION'=>$caption);
		$this->db->set($data);
		$this->db->where('ID_POST',$id_post);
		if(!empty($id_user)){
			$this->db->where('ID_USER',$id_user);
		}
		$result = $this->db->update('post');
		return $result;
	}
	
	public function delete_post($id_post,$id_user=NULL){
		$data = array('IS_AKTIF'=>0);
		$this->db->set($data);
		$this->db->where('ID_POST',$id_post);
		if(!empty($id_user)){
			$this->db->where('ID_USER',$id_user);
		}
		$result = $this->db->update('post');
		return $result;
	}

	public function create_comment($id_post,$id_user,$comment,$is_aktif=1){
		$date = date("Y-m-d H:i:s");
		$data = array(
			'id_post'=>$id_post,
			'date_comment'=>$date,
			'id_user'=>$id_user,
			'comment'=>$comment,
			'is_aktif'=>$is_aktif
		);
		$this->db->set('ID_COMMENT','GENERATEID()',FALSE);
		$result = $this->db->insert('POST_COMMENT', $data);
		return $result;
	}
	
	public function edit_comment($id_comment,$caption){
		$data = array('COMMENT'=>$caption);
		$this->db->set($data);
		$this->db->where('ID_COMMENT',$id_comment);
		$result = $this->db->update('post_comment');
		return $result;
	}
	
	
	public function delete_comment($id_comment,$id_user=NULL){
		$data = array('IS_AKTIF'=>0);
		$this->db->set($data);
		$this->db->where('ID_COMMENT',$id_comment);
		if(!empty($id_user)){
			$this->db->where('ID_USER',$id_user);
		}
		$result = $this->db->update('post_comment');
		return $result;
	}
}
