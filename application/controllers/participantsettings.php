<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class participantsettings extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('profile_model');
		$this->load->model('participantuser_model');
		$this->load->model('login_model');
		$this->load->library(array('session','form_validation'));
		$this->load->helper('url');
		
		if($this->islogged() == false){
			redirect("http://localhost/meteor/index.php/pages");
		}
		if(!$this->login_model->isValid($this->session->userdata('username'))){
			redirect("http://localhost/meteor/index.php/pages/invalid");
		}
	}

	public function index()
	{
		$data['title'] = 'MeTEOR | Settings';
		$this->load->helper('url');
		
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$data['userid'] = $uid['id'];

		$data['user'] = $this->participantuser_model->profileInfo($data['userid']);
		$data['addr'] = $this->participantuser_model->profileAddr($data['userid']);
		
		foreach( $data['addr'] as $row ){
			$data['street'] = $row['street'];			
			$data['neighborhood'] = $row['neighborhood'];
			$data['city'] = $row['city'];
		}
		
		$data['mobile'] = $this->participantuser_model->profileMobile($data['userid']);
		
		foreach( $data['mobile'] as $row )
			$data['number'] = $row['number'];
		
		$this->load->view('templates/indexparticipant', $data);
		$this->load->view('participantprofile/settings', $data);
		$this->load->view('templates/footerparticipant');
	}
	
	public function changeform(){
		
		$data['title'] = 'MeTEOR | Settings';
		
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$data['userid'] = $uid['id'];
		$data['user'] = $this->participantuser_model->profileInfo($data['userid']);
		
		$data['street'] = $_POST['street'];			
		$data['neighborhood'] = $_POST['neighborhood'];
		$data['city'] = $_POST['city'];
		
		$data['number'] = $_POST['number'];
			
		$this->load->view('templates/indexparticipant', $data);
		$this->load->view('participantprofile/settingsuser', $data);
		$this->load->view('templates/footerparticipant');
	}
	
	public function change(){
		$config = array(
			array(
				'field'   => 'street', 
                'label'   => 'Street', 
                'rules'   => ''
            ),
            array(
				'field'   => 'hood', 
				'label'   => 'Neighborhood', 
				'rules'   => ''
            ),
			array(
				'field'   => 'city', 
				'label'   => 'City', 
				'rules'   => ''
            ),
			array(
				'field'   => 'mobile', 
				'label'   => 'Mobile', 
				'rules'   => 'numeric'
            )
        );
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE){
			$this->index();
		}
		else{
			$mobile = $this->input->post('number');
			$street = $this->input->post('street');
			$hood = $this->input->post('neighborhood');
			$city = $this->input->post('city');
			$this->profile_model->changemobile($this->session->userdata('username'),$mobile);
			$this->profile_model->changeaddr($this->session->userdata('username'),$street,$hood,$city);
			$this->index();
		}
	}
	
	public function forgotform(){
		//session_start();
		$this->session->set_userdata('change', TRUE);
		//$_SESSION['change'] = TRUE;
		redirect(base_url('index.php/participantprofile'));
		/*$uid = $this->login_model->getuid($this->session->userdata('username'));

		header('Location: '.base_url('index.php/participantprofile').'?message='.$uid['slug']);*/
	}
	
	public function forgot(){
		$config = array(
			array(
				'field'   => 'newpass', 
                'label'   => 'New Password', 
                'rules'   => 'required|matches[pconf]'
            ),
            array(
				'field'   => 'pconf', 
				'label'   => 'Password Confirm', 
				'rules'   => 'required'
            )
        );
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE){
			$this->index();
		}
		else{
			$pword = $this->input->post('newpass');
			$this->profile_model->changepass($this->session->userdata('username'),$pword);
			$this->index();
		}
	}
}

?>