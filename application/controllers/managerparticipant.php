<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class managerparticipant extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('participant_model');
		$this->load->model('participantuser_model');
		$this->load->model('course_model');
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
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		/*$query = $this->db->get_where( 'details', array('user_id' => $uid['id']) );
		$ans = $query->row_array();

		if( empty($ans['id']) ){
			redirect(base_url('index.php/participantprofile'));
			return;
		}*/

		include_once('course_temp.php');
		$me = new course_temp;

		$r = $me->listCourseUsers2();

		$data['participant'] = $this->participant_model->get_participant();
		$data['array'] = $r['array'];
		$data['count_All'] = $r['count'];
		$data['title'] = 'MeTEOR | Participant';
		
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$data['userid'] = $uid['id'];
		$data['manager'] = 1;

		$this->load->helper('url');
		$data['active_nav'] = 'VIEW';
		$this->load->view('templates/indexmanager', $data);
		$this->load->view('templates/sidebar_partMan', $data);
		$this->load->view('participant/index', $data);
		//$this->load->view('templates/footerman');
	}

	public function viewprofile( $message = '', $id = '', $err=0 )
	{
		 
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$data['title'] = 'MeTEOR | View Profile';
		
		
		$this->load->helper('url');
		
		if( isset($_POST['user_id']) ) $userrow = $_POST['user_id'];
		else $userrow = $id;
	
		$data['user'] = $this->participantuser_model->profileInfo($userrow);
		$data['addr'] = $this->participantuser_model->profileAddr($userrow);
		foreach( $data['addr'] as $row ){
			$data['region'] = $row['region'];			
			$data['province'] = $row['province'];
			$data['city'] = $row['city'];
		}

		$data['mobile'] = $this->participantuser_model->profileMobile($userrow);
		$data['countNnum'] = 0;
		foreach( $data['mobile'] as $row ){		
			$data['number'][] = $row['number'];
			$data['countNnum']++;
		}
		
		$data['courses'] = $this->course_model->get_courses(1);
		$data['count'] = 0;

		include_once('course_temp.php');
		$me = new course_temp;

		foreach( $data['courses'] as $row ){
			/*if( $row['id'] == $course_id ){
			}*/
			$data['id'][] = $row['id'];
			$data['name'][] = $row['name'];
			$data['venue'][] = $row['venue'];
			$data['cost'][] = $row['cost'];

			//echo($temporary);// $data['user'][0]['id'];
			$variable = $this->participantuser_model->getDB( 'completed', 'course_id', $row['id'], 'user_id', $userrow, 1 );
			$variable = $variable->result_array();
			//var_dump($variable);
			if( !empty($variable[0]['id']) ) $data['expected'][] = $variable[0]['string'];
			else {
				$temp1 = date('M d y', strtotime($row['start']));
				$temp2 = date('M d y', strtotime($row['end']));
				$forClean = $me->seperate( $temp1, $temp2);
				list( $m1, $y1 ) = explode(" . ", $forClean);
				$m1 .= " ".$y1;
				list( $m1, $y1 ) = explode(" ; ", $m1);
				$m1 .= " ".$y1;
				$data['expected'][] = $m1;
			}

			$data['count']++;
		}
		$data['message'] = $message;
		$data['error'] = $err;
		$data['active_nav'] = 'VIEW';
		$data['manager'] = 1;
		
		$this->load->view('templates/indexmanager', $data);
		$this->load->view('templates/sidebar_partMan', $data);
		$this->load->view('participant/viewprofile', $data);
		//$this->load->view('templates/footeradmin');
	}

	public function search_users()
	{
		if( !isset($_POST['search']) ) {
			redirect('http://localhost/meteor/index.php/managerparticipant'); 
			return;
		}
		include_once('course_temp.php');
		$me = new course_temp;

		$r = $me->listCourseUsers2();

		$data['search'] = $_POST['search'];
		$data['title'] = "MeTEOR | Search Users";
		$a = array();
		$a['array'] = $r['array'];
		$a['count_All'] = $r['count'];
		$a['counter']=0;
		
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$data['userid'] = $uid['id'];
		
		$result = $this->participant_model->get_users($data, 'users');

		foreach($result->result() as $row)
		{
			if( $row->role == 2 ){
				$a['id'][] = $row->id;
				$a['username'][] = $row->username;
				$a['firstname'][] = $row->firstname;
				$a['middlename'][] = $row->middlename;
				$a['lastname'][] = $row->lastname;			
				$a['counter']++;
			}
		}
		
		$this->load->helper('url');
		$a['manager'] = 1;
		$data['active_nav'] = 'VIEW';

		$this->load->view('templates/indexmanager', $data);
		$this->load->view('templates/sidebar_partMan', $data);
		$this->load->view('participant/search_find', $a);
		//$this->load->view('templates/footerman');
	}
}