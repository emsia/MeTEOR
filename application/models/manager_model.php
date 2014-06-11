<?php
class manager_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_managerLists($id){
		$query = $this->db->get_where( 'managers', array('user_id' => $id) );
		return $query->result_array();
	}
	
	public function get_results($data)
	{
		$search = $data['search'];
		
		$from = "users U, managers M";
		$where = "(U.role LIKE '%$search%' OR U.id LIKE '%$search%' OR M.id LIKE '%$search%' OR M.user_id LIKE '%$search%' OR U.username LIKE '%$search%'
			OR U.firstname LIKE '%$search%' OR U.lastname LIKE '%$search%') AND U.id = M.user_id";
				
		$this->db->from($from);
		$this->db->where($where);
		$this->db->order_by( 'U.lastname', 'ASC' );
		
		$query = $this->db->get();
		return $query;
	}
	
	public function get_managers($slug = FALSE)
	{
		if ($slug === FALSE)
		{
			$query = $this->db->get('users');
			return $query;
		}
		
		$query = $this->db->get_where('users', array('slug' => $slug));
		return $query;
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
	
	public function set_managers()
	{
		$this->load->helper('url');		
		$slug = url_title($this->input->post('title'), 'dash', TRUE);

		$this->load->library('phpmailer');
		$mail = new PHPMailer();

		$mail = new PHPMailer();  // create a new object
		$mail->IsSMTP(); // enable SMTP
		$mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true;  // authentication enabled
		$mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587; 
		$mail->Username = 'meteor.upitdc@gmail.com';  
		$mail->Password = 'meteor123';  
		$mail->Subject = '[MeTEOR] Managers';
		$mail->SetFrom('noreply@localhost/meteor', 'MeTEOR Notification');
		
		$a = array();
		$a['numS'] = 5;
		$a['kind'] = "Managers";
	
		//for ($i=0, $x=$index[$i];$i<$numOfdata;$i++) {
			
			$data = array(
			   'username' => $_POST['email'],
			   'password' => sha1($_POST['password']),
			   'firstname' => ucwords(strtolower($_POST['firstname'])),
			   'lastname' => ucwords(strtolower($_POST['lastname'])),
			   'role' => 1,
			   'verified' => 1,
			   'slug' => $this->saltgen(25)
			);	

			$a['firstname'] = ucwords(strtolower($_POST['firstname']));
			$a['username'] = $_POST['email'];
			$a['password'] = $_POST['password'];

			$mail->Body = $this->load->view('pages/sendFile', $a, TRUE);
			$mail->AddAddress($_POST['email']);
			$mail->IsHTML(true);//$mail->ClearAddresses(); 

			if(!$mail->Send()) {
				$error = 'Mail error: '.$mail->ErrorInfo; 
				return $error;
			}
			$mail->ClearAddresses();
		//}
		
		$this->db->insert('users', $data);
			
		$query = $this->db->get_where('users', array('username' => $_POST['email']));
		$array = $query->row_array();
					
		$this->db->set('user_id', $array['id']); 
		$this->db->set('status', 1); 
		$this->db->insert('managers');
		
		return ''; 
	}
		
	public function set_managerstatus()
	{
		$this->load->helper('url');
		
		$data = array(
			'status' => 1
		);
		
		$data2 = array(
			'status' => 0	
		);
		
		$this->db->where('user_id', $_POST['user_id']);
		
		if($_POST['status'] == 0){
			$this->db->update('managers', $data);
			$this->db->where('id', $_POST['user_id']);
			$this->db->update('users', array('role' => 1));
		}
		else{
			$this->db->update('managers', $data2);
			$this->db->where('id', $_POST['user_id']);
			$this->db->update('users', array('role' => 2));
		}

		return;
	}
	
	public function set_managerpromotion()
	{
		$this->load->helper('url');
		
		$data = array(
			'role' => 1
		);
		
		$data2 = array(
			'role' => 0	
		);
		
		$this->db->where('id', $_POST['id']);
		
		if($_POST['role'] == 0) $this->db->update('users', $data);
		else $this->db->update('users', $data2);

		return;
	}
}

