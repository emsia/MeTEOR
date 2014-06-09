<?php
class login_model extends CI_Model{
	
	public function __construct()
	{
		$this->load->database();
		$this->load->library('phpmailer');
	}
	
	function counting( $where, $table, $value ){
		$this->db->where( $where, $value );
		$this->db->from( $table );
		return $this->db->count_all_results();
	}

	function verifyLog($uname,$pword){
		$query = $this->db->get_where('users',array('username' => $uname));
		foreach($query->result() as $row){
			$hash = sha1($pword);
			if(($uname === $row->username && $hash === $row->password)) 
				return true;
		}
		return false;
	}
	
	function getAllUsers(){
		$query = $this->db->get('users');
		return $query;
	}

	function getAllUsers_not_you($id){
		$this->db->where_not_in('id',$id);
		$query = $this->db->get('users');
		return $query;
	}

	function putData( $num = 0, $unique = 0, $CourseName = '' ){
		//echo $num;
		$email = $this->input->post('mail');
		$id = $this->saltgen(25);

		if( !$num ){
			$hpass = sha1($this->input->post('pass'));
			$data = array(
				'username' => $email,
				'password' =>  $hpass,
				'firstname' => ucwords(strtolower($this->input->post('fname'))),
				'middlename' => ucwords(strtolower($this->input->post('mname'))),
				'lastname' => ucwords(strtolower($this->input->post('lname'))),
				'role' => 2,
				'slug' => $id
			);
			if( !$unique ) $cont = $this->sendvalid($id,$email, 0);
			else { 
				$CourseName = str_replace("%20"," ",$CourseName);
				$cont = $this->sendvalid($id,$email, 3, '', $unique, $CourseName);
			}	
			if( $cont ) $this->db->insert('users', $data);
		}else{
			$query = $this->db->get_where('users',array('username' => $email));
			$row = $query->row_array();
			//echo $row['username'];
			if( empty($row['id']) ) return FALSE;
			else{
				//echo "TAMA";
				$true = $this->sendvalid($id,$email,1, $row['firstname']);
				//echo "    sdfsdf ".$true." fdsfsdfsdfsdf";
				if( $true ){
					$hpass = sha1($id);
					$dta = array(
						'slug' => $id,
						'password' => $hpass
					);
					$this->db->where('id', $row['id']);
					$this->db->update('users', $dta);
					return TRUE;
				}
				return FALSE;
			}
		}

	}
	
	public function sendvalid($ident,$mail, $num1, $name = '', $unique = 0, $CourseName = ''){		
		$to = $mail;
		$data['ident'] = $ident;
		$data['numS'] = $num1;
		$data['unique'] = $unique;
		$data['CourseName'] = $CourseName;
		$mail = new PHPMailer();  // create a new object
		$mail->IsSMTP(); // enable SMTP
		$mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true;  // authentication enabled
		$mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587; 
		$mail->Username = 'meteor.upitdc@gmail.com';  
		$mail->Password = 'meteor123';  

		$mail->SetFrom('noreply@localhost/meteor', 'MeTEOR Validator');

		if( $num1 == 3 ){
			$mail->Subject = '[MeTEOR] Attendance Confirmation';
			$data['kind'] = 'Confirm Attendance';
		}
		elseif( $num1 == 0 ){ 
			$mail->Subject = '[MeTEOR] Confirm Validation';
			$data['kind'] = 'Confirm Validation';
		}	
		else {
			$mail->Subject = '[MeTEOR] Password Change';
			$data['kind'] = 'Password Change';
			$data['firstname'] = $name;
		}	

		$mail->Body = $this->load->view('pages/sendFile', $data, TRUE);
		$mail->AddAddress($to);
		$mail->IsHTML(true);

		if(!$mail->Send()) {
			$error = 'Mail error: '.$mail->ErrorInfo; 
			return 0;
		} else {
			$error = 'Message sent!';
			return 1;
		}
	}
	
	function setValidation($ident){
		$this->db->where('slug',$ident);
		$this->db->update('users',array('verified' => 1));
		$query = $this->db->get_where('users',array('slug' => $ident));
		return $query->row_array();
	}
	
	function isValid($user){
		$query = $this->db->get_where('users',array('username' => $user));
		$row = $query->row_array();
		if($row['verified'] == 1){
			return true;
		}
		return false;
	}

	function getuid($name){
		$query = $this->db->get_where('users',array('username' => $name));
		return $query->row_array();
	}
	
	function getuser($pw){
		$query = $this->db->get_where('users',array('password' => $pw));
		return $query->row_array();
	}
	
	function forgot($user){
		$query = $this->db->get_where('users',array('username' => $user));
		$row = $query->row_array();
		$rand = $this->saltgen(25);
		if(empty($row['username'])){
			return false;
		}
		else{
			$this->db->update('users',array('password' => $rand),array('username' => $user));
			$this->sendpass($rand,$user);
			return true;
		}
	}
	
	function isReal($rand){
		$query = $this->db->get_where('users',array('password' => $rand));
		$row = $query->row_array();
		if(empty($row)){
			return false;
		}
		return true;
	}

	public function saltgen($max){
        $characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $i = 0;
        $salt = "";
        while ($i < $max) {
            $salt .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
            $i++;
        }
        return $salt;
	}

	public function validateUser( $user, $pass ){
		$query = $this->db->get_where('users',array('username' => $user));
		foreach($query->result() as $row){
			$hash = sha1($pass);
			if(($user === $row->username && $hash === $row->password) && $row->verified ) 
				return true;
		}
		return false;
	}

	public function getAdmins(){
		$query = $this->db->get_where('users', array('role' => 0));
		return $query;
	}
}