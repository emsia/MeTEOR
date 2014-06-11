<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class adminsettings extends CI_Controller {

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

	public function change(){
		$num = $_POST['num'];
		$config = array(
			array(
				'field'   => 'street', 
                'label'   => 'Street', 
                'rules'   => ''
            ),
            array(
				'field'   => 'neighborhood', 
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
			$this->index($num);
		}
		else{
			$mobile = $this->input->post('number');
			$street = $this->input->post('street');
			$hood = $this->input->post('neighborhood');
			$city = $this->input->post('city');
			$this->profile_model->changemobile($this->session->userdata('username'),$mobile);
			$this->profile_model->changeaddr($this->session->userdata('username'),$street,$hood,$city);
			$this->index($num);
		}
	}
	
	public function forgotform( $num = 0 ){
		 
		$data['title'] = 'MeTEOR | Settings';
		
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$data['userid'] = $uid['id'];
		$data['numS'] = $num;
		$data['user'] = $this->participantuser_model->profileInfo($data['userid']);
		$data['addr'] = $this->participantuser_model->profileAddr($data['userid']);
		
		foreach( $data['addr'] as $row ){
			$data['street'] = $row['street'];			
			$data['neighborhood'] = $row['neighborhood'];
			$data['city'] = $row['city'];
		}
		
		$data['mobile'] = $this->participantuser_model->profileMobile($data['userid']);
		foreach( $data['mobile'] as $row ){		
			$data['number'] = $row['number'];
		}
		
		if( !$num ) $this->load->view('templates/indexadmin', $data);
		else $this->load->view('templates/indexmanager', $data);
		
		$this->load->view('adminprofile/settingspass', $data);
		
		if( !$num ) $this->load->view('templates/footeradmin');
		else $this->load->view('templates/footerman');
	}
	
	public function forgot(){
		$num = $_POST['num'];
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
			$this->index( $num );
		}
		else{
			$pword = $this->input->post('newpass');
			$this->profile_model->changepass($this->session->userdata('username'),$pword);
			$this->index( $num );
		}
	}
}

?>