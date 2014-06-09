<?php

class CSU_Controller extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->model('login_model');
	}
	
	public function log($uname){
		$this->session->set_userdata('logged',true);
		$this->session->set_userdata('username',$uname);
	}
	
	public function unlog(){
		$this->session->sess_destroy();
		redirect('http://localhost/index.php/pages');
	}
	
	public function islogged(){
		$user = $this->session->userdata('username');
		$sess = $this->session->userdata('logged');
		if(empty($user) || empty($sess) ){
			$data['title'] = "Login";
			
			$this->load->view('templates/indexheader',$data);
			$this->load->view('pages/login');
			$this->load->view('templates/footer');
			return false;
		}
		return true;
	}
}