<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class validation extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('validation_model','vm');
		$this->load->model('login_model');
		$this->load->model('participantuser_model');
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
		
		$this->load->view('templates/indexadmin', $title);
		$this->load->view('validation/index');
		$this->load->view('templates/footeradmin');
	}
	
	public function changeForms(){
		$userid = $_POST['temp'];
		$tempId = $_POST['tempId'];
		$man = $_POST['manager'];
		$tag = $_POST['tag'];

		$query = $this->participantuser_model->getDB('users','id',$userid,'','',0);
		$query = $query->result_array();

		if($query[0]['form']==0){
			$data = array(
				'form' => 1
			);
		}else{
			$data =  array(
				'form' => 0
			);
		}

		$this->db->where('id', $query[0]['id']);
		$this->db->update('users', $data);

		include_once('course_temp.php');
		$me = new course_temp;

		$me->seeRequest( $tempId, $man, $tag );
		return;
	}

	public function search_reports($var, $num = 0, $starting = 0, $ending = 0)
	{
		$title['title'] = 'MeTEOR | Search Users';
		$data['search'] = $var;
		
		$var1 = $this->input->post('type');
		if( !$num || $var === "COURSE" )redirect('http://localhost/meteor/index.php/course/reports_search/'.$var1.'');	
		
		$a = array();
		$a['counter']=0;
		
		$result = $this->vm->get_results($data);
		
		foreach($result->result() as $row)
		{
			$b = array();
			$c = array();
			$d = array();
			$e = array();
			$param = array();
			
			$a['id'][] = $row->id;
			$a['username'][] = $row->username;
			$a['firstname'][] = $row->firstname;
			$a['lastname'][] = $row->lastname;
			
			$param['id'] = $row->id;
			$result1 = $this->vm->get_reserved($param);
			$result2 = $this->vm->get_payment($param);
			$result4 = $this->vm->get_refund($param);
			
			foreach($result1->result() as $row)
			{
				$b[] = $row->id;
			}
			foreach($result2->result() as $row)
			{
				$c[] = $row->id;
			}
			foreach($result4->result() as $row)
			{
				$e[] = $row->course_id;
			}
			
			$holder = array_diff($b, $c);
			$a['hold'] = $holder;
			if(empty($holder)) $a['validated'][] = 1;
			else $a['validated'][] = 0;
			if(empty($e))  $a['refunded'][] = 1;
			else $a['refunded'][] = 0;
			
			$a['counter']++;
		}
	
		$this->load->helper('url');
		
		if( !$num ){
			$this->load->view('templates/indexadmin', $title);
			$this->load->view('validation/search', $a);
			$this->load->view('templates/footeradmin');
		}
		else{
			$a['starting1'] = $starting;
			$a['ending1'] = $ending;

			$data['title'] = "MeTEOR | Search Results";
			$this->load->view('templates/indexadmin', $data);
			$this->load->view('course/wat', $a);
			$this->load->view('templates/footeradmin');
		}
	}
	
	public function search_results($var)
	{
		$title['title'] = 'MeTEOR | Search Users';
		$data['search'] = $var;
		
		$var1 = $this->input->post('type');
		if( $var === "COURSE" )redirect('http://localhost/meteor/index.php/course/search_findTemp/'.$var1.'');	
		
		$a = array();
		include_once('course_temp.php');
		$me = new course_temp;

		$r = $me->listCourseUsers();
		$a['array'] = $r['array'];
		$a['count_All'] = $r['count'];

		$a['counter']=0;
		
		$result = $this->vm->get_results($data);
		
		foreach($result->result() as $row)
		{
			$b = array();
			$c = array();
			$d = array();
			$e = array();
			$param = array();
			
			$a['id'][] = $row->id;
			$a['username'][] = $row->username;
			$a['firstname'][] = $row->firstname;
			$a['lastname'][] = $row->lastname;
			
			$param['id'] = $row->id;
			$result1 = $this->vm->get_reserved($param);
			$result2 = $this->vm->get_payment($param);
			$result4 = $this->vm->get_refund($param);
			
			foreach($result1->result() as $row)
			{
				$b[] = $row->id;
			}
			foreach($result2->result() as $row)
			{
				$c[] = $row->id;
			}
			foreach($result4->result() as $row)
			{
				$e[] = $row->course_id;
			}
			
			$holder = array_diff($b, $c);
			$a['hold'] = $holder;
			if(empty($holder)) $a['validated'][] = 1;
			else $a['validated'][] = 0;
			if(empty($e))  $a['refunded'][] = 1;
			else $a['refunded'][] = 0;
			
			$a['counter']++;
		}
	
		$this->load->helper('url');
		$a['active_nav'] = 'VIEW';
		$a['manager'] = 0;
		$this->load->view('templates/indexadmin', $title);
		$this->load->view('templates/sidebar_admin', $a);
		$this->load->view('validation/search_find', $a);
		//$this->load->view('templates/footeradmin');
		
	}
	
	public function manager_search_results($var)
	{
		$title['title'] = 'MeTEOR | Search Users';
		$data['search'] = $var;
		
		$var1 = $this->input->post('type');
		if( $var === "COURSE" )redirect('http://localhost/meteor/index.php/managercourse/search_findTemp/'.$var1.'');	
		
		$a = array();
		include_once('course_temp.php');
		$me = new course_temp;
		$r = $me->listCourseUsers();
		$a['array'] = $r['array'];
		$a['count_All'] = $r['count'];

		$a['counter']=0;
		
		$result = $this->vm->get_results($data);
		
		foreach($result->result() as $row)
		{
			$b = array();
			$c = array();
			$d = array();
			$e = array();
			$param = array();
			
			$a['id'][] = $row->id;
			$a['username'][] = $row->username;
			$a['firstname'][] = $row->firstname;
			$a['lastname'][] = $row->lastname;
			
			$param['id'] = $row->id;
			$result1 = $this->vm->get_reserved($param);
			$result2 = $this->vm->get_payment($param);
			$result4 = $this->vm->get_refund($param);
			
			foreach($result1->result() as $row)
			{
				$b[] = $row->id;
			}
			foreach($result2->result() as $row)
			{
				$c[] = $row->id;
			}
			foreach($result4->result() as $row)
			{
				$e[] = $row->course_id;
			}
			
			$holder = array_diff($b, $c);
			
			if(empty($holder)) $a['validated'][] = 1;
			else $a['validated'][] = 0;
			if(empty($e))  $a['refunded'][] = 1;
			else $a['refunded'][] = 0;
			
			$a['counter']++;
		}
	
		$this->load->helper('url');
		$a['active_nav'] = 'VIEW';
		$a['manager'] = 1;

		$this->load->view('templates/indexmanager', $title);
		$this->load->view('templates/sidebar_manager', $a);
		$this->load->view('validation/search_find', $a);
		//$this->load->view('templates/footerman');
		
	}
	
	public function removeStudent(){
		$title['title'] = 'MeTEOR | Validation';
		$user_id = $_POST['temp'];
		$stat = $_POST['stat'];
		$course_id = $_POST['course_id'];
		$temporary = $_POST['tempId'];
		$tag = $_POST['tag'];
		$man = $_POST['manager'];

		if($stat){
			$data = array(
				'user_id' => $user_id,
				'course_id' => $course_id,
				'refunded' => 1,
				'date' => date('Y-m-d G:i:s'),
				'untag' => 1,
			);

			$query = $this->participantuser_model->getDB('cancelled', 'user_id', $user_id, 'course_id', $course_id, 1);
			$query = $query->result_array();

			if(!count($query)){
				$this->db->insert('cancelled', $data);
			}
		}
		$this->vm->removeStudent($course_id, $user_id, $temporary);
		if( isset($_POST['tag']) ) redirect("http://localhost/meteor/index.php/course/seeRequest/".$temporary."/".$man."/".$tag);
		else redirect("http://localhost/meteor/index.php/course/process/".$course_id);
	}

	public function validate()
	{
		$title['title'] = 'MeTEOR | Validation';
		$temp = $_POST['temp'];
		$cbn = $_POST['cbn'];
		
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
			$a['middlename'] = $row->middlename;
		}
		
		$param['id'] = $a['id'];		
		$result1 = $this->vm->get_reserved($param);
		$result2 = $this->vm->get_payment($param);
			
		foreach($result1->result() as $row)
		{
			$b[] = $row->id;
		}
		foreach($result2->result() as $row)
		{
			$c[] = $row->id;
		}
		
		$holder = array_diff($b, $c);	
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
				$a['venue'][] = $row->venue;
				$a['reserved'][] = $row->reserved;
				$a['available'][] = $row->available;
				$a['paid'][] = $row->paid;
			}
		}
		
		$this->load->helper('url');
		$a['manager'] = $_POST['manager'];
		$a['active_nav'] = 'VIEW';

		$uid = $this->login_model->getuid($this->session->userdata('username'));

		if( !$uid['role'] ){
			$this->load->view('templates/indexadmin', $title);
			$this->load->view('templates/sidebar_admin', $a);
		}
		else{
			$this->load->view('templates/indexmanager', $title);
			$this->load->view('templates/sidebar_manager', $a);
		}

		if($cbn == 0) $this->load->view('validation/validate2', $a);
		elseif($cbn == 1) $this->load->view('validation/cash', $a);
		else $this->load->view('validation/bank', $a);
		
		//if( !$a['manager'] ) $this->load->view('templates/footeradmin');
		//else $this->load->view('templates/footerman');
	} 
	
	public function pkCash(){
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$data['cid'] = $_POST['temp'];
		$data['id'] = $_POST['uid'];
		$data['title'] = "MeTOER | Payment"	;
		$data['manager'] = $_POST['manager'];
		$data['total'] = $_POST['total'];
		
		if( isset($_POST['remarks']) ) $remarks = $_POST['remarks'];
		
		$ornum = $_POST['ornumber'];
		if(!isset($_POST['temp'])){
			echo "bakit?";
		}
		else{
			foreach($_POST['temp'] as $temp){
				$this->vm->pCash($ornum,$temp,$_POST['uid'], $remarks);
			}
			if( !$data['manager'] )	redirect("http://localhost/meteor/index.php/course");
			else redirect("http://localhost/meteor/index.php/managercourse");
		}
	}
	
	public function template(){
		$j = 0;
		$sum = 0.00;
		$names = array();
		$data['manager'] = $_POST['manager'];
		$title['title'] = "MeTEOR | Payment";
		if(isset($_POST['check'])){
			foreach($_POST['check'] as $item){	
				$sum = $sum + $_POST['cost'][$item];
				$names[$item] = $_POST['name'][$item];
				$course[$item] = $_POST['course'][$item];
				$user = $_POST['user'];
			}
		}
	
		if(isset($_POST['cash'])){
			$data['total'] = $sum;
			$data['name'] = $names;
			$data['cid'] = $course;
			$data['id'] = $user;
			$data['active_nav'] = 'VIEW';
						
			if( !$data['manager'] ){
				$this->load->view('templates/indexadmin', $title);
				$this->load->view('templates/sidebar_admin', $data);
			}
			else{
				$this->load->view('templates/indexmanager', $title);
				$this->load->view('templates/sidebar_manager', $data);
			}
			
			$this->load->view('validation/cash2',$data);
			
			//if( !$data['manager'] )	$this->load->view('templates/footeradmin');
			//else $this->load->view('templates/footerman');
		}	
	}

}
