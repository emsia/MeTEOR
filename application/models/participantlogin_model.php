<?php
class participantlogin_model extends CI_Model{
		
	public function __construct()
	{
		$this->load->database();
		$this->load->library(array('email'));
	}
	function verifyLog($uname,$pword){
		$query = $this->db->get_where('users',array('username' => $uname));
		foreach($query->result() as $row){
			$hash = sha1($pword);
			if($uname === $row->username && $hash === $row->password) 
				return true;
		}
		return false;
	}
	
	function getuid($uname){
		$query = $this->db->get_where('users',array('username' => $uname));
		foreach($query->result() as $row){
			return $row;
		}
	}
	
	function putData(){
		$hpass = sha1($this->input->post('pass'));
		$email = $this->input->post('mail');
		$id = $this->saltgen(25);
		
		$data = array(
			'username' => $email,
			'password' =>  $hpass,
			'firstname' => $this->input->post('fname'),
			'lastname' => $this->input->post('lname'),
			'role' => 2
		);
		$this->db->insert('users', $data);
		//$this->sendvalid($id,$email);
	}
	
	public function sendvalid($ident,$mail){
		$this->email->to($mail);
		$this->email->from('noreply@localhost/meteor','MeTEOR Signup Validator');
		$this->email->subject('Confirm Validation');
		$this->email->message('Thank you for registering. Please click the proceeding link to confirm your registration: http://localhost/meteor/index.php/validate/' . $ident);
		if(!$this->email->send()){
			echo $this->email->print_debugger();
		}
	}
	
	function isVerified($id){
		$query = $this->db->get_where('users',array('username' => $id));
		foreach($query->result() as $row){
			if($row->verified == 0) return false;
		}
		return true;
	}

	private function saltgen($max){
        $characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $i = 0;
        $salt = "";
        while ($i < $max) {
            $salt .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
            $i++;
        }
        return $salt;
	}
}