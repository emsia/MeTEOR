<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class participant extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('participant_model');
		$this->load->model('participantuser_model');
		$this->load->model('course_model');
		$this->load->model('validation_model');
		$this->load->model('login_model');
		$this->load->library('mpdf');
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
		
		$data['title'] = 'MeTEOR | Participants';
				
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$data['userid'] = $uid['id'];
		
		$this->load->helper('url');

		$data['active_nav'] = 'VIEW';
		$data['manager'] = 0;
		$this->load->view('templates/indexadmin', $data);
		$this->load->view('templates/sidebar_part', $data);
		$this->load->view('participant/index', $data);
		//$this->load->view('templates/footeradmin');
	}
	
	public function addStudent(){
		$data['title'] = 'MeTEOR | Participants';
				
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$data['userid'] = $uid['id'];
		
		$this->load->helper('url');

		$this->load->view('templates/indexadmin', $data);
		$this->load->view('participant/addStudent', $data);
		$this->load->view('templates/footeradmin');
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
		$this->load->view('templates/indexadmin', $data);
		$this->load->view('templates/sidebar_part', $data);
		$this->load->view('participant/viewprofile', $data);
		//$this->load->view('templates/footeradmin');
	}

	public function search_users()
	{
		if( !isset($_POST['search']) ) {
			redirect('http://localhost/meteor/index.php/participant');
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
		
		$data['active_nav'] = 'VIEW';
		$this->load->view('templates/indexadmin', $data);
		$this->load->view('templates/sidebar_part', $data);

		$this->load->view('participant/search_find', $a);
		//$this->load->view('templates/footeradmin');
	}

	public function printAttendance(){
		$user_id = $_POST['user_id'];
		$data = array();
		$data['fullname'] = $_POST['fullname'];
		$data['count'] = 0;
		$paid_list = $this->participantuser_model->getDB( 'payment', 'user_id', $user_id, '', '', 0);
		foreach ($paid_list->result_array() as $key) {
			//echo $key['course_id']."<br/>";
			$paid = $this->participantuser_model->getDB( 'courses', 'id', $key['course_id'], '', '', 0);
			$paid = $paid->result_array();
			foreach ($paid as $value) {
				$data['names'][] = $value['name'];
				$data['start'][] = date('M d, Y', strtotime($value['start'])); //$value['start'];
				$data['end'][] = date('M d, Y', strtotime($value['end']));// $value['end'];
				$data['startTime'][] = date('g:i A', strtotime($value['startTime']));//$value['startTime'];
				$data['endTime'][] = date('g:i A', strtotime($value['endTime']));//$value['startTime'];
				$data['venue'][] = $value['venue'];
				$data['count']++;
			}
		}

		$stylesheet = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/meteor/css/printEvalSheet.css');
		$stylesheet1 = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/meteor/css/printS.css');		
		$stylesheet2 = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/meteor/css/styleGeneral.css');

		$mpdf = new mPDF('',    // mode - default ''
		'A4',    // format - A4, for example, default ''
		12,     // font size - default 0
		'',    // default font family
		0,    // margin_left
		0,    // margin right
		49,     // margin top
		15,    // margin bottom
		6,     // margin header
		2,     // margin footer
		'P'); 

		$mpdf->WriteHTML($stylesheet,1);
		$mpdf->WriteHTML($stylesheet1,1);	
		$mpdf->WriteHTML($stylesheet2,1);	

		$mpdf->SetHTMLHeader('<img src="'.$_SERVER['DOCUMENT_ROOT'].'/meteor/css/images/docLogo2.png" class="header">');
		$mpdf->SetHTMLFooter('<img src="'.$_SERVER['DOCUMENT_ROOT'].'/meteor/css/images/doc2.png" class="footer">');
		
		//$this->load->view('participant/attendance', $data);
		$mpdf->WriteHTML($this->load->view('participant/attendance', $data, TRUE));

		$filename ='attendance_of_'.$data['fullname'].'.pdf';
		$test = utf8_encode($filename);
		
		$mpdf->Output(utf8_decode($test),"","D");

		//var_dump($data['courses']);
		//printing na to
	}
}