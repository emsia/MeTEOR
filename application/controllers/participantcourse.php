<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class participantcourse extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('course_model');
		$this->load->model('participantuser_model');
		$this->load->model('login_model');
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library("pagination");
		$this->load->library('mpdf');
		
		if($this->islogged() == false){
			redirect("http://localhost/meteor/index.php/pages");
		}
		if(!$this->login_model->isValid($this->session->userdata('username'))){
			redirect("http://localhost/meteor/index.php/pages/invalid");
		}	

	}

	public function index( $error = '' )
	{		
		$letter = $this->uri->segment(3);
		$data['letter'] = substr( $letter, 0 , 1 );
		$data['error'] = $error;
		$config = array();
		$config['per_page'] = $this->course_model->record_count();
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0 ;
		
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$data['courses'] = $this->course_model->fetch_courses( 'courses', $data['letter'], $config['per_page'], $page);
		$data['title'] = 'MeTEOR | Reserved Courses';			
		
		$data['userid'] = $uid['id'];
		$data['user'] = $this->participantuser_model->profileInfo($data['userid']);
		
		//$this->updateEndCourses($data['userid']);
		
		$this->load->helper('url');

		$this->load->view('templates/indexparticipant', $data);
		$this->load->view('participantcourse/index', $data);
		$this->load->view('templates/footerparticipant');
	}

	public function origsurvey() {
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$data['title'] = 'MeTEOR | Survey';	
		$data['userid'] = $uid['id'] ;
		$data['user'] = $this->participantuser_model->profileInfo($data['userid']);
		$data['course_id'] = $_POST['course_id'];
		
		$data['count'] = 0;
		$i = 0;
		$a = array();

		$arr = $this->participantuser_model->getDB( 'categories_questions', 'belong', '1', '', '', 0 ); 
		foreach ($arr->result_array() as $value) {
			$arr2 = $this->participantuser_model->getDB( 'all_questions', 'category_id', $value['id'], '', '', 0 );
			$b = array();
			$b['count_all'] = 0;
			foreach($arr2->result_array() as $value2){
				$b['ids'][] = $value2['id'];
				$b['questions_all'][] = $value2['questions'];
				$b['type_all'][] = $value2['type'];
				$b['count_all']++;
			}
			$data['titles'][] = $value['title'];
			$a[$i][] = $b;
			$data['count']++;
			$i++;
		}
		$data['survey'] = 1;
		$data['full_array'] = $a;

		$data['active_nav'] = 'COMPLETED';
		$this->load->view('templates/indexparticipant', $data);
		$this->load->view('templates/sidebar_participants', $data);
		$this->load->view('participantcourse/form_temp2', $data);
		//$this->load->view('templates/footerparticipant');
	}

	public function formOrigSurvey() {
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$data['title'] = 'MeTEOR | Survey';	
		$data['course_id'] = $_POST['course_id'];
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$data['user'] = $this->participantuser_model->profileInfo($uid['id']);

		$arr = $this->participantuser_model->getDB( 'categories_questions', 'belong', '1', '', '', 0 );
		foreach ($arr->result_array() as $value) {
			$arr2 = $this->participantuser_model->getDB( 'all_questions', 'category_id', $value['id'], '', '', 0 );
			foreach($arr2->result_array() as $value2){
				$pangalan = $value2['id']."_id";
				$this->form_validation->set_rules($pangalan, "Q_".$value2['id'], 'required');
			}
		}
		
		//Q8
		//$this->Sur_validation->set_rules('topic', 'Topic', 'required');
		//$this->form_validation->set_rules('traindev', 'Traindev', 'required');
		//$this->form_validation->set_rules('comments', 'Comments', 'required');
	
	
		if ($this->form_validation->run() == FALSE)
		{
			$data['err'] = 1;
			$data['count'] = 0;
			$i = 0;
			$a = array();

			$arr = $this->participantuser_model->getDB( 'categories_questions', 'belong', '1', '', '', 0 ); 
			foreach ($arr->result_array() as $value) {
				$arr2 = $this->participantuser_model->getDB( 'all_questions', 'category_id', $value['id'], '', '', 0 );
				$b = array();
				$b['count_all'] = 0;
				foreach($arr2->result_array() as $value2){
					$b['ids'][] = $value2['id'];
					$b['questions_all'][] = $value2['questions'];
					$b['type_all'][] = $value2['type'];
					$b['count_all']++;
				}
				$data['survey'] = 0;
				$data['titles'][] = $value['title'];
				$a[$i][] = $b;
				$data['count']++;
				$i++;
			}
			$data['survey'] = 1;
			$data['full_array'] = $a;
			$data['active_nav'] = 'COMPLETED';

			$this->load->view('templates/indexparticipant', $data);
			$this->load->view('templates/sidebar_participants', $data);
			$this->load->view('participantcourse/form_temp2', $data);
			//$this->load->view('templates/footerparticipant');
		}
		else{
			$this->participantuser_model->addPartSurvey( $uid['id'] );
			//$data['temp'] = 3;
			//$this->load->view('templates/indexparticipant', $data);
			//$this->load->view('course/success', $data);
			//$this->load->view('templates/footerparticipant');
			$this->completed('Survey Form has been saved', 1);
		}
	}
	
	public function survey() {
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$data['title'] = 'MeTEOR | Survey';	
		$data['userid'] = $uid['id'] ;
		$data['user'] = $this->participantuser_model->profileInfo($data['userid']);

		$data['course_id'] = $_POST['course_id'];
		$data['num'] = 1;

		$data['count'] = 0;
		$i = 0;
		$a = array();

		$arr = $this->participantuser_model->getDB( 'categories_questions', 'belong', '0', '', '', 0 ); 
		foreach ($arr->result_array() as $value) {
			$arr2 = $this->participantuser_model->getDB( 'all_questions', 'category_id', $value['id'], '', '', 0 );
			$b = array();
			$b['count_all'] = 0;
			foreach($arr2->result_array() as $value2){
				$b['ids'][] = $value2['id'];
				$b['questions_all'][] = $value2['questions'];
				$b['type_all'][] = $value2['type'];
				$b['count_all']++;
			}
			$data['titles'][] = $value['title'];
			$a[$i][] = $b;
			$data['count']++;
			$i++;
		}
		$data['survey'] = 0;
		$data['full_array'] = $a;

		$data['active_nav'] = 'COMPLETED';
		$this->load->view('templates/indexparticipant', $data);
		$this->load->view('templates/sidebar_participants', $data);
		$this->load->view('participantcourse/form_temp', $data);
		//$this->load->view('templates/footerparticipant');

		//var_dump($data);
	}
	
	public function formSurvey() {
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$data['title'] = 'MeTEOR | Survey';	
		$data['course_id'] = $_POST['course_id'];
		$surveys = $_POST['survey'];

		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$data['user'] = $this->participantuser_model->profileInfo($uid['id']);

		$arr = $this->participantuser_model->getDB( 'categories_questions', 'belong', $surveys, '', '', 0 );
		foreach ($arr->result_array() as $value) {
			$arr2 = $this->participantuser_model->getDB( 'all_questions', 'category_id', $value['id'], '', '', 0 );
			foreach($arr2->result_array() as $value2){
				$pangalan = $value2['id']."_id";
				$this->form_validation->set_rules($pangalan, "Q_".$value2['id'], 'required');
			}
		}
	
		if ($this->form_validation->run() == FALSE)
		{
			$data['err'] = 1;
			$data['count'] = 0;
			$i = 0;
			$a = array();

			$arr = $this->participantuser_model->getDB( 'categories_questions', 'belong', '0', '', '', 0 ); 
			foreach ($arr->result_array() as $value) {
				$arr2 = $this->participantuser_model->getDB( 'all_questions', 'category_id', $value['id'], '', '', 0 );
				$b = array();
				$b['count_all'] = 0;
				foreach($arr2->result_array() as $value2){
					$b['ids'][] = $value2['id'];
					$b['questions_all'][] = $value2['questions'];
					$b['type_all'][] = $value2['type'];
					$b['count_all']++;
				}
				$data['survey'] = 0;
				$data['titles'][] = $value['title'];
				$a[$i][] = $b;
				$data['count']++;
				$i++;
			}
			$data['survey'] = $surveys;
			$data['full_array'] = $a;
			$data['active_nav'] = 'COMPLETED';

			$this->load->view('templates/indexparticipant', $data);
			$this->load->view('templates/sidebar_participants', $data);
			$this->load->view('participantcourse/form_temp', $data);
			//$this->load->view('templates/footerparticipant');
		}
		else{
			if(!$surveys) $this->participantuser_model->addPart( $uid['id'] );
			else $this->participantuser_model->addPartSurvey( $uid['id'] );
			//$data['temp'] = 3;
			//$this->load->view('templates/indexparticipant', $data);
			$this->completed('Evaluation Form has been saved',1);
			//$this->load->view('course/success', $data);
			//$this->load->view('templates/footerparticipant');
		}
	}
	
	public function upcoming($message='',$err=0)
	{			
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$query = $this->db->get_where( 'details', array('user_id' => $uid['id']) );
		$ans = $query->row_array();

		$query1 = $this->db->get_where( 'shortForm_all', array('user_id' => $uid['id']) );
		$ans1 = $query1->row_array();

		if( empty($ans['id']) && empty($ans1['id']) ){
			redirect(base_url('index.php/participantprofile'));
			return;
		}	

		$data['courses'] = $this->course_model->get_courses(1);
		
		$data['userid'] = $uid['id'] ;
		$data['user'] = $this->participantuser_model->profileInfo($data['userid']);
		
		$data['title'] = 'MeTEOR | Upcoming Courses';				
		
		$a = array();
		include_once('course_temp.php');
		$me = new course_temp;
		$r = $me->listCourseUsers1();
		$a['array'] = $r['array'];
		$a['count_All'] = $r['count'];

		$a['count'] = 0; $a['decount'] = 0; $a['counter'] = 0;
		$reserves = array();
		
		foreach( $data['courses'] as $row ){
			$reserves = $this->participantuser_model->reservesCourse( $uid['id'], $row['id'] );
			$arrayReserves = $reserves->row_array();
				
			if(empty($arrayReserves['id'])){
				$a['tag'][] = $row['id'];
				$a['decount']++;
			}
				$start_time = date_create($row['startTime']);
				$startTimes = date_format($start_time, 'g:i A');

				$endTimes = date_create($row['endTime']);
				$endTimes = date_format($endTimes, 'g:i A');

				$a['count']++;
				$a['id'][] = $row['id'];
				$a['tempId'][] = $row['tempId'];
				$a['name'][] = $row['name'];
				$a['Time'][] = $startTimes." - ".$endTimes;
				$a['description'][] = $row['description'];
				$a['start'][] = $row['start'];
				$a['end'][] = $row['end'];
				$a['venue'][] = $row['venue'];
				$a['cost'][] = $row['cost'];
				$a['available'][] = $row['available'];
				$a['reserved'][] = $row['reserved'];
				$a['paid'][] = $row['paid'];
		}

		$data['pay'] = $this->course_model->get_courses(1);
		$this->load->helper('url');
		$data['message'] = $message;
		$data['error'] = $err;

		$data['active_nav'] = 'UPCOMING';
		$this->load->view('templates/indexparticipant', $data);
		$this->load->view('templates/sidebar_participants', $data);
		$this->load->view('participantcourse/upcoming', $a);
		//$this->load->view('templates/footerparticipant');
	}

	public function reserved()
	{		 
		$letter = $this->uri->segment(3);
		$data['letter'] = substr( $letter, 0 , 1 );
		
		$config = array();
		$config['per_page'] = $this->course_model->record_count();
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0 ;
		
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$data['courses'] = $this->course_model->fetch_courses( 'courses', $data['letter'], $config['per_page'], $page);
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$data['title'] = 'MeTEOR | Reserve Course';
		
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$data['userid'] = $uid['id'];
		$data['user'] = $this->participantuser_model->profileInfo($data['userid']);
		
		$this->load->helper('url');

		$this->form_validation->set_rules('user_id', 'User_id', 'required');
		$this->form_validation->set_rules('course_id', 'Course_id', 'required');
		$this->form_validation->set_rules('date', 'Date', 'required');

		if ($this->form_validation->run() === FALSE)
		{	
			$data['active_nav'] = 'UPCOMING';
			$this->load->view('templates/indexparticipant', $data);
			$this->load->view('templates/sidebar_participants', $data);
			$this->load->view('participantcourse/upcoming', $data);
			//$this->load->view('templates/footerparticipant');
			
		}
		else
		{
			$cont = $this->participantuser_model->reservedCourse();			
			if($cont) $this->upcoming();
			else $this->upcoming();
		}
	}
	
	public function unreservedres()
	{
		$letter = $this->uri->segment(3);
		$data['letter'] = substr( $letter, 0 , 1 );
		
		$config = array();
		$config['per_page'] = $this->course_model->record_count();
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0 ;
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$data['title'] = 'MeTEOR | Reserve Course';
		$data['courses'] = $this->course_model->fetch_courses( 'courses', $data['letter'], $config['per_page'], $page);
		
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$data['userid'] = $uid['id'];
		$data['user'] = $this->participantuser_model->profileInfo($data['userid']);
		
		$this->load->helper('url');

		$this->form_validation->set_rules('user_id', 'User_id', 'required');
		$this->form_validation->set_rules('course_id', 'Course_id', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('templates/indexparticipant', $data);
			$this->load->view('participantcourse/upcoming', $data);
			$this->load->view('templates/footerparticipant');
			
		}
		else
		{
			$this->participantuser_model->unreservedCourse();			
			redirect("http://localhost/meteor/index.php/participantcourse/upcoming");
		}
	}	
	
	public function getMyId( $num ){
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		if( $num==1 )	return $uid['id'];
		else if( $num==2 ) return $uid['firstname'];
		else if( $num==3 ) return $uid['lastname'];
		else if( $num==4 ) return $uid['middlename'];
	}

	public function search_completed(){
		$a = array();
		include_once('course_temp.php');
		$me = new course_temp;
		$r = $me->listCourseUsers1();
		$a['array'] = $r['array'];
		$a['count_All'] = $r['count'];
		
		$a['count']=0;
		$a['countDef']=0;
		$a['countPhoto'] = 0;
		$a['countSurvey'] = 0;
		$a['countPermission'] = 0;
		$a['search'] = $_POST['search'];
		$a['title'] = "MeTEOR | Search Completed";
		
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$a['userid'] = $uid['id'];
		$a['user'] = $this->participantuser_model->profileInfo($a['userid']);
				
		$result = $this->course_model->get_results($a, 'courses',1);

		foreach($result->result_array() as $row)
		{
			$queryPaid = $this->participantuser_model->getDB( 'payment','course_id', $row['id'], 'user_id', $uid['id'], 1 );
			$arrayPaid = $queryPaid->row_array();
			
			$queryAns = $this->participantuser_model->getDB( 'survey', 'course_id', $row['id'], 'userid', $uid['id'], 1 );
			$arrayAns = $queryAns->row_array();

			$surveyAns = $this->participantuser_model->getDB( 'origsurvey', 'course_id', $row['id'], 'userid', $uid['id'], 1 );
			$arraySurveyAns = $surveyAns->row_array();

			$queryCert = $this->participantuser_model->getDB( 'signature', 'course_id', $row['id'], '', '', 0 );
			$arrayCert = $queryCert->row_array();

			if( !empty($arrayPaid['id']) ){
				$a['count']++;
				if( !empty($arrayAns['id']) ){
					$a['tag'][] = $row['id'];
					$a['countDef']++;
					if( $arrayAns['certOk'] ){
						$a['alreadyGet'][] = $row['id'];
					}
				}

				if( !empty($arrayAns['id']) && $arrayAns['permission'] == 1 ){
					$a['tagPermission'][] = $row['id'];
					$a['countPermission']++;
				}

				if( !empty($arraySurveyAns['id']) ){
					$a['tagSuperSurveyS'][] = $row['id'];
					$a['countSurvey']++;
				}

				$a['id'][] = $row['id'];
				$a['name'][] = $row['name'];
				$a['description'][] = $row['description'];
				$a['start'][] = $row['start'];
				$a['end'][] = $row['end'];
				$a['startTime'][] = $row['startTime'];
				$a['endTime'][] = $row['endTime'];
				$a['venue'][] = $row['venue'];
				$a['cost'][] = $row['cost'];
				$a['available'][] = $row['available'];
				$a['reserved'][] = $row['reserved'];
				$a['paid'][] = $row['paid'];
				$a['typeS'][] = $arrayCert['type'];
			}

			if( !empty($arrayCert['id']) ){
				$a['photoId'][] = $row['id'];
				$a['countPhoto']++;
			}
		}
		
		$this->load->helper('url');
		$a['search'] = 1;
		$a['active_nav'] = 'COMPLETED';
		$this->load->view('templates/indexparticipant', $a);
		$this->load->view('templates/sidebar_participants', $a);
		$this->load->view('participantcourse/completed', $a);
		//$this->load->view('templates/footerparticipant');
	}
	public function completed($messages = '', $err=0 )
	{		
		$a = array();
		include_once('course_temp.php');
		$me = new course_temp;
		$r = $me->listCourseUsers1();
		$a['array'] = $r['array'];
		$a['count_All'] = $r['count'];

		$letter = $this->uri->segment(3);
		$a['letter'] = substr( $letter, 0 , 1 );
		
		$config = array();
		$config['per_page'] = $this->course_model->record_count();
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0 ;
		
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$a['courses'] = $this->course_model->fetch_courses( 'courses', $a['letter'], $config['per_page'], $page, 1 );
		$a['title'] = 'MeTEOR | Completed Courses';			
		$a['userid'] = $uid['id'];
		$a['user'] = $this->participantuser_model->profileInfo($a['userid']);
		date_default_timezone_set("Asia/Manila");											
		$date = date('Y-m-d');
		$a['count'] = 0;
		$a['countDef'] = 0; $a['countPhoto'] = 0; $a['countSurvey'] = 0; $a['countPermission'] = 0;
		
		foreach($a['courses'] as $row){
			$queryPaid = $this->participantuser_model->getDB( 'payment','course_id', $row['id'], 'user_id', $uid['id'], 1 );
			$arrayPaid = $queryPaid->row_array();
			
			$queryAns = $this->participantuser_model->getDB( 'survey', 'course_id', $row['id'], 'userid', $uid['id'], 1 );
			$arrayAns = $queryAns->row_array();

			$surveyAns = $this->participantuser_model->getDB( 'origsurvey', 'course_id', $row['id'], 'userid', $uid['id'], 1 );
			$arraySurveyAns = $surveyAns->row_array();

			$queryCert = $this->participantuser_model->getDB( 'signature', 'course_id', $row['id'], '', '', 0 );
			$arrayCert = $queryCert->row_array();

			if( !empty($arrayPaid['id']) && $row['end'] <= $date  ){
				$a['count']++;
				if( !empty($arrayAns['id']) ){
					$a['tag'][] = $row['id'];
					$a['countDef']++;
					if( $arrayAns['certOk'] ){
						$a['alreadyGet'][] = $row['id'];
					}
				}

				if( !empty($arrayAns['id']) && $arrayAns['permission'] == 1 ){
					$a['tagPermission'][] = $row['id'];
					$a['countPermission']++;
				}

				if( !empty($arraySurveyAns['id']) ){
					$a['tagSuperSurveyS'][] = $row['id'];
					$a['countSurvey']++;
				}

				$a['id'][] = $row['id'];
				$a['name'][] = $row['name'];
				$a['description'][] = $row['description'];
				$a['start'][] = $row['start'];
				$a['end'][] = $row['end'];
				$a['startTime'][] = $row['startTime'];
				$a['endTime'][] = $row['endTime'];
				$a['venue'][] = $row['venue'];
				$a['cost'][] = $row['cost'];
				$a['available'][] = $row['available'];
				$a['reserved'][] = $row['reserved'];
				$a['paid'][] = $row['paid'];
				$a['typeS'][] = $arrayCert['type'];
			}

			if( !empty($arrayCert['id']) ){
				$a['photoId'][] = $row['id'];
				$a['countPhoto']++;
			}
		}
		
		$this->load->helper('url');
		$a['search'] = 0;
		$a['message'] = $messages;
		$a['error'] = $err;
		$a['active_nav'] = 'COMPLETED';

		$this->load->view('templates/indexparticipant', $a);
		$this->load->view('templates/sidebar_participants', $a);
		$this->load->view('participantcourse/completed', $a);
		//$this->load->view('templates/footerparticipant');
	}
	
	public function search_upcoming(){
		$data['search'] = $_POST['search'];
		$data['title'] = "MeTEOR | Search Results";
		$a = array();
		include_once('course_temp.php');
		$me = new course_temp;
		$r = $me->listCourseUsers1();
		$a['array'] = $r['array'];
		$a['count_All'] = $r['count'];

		$a['counter']=0;
		$a['countOngoing']=0;
		$a['countPaid']=0;
		$a['countReserved']=0;
		
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$data['userid'] = $uid['id'];
		$data['user'] = $this->participantuser_model->profileInfo($data['userid']);
		
		$result = $this->course_model->get_results($data, 'courses');

		foreach($result->result() as $row)
		{
			//date_default_timezone_set("Asia/Manila");											
			//$date = date('Y-m-d G:i:s');
			
			$queryReserved = $this->participantuser_model->getDB( 'reserved', 'course_id', $row->id, 'user_id', $data['userid'], 1 );
			$arrayReserved = $queryReserved->result_array();
			
			$queryPaid = $this->participantuser_model->getDB( 'payment', 'course_id', $row->id, 'user_id', $data['userid'], 1 );
			$arrayPaid = $queryPaid->row_array();
			
			$queryCancelled = $this->participantuser_model->getDB('cancelled', 'course_id', $row->id, 'user_id', $data['userid'], 1);
			$arrayCancelled = $queryCancelled->row_array();	
			
			$queryDis = $this->participantuser_model->getDB('dissolved', 'course_id', $row->id, 'user_id', $data['userid'], 1);
			$arrayDis = $queryDis->row_array();
				
			if( !empty($arrayReserved['id']) && ( empty($arrayCancelled['id']) && empty($arrayDis['id'])) ){
				$a['tagReserved'][] = $row->id;
				$a['countReserved']++;				
			}	
			if( !empty($arrayPaid['id']) && ( empty($arrayCancelled['id']) && empty($arrayDis['id'])) ){
				$a['tagPaid'][] = $row->id;
				$a['countPaid']++;				
			}
			
			$a['id'][] = $row->id;
			$a['name'][] = $row->name;
			$a['description'][] = $row->description;
			$a['start'][] = $row->start;
			$a['end'][] = $row->end;
			$a['venue'][] = $row->venue;
			$a['cost'][] = $row->cost;
			$a['reserved'][] = $row->reserved;
			$a['available'][] = $row->available;
			$a['paid'][] = $row->paid;
			$a['counter']++;	
		}
		
		$this->load->helper('url');
		
		$a['active_nav'] = 'UPCOMING';
		$this->load->view('templates/indexparticipant', $a);
		$this->load->view('templates/sidebar_participants', $data);
		$this->load->view('participantcourse/search_upcoming', $a);
		//$this->load->view('templates/footerparticipant');
	}
	
	public function sendPermission(){
		$a = array();
		$a['title'] = $_POST['CourseName'];
		$a['fullName'] = $_POST['fullName'];
		$a['user_slug'] = $_POST['user_slug'];
		$a['unique'] = $_POST['course_id'];
		$a['type'] = $_POST['typeD'];
		$a['userID'] = $_POST['user_id'];

		include_once('course_temp.php');
		$me = new course_temp;

		$orderByDate = array(); $num = 0;
		$check = 0;
		foreach ($_POST['ending'] as $key => $value) { // sort the date into ascending order
			//$mail->AddAddress($value);
			if( empty($value) && $check == 0 ){
				break;
			}
			list($S1, $S2) = explode(' - ',$value);
			//echo $S1;
			$orderByDate[$key][$num]  = strtotime($S1);
			$orderByDate[$key][$num + 1]  = strtotime($S2);
			$num = 0; $check++;
		}

		if( !$check ){
			$this->completed("Please select date(s) of attendance.");
			return;
		}

		array_multisort($orderByDate, SORT_ASC, $_POST['ending']);
		$start_sift = array(); $i = 0; $full_string = "";

		foreach ($_POST['ending'] as $key => $value) {
			list( $s1, $s2 ) = explode(" - ",  $value);
			if( !$i ) $first = $s1;
			$last = $s2;
			$start_sift[$i] = $me->seperate( $s1, $s2 );
			$i++;
		}

		for( $j = 0; $j < $i; $j++ ){
			if( !$j ) $full_string .= $start_sift[$j];
			else $full_string = $me->second_sift( $full_string, $start_sift[$j] );
		}
		$full_string = str_replace(" ;", " ", $full_string);
		$full_string = str_replace(" . ", " ", $full_string);
		$this->course_model->updater($a['unique'], $a['userID'], $full_string, $last, $first);

		$this->load->library('phpmailer');
		$mailer = new PHPMailer();

		$mailer->IsSMTP(); // enable SMTP
		$mailer->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
		$mailer->SMTPAuth = true;  // authentication enabled
		$mailer->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
		$mailer->Host = 'smtp.gmail.com';
		$mailer->Port = 587; 
		$mailer->Username = 'meteor.upitdc@gmail.com';  
		$mailer->Password = 'meteor123';  

		$mailer->SetFrom('noreply@localhost/meteor', 'MeTEOR Request for Certificate Generation');
		$mailer->Subject = '[MeTEOR] Certificate Request';
		$query = $this->login_model->getAdmins();

		foreach( $query->result_array() as $row ){
			//$hpass = sha1($this->input->post('pass'));
			$a['username'] = $row['slug'];
			$mailer->Body = $this->load->view('participantcourse/sendRequest', $a, TRUE);
			$mailer->AddAddress($row['username']);
		}

		$mailer->IsHTML(true);
		if(!$mailer->Send()) {
			$error = 'Mail error: '.$mailer->ErrorInfo; 
			$this->completed($error);
			return;
		} else {
			$this->completed('Request Sent!');
			return;
		}
	}

	public function certGen(){
		$a = array();
		$a['cid'] = $this->input->post('course_id');
		$a['userID'] = $this->input->post('user_id');

		$a['start'] = $this->input->post('startDate');
		$a['end'] = $this->input->post('endDate');
		$a['venue'] =  $this->input->post('venue');
		$cert = $this->participantuser_model->getDB( 'signature', 'course_id', $a['cid'], '', '', 0);
		$arrayCert = $cert->result_array();
		$a['course_name'] = $this->input->post('CourseName');

		foreach ($arrayCert as $key) {
			$photoId = $key['photo_id']; $tagS = 0;
			$cert = $this->participantuser_model->getDB( 'picture', 'id', $photoId, '', '', 0);
			$arrayCert = $cert->row_array();

			if( $key['photo_id2'] ){
				$cert2 = $this->participantuser_model->getDB( 'picture', 'id', $key['photo_id2'], '', '', 0);
				$arrayCert2 = $cert2->row_array();
				$a['place2'] = $arrayCert2['name'];
				$tagS = 1;
			}

			$a['type'] = $key['type'];
			$a['name1'] = $key['name1'];
			$a['name2'] = $key['name2'];
			$a['position1'] = $key['position1'];
			$a['position2'] = $key['position2'];
			$a['place'] = $arrayCert['name'];
			//echo $a['place']."45454";
			//$this->updateForm( $a['cid'] );
			$this->createCOP( $a, $tagS );			
		}
	}

	private function createCOP( $a, $num ){
		//$img_file_name1, $workshop
		$this->load->helper("file");
		$stylesheet = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/meteor/css/stylesheetCOP.css');
		
		//echo $a['course_name'];
		
		//$data['fname']=iconv('UTF-8', 'windows-1252', $string_array[$temp][0]);
		//getMyId(2)
		$data['type'] = $a['type'];
		$data['signatory_name1'] = $a['name1'];
		$data['signatory_name2'] = $a['name2'];
		$data['signatory_position1'] = $a['position1'];
		$data['signatory_position2'] = $a['position2'];
		//echo strtolower($a['type']);
		//exit;
		if( strtolower($a['type']) == "appearance" ){
			$stylesheet = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/meteor/css/appearance_css.css');
			$view ='participantcourse/cert_of_appearance';
			$mpdf = new mPDF('', 'LETTER', 0, 0, 0, 0, 40, 0, 0, 5,'P');
			$mpdf->SetHTMLHeader('<img id="bg" src="' .$_SERVER['DOCUMENT_ROOT'].'/meteor/css/images/docLogo2.png">');
			$mpdf->SetHTMLFooter('<img src="' .$_SERVER['DOCUMENT_ROOT'].'/meteor/css/images/doc2.png" class="footer">');
		}else{
			$mpdf = new mPDF('', 'LETTER-L', 0, 0, 0, 0, 0, 0, 0, 0,'L');
			$mpdf->SetHTMLHeader('<img id="bg" src="' .$_SERVER['DOCUMENT_ROOT'].'/meteor/css/images/cert.png">');
			$view ='participantcourse/cert_of_participation2';
		}

		$mpdf->WriteHTML($stylesheet,1);

		$certificateDate = $this->participantuser_model->getDB( 'completed', 'user_id', $a['userID'], 'course_id', $a['cid'], 1 );
		$certDate = $certificateDate->result_array();
		$check = $certificateDate->row_array();

		$data['fname'] = $this->getMyId(2);
		$data['mname'] = $this->getMyId(4);
		$data['lname'] = $this->getMyId(3);
		$data['nameS'] = $data['fname']." ".strtoupper($data['mname'][0]).". ".$data['lname'];
		// /echo $data['nameS'];
		$data['workshop'] = $a['course_name'];
		$data['eventStart'] = $a['start'] ;
		$data['eventEnd'] = $a['end'] ;//endDateCert

		$endD = date('jS \of F Y', strtotime($data['eventEnd']));
		//echo $endD; exit;
		$data['endDateCert'] = $endD;
		if( !empty($check['id']) ){
			$data['endDateCert'] = date('jS \of F Y', strtotime($certDate[0]['last']));
			$data['message2'] = $certDate[0]['string'];
		}


		$data['venue'] = $a['venue'] ;
		// /$data['img_loc'] = $_SERVER['DOCUMENT_ROOT'].'/meteor/cssmvc2/files/img/cert.png';

		$data['signature1'] = $_SERVER['DOCUMENT_ROOT'].'/meteor/upload/'.$a['place'];
		$data['numFormat'] = 0;
		if( $num ){
			$data['signature2'] = $_SERVER['DOCUMENT_ROOT'].'/meteor/upload/'.$a['place2'];
			$data['numFormat'] = 1;
		}	
		
		//$this->load->view($view, $data);
		//$water = base_url()."css/images/CertA.jpg";
		//$mpdf->SetWatermarkImage($water, 1);
		//$mpdf->showWatermarkImage = true;	

		$mpdf->WriteHTML($this->load->view($view, $data, TRUE));
		
		$filename = $data['nameS']. '.pdf';
		$test = utf8_encode($filename);
		
		$mpdf->Output(utf8_decode($test),"","I");
		//redirect("http://localhost/meteor/index.php/participantcourse/completed");
		exit;
	}

	public function updateForm( $course_id ){
		$myId = $this->getMyId(1);
		$data = array(
			'certOk' => 1
		);

		$this->db->where('userid', $myId);
		$this->db->where('course_id', $course_id );
		$this->db->update('survey', $data);
	}
}