<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class managercourse extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('course_model');
		$this->load->library('pagination');
		$this->load->model('participant_model');
		$this->load->model('participantuser_model');
		$this->load->model('validation_model', 'vm');
		$this->load->library('calendar');
		
		$this->load->model('login_model');
		$this->load->library('session');
		$this->load->helper('url');
		
		if($this->islogged() == false){
			redirect("http://localhost/meteor/index.php/pages");
		}
		if(!$this->login_model->isValid($this->session->userdata('username'))){
			redirect("http://localhost/meteor/index.php/pages/invalid");
		}
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$data['userid'] = $uid['id'];
	}

	public function index()
	{		
		$this->load->helper('url');
		include_once('course_temp.php');
		$me = new course_temp;

		/*$uid = $this->login_model->getuid($this->session->userdata('username'));
		$query = $this->db->get_where( 'details', array('user_id' => $uid['id']) );
		$ans = $query->row_array();

		if( empty($ans['id']) ){
			redirect(base_url('index.php/participantprofile'));
			return;
		}*/
		
		$r = $me->listCourseUsers();
		$a['array'] = $r['array'];
		$a['count_All'] = $r['count'];
		
		$letter = $this->uri->segment(3);
		$data['letter'] = substr( $letter, 0 , 1 );
		
		$config = array();
		$config['per_page'] = $this->course_model->record_count();
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0 ;
		
		$data['courses'] = $this->course_model->fetch_courses( 'courses', $data['letter'], $config['per_page'], $page, 1);
		$data['users'] = $this->course_model->fetch_users( $data['letter'] );
		$data['cancelled'] = $this->course_model->get_cancelledCourses();
		$a['title'] = 'MeTEOR | Courses';
		
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$a['userid'] = $uid['id'];
		
		$cancelled = array();
		$dissolved = array();
		$a['count'] = 0;
		
		foreach( $data['courses'] as $row ){
			$cancelled = $this->course_model->fetch_cancelled($row['id']);
			$arrayCancelled = $cancelled->row_array();
			$dissolved = $this->course_model->fetch_dissolved($row['id']);
			$arrayDissolved = $dissolved->row_array();
			if( empty($arrayCancelled['id']) && empty($arrayDissolved['id']) ){
				$paid_list = $this->participantuser_model->getDB( 'payment', 'course_id', $row['id'], '', '', 0);
				$paid_list = $paid_list->result_array();

				$a['count']++;
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
				$a['objectives'][] = $row['objectives'];
				$a['attendees'][] = $row['attendees'];
				$a['food'][] = $row['food'];
				$a['foodRemarks'][] = $row['foodRemarks'];
				$a['landTranspo'][] = $row['landTranspo'];
				$a['landRemarks'][] = $row['landRemarks'];
				$a['airfare'][] = $row['airfare'];
				$a['airfareRemarks'][] = $row['airfareRemarks'];
				$a['accommodation'][] = $row['accomodation'];
				$a['accommodationRemarks'][] = $row['accomodationRemarks'];
				$a['paid'][] = count($paid_list);
			}			
		}

		$a['active_nav'] = 'VIEW';
		$this->load->view('templates/indexmanager', $a);
		$this->load->view('templates/sidebar_manager', $a);
		$this->load->view('managercourse/index', $a);
		//$this->load->view('templates/footerman');
		
	}
	
	public function search_survey(){
		include('course_temp.php');
		$me = new course_temp;
		$me->search_survey( 1 );	
	}	
	
	public function view($slug)
	{	
		$data['course_item'] = $this->course_model->get_courses($slug);
		$data['cancelled_item'] = $this->course_model->get_cancelledCourses($slug);
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$data['userid'] = $uid['id'];
			
		if( empty($data['course_item']) )
		{
			show_404();
		}
		else if( empty($data['cancelled_item']) )
		{
			show_404();
		}
			
		$this->load->helper('url');
			
		$this->load->view('templates/indexmanager', $data);
		$this->load->view('managercourse/view', $data);
		$this->load->view('templates/footer');
	}
	
	public function search_findTemp($var2){
		$data['search'] = $var2;
	}
		
	public function search_find()
	{
		if( !isset($_POST['search']) ){
			redirect('http://localhost/meteor/index.php/managercourse'); 
			return;
		}
		$data['search'] = $_POST['search'];
		$data['title'] = "MeTEOR | Search Results";
		$var = $this->input->post('type');
		$var1 = $this->input->post('search');
		
		if( $var === "USER" ){ 
			//redirect('http://localhost/meteor/index.php/validation/manager_search_results/'.$var1.'');
			include_once('validation.php');
			$me = new validation;
			$me->manager_search_results($var1);
			return;
		}
		
		$a = array();
		include_once('course_temp.php');
		$me = new course_temp;
		$r = $me->listCourseUsers();
		$a['array'] = $r['array'];
		$a['count_All'] = $r['count'];

		$a['count']=0;
		
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$a['userid'] = $uid['id'];
		
		$result = $this->course_model->get_results($data, 'courses');
		$cancelled = array();
		$dissolved = array();
		$a['decount'] = 0;
		
		foreach($result->result_array() as $row)
		{
			$cancelled = $this->course_model->fetch_cancelled($row['id']);
			$arrayCancelled = $cancelled->row_array();
			$dissolved = $this->course_model->fetch_dissolved($row['id']);
			$arrayDissolved = $dissolved->row_array();
			
			if( empty($arrayCancelled['id']) && empty($arrayDissolved['id']) ){
				$paid_list = $this->participantuser_model->getDB( 'payment', 'course_id', $row['id'], '', '', 0);
				$paid_list = $paid_list->result_array();

				$a['count']++;
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
				$a['objectives'][] = $row['objectives'];
				$a['attendees'][] = $row['attendees'];
				$a['food'][] = $row['food'];
				$a['foodRemarks'][] = $row['foodRemarks'];
				$a['landTranspo'][] = $row['landTranspo'];
				$a['landRemarks'][] = $row['landRemarks'];
				$a['airfare'][] = $row['airfare'];
				$a['airfareRemarks'][] = $row['airfareRemarks'];
				$a['accommodation'][] = $row['accomodation'];
				$a['accommodationRemarks'][] = $row['accomodationRemarks'];
				$a['paid'][] = count($paid_list);
			}

		}
		
		$data['search'] = 1;
		$this->load->helper('url');
		$data['active_nav'] = 'VIEW';
		$this->load->view('templates/indexmanager', $data);
		$this->load->view('templates/sidebar_manager', $data);
		$this->load->view('managercourse/index', $a);
		//$this->load->view('templates/footerman');
	}
	
	public function search_cancelled(){
		include_once('course_temp.php');
		$me = new course_temp;
		$me->search_cancelled();
		
		/*if( !isset($_POST['search']) ){
			redirect('http://localhost/meteor/index.php/managercourse/cancelled'); 
			return;
		}
		$data['search'] = $_POST['search'];
		$data['title'] = "MeTEOR | Search Results";
		$a = array();
		$a['counter']=0;
		
		$result = $this->course_model->get_results($data, 'courses',1);

		foreach($result->result() as $row)
		{			
			$a['id'][] = $row->id;
			$a['name'][] = $row->name;
			$a['description'][] = $row->description;
			$a['venue'][] = $row->venue;
			$a['cost'][] = $row->cost;
			$a['reserved'][] = $row->reserved;
			$a['available'][] = $row->available;
			$a['paid'][] = $row->paid;
			$a['counter']++;	
		}
		
		$this->load->helper('url');
		
		$this->load->view('templates/indexmanager', $data);
		$this->load->view('managercourse/cancelled_find', $a);
		$this->load->view('templates/footerman');*/
	}
	
	public function cancelled_find($num){
		$data['letter'] = $num;
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$data['userid'] = $uid['id'];
		
		$config = array();
		$config['total_rows'] = $this->course_model->record_count();
		$config['per_page'] = $this->course_model->record_count();
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0 ;
		
		$data['courses'] = $this->course_model->fetch_courses_cancelled( $data['letter'], $config['per_page'], $page);
		$data['cancelled'] = $this->course_model->fetch_courses_cancelled( $data['letter'], $config['per_page'], $page);
		$data['title'] = 'MeTEOR | Cancelled Course';	
		
		$this->load->helper('url');
		
		$this->load->view('templates/indexmanager', $data);
		$this->load->view('managercourse/cancelled', $data);
		$this->load->view('templates/footerman');
	}
	
	public function seeCancelled( $num ){		
		$data['title'] = 'MetEOR | Refund List';
		$this->load->helper('url');
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$data['userid'] = $uid['id'];
		
		$data['id'] = $num;
		
		$results = $this->course_model->fetch_cancelled( $num );
		$data['users'] = $results->result_array();
						
		$this->load->view('templates/indexmanager', $data);
		$this->load->view('managercourse/participants1', $data);
		$this->load->view('templates/footerman');
	}
	
	public function process( $num )
	{
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$data['userid'] = $uid['id'];
		
		if( $num >= 'A' && $num <= 'Z' ){
			$data['letter'] = $num;
			
			$config = array();
			$config['total_rows'] = $this->course_model->record_count();
			$config['per_page'] = $this->course_model->record_count();
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0 ;
			$data['courses'] = $this->course_model->fetch_courses( 'courses', $data['letter'], $config['per_page'], $page);
			$data['title'] = 'Course';
			
			$this->load->view('templates/indexmanager', $data);
			$this->load->view('managercourse/index', $data);
			$this->load->view('templates/footerman');
			
		}
		else{
			$data['title'] = 'MeTEOR | Participants';
			include_once('course_temp.php');
			$me = new course_temp;
			$r = $me->listCourseUsers();
			$data['array'] = $r['array'];
			$data['count_All'] = $r['count'];
			
			$this->load->helper('url');
			
			$data['id'] = $num;
			$data['countRes'] = 0;
			$data['countPaid'] = 0;
			
			$results = $this->course_model->fetch_All( $data['id'] );
			$data['users'] = $results->result_array();		

			foreach( $data['users'] as $row ){
				$queryRes = $this->db->get_where( 'reserved', array('user_id' => $row['user_id'], 'course_id' => $row['course_id']) );
				$arrRes = $queryRes->result_array();
				
				
				$queryPaid = $this->db->get_where( 'payment', array('user_id' => $row['user_id'], 'course_id' => $row['course_id']) );
				$arrPaid = $queryPaid->result_array();
				
				foreach( $arrRes as $ro1 ) {
					$data['tagR'][]  = $row['user_id'];
					$data['countRes']++;
				}	
				
				foreach( $arrPaid as $ro2 ){
					$data['tagP'][]  = $row['user_id'];
					$data['countPaid']++;
				}
			}			
			
			$data['man'] = 1;
			$data['temporary'] = 1;
			$data['active_nav'] = 'VIEW';
			$this->load->view('templates/indexmanager', $data);
			$this->load->view('templates/sidebar_manager', $data);
			$this->load->view('course/participants', $data);
			//$this->load->view('templates/footerman');
		}	
	}
	
	public function cancelledStatus()
	{		 
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
			
		$config = array(
			array(
				'field' => 'course_id',
				'label' => 'Course_id',
				'rules' => 'required'
				), 
			array(
				'field' => 'user_id',
				'label' => 'User_id',
				'rules' => 'required'
			),
			array(
				'field' => 'date',
				'label' => 'Date',
				'rules' => 'required'
			),
			array(
				'field' => 'refunded',
				'label' => 'Refunded',
				'rules' => 'required'
			)
		);
			
		$this->form_validation->set_rules($config);
		
		if( $this->form_validation->run() === FALSE )
		{	
			$this->load->view('templates/indexmanager', $data);	
			$this->load->view('managercourse/index');
			$this->load->view('templates/footerman');
			$this->index();
		}
		else
		{
			$this->course_model->set_cancelledStatus();
			$this->index();
		}		
	}
	
	public function cancelled()
	{		
		include_once('course_temp.php');
		$me = new course_temp;
		$me->cancelled();
	}
	
	public function upload_image($field_name, $new_name){
		
		$config2['upload_path'] = 'upload/';
		$config2['allowed_types'] = 'gif|jpg|png|jpeg|jpe';
		$config2['max_size']	= '100';
		$config2['max_width']  = '1024';
		$config2['max_height']  = '768';
		$config2['file_name'] = $new_name;
		$config2['overwrite'] = true;
		
		$this->load->library('upload', $config2);
		$this->upload->initialize($config2);		
		
		if ( ! $this->upload->do_upload($field_name) ){
			$error = array('error' => $this->upload->display_errors());
			$this->upload( $error );
			return '';
		}
		else{
			$imgOriginalData = $this->upload->data();
			return $imgOriginalData[ 'orig_name' ];
		}
	}
	
	public function upSig(){
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		date_default_timezone_set("Asia/Manila");
		$starting = date('Y-m-d');	

		$ending = date('Y-m-d', strtotime($_POST['ending']));
		//$ending = date( 'Y-m-d' , strtotime($conv));

		if( empty($_POST['ending']) ){
			$error = array('error' => "No Ending Date Selected");
			$this->upload( $error );
			return;
		}
		
		$nameS = 'photo';
		$name2 = 'photo2';

		$signee = 0;
		$signee = (int)$this->input->post('signee');

		$signatory_name1 = $_POST['CompName1'];
		$signatory_name2 = $_POST['CompName2'];

		$signatory_position1 = $_POST['position1'];
		$signatory_position2 = $_POST['position2'];

		$field_name = $_FILES[$nameS]['name'];
		$field_name2 = $_FILES[$name2]['name'];
		$type = $this->input->post('cert');

		if($_FILES[$nameS]['size'] <= 0){ $place = ''; }
		if($_FILES[$name2]['size'] <= 0){ $place2 = ''; }
		$place = $this->upload_image('photo', $ending."".$field_name);
		if( !$signee ) $place2 = $this->upload_image('photo2', $ending."".$field_name2);

		$error = array('error' => "Error Uploading");
		if( !empty($place) ){
			$error = array('error' => "Success Uploading");
			if( !$signee && !empty($place2) ){
				if( isset($_POST['check']) ){
					foreach( $_POST['check'] as $item){	
						$course_id = $_POST['course'][$item];
						$this->course_model->insert_pic( $starting, $ending, $place, $course_id, $place2, 1, $type, $signatory_name1, $signatory_position1, $signatory_name2, $signatory_position2);
					}
				}else $error = array('error' => "No Course Selected");
			}
			elseif( $signee ) {
				if( isset($_POST['check']) ){
					foreach( $_POST['check'] as $item){	
						$course_id = $_POST['course'][$item];
						$this->course_model->insert_pic( $starting, $ending, $place, $course_id, '', 0, $type, $signatory_name1, $signatory_position1, '', '' );
					}
				}else $error = array('error' => "No Course Selected");
			}
		}
		$this->upload( $error );
	}
	
	public function upload( $err = '' ){
		$this->load->helper('url');
		
		$letter = $this->uri->segment(3);
		$data['letter'] = substr( $letter, 0 , 1 );
		
		$config = array();
		$config['per_page'] = $this->course_model->record_count();
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0 ;
		
		$data['courses'] = $this->course_model->fetch_courses( 'courses', $data['letter'], $config['per_page'], $page, 1);
		
		$a = $this->indexCourse($data, 1);
		$a['title'] = 'MeTEOR | Upload Signature';
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$a['userid'] = $uid['id'];
		
		if( !empty($err) )
		$a['error'] = $err['error'];
		
		$a['man'] = 1;
		$a['active_nav'] = 'UPLOAD';
		$this->load->view('templates/indexmanager', $a);
		$this->load->view('templates/sidebar_manager', $a);
		$this->load->view('course/upload', $a );
		//$this->load->view('templates/footerman');
	}
	
	public function search_upload()
	{
		if( !isset($_POST['search']) ){
			redirect('http://localhost/meteor/index.php/managercourse/upload'); 
			return;
		}

		$data['search'] = $_POST['search'];
		$data['title'] = "MeTEOR | Search Results";
				
		$a = array();
		$a['counter']=0;
		
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$a['userid'] = $uid['id'];
		
		$result = $this->course_model->get_results($data, 'courses');
		$cancelled = array();
		$dissolved = array();
		$a['decount'] = 0;
		
		foreach($result->result() as $row)
		{
			$cancelled = $this->course_model->fetch_cancelled($row->id);
			$arrayCancelled = $cancelled->row_array();
			$dissolved = $this->course_model->fetch_dissolved($row->id);
			$arrayDissolved = $dissolved->row_array();
			
			$canTag = 0;
			if( !empty($arrayCancelled['id']) || !empty($arrayDissolved['id']) ){
				$a['tag'][] = $row->id;
				$a['decount']++;
				$canTag = 1;
			}
			
			$arr = $this->participantuser_model->getDB('signature', 'course_id', $row->id, '', '', 0);
			$result = $arr->result_array();
			$tag = 0;

			foreach ($result as $value) {
				if( $value['id'] ) $tag = 1;
			}

			if( !$tag && !$canTag ){	
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
		}
		
		$this->load->helper('url');
		
		$a['man'] = 1;
		$data['active_nav'] = 'UPLOAD';
		$this->load->view('templates/indexmanager', $data);
		$this->load->view('templates/sidebar_manager', $data);
		$this->load->view('course/search_upload', $a);
		//$this->load->view('templates/footerman');
	}
	
	public function reports( $error = '')
	{		
		include_once('course_temp.php');
		$me = new course_temp;
		$me->reports();
	}
	
	public function reports_search()
	{
		$data['title'] = "MeTEOR | Search Results";
		$var = $this->input->post('type');
		$var1 = $this->input->post('search');
		$dept = $this->input->post('dept');

		if( !isset($_POST['starting']) ){
			redirect('http://localhost/meteor/index.php/managercourse/reports'); 
			return;
		}

		$temp1 = date('Y-m-d', strtotime($_POST['starting']));
		$temp2 = date('Y-m-d', strtotime($_POST['ending']));

		if( $temp1 > $temp2 ){
			$this->reports('Start Date should be less than End Date');
			return;
		}
		
		if( $var === "USER" ){//redirect('http://localhost/meteor/index.php/validation/search_reports/'.$var1.'');	
			include_once('course_temp.php');
			$me = new course_temp;
			//$me->search_reports('USER', 1, $a['starting'], $a['ending']);
			$a = array();
			$a['counter'] = 0;
			$secresult = $this->course_model->getUserRep();
			$a = $me->search_reports($secresult);

			$a['starting1'] = $temp1;
			$a['ending1'] = $temp2;

			$a['man'] = 1;
			$this->load->view('templates/indexmanager', $data);
			$this->load->view('course/wat', $a);
			$this->load->view('templates/footerman');
		} else {
			if( $dept == '-- Dept --' ){
				$a = array();
				$result = $this->course_model->get_reports('courses', 1);
				$a = $this->getCourseList($result);
				
				$a['starting'] = $temp1;
				$a['deptTrue'] = 0;
				$a['dept'] = $dept;
				$a['ending'] = $temp2;
				
				$this->load->helper('url');
				
				$this->load->view('templates/indexmanager', $data);
				$this->load->view('managercourse/reports_search', $a);
				$this->load->view('templates/footerman');	
			} else{
				$a = array();
				if( $dept == '-- ALL --' ) $result = $this->course_model->get_tempCourses(1);
				else $result = $this->course_model->get_tempCourses();
				$a = $this->getCourseList($result, 1);
				
				$a['starting'] = $temp1;
				$a['deptTrue'] = 1;
				$a['dept'] = $dept;
				$a['ending'] = $temp2;
				
				$this->load->helper('url');
				
				$this->load->view('templates/indexmanager', $data);
				$this->load->view('managercourse/reports_search', $a);
				$this->load->view('templates/footerman');	
			}
		}
	}
	
	public function getCourseList( $result, $num = 0 ){
		$a = array();
		$a['counter']=0;
		$a['decount'] = 0;
		
		$cancelled = array();
		$dissolved = array();
		
		foreach($result->result() as $row)
		{
			$cancelled = $this->course_model->fetch_cancelled($row->id);
			$arrayCancelled = $cancelled->row_array();
			$dissolved = $this->course_model->fetch_dissolved($row->id);
			$arrayDissolved = $dissolved->row_array();
			
			if( !empty($arrayCancelled['id']) || !empty($arrayDissolved['id']) ){
				$a['tag'][] = $row->id;
				$a['decount']++;
			}
			
			$a['id'][] = $row->id;
			$a['name'][] = $row->name;
			$a['start'][] = $row->start;
			$a['end'][] = $row->end;			
			$a['venue'][] = $row->venue;
			$a['paid'][] = $row->paid;
			$a['reserved'][] = $row->reserved;

			if( !$num ){				
				$a['description'][] = $row->description;
				$a['cost'][] = $row->cost;
				$a['available'][] = $row->available;
			}else{
				$a['count'][] = $row->count;
				$a['facilitator'][] = $row->facilitator;
				$a['department'][] = $row->department;
			}
			$a['counter']++;
		}
		
		return $a;
	}
	
	public function participantReport( $num, $temp ){
		$data = array();
		$this->load->helper('url');
		
		$name = $this->course_model->courseGet( $num, $temp );
		$num = $name[0]['id'];
		include_once('course_temp.php');
		$me = new course_temp;

		$data = $me->getParticipantReport($num);
		
		foreach( $name as $row ){
			$data['name'] = $row['name'];
			$data['starting1'] = $row['start'];
			$data['ending1'] = $row['end'];
			$data['course_id'] = $row['id'];
			$data['description'] = $row['description'];
			break;
		}
		$data['title'] = 'MeTEOR | Participants Reports';
		$data['id'] = $num;
		
		$this->load->view('templates/indexmanager', $data);
		$this->load->view('managercourse/participantsReports', $data);
		$this->load->view('templates/footerman');
	}
	
	public function surveyResult(){
		$a = array();
		$a['count'] = 0;
		include_once('pages.php');
		$me = new pages;
		$survey = $this->course_model->calculateTotal( 0 );
		$me->updateTotal($survey);
		
		$survey = $this->course_model->calculateTotal( 1 );
		foreach ($survey->result() as $key) {
			$total = 0; $total1 = 0; $total2 = 0; $total3 = 0; $total4 = 0; $total5 = 0; $total6 = 0;

			$usersList = $this->participantuser_model->getDB( 'users', 'id', $key->userid, '', '', 0 );
			$userListArray = $usersList->result_array();

			foreach ($userListArray as $value) {
				$a['lastname'][] = $value['lastname'];
				$a['firstname'][] = $value['firstname'];
			}

			$courseList = $this->participantuser_model->getDB( 'courses', 'id', $key->course_id, '', '', 0 );
			$courseListArray = $courseList->result_array();

			foreach ($courseListArray as $value1) {
				$a['courseName'][] = $value1['name'];
			}

			for( $i = 1; $i <= 8; $i++ ){
				$name = 'objective'.$i;
				$total = $total + $key->$name;
				$total1 = $total1 + $key->$name;
			}

			$a['total1'][] = $total1;

			for( $i = 1; $i <= 5; $i++ ){
				$name = 'facilities'.$i;
				$total = $total + $key->$name;
				$total4 = $total4 + $key->$name;
			}

			$a['total4'][] = $total4;

			for( $i = 1; $i <= 6; $i++ ){
				$name = 'instructor'.$i;
				$total = $total + $key->$name;
				$total5 = $total5 + $key->$name;
			}

			$a['total5'][] = $total5;

			for( $i = 1; $i <= 3; $i++ ){
				$name = 'methodology'.$i;
				$total = $total + $key->$name;
				$total2 = $total2 + $key->$name;
			}

			$a['total2'][] = $total2;

			for( $i = 1; $i <= 3; $i++ ){
				$name = 'materials'.$i;
				$total = $total + $key->$name;
				$total3 = $total3 + $key->$name;
			}

			$a['total3'][] = $total3;

			for( $i = 1; $i <= 6; $i++ ){
				$name = 'overall'.$i;
				$total = $total + $key->$name;
				$total6 = $total6 + $key->$name;
			}

			$a['total6'][] = $total6;

			$a['count']++;
			$a['overAllTotal'][] = $total;
		}
		$a['man'] = 1;
		$a['title']  = "MeTEOR | Survey Result";
		$this->load->view('templates/indexmanager', $a);
		$this->load->view('course/resultSurvey', $a);
		$this->load->view('templates/footerman');
	}

	public function printS(){
		include('course_temp.php');
		$new = new course_temp;
		$new->printS();
	}
	
	public function printOne(){		
		include('course_temp.php');
		$new = new course_temp;
		$new->printOne();
	}

	public function SURVEY(){
		include('course_temp.php');
		$new = new course_temp;
		$new->SURVEY(1);
	}

	public function origsurveyResult(){
		include('course_temp.php');
		$new = new course_temp;
		$new->origsurveyResult(1);		
	}

	public function request(){
		include('course_temp.php');
		$new = new course_temp;
		$new->request('', 1);
	}

	public function search_request(){
		include('course_temp.php');
		$new = new course_temp;
		$new->search_request(1);
	}

	public function seeRequest( $tempId, $man, $tag ){
		include('course_temp.php');
		$new = new course_temp;
		$new->seeRequest( $tempId, $man, $tag );
	}	

	public function sendEmail(){
		include('course_temp.php');
		$new = new course_temp;
		$new->sendEmail( 1 );
	}

	public function setSurvey(){
		include_once('course_temp.php');
		$new = new course_temp;

		if( !isset($_POST['course_idDate']) ) {
			redirect('http://localhost/meteor/index.php/managerparticipant'); 
			return;
		}

		$cid = $_POST['course_idDate']; 
		$uid = $_POST['user_id']; 

		$orderByDate = array(); $num = 0;
		foreach ($_POST['endDateCert'] as $key => $value) { // sort the date into ascending order
			//$mail->AddAddress($value);
			list($S1, $S2) = explode(' - ',$value);
			//echo $S1;
			$orderByDate[$key][$num]  = strtotime($S1);
			$orderByDate[$key][$num + 1]  = strtotime($S2);
			$num = 0;
		}
		array_multisort($orderByDate, SORT_ASC, $_POST['endDateCert']);
		$start_sift = array(); $i = 0; $full_string = "";

		foreach ($_POST['endDateCert'] as $key => $value) {
			$value = str_replace(",", "", $value);
			list( $s1, $s2 ) = explode(" - ",  $value);
			$last = $s2;
			if( !$i ) $first = $s1;
			$start_sift[$i] = $new->seperate( $s1, $s2 );
			$i++;
		}

		for( $j = 0; $j < $i; $j++ ){
			if( !$j ) $full_string .= $start_sift[$j];
			else $full_string = $new->second_sift( $full_string, $start_sift[$j] );
		}

		$full_string = str_replace(" ;", " ", $full_string);
		$full_string = str_replace(" . ", " ", $full_string);

		$this->course_model->updater($cid, $uid, $full_string, $last, $first);

		include_once('managerparticipant.php');
		$me = new managerparticipant;
		$me->viewprofile('End dates for certificate saved', $uid, 1);
		return;
	}

	public function indexCourse( $data, $num ){
		$cancelled = array();
		$dissolved = array();
		$a = array();
		$a['count'] = 0; $a['counter'] = 0; $a['certDownload'] = 0;
		
		foreach( $data['courses'] as $row ){
			$cancelled = $this->course_model->fetch_cancelled($row['id']);
			$arrayCancelled = $cancelled->row_array();
			$dissolved = $this->course_model->fetch_dissolved($row['id']);
			$arrayDissolved = $dissolved->row_array();
			if( empty($arrayCancelled['id']) && empty($arrayDissolved['id']) ){
				if( $num ){
					$arr = $this->participantuser_model->getDB('signature', 'course_id', $row['id'], '', '', 0);
					$result = $arr->result_array();
					$tag = 0;

					foreach ($result as $value) {
						if( $value['id'] ){
							$tag = 1;
							$a['certDownload']++;
							$a['certID'][] = $value['course_id'];
							$a['Certname'][] = $row['name'];
							$a['Certdescription'][] = $row['description'];
							$a['Certstart'][] = $row['start'];
							$a['Certend'][] = $row['end'];
							$a['Certpaid'][] = $row['paid'];
							$a['venue'][] = $row['venue'];
							$a['Certcost'][] = $row['cost'];
							$a['Certavailable'][] = $row['available'];
							$a['Certreserved'][] = $row['reserved'];	
						} 
					}

					if( !$tag ){
						$a['counter']++;
						$a['id'][] = $row['id'];
						$a['name'][] = $row['name'];
						$a['description'][] = $row['description'];
						$a['start'][] = $row['start'];
						$a['end'][] = $row['end'];
						$a['paid'][] = $row['paid'];
						$a['venue'][] = $row['venue'];
						$a['cost'][] = $row['cost'];
						$a['available'][] = $row['available'];
						$a['reserved'][] = $row['reserved'];	
					}					
				}
				else{
					$a['count']++;
					$a['id'][] = $row['id'];
					$a['name'][] = $row['name'];
					$a['objectives'][] = $row['objectives'];
					$a['description'][] = $row['description'];
					$a['start'][] = $row['start'];
					$a['end'][] = $row['end'];
					$a['paid'][] = $row['paid'];
					$a['startTime'][] = $row['startTime'];
					$a['endTime'][] = $row['endTime'];
					$a['venue'][] = $row['venue'];
					$a['cost'][] = $row['cost'];
					$a['available'][] = $row['available'];
					$a['reserved'][] = $row['reserved'];
					$a['attendees'][] = $row['attendees'];
					$a['package'][] = $row['package'];
					$a['startTime'][] = $row['startTime'];
					$a['endTime'][] = $row['endTime'];
					$a['landTranspo'][] = $row['landTranspo'];
					$a['landRemarks'][] = $row['landRemarks'];
					$a['airfare'][] = $row['airfare'];
					$a['airfareRemarks'][] = $row['airfareRemarks'];
					$a['totalexp'][] = $row['totalexp'];
				}
			}			
		}
		
		return $a;
	}
}