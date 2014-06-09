<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class managervalidation extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('validation_model', 'vm');
		$this->load->model('login_model');
		$this->load->library('session');
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
		
		$title['title'] = 'MeTEOR | Validation';
	
		$this->load->helper('url');
		
		$this->load->view('templates/indexmanager', $title);
		$this->load->view('managervalidation/index');
		$this->load->view('templates/footerman');
	}
	
	public function search_results()
	{
	
		$title['title'] = 'MeTEOR | Validation';
		$data['search'] = $_POST['search'];
		$data['option'] = $_POST['option'];
		
		$a = array();
		$a['counter']=0;
		
		$result = $this->vm->get_results($data);
		
		foreach($result->result() as $row)
		{
			$b = array();
			$c = array();
			$d = array();
			$param = array();
			
			$a['id'][] = $row->id;
			$a['username'][] = $row->username;
			$a['firstname'][] = $row->firstname;
			$a['lastname'][] = $row->lastname;
			
			$param['id'] = $row->id;
			$result1 = $this->vm->get_reserved($param);
			$result2 = $this->vm->get_cashed($param);
			$result3 = $this->vm->get_banked($param);
			
			foreach($result1->result() as $row)
			{
				$b[] = $row->id;
			}
			foreach($result2->result() as $row)
			{
				$c[] = $row->id;
			}
			foreach($result3->result() as $row)
			{
				$d[] = $row->id;
			}
			
			$holder = array_diff($b, $c, $d);
			
			if(empty($holder)) $a['validated'][] = 1;
			else $a['validated'][] = 0;
			
			$a['counter']++;
		}
	
		$this->load->helper('url');
		
		$this->load->view('templates/indexmanager', $title);
		$this->load->view('managervalidation/search', $a);
		$this->load->view('templates/footerman');
		
	}
	
	public function validate()
	{

		$title['title'] = 'MeTEOR | Validation';
		$temp = $_POST['temp'];
		$cbn = $_POST['cbn'];
		//$cbn = 0 if null, 1 if cash, 2 if bank
		
		$data['search'] = $temp;
		$data['option'] = 'id';
		
		$a = array();
		$b = array();
		$c = array();
		$d = array();
		$e = array();
		$param = array();
		
		$result = $this->vm->get_results($data);
		
		foreach($result->result() as $row)
		{
			$a['id'] = $row->id;
			$a['username'] = $row->username;
			$a['firstname'] = $row->firstname;
			$a['lastname'] = $row->lastname;
		}
		
		$param['id'] = $a['id'];		
		$result1 = $this->vm->get_reserved($param);
		$result2 = $this->vm->get_cashed($param);
		$result3 = $this->vm->get_banked($param);
			
		foreach($result1->result() as $row)
		{
			$b[] = $row->id;
		}
		foreach($result2->result() as $row)
		{
			$c[] = $row->id;
		}
		foreach($result3->result() as $row)
		{
			$d[] = $row->id;
		}
		
		$holder = array_diff($b, $c, $d);	
		$a['counter'] = count($holder);
		
		foreach($holder as $h)
		{
			$e['id'] = $h;
			$results = $this->vm->get_courses($e);
			foreach($results->result() as $row)
			{
				$a['cid'][] = $row->id;
				$a['name'][] = $row->name;
				$a['description'][] = $row->description;
				$a['cost'][] = $row->cost;
				$a['start'][] = $row->start;
				$a['end'][] = $row->end;
				$a['reserved'][] = $row->reserved;
				$a['available'][] = $row->available;
				$a['paid'][] = $row->paid;
			}
		}
		
		$this->load->helper('url');
		
		$this->load->view('templates/indexmanager', $title);
		
		if($cbn == 0) $this->load->view('managervalidation/validate', $a);
		elseif($cbn == 1) $this->load->view('managervalidation/cash', $a);
		else $this->load->view('managervalidation/bank', $a);
		
		$this->load->view('templates/footerman');
	} 

	public function payment() 
	{

		$title['title'] = 'MeTEOR | Validation';	
		$temp = $_POST['temp'];
		$cbn = $_POST['cbn'];
		//$cbn = 1 if cash, 2 if bank
		
		$a = array();
		$b = array();
		$c = array();
		$d = array();
		$e = array();
		$param = array();
		
		$param['id'] = $temp;		
		$result1 = $this->vm->get_reserved($param);
		$result2 = $this->vm->get_cashed($param);
		$result3 = $this->vm->get_banked($param);
			
		foreach($result1->result() as $row)
		{
			$b[] = $row->id;
		}
		foreach($result2->result() as $row)
		{
			$c[] = $row->id;
		}
		foreach($result3->result() as $row)
		{
			$d[] = $row->id;
		}
		
		$holder = array_diff($b, $c, $d);	
		$a['counter'] = count($holder);
		
		foreach($holder as $h)
		{
			$e['id'] = $h;
			$results = $this->vm->get_courses($e);
			foreach($results->result() as $row)
			{
				$a['cid'][] = $row->id;
				$a['cost'][] = $row->cost;
				$a['reserved'][] = $row->reserved;
				$a['available'][] = $row->available;
				$a['paid'][] = $row->paid;
			}
		}
		$i=0;
		foreach($holder as $h)
		{
			$data['user_id'] = $temp;
			$data['course_id'] = $h;
			$data['reserved'] = $a['reserved'][$i];
			$data['paid'] = $a['paid'][$i];
			if($cbn == 1) 
			{
				$data['cbn'] = 1;
				$data['amount'] = $a['cost'][$i];
				$data['ornumber'] = $_POST['ornumber'];
			}
			else
			{
				$data['cbn'] = 2;
				$data['bankname'] = $_POST['bankname'];
				$data['bankbranch'] = $_POST['bankbranch'];
				$data['transaction_id'] = $_POST['transaction_id'];	
			}
			$this->vm->make_payment($data);
			
			$i++;
		}
				
		$this->load->view('templates/indexmanager', $title);
		$this->load->view('managervalidation/index');
		$this->load->view('templates/footerman');
	}

}