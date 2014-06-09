<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Temp extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('login_model');
		$this->load->helper('url');
		$this->load->library(array('form_validation','session'));
		$this->load->model('course_model');	
	}

	public function forgotpw( $error = '' ){
		$data['title'] = "MeTEOR | Login";

		$data['error'] = "";
		if( !empty($error) ) $data['error'] = $error;

		$this->load->view('templates/indexheader',$data);
		$this->load->view('pages/forgot',$data);
		$this->load->view('templates/footer');
	}	
}

?>