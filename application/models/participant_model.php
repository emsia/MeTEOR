<?php
class Participant_Model extends CI_Model {
	
	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_participant( $slug = FALSE )
	{
		if( $slug === FALSE ){
			$this->db->order_by('users.lastname', 'ASC');
			$query = $this->db->get_where( 'users', array('role' => 2) );
			return $query->result_array();
		}
		
		$query = $this->db->get_where( 'users', array('role' => 2) );
		return $query->result_array();
	}
	
	public function get_userid(  )
	{
		
		$query = $this->db->get_where( 'users', array('id' => $_POST['user_id']) ); 
		 return  $query->row_array();
	}
	
	public function get_users($data, $place)
	{
		$search = $data['search'];
		$where = "id LIKE '%$search%' OR username LIKE '%$search%' OR firstname LIKE '%$search%' 
			OR lastname LIKE '%$search%'";
		$this->db->where($where);
		$query = $this->db->get($place);
				
		return $query;
	}
}
