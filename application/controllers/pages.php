<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	session_start();

class pages extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model(array('login_model','course_model', 'participantuser_model'));
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','mpdf'));
	}

	public function index( $data = '', $message='', $reset=0, $ver=0, $err='' ){
		if(!$this->islogged()){
			if( empty($data['unique']) )
				$data['unique'] = 0;
			if( empty($data['CourseName']) )
				$data['CourseName'] = '';

			$data['title'] = "MeTEOR | Login";
			$data['error'] = $err;
			$data['message'] = $message;
			$data['reset'] = $reset;
			$data['ver'] = $ver;
			$b = $this->login_model->getAllUsers();
			foreach($b->result_array() as $res){
				$data['emails'][] = $res['username'];
			}

			$this->load->view('templates/indexheader',$data);
			$this->load->view('pages/login',$data);
			$this->load->view('templates/footer');
		}
		else{
			$role = $this->islogged();
			$role = $role - 1;
			if($role == 0) redirect('http://localhost/meteor/index.php/course_temp');	
			else if($role == 1) redirect('http://localhost/meteor/index.php/managercourse');
			else if($role == 2) redirect('http://localhost/meteor/index.php/participantcourse/upcoming');
		}
	}

	public function invalid(){
		$this->index('','Please Check your email for verification',0,1);
		return;
	}
	
	public function listCourseUsers1(){
		$a['count'] = 0;
		$a['array'] = '[';

		$query = $this->db->get('courses');
		foreach ($query->result_array() as $row) {
			$name = $row['name'];
			$a['array'] .= "\"$name\"";
			if(($a['count']+1) < count($query->result_array())) $a['array'] .= ', ';
			$a['count']++;
		}

		$a['array'] .= ']';
			
		return $a;
	}

	public function courselist(){
		$r = $this->listCourseUsers1();

		$data['courses'] = $this->course_model->get_courses();
		$data['cancelled'] = $this->course_model->get_cancelledCourses();
		
		$a = array();
		$a['array'] = $r['array'];
		$a['count_All'] = $r['count'];
		$a['title'] = 'MeTEOR | Course List';
		
		$this->load->helper('url');
		
		$cancelled = array();
		$dissolved = array();
		$a['count'] = 0;
		
		foreach( $data['courses'] as $row ){
			$cancelled = $this->course_model->fetch_cancelled($row['id']);
			$arrayCancelled = $cancelled->row_array();
			$dissolved = $this->course_model->fetch_dissolved($row['id']);
			$arrayDissolved = $dissolved->row_array();
			if( empty($arrayCancelled['id']) && empty($arrayDissolved['id']) ){
				$a['count']++;
				$a['id'][] = $row['id'];
				$a['name'][] = $row['name'];
				$a['description'][] = $row['description'];
				$a['start'][] = $row['start'];
				$a['time'][] = date('h:i A', strtotime($row['startTime']))." - ". date('h:i A', strtotime($row['endTime'])) ;
				$a['end'][] = $row['end'];
				$a['venue'][] = $row['venue'];
				$a['cost'][] = $row['cost'];
				$a['available'][] = $row['available'];
				$a['reserved'][] = $row['reserved'];
				$a['paid'][] = $row['paid'];
			}			
		}
		
		$this->load->view('templates/indexheader', $a);
		$this->load->view('pages/courselist', $a);
		$this->load->view('templates/footerme');
	}
	
	public function enroll(){
		$data['title'] = "MeTEOR | Login";
		if( !$this->islogged() ){
			$data['error'] = "Please Login First";
			$data['date'] = $this->input->post('date');
			$data['course_id'] = $this->input->post('course_id');

			$b = $this->login_model->getAllUsers();
			foreach($b->result_array() as $res){
				$data['emails'][] = $res['username'];
			}

			$data['enroll'] = 1;
			$this->load->view('templates/indexheader', $data);
			$this->load->view('pages/login');
			$this->load->view('templates/footer');
		}
		else{
			$this->insert_data();
		}	
	}

	public function submit(){
		$config = array(
			array(
				'field'   => 'fname', 
                'label'   => 'First name', 
                'rules'   => 'required'
            ),
            array(
				'field'   => 'lname', 
				'label'   => 'Last name', 
				'rules'   => 'required'
            ),
            array(
				'field'   => 'mname', 
				'label'   => 'Middle name', 
				'rules'   => 'required'
            ),
			array(
				'field'   => 'mail', 
				'label'   => 'Email', 
				'rules'   => 'required|valid_email|matches[mailconf]|is_unique[users.username]'
            ),
			array(
				'field'   => 'mailconf', 
				'label'   => 'Email Confirm', 
				'rules'   => 'required|valid_email'
            ),
			array(
				'field'   => 'pass', 
				'label'   => 'Password', 
				'rules'   => 'required|matches[passconf]|min_length[6]'
            ),
			array(
				'field'   => 'passconf', 
				'label'   => 'Password Confirm', 
				'rules'   => 'required|min_length[6]'
            )
        );
		$this->form_validation->set_rules($config);

		if ($this->form_validation->run() == FALSE){
			$data['unique']  = $_POST['unique'];
			$data['CourseName']  = $_POST['CourseName'];
			$this->index( $data );
		}
		else{
			include_once $_SERVER['DOCUMENT_ROOT'].'/meteor/securimage/securimage.php';
			$securimage = new Securimage();

			if ($securimage->check($_POST['captcha_code']) == false) {
				$data['unique']  = $_POST['unique'];
				$data['CourseName']  = $_POST['CourseName'];
				$data['errors'] = 'The SECURITY CODE entered was incorrect';
				$this->index( $data );
			} else {
				if( $_POST['unique'] ) $this->login_model->putData( 0, $_POST['unique'], $_POST['CourseName'] );
				else $this->login_model->putData();
				$this->invalid();
			}
		}
	}
	
	
	public function validate3(){
		$data['title'] = "MeTEOR | Validation";
		$this->load->view('templates/indexheader',$data);
		$this->load->view('pages/validate2');
		$this->load->view('templates/footer');
	}
	
	public function submitPass(){
		$config = array(
			array(
				'field'   => 'mail', 
				'label'   => 'Email', 
				'rules'   => 'required|valid_email'
            )
        );
		$this->form_validation->set_rules($config);
		
		if ($this->form_validation->run() == FALSE){
			include_once('temp.php');
			$me = new temp;
			$error = "Email is Required";
			$me->forgotpw($error);
		}
		else{
			//$user = $this->input->post('mail');
			//echo "dasdasdasd";
			$result = $this->login_model->putData(1);//forgot($user);
			//echo $result;
			if($result){
				$this->index('','Please Check your email for your password reset',1);
				return;
			}
			else{
				$data['title'] = "MeTEOR | Validation";
				$data['error'] = "Invalid username";
				$this->load->view('templates/indexheader',$data);
				$this->load->view('pages/forgot',$data);
				$this->load->view('templates/footer');
			}
			
		}
	}
	
	public function login_enroll(){
		$config = array(
			array(
				'field'   => 'user', 
                'label'   => 'Username', 
                'rules'   => 'required|valid_email'
            ),
            array(
				'field'   => 'pword', 
				'label'   => 'Password', 
				'rules'   => 'required'
            )
        );
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE){
			$this->index('','',0,0,'Invalid username and/or password');
		}
		else{
			$uname = $this->input->post('user');
			$pword = $this->input->post('pword');
			$data['date'] = $this->input->post('date');
			$data['course_id'] = $this->input->post('course_id');
			
			if(!$this->login_model->verifyLog($uname,$pword)){
				$b = $this->login_model->getAllUsers();
				foreach($b->result_array() as $res){
					$data['emails'][] = $res['username'];
				}

				$data['title'] = "MeTEOR | Login";
				$data['error'] = "Invalid username and/or password";
				$data['enroll'] = 1;
				$this->load->view('templates/indexheader', $data);
				$this->load->view('pages/login', $data);
				$this->load->view('templates/footer');
			}
			else{
				$result = $this->login_model->getuid($uname);
				$this->log($uname, $result['role']);
				if($result['role'] == 2){
					$continue = $this->insert_data( $this->input->post('course_id'), $this->input->post('date') );
					if( $continue ) redirect('http://localhost/meteor/index.php/participantcourse/upcoming');	
					else{
						$b = $this->login_model->getAllUsers();
						foreach($b->result_array() as $res){
							$data['emails'][] = $res['username'];
						}

						$data['title'] = "MeTEOR | Login";
						$data['error'] = "No More Available Slot.";
						$data['enroll'] = 1;

						$data['date'] = $this->input->post('date');
						$data['course_id'] = $this->input->post('course_id');
						$this->session->sess_destroy();
						$this->load->view('templates/indexheader', $data);
						$this->load->view('pages/login', $data);
						$this->load->view('templates/footer');
					}
				}
				else if($result['role'] == 1) redirect('http://localhost/meteor/index.php/managercourse');
				else if($result['role'] == 0) redirect('http://localhost/meteor/index.php/course_temp');	
			}
		}
	}
	
	public function insert_data( $course_id, $date ){
		$this->load->helper('url');
		$uname = $this->input->post('user');
		
		$uname = $this->db->get_where('users', array('username' => $uname));
		$uname = $uname->row_array();
		
		$queryRe = $this->db->get_where('reserved', array('course_id' => $course_id, 'user_id' => $uname['id']));
		$dataRe = $queryRe->row_array();
		
		$queryCash = $this->db->get_where('payment', array('course_id' => $course_id, 'user_id' => $uname['id']));
		$dataCash = $queryCash->row_array();
		
		if( empty($dataCash['id']) && empty($dataRe['id']) ){				
			$query = $this->db->get_where('courses', array('id' => $course_id));
			$data = $query->row_array();
			
			$a = $this->login_model->counting( 'course_id', 'reserved', $course_id );
			$b = $this->login_model->counting( 'course_id', 'payment', $course_id );
			$c = $a + $b;
			//var_dump($data);
			if( $c+1 > $data['available'] ) return 0; 
			else $a++;	
			
			$data = array(
				'reserved' => $a
			);

			$this->db->where('id', $course_id);
			$this->db->update('courses', $data);
			
			$this->db->set('user_id',  $uname['id']); 
			$this->db->set('course_id', $course_id); 
			$this->db->set('date', $date); 
			
			$this->db->insert('reserved');	
		}
		
		return 1;
	}
	
	public function login(){
		$config = array(
			array(
				'field'   => 'user', 
                'label'   => 'Username', 
                'rules'   => 'required|valid_email'
            ),
            array(
				'field'   => 'pword', 
				'label'   => 'Password', 
				'rules'   => 'required'
            )
        );
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE){
			$data['unique']  = $_POST['unique'];
			$data['CourseName']  = $_POST['CourseName'];
			$this->index( $data,'',0,0,'Invalid username and/or password' );
		}
		elseif( !empty($_POST['unique']) ){			
			$uname = $this->input->post('user');
			$pword = sha1($this->input->post('pword'));

			$array = $this->participantuser_model->getDB( 'users', 'username', $uname, 'password', $pword, 1 );
			$result = $array->result_array();

			if( !empty($result[0]['slug']) ) $this->finalStepRequest( $result[0]['slug'], $_POST['unique'] );//$this->login_model->putData( 0, $_POST['unique'], $_POST['CourseName'] );			
			else{
				$data['title'] = "MeTEOR | Login";
				$data['error'] = "Invalid username and/or password";
				$data['unique']  = $_POST['unique'];
				$data['CourseName']  = $_POST['CourseName'];

				$b = $this->login_model->getAllUsers();
				foreach($b->result_array() as $res){
					$data['emails'][] = $res['username'];
				}

				$this->load->view('templates/indexheader',$data);
				$this->load->view('pages/login', $data);
				$this->load->view('templates/footer');
			}
		}
		else{
			$uname = $this->input->post('user');
			$pword = $this->input->post('pword');
			if(!$this->login_model->verifyLog($uname,$pword)){
				$data['title'] = "MeTEOR | Login";
				$data['error'] = "Invalid username and/or password";
				$data['unique']  = $_POST['unique'];
				$data['CourseName']  = $_POST['CourseName'];
				$b = $this->login_model->getAllUsers();
				foreach($b->result_array() as $res){
					$data['emails'][] = $res['username'];
				}

				$this->load->view('templates/indexheader',$data);
				$this->load->view('pages/login', $data);
				$this->load->view('templates/footer');
			}
			elseif( !$this->login_model->validateUser($uname,$pword) ){
				$data['title'] = "MeTEOR | Login";
				$data['error'] = "You are not not yet validated";
				$word = '';
				if( !empty($_POST['unique']) ) $word = $_POST['unique'];
				$data['unique']  = $word;
				$word = '';
				if( !empty($_POST['CourseName']) ) $word = $_POST['CourseName'];
				$data['CourseName']  = $word;

				$this->load->view('templates/indexheader',$data);
				$this->load->view('pages/login', $data);
				$this->load->view('templates/footer');
			}
			else{
				$result = $this->login_model->getuid($uname);
				$this->log($uname, $result['role']);
				date_default_timezone_set("Asia/Manila");
				$date = date('Y-m-d H:i:s');
				
				$this->course_model->updateOldCourses( $date, $result['id'] );
				$arr = $this->course_model->calculateTotal( 0 );
				$this->updateTotal($arr);

				if($result['role'] == 0) redirect('http://localhost/meteor/index.php/course_temp');	
				else if($result['role'] == 1) redirect('http://localhost/meteor/index.php/managercourse');
				else if($result['role'] == 2) redirect('http://localhost/meteor/index.php/participantcourse/upcoming');
			}
		}
	}
	
	public function updateTotal( $result, $belong=0 ){
		$questions = array();
		$count = 0;
		$all_q = $this->participantuser_model->getDB('all_questions', 'belong', $belong, 'type', '0', 1);
		foreach($all_q->result_array() as $value ){
			array_push($questions,$value['id']."_id");
			$count++;
		}

		foreach ($result->result() as $key) {
			$total = 0;
			for( $i = 0; $i < $count; $i++ ){
				$name = $questions[$i];
				$total = $total + $key->$name;
			}

			$data = array(
				'total' => $total,
				'counted' => 1
			);

			$this->db->where('id', $key->id);
			$this->db->update('survey', $data);
		}
	}

	public function checkpw($rand){
		if($this->login_model->isReal($rand)){
			$user = $this->login_model->getuser($rand);
			$this->log($user['username'], $user['role']);
			redirect('http://localhost/meteor/index.php/changepword');
		}
		else $this->index();
	
	}
	
	public function logout(){
		$this->session->sess_destroy();
		redirect('http://localhost/meteor/index.php/pages');
	}
	
	private function log($uname, $role){
		$this->session->set_userdata('logged',true);
		$this->session->set_userdata('username',$uname);
		$this->session->set_userdata('role', $role);
	}
	
	public function viewPermission($course_id, $user_slug){
		$this->load->library('zip');
		$this->load->helper("file");

		$stylesheet = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/meteor/css/stylesheetCOP.css');
		$stylesheet1 = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/meteor/css/appearance_css.css');

		$b = array();		
		$arrUsers = $this->participantuser_model->getDB( 'users', 'slug', $user_slug, '', '', 0 );
		$users = $arrUsers->result_array();

		$arr = $this->participantuser_model->getDB( 'payment', 'course_id', $course_id, '', '', 0 );
		$courseDetails = $this->participantuser_model->getDB( 'courses', 'id', $course_id, '', '', 0 );

		$cert = $this->participantuser_model->getDB( 'signature', 'course_id', $course_id, '', '', 0);
		foreach ($cert->result_array() as $certValue) {
			$firstSig = $certValue['photo_id'];
			$sectSig = $certValue['photo_id2'];

			$b['signatory_name1'] = $certValue['name1'];
			$b['signatory_position1'] = $certValue['position1'];
			$b['signatory_name2'] = $certValue['name2'];
			$b['signatory_position2'] = $certValue['position2'];
			$b['type'] = $certValue['type'];
		}

		$pic1 = $this->participantuser_model->getDB( 'picture', 'id', $firstSig, '', '', 0);
		$b['signature1'] = $_SERVER['DOCUMENT_ROOT'].'/meteor/upload/';
		$b['signature2'] = $_SERVER['DOCUMENT_ROOT'].'/meteor/upload/';
		$b['numFormat'] = 0;
		foreach ($pic1->result_array() as $placeValue) {
			$b['signature1'] .= $placeValue['name'];
		}
		if( !empty($sectSig) ){
			$pic1 = $this->participantuser_model->getDB( 'picture', 'id', $sectSig, '', '', 0);
			foreach ($pic1->result_array() as $placeValue) {
				$b['signature2'] .= $placeValue['name'];
				$b['numFormat'] = 1;
			}
		}

		foreach ($courseDetails->result_array() as $value) {
			$b['workshop'] = $value['name'];
			$b['venue'] = $value['venue'];
			$b['eventStart'] = $value['start'];
			$b['eventEnd'] = $value['end'];
			break;
		}

		if( strtolower($b['type']) == "appearance" ) $view ='participantcourse/cert_of_appearance';
		else $view ='participantcourse/cert_of_participation2';

		if( strtolower($b['type']) == "appearance" ) {
			$placeHeader = $_SERVER['DOCUMENT_ROOT'].'/meteor/css/images/headApp.png';
			$mpdf = new mPDF('', 'LETTER', 0, 0, 0, 0, 40, 0, 0, 5,'P');
			$mpdf->WriteHTML($stylesheet1,1);
			$id = '';

			$mpdf->SetHTMLHeader('<img src="'.$placeHeader.'">');
			$mpdf->SetHTMLFooter('<img src="' .$_SERVER['DOCUMENT_ROOT'].'/meteor/css/images/footer.png" class="footer">');
		}	
		else {
			$placeHeader = $_SERVER['DOCUMENT_ROOT'].'/meteor/css/images/cert.png';
			$mpdf = new mPDF('', 'LETTER-L', 0, 0, 0, 0, 0, 0, 0, 0,'L');
			$mpdf->WriteHTML($stylesheet,1);
			$id = 'bg';

			$mpdf->SetHTMLHeader('<img id="'.$id.'" src="'.$placeHeader.'">');
		}	

		$certificateDate = $this->participantuser_model->getDB( 'completed', 'user_id', $users[0]['id'], 'course_id', $course_id, 1 );
		$certDate = $certificateDate->result_array();
		$check = $certificateDate->row_array();

		foreach ($arrUsers->result_array() as $keyVal) {
			$b['lname'] = $keyVal['lastname'];
			$b['fname'] = $keyVal['firstname'];
			$b['nameS'] = $b['fname'] . ' ' . $b['lname'];
			break;
		}
		//$this->load->view($view, $b);
		$endD = date('jS \of F Y', strtotime($b['eventEnd']));
		//echo $endD; exit;
		$b['endDateCert'] = $endD;

		if( !empty($check['id']) ){
			$b['endDateCert'] = date('jS \of F Y', strtotime($certDate[0]['last']));
			$b['message2'] = $certDate[0]['string'];
		}

		//$this->load->view($view, $b);
		$mpdf->WriteHTML($this->load->view($view, $b, TRUE));
		$filename = utf8_decode($b['nameS']) . '.pdf';
		$mpdf->Output($filename, "","D");
	}

	public function givePermission($ident, $course_id, $user_slug){
		$result_user = $this->login_model->setValidation($user_slug);
		$result = $this->login_model->setValidation($ident);
		$this->log($result['username'], $result['role']);
		$data2 = array(
			'permission' => 1	
		);

		$this->db->where('course_id', $course_id);
		$this->db->update('survey', $data2);

		$a = array();
		$a['temp'] = 4;
		$a['fullName'] = ucwords(strtolower($result_user['firstname'])." ".strtolower($result_user['lastname'] ));
		$a['title'] = "MeTEOR | Success";

		if( !$result['role'] ) $this->load->view('templates/indexadmin', $a);
		else $this->load->view('templates/indexmanager', $a);

		$this->load->view('course/success', $a);

		if( !$result['role'] ) $this->load->view('templates/footeradmin');
		else $this->load->view('templates/footerman');	
	}

	public function validate($i){
		$result = $this->login_model->setValidation($i);
		$this->log($result['username'], $result['role']);
		redirect('http://localhost/meteor/index.php/participantcourse/upcoming');
	}
	
	public function confirmRequest( $unique, $CourseName ){
		$data['unique'] = $unique;
		$data['CourseName'] = $CourseName;
		$data['title'] = "MeTEOR | Login";

		$b = $this->login_model->getAllUsers();
		foreach($b->result_array() as $res){
			$data['emails'][] = $res['username'];
		}

		$this->load->view('templates/indexheader', $data);
		$this->load->view('pages/login', $data);
		$this->load->view('templates/footer');
	}

	public function finalStepRequest( $ident, $unique ){
		$result = $this->login_model->setValidation($ident);
		$this->log($result['username'], $result['role']);

		$temp_array = $this->participantuser_model->getDB( 'temp_courses', 'code', $unique, '', '', 0 );
		$temp_result = $temp_array->result_array();

		date_default_timezone_set("Asia/Manila");
		$date = date('Y-m-d G:i:s');

		$data = array(
			'user_id' => $result['id'],
			'tempId' => $temp_result[0]['id'],
			'dateToday' => $date
		);

		$check_temp = $this->participantuser_model->getDB('forsending', 'user_id', $result['id'], 'tempId', $temp_result[0]['id'], 1 );
		$check_result = $check_temp->result_array();

		if( !count($check_result) ){
			$this->db->insert('forsending', $data);
		}

		$query = $this->participantuser_model->getDB('pending', 'email', $result['username'], 'course_id', $temp_result[0]['id'],1);
		$query = $query->result_array();

		$r = array('form' => $query[0]['form']);
		$this->db->where('username', $result['username']);
		$this->db->update('users',$r);

		$this->course_model->removePending($result['username'], $temp_result[0]['id']);
		//check if the course is already approved by the admin
		//once it is approved, the user automatically paid when he/she decides to attend the course.
		$courseArray = $this->participantuser_model->getDB( 'courses', 'tempId', $temp_result[0]['id'], '', '', 0);
		$courses = $courseArray->result_array();

		if( count($courses) ){
			$paid_list = $this->participantuser_model->getDB( 'payment', 'course_id', $courses[0]['id'], 'user_id', $result['id'], 1);
			$paid_list = $paid_list->result_array();
			if( !count($paid_list) ){
				$data1 = array(
					'amount' => $temp_result[0]['cost'],
					'user_id' => $result['id'],
					'ornumber' => 0,
					'remarks' => 'free',
					'course_id' => $courses[0]['id'],
					'date' => $date
				);
				$this->db->insert('payment', $data1);
			}
		}

		$a = array();
		$a['temp'] = 2;
		$a['CourseName'] = $temp_result[0]['name'];
		$a['title'] = "MeTEOR | Success";

		//check if the user is admin
		if( $result['role']==0 ) $this->load->view('templates/indexadmin', $a);
		elseif( $result['role']==1 ) $this->load->view('templates/indexmanager', $a);
		else $this->load->view('templates/indexparticipant', $a);

		$this->load->view('course/success', $a);

		if( $result['role']==0 ) $this->load->view('templates/footeradmin');
		elseif( $result['role']==1 ) $this->load->view('templates/footerman');
		else $this->load->view('templates/footerparticipant');
	}

	public function changePassword($i){
		$result = $this->login_model->setValidation($i);
		$this->log($result['username'], $result['role']);
		redirect('http://localhost/meteor/index.php/changepword');
	}

	public function mobile(){
	
		$data['title'] = "MeTEOR | Mobile";
		$where = "";
		if( !$this->islogged() ){
			$where = 'templates/indexheader';
		} else {			
			$name = $this->session->userdata('username');
			
			$query = $this->db->get_where('users', array( 'username' => $name ) );
			$result = $query->row_array();
			
			if( $result['role'] == 0 ) $where = 'templates/indexadmin';
			else if( $result['role'] == 1 ) $where = 'templates/indexmanager';
			else $where = 'templates/indexparticipant';
		}
		
		$this->load->view($where, $data);
		$this->load->view('templates/mobile',$data);
		$this->load->view('templates/footerAndroid');		
	}
	
	public function aboutus(){
	
		$data['title'] = "MeTEOR | About Us";
		$data['num'] = 0;
		if( !$this->islogged() ){
			$where = 'templates/indexheaderP';
		} else {	
			$name = $this->session->userdata('username');
			
			$query = $this->db->get_where('users', array( 'username' => $name ) );
			$result = $query->row_array();
			
			if( $result['role'] == 0 ) $where = 'templates/indexadmin';
			else if( $result['role'] == 1 ) $where = 'templates/indexmanager';
			else $where = 'templates/indexparticipant';

			$data['num'] = 1;
		}

		$this->load->view($where,$data);
		$this->load->view('templates/aboutus2',$data);
		$this->load->view('templates/footer');		
	}
	public function search_find(){
		$data['search'] = $_POST['search'];
		$data['title'] = "MeTEOR | Search Results";
		$a = array();
		$r = $this->listCourseUsers1();

		$a['counter']=0;
		$a['array'] = $r['array'];
		$a['count_All'] = $r['count'];
		
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$data['userid'] = $uid['id'];
		
		$result = $this->course_model->get_results($data, 'courses');

		foreach($result->result() as $row)
		{
			$arr = $this->participantuser_model->getDB('cancelled', 'course_id', $row->id, '', '', 0);
			$yah = 0;
			foreach ($arr->result_array() as $keyValue) {
				$yah = 1;
				break;
			}

			if( !$yah ){
				$a['id'][] = $row->id;
				$a['name'][] = $row->name;
				$a['description'][] = $row->description;
				$a['start'][] = $row->start;
				$a['time'][] = date('h:i A', strtotime($row->startTime))." - ".date('h:i A', strtotime($row->endTime));
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
		
		$this->load->view('templates/indexheader', $data);
		$this->load->view('pages/search_find', $a);
		$this->load->view('templates/footerme');
	}
	
	public function link( $num )
	{
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$data['userid'] = $uid['id'];
		
		$data['letter'] = $num;
			
		$config = array();
		$config['total_rows'] = $this->course_model->record_count();
		$config['per_page'] = $this->course_model->record_count();
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0 ;
		$data['courses'] = $this->course_model->fetch_courses( $data['letter'], $config['per_page'], $page);
		$data['title'] = 'MeTEOR | Course List';
			
		$this->load->view('templates/indexheader', $data);
		$this->load->view('pages/courselist', $data);
		$this->load->view('templates/footerme');
	}

	public function updateSurveyTotal($result){
	foreach ($result->result() as $key) {
			$total = 0; $total1 = 0; $total2 = 0; $total3 = 0; $total4 = 0; $total5 = 0; $total6 = 0 ; $total7 = 0;
			
			for( $i = 1; $i <= 8; $i++ ){
				$name = 'concepts'.$i;
				$total = $total + $key->$name;
				$total1 = $total1 + $key->$name;
			}

			for( $i = 1; $i <= 14; $i++ ){
				$name = 'word'.$i;
				$total = $total + $key->$name;
				$total2 = $total2 + $key->$name;
			}

			for( $i = 1; $i <= 8; $i++ ){
				$name = 'spreadsht'.$i;
				$total = $total + $key->$name;
				$total3 = $total3 + $key->$name;
			}

			for( $i = 1; $i <= 4; $i++ ){
				$name = 'images'.$i;
				$total = $total + $key->$name;
				$total4 = $total4 + $key->$name;
			}

			for( $i = 1; $i <= 5; $i++ ){
				$name = 'presentation'.$i;
				$total = $total + $key->$name;
				$total5 = $total5 + $key->$name;
			}
			
			for( $i = 1; $i <= 8; $i++ ){
				$name = 'internet'.$i;
				$total = $total + $key->$name;
				$total6 = $total6 + $key->$name;
			}
			
			
			for( $i = 1; $i <= 6; $i++ ){
				$name = 'email'.$i;
				$total = $total + $key->$name;
				$total7= $total7 + $key->$name;
			}


			$data = array(
				'totalI' => $total1,
				'totalII' => $total2,
				'totalIII' => $total3,
				'totalIV' => $total4,
				'totalV' => $total5,
				'totalVI' => $total6,
				'totalVII' => $total7,
				'total' => $total,
				'counted' => 1
			);

			$this->db->where('id', $key->id);
			$this->db->update('origsurvey', $data);
		}
	}
}