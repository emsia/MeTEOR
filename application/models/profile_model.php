<?php
class profile_model extends CI_Model{
	
	public function __construct()
	{
		$this->load->database();
	}
	
	function getInfo($info){
		$query = $this->db->get_where('users',array('username' => $info));
		return $query->row_array();
	}
	
	function changepass($user,$newpass){
		$this->db->update('users',array('password' => sha1($newpass)),array('username'=>$user));
	}
	
	function changemobile($user,$newmob){
		$query = $this->db->get_where('users',array('username' => $user));
		$result = $query->row_array();
		$querytwo = $this->db->get_where('mobilenumbers',array('user_id' => $result['id']));
		$resulttwo = $querytwo->row_array();
		if( !empty($newmob) ){
			if(!empty($resulttwo['user_id'])){
				$this->db->update('mobilenumbers',array('number' => $newmob),array('user_id' => $result['id']));
			}
			else{
				$data = array(
						'user_id' => $result['id'],
						'number' => $newmob
						);
				$this->db->insert('mobilenumbers',$data);
			}
		}	
	}
	
	function changeaddr($user,$st,$hood,$city){
		$query = $this->db->get_where('users',array('username' => $user));
		$result = $query->row_array();
		$querytwo = $this->db->get_where('addresses',array('user_id' => $result['id']));
		$resulttwo = $querytwo->row_array();
		
		if( !empty($st) && (!empty($hood) && !empty($city)) ){
			if(!empty($resulttwo['user_id'])){
				$data = array(
						'street' => $st,
						'city' => $city,
						'neighborhood' => $hood
						);
				$this->db->update('addresses',$data,array('user_id' => $result['id']));
			}
			else{
				$data = array(
						'user_id' => $result['id'],
						'street' => $st,
						'city' => $city,
						'neighborhood' => $hood
						);
				$this->db->insert('addresses',$data);
			}
		}	
	}
	
}