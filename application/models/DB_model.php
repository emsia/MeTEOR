<?php
class DB_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	
	public function get_managers($slug = FALSE)
	{
		if ($slug === FALSE)
		{
			$query = $this->db->get_where('users', array('role' => 1));
			return $query->result_array();
		}
		
		$query = $this->db->get_where('users', array('slug' => $slug));
		return $query->row_array();
	}
	
	public function set_managers()
	{
		$this->load->helper('url');
		
		$slug = url_title($this->input->post('title'), 'dash', TRUE);


//INSERT INTO `users`(`username`, `password`, `firstname`, `lastname`, `role`, `verified`) 
//VALUES ('user2@email.com', 'password', 'User', 'Two', 2, 1);
	
		$data = array(
			   'username' => $this->input->post('email'),
			   'password' => $this->input->post('password'),
			   'firstname' => $this->input->post('firstname'),
			   'lastname' => $this->input->post('lastname'),
			   'role' => 1,
			   'verified' => 1,
			   'slug' => $slug
			);
				
		return $this->db->insert('users', $data);
	}
}

