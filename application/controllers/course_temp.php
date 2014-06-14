<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');
class course_temp extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('course_model');
		$this->load->library('pagination');
		$this->load->model('participantuser_model');
		$this->load->model('participant_model');
		$this->load->model('validation_model', 'vm');
		$this->load->library('calendar');
		$this->load->library('highcharts');
		$this->load->library('word');

		$this->load->model('login_model');
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library('mpdf');
		$this->load->library('zip');
		$this->load->helper("file");
		$this->load->library('form_validation');

		if($this->islogged() == false){
			redirect("http://localhost/meteor/index.php/pages");
		}
		if(!$this->login_model->isValid($this->session->userdata('username'))){
			redirect("http://localhost/meteor/index.php/pages/invalid");
		}
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$data['userid'] = $uid['id'];
		
	}

	public function index( $error=0, $message='',$manager=0 )
	{		
		$this->load->helper('url');
		/*$uid = $this->login_model->getuid($this->session->userdata('username'));
		$query = $this->db->get_where( 'details', array('user_id' => $uid['id']) );
		$ans = $query->row_array();
		if( empty($ans['id']) ){
			redirect(base_url('index.php/participantprofile'));
			return;
		}*/	
		
		$letter = $this->uri->segment(3);
		$r = $this->listCourseUsers();
		$a['array'] = $r['array'];
		$a['count_All'] = $r['count'];
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
		
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$a['userid'] = $uid['id'];
		$a['manager'] = $manager;
		$a['error'] = $error;
		$a['message'] = $message; 

		$a['active_nav'] = 'VIEW';
		if(!$manager){
			$this->load->view('templates/indexadmin', $a);
			$this->load->view('templates/sidebar_admin');
		}else{
			$this->load->view('templates/indexmanager', $a);
			$this->load->view('templates/sidebar_manager');
		}
		$this->load->view('course/index', $a);
		//$indexthis->load->view('templates/footeradmin');
		
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
			
			$this->load->view('templates/indexadmin', $data);
			$this->load->view('course/index', $data);
			$this->load->view('templates/footeradmin');
			
		}
		else{
			$data['title'] = 'MeTEOR | Participants';
			$r = $this->listCourseUsers();
			$data['array'] = $r['array'];
			$data['count_All'] = $r['count'];

			$this->load->helper('url');
			
			$data['id'] = $num;
			$data['countRes'] = 0;
			$data['countPaid'] = 0;
			
			$results = $this->course_model->fetch_All( $data['id'] );
			//( $db, $col1, $col1Value, $col2, $col2Value, $num )
			$temporary_id = $this->participantuser_model->getDB( 'courses', 'id', $num, '', '', 0);
			$templates = $temporary_id->result_array();

			$users = $results->result_array();
			$data['users'] = $users;	
			$data['temporary'] = $templates[0]['tempId'];

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
			
			$data['man'] = 0;
			$data['active_nav'] = 'VIEW';
			
			if(!$uid['role']){
				$this->load->view('templates/indexadmin', $data);
				$this->load->view('templates/sidebar_admin', $data);
			}else{
				$this->load->view('templates/indexmanager', $data);
				$this->load->view('templates/sidebar_manager', $data);
			}
			$this->load->view('course/participants', $data);
			//$this->load->view('templates/footeradmin');
		}	
	}

	public function printResult(){
		$this->load->library('excel');
		$sheet = new PHPExcel();

		$coursename = $_POST['course_name'];
		$table = $_POST['server'];
		$belong = $_POST['belonging'];
		$type = $_POST['type'];
		$course_id = $_POST['course_id'];

		$temp = $this->participantuser_model->getDB($table, 'course_id', $course_id, '', '', 0);
		$fields = $this->db->list_fields($table);

		$all_category = $this->participantuser_model->getDB('categories_questions', 'belong', $belong, '', '', 0);
		$count = 0;

		
		$styleArray = array(
		    'font'  => array(
		        'bold'  => true,
		        'color' => array('rgb' => 'FFFFFF'),
		    ),
		    'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
	    );

		foreach($all_category->result_array() as $key2){
			$column = array();

			array_push($column, "Time Stamp");
			array_push($column, "User Name");

			//echo $id."<br/>";
			$questions_all = $this->participantuser_model->getDB('all_questions', 'category_id', $key2['id'], '', '', 0);
			foreach($questions_all->result_array() as $value){
				array_push($column, $value['questions']);
			}

			$sheet->setActiveSheetIndex($count);
			$pieces = explode(" ", $key2['title']);
			$sheet->getActiveSheet()->setTitle($pieces[0]." ".$pieces[1]);

			$col = 0;
			foreach ($column as $field) {
				$sheet->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
				//$sheet->getActiveSheet()->getStyleByColumnAndRow($col,1)->getFont()->setSize(20);
				$sheet->getActiveSheet()->getStyleByColumnAndRow($col,1)->getFont()->setBold(true);
				$col++;
			}

			$row = 2;
			foreach($temp->result_array() as $value) {
				$users = $this->participantuser_model->getDB('users', 'id', $value['userid'], '', '', 0);
				$users = $users->result_array();
				$col = 0;

				$sheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value['todate']);
				$col++;
				$insert = $users[0]['firstname']." ".$users[0]['lastname'];
				$sheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $insert);

				$col = 2;
				foreach($questions_all->result_array() as $key) {
					$insert = $value[$key['id']."_id"];
					$sheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $insert);
					$sheet->getActiveSheet()->getStyleByColumnAndRow($col,$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$col++;				
				}
				$row++;
			}

			$questions_all = $this->participantuser_model->getDB('all_questions', 'category_id', $key2['id'], 'type', '0', 1);

			if(count($questions_all->result_array()) ) {
				$letter = range('A','Z');

				$sheet->getActiveSheet()->setCellValueByColumnAndRow(0, $row, "AVG SCORES");
				$sheet->getActiveSheet()->getStyleByColumnAndRow(0,$row)->getFont()->getColor()->applyFromArray(array("rgb" => 'e74c3c'));
				$sheet->getActiveSheet()->mergeCells('A'.$row.":B".$row);
				$sheet->getActiveSheet()->getStyle('A'.$row.':'.$letter[$col-1].$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('f1c40f');
				$sheet->getActiveSheet()->getStyleByColumnAndRow(0,$row)->applyFromArray($styleArray);

				$col = 2;

				//$all_q = $this->participantuser_model->getDB('all_questions', 'category_id', $key2['id'], 'type', '0', 1);
				$i = 0;
				foreach($fields as $name) {
					if(!$belong){
						if($i>7){
							$tot1 = $this->course_model->getAvg($table, $name, $course_id, 0, 1);
							$sheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $tot1);
							$sheet->getActiveSheet()->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
							$col++;
						}
					}else{
						if($i>3){
							$tot1 = $this->course_model->getAvg($table, $name, $course_id, 0, 1);
							$sheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $tot1);
							$sheet->getActiveSheet()->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
							$col++;
						}
					}
					$i++;
				}

				$col = 2;
				foreach($questions_all->result_array() as $key) {
					$name = $key['id']."_id";
					$tot1 = $this->course_model->getAvg($table, $name, $course_id, 0, 1);
					$sheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $tot1);
					$sheet->getActiveSheet()->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
					$col++;				
				}
			}
			//$objWorksheet = new PHPExcel_Worksheet($sheet);
			//$sheet->addSheet($objWorksheet);

			$sheet->createSheet();
			$count++;
		}

		$inputFileType = 'Excel5';
		$filename = $coursename.'.'.$type; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache

		$sheet_writer = PHPExcel_IOFactory::createWriter($sheet, $inputFileType);
		$sheet_writer->save('php://output');

	}

	public function search_find()
	{
		$data['search'] = $_POST['search'];
		$data['title'] = "MeTEOR | Search Results";
		$var = $this->input->post('type');
		$var1 = $this->input->post('search');
		$uid = $this->login_model->getuid($this->session->userdata('username'));

		if( $var === "USER" ){ 
			//redirect('http://localhost/meteor/index.php/validation/search_results/'.$var1.'');	
			include_once('validation.php');
			$me = new validation;
			$me->search_results($var1);
			return;
		}

		$a = array();
		$r = $this->listCourseUsers();
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
		
		$this->load->helper('url');
		$data['active_nav'] = 'VIEW';
		$data['search'] = 1;
		$data['manager'] = $uid['role'];

		if(!$uid['role']){
			$this->load->view('templates/indexadmin', $data);
			$this->load->view('templates/sidebar_admin', $a);
		}else{
			$this->load->view('templates/indexmanager', $data);
			$this->load->view('templates/sidebar_manager', $a);
		}
		$this->load->view('course/index', $a);
		//$this->load->view('templates/footeradmin');
	}

	public function save(){
		$course_id = $this->input->post("course_id");
		$name = $this->input->post("name");
		$description = $this->input->post("description");
		$objectives = $this->input->post("objectives");
		$startTime = $this->input->post("startTime");
		$endTime = $this->input->post("endTime");
		$venue = $this->input->post("venue");
		$start = $this->input->post("startDate");		
		$end = $this->input->post("endDate");


		$start = date('Y-m-d', strtotime($start));
		$end = date('Y-m-d', strtotime($end));

		$cost = $this->input->post("cost");
		$available = $this->input->post("available");
		$attendees = $this->input->post("attendees");
		$foodexp = $this->input->post("food");
		$foodRemarks = $this->input->post("foodRemarks");
		$transpo = $this->input->post("transport");
		$landRemarks = $this->input->post("transpoRemarks");
		$accommodation = $this->input->post("accoms");
		$accomodationRemarks = $this->input->post("accomRemarks");
		$airfare = $this->input->post("air");
		$airfareRemarks = $this->input->post("airRemarks");
		$totalexp = $foodexp + $accommodation + $transpo + $airfare;

		$message = array();
		$message['name'] = $name;
		$message['course_id'] = $course_id;

		$data['courses'] = $this->course_model->get_courses(1);
		foreach( $data['courses'] as $row ){
			if( $row['id'] == $course_id ){
				$message['course_id'] = $row['id'];
				if( $row['name'] !== $name ) $message['name'] = $name;
				if( $row['description'] !== $description ) $message['description'] = $description;
				if( $row['objectives'] !== $objectives ) $message['objectives'] = $objectives;
				if( $row['start'] !== $start ) $message['start'] = $start;
				if( $row['end'] !== $end ) $message['end'] = $end;
				if( $row['startTime'] !== $startTime) $message['startTime'] = $startTime;
				if( $row['endTime'] !== $endTime) $message['endTime'] = $endTime;
				if( $row['venue'] !== $venue ) $message['venue'] = $venue;
				if( $row['cost'] !== $cost ) $message['cost'] = $cost;
				if( $row['available'] !== $available ) $message['available'] = $available;
				if( $row['attendees'] !== $attendees ) $message['attendees'] = $attendees;
				if( $row['food'] !== $foodexp ) $message['food'] = $foodexp;
				if( $row['foodRemarks'] !== $foodRemarks ) $message['foodRemarks'] = $foodRemarks;
				if( $row['landTranspo'] !== $transpo ) $message['landTranspo'] = $transpo;
				if( $row['landRemarks'] !== $landRemarks ) $message['landRemarks'] = $landRemarks;
				if( $row['accomodation'] !== $accommodation ) $message['accomodation'] = $accommodation;
				if( $row['accomodationRemarks'] !== $accomodationRemarks ) $message['accomodationRemarks'] = $accomodationRemarks;
				if( $row['airfare'] !== $airfare ) $message['airfare'] = $airfare;
				if( $row['airfareRemarks'] !== $airfareRemarks ) $message['airfareRemarks'] = $airfareRemarks;
				if( $row['totalexp'] !== $totalexp ) $message['totalexp'] = $totalexp;
				$tempId = $row['tempId'];
				break;
			}
		}
		
		$continue = $this->sendvalid($message);

		if( empty($continue) ){
			$this->course_model->change($message);
			if($tempId){
				$data = array(
					'name' => $_POST['name'],
					'start' => $start,
					'end' => $end,
					'cost' => $_POST['cost'],
					'venue' => $_POST['venue'],
					'startTime' => date('H:i', strtotime($_POST['startTime'])),
					'endTime' => date('H:i', strtotime($_POST['endTime'])),
					'description' => $_POST['description']
				);
				$this->db->where('id', $tempId);
				$this->db->update('temp_courses', $data);
			}
			$this->index( 1, 'Edited course has been updated' );
			return;
		}
		$this->index( 0, $continue );
	}

	public function sendvalid($message){
		$b = array();
		$b = $message;

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

		$mailer->SetFrom('noreply@localhost/meteor', 'MeTEOR Notification');
		$mailer->Subject = '[MeTEOR] Course Detail Change';
		/*$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 25,
			'smtp_user' => 'meteor.upitdc@gmail.com',
			'smtp_pass' => 'meteor123',
			'mailtype'  => 'html',
			'wordwrap' => TRUE,
			'charset'   => 'iso-8859-1'
		);
		$this->load->library('email',$config);
		$this->email->set_newline("\r\n");
		$this->email->set_priority(1);*/
		
		if( !empty($message['description']) || !empty($message['venue']) || !empty($message['start']) || !empty($message['end']) || !empty($message['endTime']) || !empty($message['startTime'])){
			//$msg = "The course ".$message['name']." you've enrolled, received changes as follows:\n\n";
			
			//$msg .="============================================================\n";
			/*if(!empty($message['description']) ) $msg .= "\nDescription is now ".$message['description'];
			if(!empty($message['venue']) ) $msg .= "\nThe Venue is now on ".$message['venue'];
			if(!empty($message['start']) ) $msg .= "\nThe starting date is now on ".date( 'F j\, Y', strtotime($message['start']))." ";
			if(!empty($message['end']) ) $msg .= "and the ending date is now on ".date( 'F j\, Y', strtotime($message['end'])).".";
			$msg .="\n\n============================================================\n\n";
			
			$msg .= "If You have any comments, suggestions, and reactions, feel free to contact us at localhost/meteor. Thank you for registering.\n\n";
			*/

			$mailer->Body = $this->load->view('course/sendChange', $b, TRUE);
			$forSending = 0;
			
			$query = $this->course_model->fetch_All($message['course_id']);
			foreach( $query->result_array() as $row ){
				$mailList = $this->course_model->getListParticipants($row['user_id']);
				$arrayList = $mailList->row_array();
				
				$mailer->AddAddress($arrayList['username']);
				$forSending = 1;
			}

			$mailer->IsHTML(true);
			if($forSending){
				if(!$mailer->Send()) {
					$error = 'Mail error: '.$mailer->ErrorInfo; 
					return $error;
				} else {
					$error = '';
					return $error;
				}
			} else return '';
		}
	}

	public function addition(){
		$this->course_model->set_courses();
		$this->index(1, 'New Course has been added.');
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
			$this->load->view('templates/indexadmin', $data);	
			$this->load->view('course/index');
			$this->load->view('templates/footeradmin');
			$this->index();
		}
		else
		{
			$query = $this->participantuser_model->getDB('courses', 'id', $_POST['course_id'],'','',0 );
			$query = $query->result_array();

			$this->course_model->set_cancelledStatus($query[0]['tempId']);
			$this->index();
		}		
	}

	public function cancelled()
	{		
		$data['courses'] = $this->course_model->get_courses(1);
		$data['cancelled'] = $this->course_model->get_cancelledCourses();
		$uid = $this->login_model->getuid($this->session->userdata('username'));

		$this->load->helper(array('form', 'url'));
		$r = $this->listCourseUsers1();
		$data['array'] = $r['array'];
		$data['count_All'] = $r['count'];
		$data['title'] = 'MeTEOR | Cancelled Courses';
		$data['active_nav'] = 'CANCEL';

		if(!$uid['role']){
			$this->load->view('templates/indexadmin', $data);
			$this->load->view('templates/sidebar_admin', $data);
		}else{
			$this->load->view('templates/indexmanager', $data);
			$this->load->view('templates/sidebar_manager', $data);
		}
		$data['manager'] = $uid['role']; 
		$this->load->view('course/cancelled', $data);
		//$this->load->view('templates/footeradmin');		
	}

	public function untagRefund(){
		$this->load->helper('url');
		$gen_id = $_POST['genId'];
		$user_id = $_POST['user_id'];
		$course_id = $_POST['course_id'];

		$this->db->where('user_id', $user_id);
		$this->db->where('course_id', $course_id);
		$data = array(
			'untag' => 1
		);

		$this->db->update('cancelled', $data);
		$this->seeCancelled($gen_id);
		return;
	}

	public function seeCancelled( $num ){		
		$data['title'] = 'MeTEOR | Refund List';
		$this->load->helper('url');
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$data['userid'] = $uid['id'];
		$r = $this->listCourseUsers1();

		$data['array'] = $r['array'];
		$data['count_All'] = $r['count'];
		$data['id'] = $num;
		
		$results = $this->course_model->fetch_cancelled( $num );
		$data['users'] = $results->result_array();
		
		$data['active_nav'] = 'CANCEL';		
		if(!$uid['role']){
			$this->load->view('templates/indexadmin', $data);
			$this->load->view('templates/sidebar_admin', $data);
		}else{
			$this->load->view('templates/indexmanager', $data);
			$this->load->view('templates/sidebar_manager', $data);
		}
		$data['manager'] = $uid['role'];
		$this->load->view('course/participants1', $data);
		//$this->load->view('templates/footeradmin');
	}
	public function search_cancelled(){
		$data['search'] = $_POST['search'];
		$data['title'] = "MeTEOR | Search Results";
		$a = array();
		$a['counter']=0;
		
		$r = $this->listCourseUsers1();
		$a['array'] = $r['array'];
		$a['count_All'] = $r['count'];
		$result = $this->course_model->get_results($data, 'courses',1);

		foreach($result->result() as $row)
		{
			$query = $this->db->get_where('cancelled', array('course_id' => $row->id) );
			$array1 = $query->row_array();
			
			$queryDis = $this->db->get_where('dissolved', array('course_id' => $row->id) );
			$arrayDis = $queryDis->row_array();

			if( !empty($array1['id']) && !empty($arrayDis['id']) ){
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
		}
		
		$this->load->helper('url');
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$data['active_nav'] = 'CANCEL';

		if(!$uid['role']){
			$this->load->view('templates/indexadmin', $data);
			$this->load->view('templates/sidebar_admin', $data);
		}else{
			$this->load->view('templates/indexmanager', $data);
			$this->load->view('templates/sidebar_manager', $data);
		}
		$this->load->view('course/cancelled_find', $a);
		//$this->load->view('templates/footeradmin');
	}

	public function reports( $error = '')
	{		
		$this->load->helper('url');
		$a['title'] = 'MeTEOR | Courses';
		$uid = $this->login_model->getuid($this->session->userdata('username'));

		if( !empty($error) ) $a['error'] = $error;
		$a['active_nav'] = 'EVENT';

		if(!$uid['role']){
			$this->load->view('templates/indexadmin', $a);
			$this->load->view('templates/sidebar_admin', $a);
		}else{
			$this->load->view('templates/indexmanager', $a);
			$this->load->view('templates/sidebar_manager', $a);
		}
		$this->load->view('course/reports', $a);
		//$this->load->view('templates/footeradmin');
		
	}

	public function reports_search()
	{
		$data['title'] = "MeTEOR | Search Results";
		$var = $this->input->post('type');
		$dept = $this->input->post('dept');
		$var1 = $this->input->post('search');

		$temp1 = date('Y-m-d', strtotime($_POST['starting']));
		$temp2 = date('Y-m-d', strtotime($_POST['ending']));
		$uid = $this->login_model->getuid($this->session->userdata('username'));

		if( $temp1 > $temp2 ){
			$this->reports('Start Date should be less than End Date');
			return;
		}

		if( $var === "COURSE" ){
			if( $dept === "-- Dept --" ){
				$a = array();
				$result = $this->course_model->get_reports('courses', 1);
				$a = $this->getCourseList($result);
				
				$a['starting'] = $temp1;
				$a['deptTrue'] = 0;
				$a['dept'] = $dept;
				$a['ending'] = $temp2;
				
				$this->load->helper('url');
				$data['active_nav'] = 'EVENT';

				if(!$uid['role']){
					$this->load->view('templates/indexadmin', $data);
					$this->load->view('templates/sidebar_admin', $data);
				}else{
					$this->load->view('templates/indexmanager', $data);
					$this->load->view('templates/sidebar_manager', $data);
				}
				$this->load->view('course/reports_search', $a);
				//$this->load->view('templates/footeradmin');				
			}else{
				$a = array();
				if( $dept == '-- ALL --' ) $result = $this->course_model->get_tempCourses(1);
				else $result = $this->course_model->get_tempCourses();
				$a = $this->getCourseList($result, 1);
				
				$a['starting'] = $temp1;
				$a['deptTrue'] = 1;
				$a['dept'] = $dept;
				$a['ending'] = $temp2;
				
				$this->load->helper('url');
				
				$data['active_nav'] = 'EVENT';
				if(!$uid['role']){
					$this->load->view('templates/indexadmin', $data);
					$this->load->view('templates/sidebar_admin', $data);
				}else{
					$this->load->view('templates/indexmanager', $data);
					$this->load->view('templates/sidebar_manager', $data);
				}
				$this->load->view('course/reports_search', $a);
				//$this->load->view('templates/footeradmin');	
			}
		} else {
			//echo("dasdasdasdasdas");
			$a= array();
			$a['counter'] = 0;
			$secresult = $this->course_model->getUserRep();
			$a = $this->search_reports($secresult);
			//echo($a['counter']);
			$a['starting1'] = $temp1;
			
			$a['ending1'] = $temp2;
			$a['man'] = 0;
			$this->load->view('templates/indexadmin', $data);
			$this->load->view('course/wat', $a);
			$this->load->view('templates/footeradmin');
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
			$a['reserved'][] = $row->reserved;
			$a['paid'][] = $row->paid;
			$a['cost'][] = $row->cost;

			if( !$num ){				
				$a['description'][] = $row->description;
				$a['objectives'][] = $row->objectives;
				$a['available'][] = $row->available;
				$a['startTime'][] = $row->startTime;
				$a['endTime'][] = $row->endTime;
				$a['attendees'][] = $row->attendees;
				$a['food'][] = $row->food;
				$a['foodRemarks'][] = $row->foodRemarks;
				$a['accomodation'][] = $row->accomodation;
				$a['accomodationRemarks'][] = $row->accomodationRemarks;
				$a['landTranspo'][] = $row->landTranspo;
				$a['landRemarks'][] = $row->landRemarks;
				$a['airfare'][] = $row->airfare;
				$a['airfareRemarks'][] = $row->airfareRemarks;
				$a['totalexp'][] = $row->totalexp;
			}else{
				$a['count'][] = $row->count;
				$a['facilitator'][] = $row->facilitator;
				$a['department'][] = $row->department;
			}
			$a['counter']++;
		}

		return $a;
	}

	public function date_string($start, $end){
		if( $start == $end ) $message = date('M d, Y', strtotime($start));
		else{
			$message = "";
			$dateStart = date('d M Y', strtotime($start));
			$dateEnd = date('d M Y', strtotime($end));

			$startPieces2 = explode(" ", $dateStart);
			$endPieces2 = explode(" ", $dateEnd);

			$startPieces = explode("-", $start);
			$endPieces = explode("-", $end);
			
			$totDays = date("t",strtotime($startPieces[0].'-'.$startPieces[1].'-01'));

			if( $startPieces[0] == $endPieces[0] && (($startPieces[1] == 1 && $endPieces[1] == 12) ) && ($startPieces[2] == 1 && $endPieces[2] == 31) ){
				$message = "for YEAR ".$startPieces[0];	
			} 
			else if( $startPieces[0] == $endPieces[0] ){ //year
				/*month checker*/ 
				if( $startPieces[1] == $endPieces[1] ){
					//$message .= $startPieces2[0]." to ".$endPieces2[0]." of ".$startPieces2[2]." ".$startPieces[0];
					$totalDays = ($endPieces[2] - $startPieces[2]) + 1;
					if( $totalDays == $totDays ) $message .= "Month of ".$startPieces2[1]." ".$startPieces[0];
					else $message .= $startPieces2[0]." to ".$endPieces2[0]." of ".$startPieces2[1]." ".$startPieces[0];
				} 
				else {
					if( $startPieces[2] == $endPieces[2] ) $message = $startPieces2[0]." of ".$startPieces2[1]."-".$endPieces2[1]." ".$startPieces[0];
					else $message = $startPieces2[0]." of ".$startPieces2[1]." - ".$endPieces2[0]." of ".$endPieces2[1]." ".$startPieces[0];	
				}	
			}else{
				if( $startPieces[1] == $endPieces[1] ){
					if( $startPieces[2] == $endPieces[2] ) $message = $startPieces2[0]." of ".$startPieces2[2]." ".$startPieces[0]."-".$endPieces[0];
					else $message = $startPieces2[0]."-".$endPieces2[0]." of ".$startPieces2[1]." ".$startPieces[0]."-".$endPieces[0];
				}else {
					if( $startPieces[2] == $endPieces[2]) $message = $startPieces2[0]." of ".$startPieces2[1]."-".$endPieces2[1]." ".$startPieces[0]."-".$endPieces[0];
					else $message = $dateStart." - ".$dateEnd;
				}	
			}
		}
		return $message;
	}

	public function normalize_str($str)
	{
		$invalid = array('Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z',
		'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A',
		'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E',
		'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
		'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y',
		'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a',
		'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e',  'ë'=>'e', 'ì'=>'i', 'í'=>'i',
		'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
		'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y',  'ý'=>'y', 'þ'=>'b',
		'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r', "`" => "'", "´" => "'", "„" => ",", "`" => "'", '&' => 'and', '/' => 'or',
		"´" => "'", "“" => "\"", "”" => "\"", "´" => "'", "&acirc;€™" => "'", "{" => "",
		"~" => "", "–" => "-", "’" => "'");
	 
		$str = str_replace(array_keys($invalid), array_values($invalid), $str);
		 
		return $str;
	}
	public function printEventForms(){
		$this->load->library('word');
		$this->load->library('zip');
		$this->load->helper("file");

		/*$stylesheet = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/meteor/css/printEvalSheet.css');
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
		*/

		$data = array();		
		$num = $_POST['deptTrue'];
		$all = 0;
		if( $_POST['dept'] == '-- ALL --' ) $all = 1;
		if( !$num ) $result = $this->course_model->get_reports('courses', 1);
		else $result = $this->course_model->get_tempCourses( $all );
		$data = $this->getCourseList($result, $num);		
		//var_dump($data);

		//$data['starting'] = $_POST['starting'];//date('F j\, Y', $temp).PHP_EOL;
		//$data['ending'] = $_POST['ending'];//date('F j\, Y', $temp).PHP_EOL;
		
		//if( $_POST['starting'] == $_POST['ending'] )
		//	$data['nameS'] = "Courses( ".date('F j\, Y', strtotime($_POST['starting']))." )";
		//else $data['nameS'] = "Courses( ".date('F j\, Y', strtotime($_POST['starting']))." - ".date('F j\, Y', strtotime($_POST['ending']))." )";

		$data['deptTrue'] = $num;
		$count = count($data['name']);

		$a = array();
		$temp_name = ''; $count_name = 1;

		for( $i = 0; $i < $count; $i++ ){
			$word = new PHPWord();
			$document = $word->loadTemplate($_SERVER['DOCUMENT_ROOT'].'/meteor/template.docx');

			$name = $this->normalize_str($data['name'][$i]);
			//$description = nl2br($data['description'][$i]);
			$objectives = nl2br(utf8_encode($data['objectives'][$i]));

			$message = $this->date_string($data['start'][$i], $data['end'][$i]);

			$hours = $data['endTime'][$i] - $data['startTime'][$i];
			$startTime = date('h:i A', strtotime($data['startTime'][$i]));
			$endTime = date('h:i A', strtotime($data['endTime'][$i]));

			$posAM1 = strpos($startTime, "AM");
			$posAM2 = strpos($endTime, "AM");

			$posPM1 = strpos($startTime, "PM");
			$posPM2 = strpos($endTime, "PM");

			if( ($posAM1 && $posAM2) || ($posPM1 && $posPM2) ) $hours -= 0;
			else $hours--;

			$venue = nl2br($data['venue'][$i]);
			$attendees = nl2br($data['attendees'][$i]);
			$available = $data['available'][$i];
			$food = number_format($data['food'][$i],2);
			$foodRemarks = nl2br($data['foodRemarks'][$i]);
			$accomodation = number_format($data['accomodation'][$i],2);
			$accomodationRemarks = nl2br($data['accomodationRemarks'][$i]);
			$landTranspo = number_format($data['landTranspo'][$i],2);
			$landRemarks = nl2br($data['landRemarks'][$i]);
			$airfare = number_format($data['airfare'][$i],2);
			$airfareRemarks = nl2br($data['airfareRemarks'][$i]);
			$totalexp = number_format($data['totalexp'][$i],2);

			$document->setValue('name', $this->normalize_str($name));
			$document->setValue('objectives', $this->normalize_str($objectives));
			$document->setValue('message', $this->normalize_str($message));
			$document->setValue('startTime', $startTime);
			$document->setValue('endTime', $endTime);
			$document->setValue('hours', $hours);
			$document->setValue('venue', $venue);
			$document->setValue('attendees', $this->normalize_str($attendees));
			$document->setValue('available', $available);
			$document->setValue('food', $food);
			$document->setValue('foodRemarks', $this->normalize_str($foodRemarks));
			$document->setValue('accomodation', $accomodation);
			$document->setValue('accomodationRemarks', $this->normalize_str($accomodationRemarks));
			$document->setValue('landTranspo', $landTranspo);
			$document->setValue('landRemarks', $this->normalize_str($landRemarks));
			$document->setValue('airfare', $airfare);
			$document->setValue('airfareRemarks', $this->normalize_str($airfareRemarks));
			$document->setValue('totalexp', $totalexp);

			/*$mpdf = new mPDF('',    // mode - default ''
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

			$mpdf->SetHTMLHeader('<img src="'.$_SERVER['DOCUMENT_ROOT'].'/css/images/docLogo2.png" class="header">');
			$mpdf->SetHTMLFooter('<img src="'.$_SERVER['DOCUMENT_ROOT'].'/css/images/doc2.png" class="footer">');
			
			//$this->load->view('course/eventformPrint', $a);
			$mpdf->WriteHTML($this->load->view("course/eventformPrint", $a, TRUE));
			*/

			if($temp_name != $name) $temp_name = $name;
			else{
				$name .= $count_name;
				$count_name++;
			}
			$filename = $_SERVER['DOCUMENT_ROOT'].'/meteor/temp/'.$TITLE[$n].utf8_decode($name).'.docx';
			$document->save($filename);
			//header('Content-Description: File Transfer');
			//header('Content-type: application/force-download');
			//header('Content-Disposition: attachment; filename='.basename($filename));
			//header('Content-Transfer-Encoding: binary');
			//header('Content-Length: '.filesize($filename));
			//$mpdf->Output($filename);
			$this->zip->read_file($filename);

			//unlink($filename);
		}					

		$zipfilename = 'TRAINING_EVENT_SCHEDULE_FORM'.'.zip';
		$this->zip->download($zipfilename);
		exit;		
		//pdf here
		/*$val = $result->result_array();
		foreach ( $val as $value) {
			var_dump($value['name']);
		}

		for($i=0; $i<$count; $i++){
			$a[]['name']
		}*/
	}

	public function participantReport( $num, $temp ){
		$data = array();
		$this->load->helper('url');
		
		$name = $this->course_model->courseGet( $num, $temp );
		$num = $name[0]['id'];
		$uid = $this->login_model->getuid($this->session->userdata('username'));

		$data = $this->getParticipantReport( $num );
		
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
		$data['active_nav'] = 'EVENT';

		if(!$uid['role']){
			$this->load->view('templates/indexadmin', $data);
			$this->load->view('templates/sidebar_admin', $data);
		}else{
			$this->load->view('templates/indexmanager', $data);
			$this->load->view('templates/sidebar_manager', $data);
		}
		$this->load->view('course/participantsReports', $data);
		//$this->load->view('templates/footeradmin');
	}

	public function getParticipantReport( $a ){
		$data = array();
		
		$data['count'] = 0;
		$data['decount'] = 0;
		
		$results = $this->course_model->fetch_ALL( $a );
		$data['users'] = $results->result_array();	

		foreach( $data['users'] as $row ){
			$queryCan = $this->participantuser_model->getDB( 'cancelled', 'course_id', $row['course_id'], 'user_id', $row['user_id'], 1 );
			$arrayCan = $queryCan->result_array();
			$data['count']++;
			
			if( !empty($arrayCan['id']) ){
				$queryCancelled = $this->participantuser_model->getCan($row['user_id'],$arrayCan['id']);
				foreach( $queryCancelled->result() as $row2 ){
					$data['decount']++;
					$data['tagS'][] = $row['user_id'];
					$data['user_id'][] = $row['user_id'];
					$data['lastname'][] = $row2->lastname;
					$data['firstname'][] = $row2->firstname;
					$data['username'][] = $row2->username;
				}
			}
			else{
				$queryCancelled = $this->course_model->getListParticipants($row['user_id']);
				foreach( $queryCancelled->result() as $row2 ){
					$data['user_id'][] = $row['user_id'];
					$data['lastname'][] = $row2->lastname;
					$data['firstname'][] = $row2->firstname;
					$data['username'][] = $row2->username;
				}
			}
		}
		
		return $data;
	}

	public function data_sets( $all_q, $table, $total, $column_name )
	{
		$a['all_type']['data'] = array();
		$a['all_type']['name'] = 'Percentage';
		$i = 0;
		$count = 0;
		if($column_name=='age'){
			$a['categ'] = array();
			$a['all_type']['name'] = 'Count';
		}

		foreach($all_q->result_array() as $key){
			$tot1 = $this->participantuser_model->getCount($table, $column_name, $key[$column_name]);
			if($column_name!='age'){
				if($i == (int)(count($all_q->result_array())/2)){
					$b = array(
						'name' => $key[$column_name]."(Count: ".$tot1[0]['numrows'].")",
						'y' => floatval($tot1[0]['numrows']/$total),
						'sliced' => true,
	                    'selected' => true,
					);
					array_push($a['all_type']['data'], $b );	
				}
				else array_push($a['all_type']['data'],array($key[$column_name]."(Count: ".$tot1[0]['numrows'].")", floatval($tot1[0]['numrows']/$total)) );
			}else{
				array_push($a['categ'], $key[$column_name]." yrs old");
				array_push($a['all_type']['data'], (int)$tot1[0]['numrows'] );	
			}
			$count += $tot1[0]['numrows'];
			$i++;
		}

		$a['countAll'] = $count;
		return $a;
	}

	public function reports_chart(){
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$data['title'] = "MeTEOR | Reports";
		$arr = $this->participantuser_model->getDB('users', 'role', '2', '', '', 0);
		$data['totalCount'] = 0;

		foreach ($arr->result_array() as $value) {
			$ans = $this->participantuser_model->getDB('details', 'user_id', $value['id'], '', '', 0);
			if($ans->num_rows()) $data['totalCount']++;
		}

		$layer1 = array('addresses','addresses','employment_history','employment_history','details');
		$layer2 = array('region','city','industries', 'designation','age');

		$c = array();
		$data['countChart'] = count($layer1);
		
		for($i=0;$i<count($layer1);$i++){
			$panel_all = $this->participantuser_model->selectDistinct($layer1[$i],$layer2[$i]);
			$data_set = $this->data_sets($panel_all,$layer1[$i],$data['totalCount'],$layer2[$i]);

			$high = new Highcharts();
			if($i<(count($layer1)-1)){
				$high->set_type('pie'); // drauwing type
				$title = 'Summary Percentage of Participants Per ';
			}
			else{
				$high->set_type('areaspline');
				$title = 'Summary Count of Participants Per ';
			}

			$high->set_title($title.ucwords($layer2[$i]), 'Total Count: '.$data_set['countAll']);

			if($i<(count($layer1)-1)){
				$options = array(
					'allowPointSelect' => true,
		            'cursor' => 'pointer',
		            'dataLabels' => array(
		                'enabled' => false,
		                //'format' => '<b>{point.name}</b>: {point.percentage:.1f} %',
		            ),
		            'showInLegend' => true
				);

				$options2 = array(
	                'layout' =>'vertical',
	                'align' => 'right',
	                'verticalAlign' => 'middle',
	                'borderWidth' => 0
	            );

				$high->set_whatever($options,'pie','plotOptions',0);
				$high->set_whatever($options2,'wala','legend',1);
				$high->set_tooltip('{series.name}: <b>{point.percentage:.1f}%</b>');
			}else{
				$options = array(
					'fillOpacity' => 0.5,
				);

				$options2 = array('allowDecimals' => false);
				$high->set_whatever($options2,'wala','xAxis',0);
				$high->set_whatever($options,'areaspline','plotOptions',0);

				$high->set_xAxis($data_set['categ']);
				$high->set_yAxis('','Count');
				$high->toggle_legend(FALSE);
				$high->inAllowDecimals('yAxis',FALSE);
			}

			$options1 = array(
				'plotBackgroundColor' => null,
				'plotBorderWidth' => null,
				'plotShadow' => false,
			);


			$high->display_credit(FALSE);
			$high->set_whatever($options1,'wala','chart',1);

			$high->set_serie($data_set['all_type']);
			$high->set_dimensions(600,420);

			$graph = 'graph'.$i;
			$high->render_to($graph);
			$c[$graph] = $high->render();
		}

		$data['all_charts'] = $c;
		$data['set'] = $data['totalCount'];

		$data['role'] = $uid['role'];
		$data['active_nav'] = 'REPORTS';

		if(!$uid['role']){
			$this->load->view('templates/indexadmin', $data);
			$this->load->view('templates/sidebar_admin', $data);
		}
		elseif($uid['role']==1){
			$this->load->view('templates/indexmanager', $data);
			$this->load->view('templates/sidebar_manager', $data);
		}
		else $this->load->view('templates/indexparticipant', $data);

		$this->load->view('course/reg', $data);

	}

	public function upload( $error=0, $message = '' ){
		$this->load->helper('url');
		
		$letter = $this->uri->segment(3);
		$data['letter'] = substr( $letter, 0 , 1 );
		
		$config = array();
		$config['per_page'] = $this->course_model->record_count();
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0 ;
		
		$data['courses'] = $this->course_model->fetch_courses( 'courses', $data['letter'], $config['per_page'], $page, 1);

		$a = $this->indexCourse($data, 1);
		$r = $this->listCourseUsers1();

		$a['array'] = $r['array'];
		$a['count_All'] = $r['count'];

		$a['title'] = 'MeTEOR | Upload Signature';
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$a['userid'] = $uid['id'];
		
		$a['error'] = $error;
		$a['message'] = $message;
		
		$a['man'] = 0;
		$a['active_nav'] = 'UPLOAD';
		$this->load->view('templates/indexadmin', $a);
		$this->load->view('templates/sidebar_admin', $a);
		$this->load->view('course/upload', $a );
		//$this->load->view('templates/footeradmin');
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

	public function search_upload()
	{
		$data['search'] = $_POST['search'];
		$data['title'] = "MeTEOR | Search Results";
				
		$a = array();
		$r = $this->listCourseUsers1();

		$a['array'] = $r['array'];
		$a['count_All'] = $r['count'];

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
		
		$a['man'] = 0;
		$data['active_nav'] = 'UPLOAD';
		$this->load->view('templates/indexadmin', $data);
		$this->load->view('templates/sidebar_admin', $data);
		$this->load->view('course/search_upload', $a);
		//$this->load->view('templates/footeradmin');
	}

	public function upSig(){
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		date_default_timezone_set("Asia/Manila");
		$starting = date('Y-m-d');	

		$ending = date('Y-m-d', strtotime($_POST['ending']));
		//$ending = date( 'Y-m-d' , strtotime($conv));

		if( empty($_POST['ending']) ){
			$this->upload( 0, 'No Ending Date Selected' );
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

		$err = 1;
		$error = "Error Uploading";
		if( !empty($place) ){
			$error = "Success Uploading";
			if( !$signee && !empty($place2) ){
				if( isset($_POST['check']) ){
					foreach( $_POST['check'] as $item){	
						$course_id = $_POST['course'][$item];
						$this->course_model->insert_pic( $starting, $ending, $place, $course_id, $place2, 1, $type, $signatory_name1, $signatory_position1, $signatory_name2, $signatory_position2);
					}
				}else{
					$error = "No Course Selected";
					$err = 0;
				}
			}
			elseif( $signee ) {
				if( isset($_POST['check']) ){
					foreach( $_POST['check'] as $item){	
						$course_id = $_POST['course'][$item];
						$this->course_model->insert_pic( $starting, $ending, $place, $course_id, '', 0, $type, $signatory_name1, $signatory_position1, '', '' );
					}
				}else{
					$error = "No Course Selected";
					$err = 0;
				}
			}
		}
		$this->upload( $err, $error );
	}

	public function upload_image($field_name, $new_name){
		$path = $_SERVER['DOCUMENT_ROOT']."/meteor/upload/";
		$config2['upload_path'] =  $path;
		$config2['allowed_types'] = 'gif|jpg|png|jpeg|jpe';
		$config2['max_size']	= '100';
		$config2['max_width']  = '1024';
		$config2['max_height']  = '768';
		$config2['file_name'] = $new_name;
		$config2['overwrite'] = true;
		
		$this->load->library('upload', $config2);
		$this->upload->initialize($config2);		
		
		if ( !$this->upload->do_upload($field_name) ){
			$error = $this->upload->display_errors();
			return '';
		}
		else{
			$imgOriginalData = $this->upload->data();
			return $imgOriginalData[ 'orig_name' ];
		}
	}

	public function editSig(){		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		date_default_timezone_set("Asia/Manila");
		$starting = date('Y-m-d');	

		$course_id = $_POST['course_id'];

		$ending = date('Y-m-d', strtotime($_POST['endDate']));
		//$ending = date( 'Y-m-d' , strtotime($conv));

		if( empty($_POST['endDate']) ){
			$this->upload( 0, 'No Ending Date Selected' );
			return;
		}

		$nameS = 'photoEdit';
		$name2 = 'photoEdit2';

		$sig_name1 = $_POST['name1'];
		$sig_pos1 = $_POST['position1'];
		$sig_name2 = $_POST['name2'];
		$sig_pos2 = $_POST['position2'];

		$field_name = $_FILES[$nameS]['name'];
		$field_name2 = $_FILES[$name2]['name'];
		$type = $this->input->post('cert');

		if($_FILES[$nameS]['size'] <= 0){ $place = ''; }
		if($_FILES[$name2]['size'] <= 0){ $place2 = ''; }

		$place = $this->upload_image($nameS, $ending."".$field_name);
		$place2 = $this->upload_image($name2, $ending."".$field_name2);

		if( empty($place) && empty($place2) ){
			$error = 'No File Selected';
			$this->upload( 0, $error );
			return;
		}

		$arr = $this->participantuser_model->getDB( 'signature', 'course_id', $course_id, '', '', 0);
		//$this->participantuser_model->getDB( 'cancelled', 'course_id', $row['course_id'], 'user_id', $row['user_id'], 1 );

		$key = $arr->result_array();
			$id1 = $key[0]['photo_id'];
			$id2 = $key[0]['photo_id2'];

			$this->db->delete('signature', array('course_id' => $course_id));
			$p1 = $this->participantuser_model->getDB( 'picture', 'id', $id1, '', '', 0);
			$arr_p1 = $p1->result_array();

			if( ($arr_p1[0]['count'])-1 == 0 ){
				//$this->db->where('id', $id1);
				$this->db->delete('picture', array('id' => $id1) );
				$my_file = $_SERVER['DOCUMENT_ROOT']."/meteor/upload/".$arr_p1[0]['name'];
				if(file_exists($my_file)) unlink($my_file);
			}elseif( !empty($arr_p1[0]['count']) ){
				$temp = $arr_p1[0]['count'] - 1;
				$data = array( 'count' => $temp );
				$this->db->where( 'id', $id1 );
				$this->db->update('picture', $data);
			}

			$p1 = $this->participantuser_model->getDB( 'picture', 'id', $id2, '', '', 0);
			$arr_p1 = $p1->result_array();

			if( ($arr_p1[0]['count'])-1 == 0 ){
				//$this->db->where('id', $id2);
				$this->db->delete('picture', array('id' => $id2) );
				$my_file = $_SERVER['DOCUMENT_ROOT']."/meteor/upload/".$arr_p1[0]['name'];
				unlink($my_file);
			}elseif( !empty($arr_p1[0]['count']) ){
				$temp = $arr_p1[0]['count'] - 1;
				$data = array( 'count' => $temp );
				$this->db->where( 'id', $id2 );
				$this->db->update('picture', $data);
			}				

		$err = 1;
		$error = 'Success Uploading';
		if( !empty($place) ){
			if( !empty($place2) ) $this->course_model->insert_pic( $starting, $ending, $place, $course_id, $place2, 1, $type, $sig_name1, $sig_pos1, $sig_name2, $sig_pos2 );
			else{
				$this->course_model->insert_pic( $starting, $ending, $place, $course_id, '', 0, $type, $sig_name1, $sig_pos1, '', '' );
			}
		} elseif( !empty($place2) ){
			$this->course_model->insert_pic( $starting, $ending, $place2, $course_id, '', 0, $type, $sig_name2, $sig_pos2, '', '' );
		} else {
			$error = "No Course Selected";
			$err = 0;
		}

		$this->upload( $err, $error );
		return;
	}

	public function downloadBatch( $CID ){
		$this->load->library('zip');
		$this->load->helper("file");
		
		$stylesheet = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/meteor/css/stylesheetCOP.css');//appearance_css
		$stylesheet1 = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/meteor/css/appearance_css.css');

		$b = array();		
		$arr = $this->participantuser_model->getDB( 'payment', 'course_id', $CID, '', '', 0 );
		$courseDetails = $this->participantuser_model->getDB( 'courses', 'id', $CID, '', '', 0 );

		$cert = $this->participantuser_model->getDB( 'signature', 'course_id', $CID, '', '', 0);
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

		foreach ($arr->result_array() as $key) {

			if( strtolower($b['type']) == "appearance" ) {
				$placeHeader = $_SERVER['DOCUMENT_ROOT'].'/meteor/css/images/docLogo2.png';
				$mpdf = new mPDF('', 'LETTER', 0, 0, 0, 0, 40, 0, 0, 5,'P');
				$mpdf->WriteHTML($stylesheet1,1);
				$id = '';

				$mpdf->SetHTMLHeader('<img src="'.$placeHeader.'" class="header">');
				$mpdf->SetHTMLFooter('<img src="' .$_SERVER['DOCUMENT_ROOT'].'/meteor/css/images/doc2.png" class="footer">');
			}	
			else {
				$placeHeader = $_SERVER['DOCUMENT_ROOT'].'/meteor/css/images/cert.png';
				$mpdf = new mPDF('', 'LETTER-L', 0, 0, 0, 0, 0, 0, 0, 0,'L');
				$mpdf->WriteHTML($stylesheet,1);
				$id = 'bg';

				$mpdf->SetHTMLHeader('<img id="'.$id.'" src="'.$placeHeader.'">');
			}	


			$arrUsers = $this->participantuser_model->getDB( 'users', 'id', $key['user_id'], '', '', 0 );
			$certificateDate = $this->participantuser_model->getDB( 'completed', 'user_id', $key['user_id'], 'course_id', $CID, 1 );
			$certDate = $certificateDate->result_array();
			$check = $certificateDate->row_array();

			foreach ($arrUsers->result_array() as $keyVal) {
				$b['lname'] = $keyVal['lastname'];
				$b['mname'] = $keyVal['middlename'];
				$b['fname'] = $keyVal['firstname'];
				$b['nameS'] = $b['fname']." ".strtoupper($b['mname'][0]).". ".$b['lname'];
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

			$mpdf->WriteHTML($this->load->view($view, $b, TRUE));
			$filename = 'temp/' . utf8_decode($b['nameS']) . '.pdf';
			$mpdf->Output($filename);
			$this->zip->read_file($filename);

			unlink($filename);
		}
		$zipfilename='All_certificate_of_'.$b['workshop'].'zip';
		$this->upload();
		$this->zip->download($zipfilename);
		exit; // IMPORTANT needed for the mdpf to stop
	}

	public function SURVEY( $manS = 0, $message=NULL ){		
		$data['courses'] = $this->course_model->completed_course();
		$a = array();
		$r = $this->listCourseUsers1();

		$a['array'] = $r['array'];
		$a['count_All'] = $r['count'];

		$a['count'] = 0;
		$a['set'] = 0; $a['all'] = 0; 

		foreach ($data['courses']->result_array() as $key) {
			$tag = 0; $a['hasParticipant'] = 0;		

			$variable = $this->participantuser_model->getDB( 'survey', 'course_id', $key['id'], '', '', 0 ); //$db, $col1, $col1Value, $col2, $col2Value, $num
			
			$totalCount = $this->participantuser_model->getDB('courses', 'id', $key['id'], '', '', 0);
			$totalCount_arr = $totalCount->result_array();

			$a['totalCount'][] = $totalCount_arr[0]['available'];

			foreach ($variable->result_array() as $keyValue) {
				$a['courseS'][] = $keyValue['course_id'];				
				//echo $keyValue['course_id']."<br/>";
				$a['hasParticipant']++;
				$tag = 1;
				$a['all']++;
			}

			if( $tag ){
				$a['count']++;
				$a['idS'][] = $key['id'];
				$a['studentCount'][] = $a['hasParticipant'];
			
				$a['name'][] = $key['name'];
				$a['description'][] = $key['description'];
				$a['venue'][] = $key['venue'];
				$a['cost'][] = $key['cost'];
				$a['set'] = 1;
			}
		}

		$a['man'] = $manS;
		$a['search'] = 0;
		$a['pili'] = 0;
		$a['message'] = $message;

		$a['title'] = "MeTEOR | Evaluation Result";
		$a['active_nav'] = 'EVALUATION';

		if( !$manS ){
			$this->load->view('templates/indexadmin', $a);
			$this->load->view('templates/sidebar_admin', $a);
		}
		else{
			$this->load->view('templates/indexmanager', $a);
			$this->load->view('templates/sidebar_manager', $a);
		}

		$this->load->view('course/resultSurvey', $a);

		//if( !$manS ) $this->load->view('templates/footeradmin');
		//else $this->load->view('templates/footerman');
	}

	public function search_survey( $manS = 0 ){
		$info = $this->input->post('search');
		$evalOrSurvey = $this->input->post('evalOrSurvey');
		$getSearch = $this->course_model->getSurvey( $info );

		$a = array();
		$r = $this->listCourseUsers1();

		$a['array'] = $r['array'];
		$a['count_All'] = $r['count'];

		$a['count'] = 0;
		$a['set'] = 0; $a['all'] = 0;

		foreach ($getSearch->result_array() as $key) {
			$tag = 0; $a['hasParticipant'] = 0;		

			if( !$evalOrSurvey ) $variable = $this->participantuser_model->getDB( 'survey', 'course_id', $key['id'], '', '', 0 ); //$db, $col1, $col1Value, $col2, $col2Value, $num
			else $variable = $this->participantuser_model->getDB( 'origsurvey', 'course_id', $key['id'], '', '', 0 );

			$totalCount = $this->participantuser_model->getDB('courses', 'id', $key['id'], '', '', 0);
			$totalCount_arr = $totalCount->result_array();

			$a['totalCount'][] = $totalCount_arr[0]['available'];

			foreach ($variable->result_array() as $keyValue) {
				$a['courseS'][] = $keyValue['course_id'];				
				//echo $keyValue['course_id']."<br/>";
				$a['hasParticipant']++;
				$tag = 1;
				$a['all']++;
			}

			if( $tag ){
				$a['count']++;
				$a['idS'][] = $key['id'];
				$a['studentCount'][] = $a['hasParticipant'];
			
				$a['name'][] = $key['name'];
				$a['description'][] = $key['description'];
				$a['venue'][] = $key['venue'];
				$a['cost'][] = $key['cost'];
				$a['set'] = 1;
			}
		}

		$a['man'] = $manS;
		$a['search'] = 1;
		$a['pili'] = $evalOrSurvey;
		$a['title'] = "MeTEOR | Evaluation Results";
		if(!$evalOrSurvey) $a['active_nav'] = 'EVALUATION';
		else $a['active_nav'] = 'SURVEY';

		if( !$manS ){
			$this->load->view('templates/indexadmin', $a);
			$this->load->view('templates/sidebar_admin', $a);
		}
		else{
			$this->load->view('templates/indexmanager', $a); 
			$this->load->view('templates/sidebar_manager', $a);
		}

		if( !$evalOrSurvey ) $this->load->view('course/resultSurvey', $a);
		else  $this->load->view('course/resultOrigSurvey', $a);

		//if( !$manS ) $this->load->view('templates/footeradmin');
		//else $this->load->view('templates/footerman');
	}

	public function viewCat($message=NULL,$where=0,$manS=0,$belong=0,$err=0){
		if(!$belong){
			$manS = $this->input->post('manager');
			$belong = $this->input->post('belong');
		}
		$a['title'] = "MeTEOR | View Question Categories";
		$a['belong'] = $belong;
		$a['manager'] = $manS;
		$a['message'] = $message;
		$a['error'] = $err;

		$this->db->order_by('title', 'asc');
		$query = $this->db->get_where('categories_questions', array('belong' => $belong ) );
		$a['count'] = 0;
		foreach($query->result_array() as $value){
			$a['ids'][] = $value['id'];
			$a['titles'][] = $value['title'];
			$a['count']++;
		}
		//$arr = $this->participantuser_model->getDB( 'categories_questions', 'belong', $belong, '', '', 0 );

		if(!$belong) $a['active_nav'] = 'EVALUATION';
		else $a['active_nav'] = 'SURVEY';

		if( !$manS ){
			$this->load->view('templates/indexadmin', $a);
			$this->load->view('templates/sidebar_admin', $a);
		}
		else{
			$this->load->view('templates/indexmanager', $a); 
			$this->load->view('templates/sidebar_manager', $a);
		}

		$this->load->view('course/viewCat', $a);

		//if( !$manS ) $this->load->view('templates/footeradmin');
		//else $this->load->view('templates/footerman');
	}

	public function addCategories(){
		$this->course_model->addCategories();
		$belong = $_POST['belong'];
		$manS = $_POST['manager'];

		$this->viewCat('Categories saved',1,$manS,$belong,1);
	}

	public function editCategory(){
		$belong = $_POST['belong'];
		$manS = $_POST['manager'];

		$this->course_model->editCategories();
		$this->viewCat('Edited Category saved',1,$manS,$belong,1);
		return;
	}

	public function delCategories(){
		$belong = $_POST['belong'];
		$manS = $_POST['manager'];

		$this->course_model->delCategory();
		$this->viewCat('Successfully Deleted',1,$manS,$belong,1);
		return;
	}

	public function viewQuestions($message=NULL,$where=0,$manS=0,$category_id=0,$belong=0, $title_name=NULL){
		if(!$where){
			$category_id = $this->input->post('id_view');
			$manS = $this->input->post('manager');
			$belong = $this->input->post('belong');
			$title_name = $this->input->post('title_name');
		}

		$arr = $this->participantuser_model->getDB('all_questions', 'category_id', $category_id, '', '', 0 );
		//$a['questions_all'] = $variable->result_array();
		$a['category_id'] = $category_id;
		$a['man'] = $manS;
		$a['title_name'] = $title_name;
		$a['title'] = "MeTEOR | Category Questions";
		$a['count'] = 0;
		$a['belong'] = $belong;
		$a['message'] = $message;

		foreach ($arr->result_array() as $value) {
			$a['questions'][] = $value['questions'];
			$a['type'][] = $value['type'];
			$a['count']++;
		}

		if(!$belong) $a['active_nav'] = 'EVALUATION';
		else $a['active_nav'] = 'SURVEY';

		if( !$manS ){
			$this->load->view('templates/indexadmin', $a);
			$this->load->view('templates/sidebar_admin', $a);
		}
		else{
			$this->load->view('templates/indexmanager', $a);
			$this->load->view('templates/sidebar_manager', $a);
		}

		$this->load->view('course/questionsAll', $a);

		//if( !$manS ) $this->load->view('templates/footeradmin');
		//else $this->load->view('templates/footerman');
	}

	public function origsurveyResult( $manS = 0, $message=NULL ){
		$data['courses'] = $this->course_model->completed_course();
		$a = array();
		$r = $this->listCourseUsers1();

		$a['array'] = $r['array'];
		$a['count_All'] = $r['count'];

		$a['count'] = 0;
		$a['set'] = 0; $a['all'] = 0;

		foreach ($data['courses']->result_array() as $key) {
			$tag = 0; $a['hasParticipant'] = 0;			

			$variable = $this->participantuser_model->getDB( 'origsurvey', 'course_id', $key['id'], '', '', 0 ); //$db, $col1, $col1Value, $col2, $col2Value, $num
			$totalCount = $this->participantuser_model->getDB('courses', 'id', $key['id'], '', '', 0);
			$totalCount_arr = $totalCount->result_array();

			$a['totalCount'][] = $totalCount_arr[0]['available'];

			foreach ($variable->result_array() as $keyValue) {
				$a['courseS'][] = $keyValue['course_id'];
				$a['hasParticipant']++;
				$a['all']++;
				$tag = 1;
			}

			if( $tag ){
				$a['count']++;
				$a['idS'][] = $key['id'];
				$a['studentCount'][] = $a['hasParticipant'];
			
				$a['name'][] = $key['name'];
				$a['description'][] = $key['description'];
				$a['venue'][] = $key['venue'];
				$a['cost'][] = $key['cost'];
				$a['set'] = 1;
			}
		}

		//echo $a['all'];
		$a['man'] = $manS;
		$a['search'] = 0;
		$a['message'] = $message;
		$a['title'] = "MeTEOR | Evaluation Result";
		$a['pili'] = 1;
		$a['active_nav'] = 'SURVEY';
		if( !$manS ){
			$this->load->view('templates/indexadmin', $a);
			$this->load->view('templates/sidebar_admin', $a);
		}
		else{
			$this->load->view('templates/indexmanager', $a);
			$this->load->view('templates/sidebar_manager', $a);
		}

		$this->load->view('course/resultOrigSurvey', $a);

		//if( !$manS ) $this->load->view('templates/footeradmin');
		//else $this->load->view('templates/footerman');
	}

	//ANDITO

	public function request( $message = '', $num = 0, $err=0 ){
		$arr = $this->course_model->getTemp();
		$a = array();
		$r = $this->listCourseUsers1();

		$a['array'] = $r['array'];
		$a['count_All'] = $r['count'];

		$a['count'] = 0;
		date_default_timezone_set("Asia/Manila");
		$date = date('y-m-d');
		$temp1 = date('y-m-d', strtotime($date));
		$a['countNotYet'] = 0;

		foreach ($arr as $key) {
			$temp2 = date('y-m-d', strtotime($key['start']));
			$count = 0; $pendingCount = 0;

			$pending = $this->participantuser_model->getDB( 'pending', 'course_id', $key['id'], '', '', 0);
			$pending_array = $pending->result_array();

			if( !$key['approved'] && ($temp1 > $temp2) ){
				$error = $this->course_model->removeRequest( $key['id'], $key['name'] );
				//echo $error;
				continue;
			}
			$a['count']++;
			$pendingCount += count($pending_array);
			//echo count($confirmed_array);
			if( !$key['approved'] ) {
				$a['notYet'][] = $key['id'];
				$a['countNotYet']++;
				$confirmed = $this->participantuser_model->getDB( 'forsending', 'tempId', $key['id'], '', '', 0);
				$confirmed_array = $confirmed->result_array();
				$count += count($confirmed_array);

			}else{

				$courses = $this->participantuser_model->getDB( 'courses', 'tempId', $key['id'], '', '', 0);
				$courses_array = $courses->result_array();

				$confirmed = $this->participantuser_model->getDB( 'reserved', 'course_id', $courses_array[0]['id'], '', '', 0);
				$confirmed_array = $confirmed->result_array();
				$count = count($confirmed_array);

				$confirmed = $this->participantuser_model->getDB( 'payment', 'course_id', $courses_array[0]['id'], '', '', 0);
				$confirmed_array = $confirmed->result_array();
				$count1 = count($confirmed_array);
				$count = $count + $count1;
			}

			$a['id'][] = $key['id'];
			$a['name'][] = $key['name'];
			$a['senderS'][] = $key['sender'];
			$a['start'][] = $key['start'];
			$a['end'][] = $key['end'];
			$a['startTime'][] = date('g:i A', strtotime($key['startTime']));//date('g:i A', strtotime($key['startTime']));
			$a['endTime'][] = date('g:i A', strtotime($key['endTime']));
			$a['venue'][] = $key['venue'];
			$a['countS'][] = $key['count'];
			$a['confirmedCount'][] = $count;
			$a['pendingCount'][] = $pendingCount;
		}

		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$a['title'] = "MeTEOR | Request";
		$a['message'] = $message;
		$a['search'] = 0;
		$a['num'] = $uid['role'];
		$a['set'] = 0;
		$a['pili'] = $uid['role'];
		$a['active_nav'] = 'REQUEST';
		$a['error'] = $err;

		if( !$uid['role'] ){
			$this->load->view('templates/indexadmin', $a);
			$this->load->view('templates/sidebar_admin', $a);
		}
		else{
			$this->load->view('templates/indexmanager', $a);
			$this->load->view('templates/sidebar_manager', $a);
		}

		$this->load->view('course/index_temp', $a);

		//if( !$num ) $this->load->view('templates/footeradmin');
		//else $this->load->view('templates/footerman');
	}

	public function search_request( $numD = 0 ){
		$data['search'] = $_POST['search'];
		$result = $this->course_model->get_results($data, 'temp_courses');
		$a = array();
		$r = $this->listCourseUsers1();

		$a['array'] = $r['array'];
		$a['count_All'] = $r['count'];

		$a['count'] = 0; $a['countNotYet'] = 0;
		$a['search'] = 1;		

		foreach($result->result() as $key)
		{
			$count = 0;
			$a['count']++;

			if( !$key->approved ) {
				$a['notYet'][] = $key->id;
				$a['countNotYet']++;
				$confirmed = $this->participantuser_model->getDB( 'forsending', 'tempId', $key->id, '', '', 0);
				$confirmed_array = $confirmed->result_array();
				$count = count($confirmed_array);

			}else{

				$courses = $this->participantuser_model->getDB( 'courses', 'tempId', $key->id, '', '', 0);
				$courses_array = $courses->result_array();

				$confirmed = $this->participantuser_model->getDB( 'reserved', 'course_id', $courses_array[0]['id'], '', '', 0);
				$confirmed_array = $confirmed->result_array();
				$count = count($confirmed_array);

				$confirmed = $this->participantuser_model->getDB( 'payment', 'course_id', $courses_array[0]['id'], '', '', 0);
				$confirmed_array = $confirmed->result_array();
				$count1 = count($confirmed_array);
				$count = $count + $count1;
			}

			$a['id'][] = $key->id;
			$a['name'][] = $key->name;
			$a['senderS'][] = $key->sender;
			$a['start'][] = $key->start;
			$a['end'][] = $key->end;
			$a['startTime'][] = date('g:i A', strtotime($key->startTime));//date('g:i A', strtotime($key['startTime']));
			$a['endTime'][] = date('g:i A', strtotime($key->endTime));
			$a['venue'][] = $key->venue;
			$a['countS'][] = $key->count;
			$a['confirmedCount'][] = $count;
		}

		$a['title'] = "MeTEOR | Search Request";
		$a['active_nav'] = 'REQUEST';

		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$a['num'] = $uid['role'];
		if( !$uid['role'] ){
			$this->load->view('templates/indexadmin', $a);
			$this->load->view('templates/sidebar_admin', $a);
		}
		else{
			$this->load->view('templates/indexmanager', $a);
			$this->load->view('templates/sidebar_manager', $a);
		}

		$this->load->view('course/index_temp', $a);

		//if( !$a['num'] ) $this->load->view('templates/footeradmin');
		//else $this->load->view('templates/footerman');	
	}

	public function sendEmail( $num = 0 ){
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('phpmailer');

		$a = array();
		$a['numD'] = $num;
		$a['id'] = $_POST['course_id'];
		$CourseName = $_POST['CourseName2'];

		$this->form_validation->set_rules('add_more[]', 'Email', 'required|valid_email');
		if ($this->form_validation->run() == FALSE){
			$this->request('Invalid Email Address', $a['numD'],0);
			return;
		}

		$mail = new PHPMailer();  // create a new object
		$mail->IsSMTP(); // enable SMTP
		$mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true;  // authentication enabled
		$mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587; 
		$mail->Username = 'meteor.upitdc@gmail.com';  
		$mail->Password = 'meteor123';  
		$mail->Subject = '[MeTEOR] Attendance Confirmation';
		$mail->SetFrom('noreply@localhost/meteor', 'MeTEOR Notification');

		$arr = $this->participantuser_model->getDB('temp_courses', 'id', $a['id'], '', '', 0);
		$this_arr = $arr->result_array();

		$a['numS'] = 2;
		$a['CourseName'] = str_replace(" ","%20",$CourseName);
		$a['tempCourseName'] = $CourseName;
		$a['unique'] = $this_arr[0]['code'];
		$a['kind'] = "Confirm Attendance";

		$mail->Body = $this->load->view('pages/sendFile', $a, TRUE);

		foreach ($_POST['add_more'] as $key => $value) {
			$this->course_model->addpending($a['id'], $value);
			$mail->AddAddress($value);
		}

		$mail->IsHTML(true);

		if(!$mail->Send()) {
			$error = 'Mail error: '.$mail->ErrorInfo; 
			$this->request($error, $a['numD'],0);
			return;
		}

		$this->request( 'Invitation Sent', $num,1 );
	}

	public function seeRequest( $tempId, $man, $tag=0 ){
		$a = array();
		$r = $this->listCourseUsers1();

		$a['array'] = $r['array'];
		$a['count_All'] = $r['count'];
		
		$a['manager'] = $man;
		$a['tag'] = $tag;
		$a['numD'] = $man;
		$a['count'] = 0;
		$a['count_pending'] = 0;

		$pending = $this->participantuser_model->getDB( 'pending', 'course_id', $tempId, '', '', 0);
		$pending_array = $pending->result_array();

		if( $tag ){
			$confirmed = $this->participantuser_model->getDB( 'forsending', 'tempId', $tempId, '', '', 0);
			$confirmed_array = $confirmed->result_array();

			$courses = $this->participantuser_model->getDB( 'temp_courses', 'id', $tempId, '', '', 0);
			$courses_array = $courses->result_array();
		}else{			
			$courses = $this->participantuser_model->getDB( 'courses', 'tempId', $tempId, '', '', 0);
			$courses_array = $courses->result_array();

			$confirmed = $this->participantuser_model->getDB( 'reserved', 'course_id', $courses_array[0]['id'] , '', '', 0);
			$confirmed_array = $confirmed->result_array();
		}

		$a['course_id'] = $courses_array[0]['id'];
		$a['temporary'] = $tempId;

		foreach ($pending_array as $key) {
			$a['count_pending']++;
			$a['email_pending'][] = $key['email'];
			$a['id'][] = $key['id'];
			$a['forms'][] = $key['form'];
		}

		foreach ($confirmed_array as $key) {
			$users = $this->participantuser_model->getDB( 'users', 'id', $key['user_id'] , '', '', 0);
			$confirmed_users = $users->result_array();

			$a['count']++;

			$a['user_id'][] = $confirmed_users[0]['id'];
			$a['firstname'][] = $confirmed_users[0]['firstname'];
			$a['lastname'][] = $confirmed_users[0]['lastname'];
			$a['middlename'][] = $confirmed_users[0]['middlename'];
			$a['username'][] = $confirmed_users[0]['username'];
			$a['form'][] = $confirmed_users[0]['form'];
		}

		if( !$tag ){
			$confirmed = $this->participantuser_model->getDB( 'payment', 'course_id', $courses_array[0]['id'] , '', '', 0);
			$confirmed_array = $confirmed->result_array();
		
			foreach ($confirmed_array as $key) {
				$users = $this->participantuser_model->getDB( 'users', 'id', $key['user_id'] , '', '', 0);
				$confirmed_users = $users->result_array();

				$a['count']++;

				$a['user_id'][] = $confirmed_users[0]['id'];
				$a['firstname'][] = $confirmed_users[0]['firstname'];
				$a['lastname'][] = $confirmed_users[0]['lastname'];
				$a['middlename'][] = $confirmed_users[0]['middlename'];
				$a['username'][] = $confirmed_users[0]['username'];
				$a['form'][] = $confirmed_users[0]['form'];
			}
		}	

		$a['set'] = $a['count'];
		$a['name'] = $courses_array[0]['name'];
		$a['title'] = "MeTEOR | Request Participants";
		$a['active_nav'] = 'REQUEST';
		$uid = $this->login_model->getuid($this->session->userdata('username'));

		if( !$uid['role'] ){
			$this->load->view('templates/indexadmin', $a);
			$this->load->view('templates/sidebar_admin', $a);
		}
		else{
			$this->load->view('templates/indexmanager', $a);
			$this->load->view('templates/sidebar_manager', $a);
		}

		$this->load->view('course/requestUsers', $a);

		//if( !$a['numD'] ) $this->load->view('templates/footeradmin');
		//else $this->load->view('templates/footerman');	
	}

	public function changeForms_pending(){
		$userid = $_POST['temp'];
		$tempId = $_POST['tempId'];
		$man = $_POST['manager'];
		$tag = $_POST['tag'];

		$query = $this->participantuser_model->getDB('pending','course_id',$tempId,'id',$userid,1);
		$query = $query->result_array();
		
		if(!$query[0]['form']){
			$data = array(
				'form' => 1
			);
		}else{
			$data =  array(
				'form' => 0
			);
		}

		$this->db->where('id', $userid);
		$this->db->update('pending',$data);

		$this->seeRequest( $tempId, $man, $tag );
		return;
	}

	public function deletePending(){
		$temp = $_POST['temporary'];
		$man = $_POST['man'];
		$tag = $_POST['tag'];

		$this->db->where('course_id', $temp);
		$this->db->delete('pending');
		$this->seeRequest( $temp, $man, $tag );
		return;
	}

	public function addRequest(){
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('phpmailer');

		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		if ($this->form_validation->run() == FALSE){
			$this->request('Invalid Email Address', $a['numD'],0);
			return;
		}

		$a = array();
		$email = $_POST['email'];
		$CourseName = $_POST['CourseName'];
		$startDate = $_POST['startDate'];
		$endDate = $_POST['endDate'];
		$start_t = $_POST['startTime'];
		$end_t = $_POST['endTime'];
		$venue = $_POST['venue'];
		$count = $_POST['count'];
		$a['numD'] = $_POST['num'];
		$countS = 0;

		$temp1 = date('y-m-d', strtotime($startDate));
		$temp2 = date('y-m-d', strtotime($endDate));

		if( $temp1 > $temp2 ){
			$this->request('Start Date should be less than End Date', $a['numD'],0);
			return;
		}

		$temp1 = date('H:i:s', strtotime($start_t));
		$temp2 = date('H:i:s', strtotime($end_t));

		if( $temp1 > $temp2 ){
			$this->request('Start Time should be less than End Time', $a['numD'],0);
			return;
		}	
		include_once($_SERVER['DOCUMENT_ROOT'].'/meteor/securimage/securimage.php');
		$securimage = new Securimage();
		if ($securimage->check($_POST['captcha_code']) == false) {
			$this->request('The SECURITY CODE entered was incorrect', $a['numD'],0);
			return;
		}

		$mail = new PHPMailer();  // create a new object
		$mail->IsSMTP(); // enable SMTP
		$mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true;  // authentication enabled
		$mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587; 
		$mail->Username = 'meteor.upitdc@gmail.com';  
		$mail->Password = 'meteor123';  
		$mail->Subject = '[MeTEOR] Request Accepted';
		$mail->SetFrom('noreply@localhost/meteor', 'MeTEOR Notification');

		include_once($_SERVER['DOCUMENT_ROOT'].'/meteor/application/models/login_model.php');
		$me = new login_model;
		//$uid = $this->login_model->getuid($this->session->userdata('username'));

		$a['numS'] = 6;
		//$a['CourseName'] = str_replace(" ","%20",$CourseName);
		$a['tempCourseName'] = $CourseName;
		$a['unique'] = $me->saltgen(25);
		$a['kind'] = "Request Accepted";

		$mail->Body = $this->load->view('pages/sendFile', $a, TRUE);
		$mail->AddAddress($email);
		$mail->IsHTML(true);
		//echo $mail;
		
		
		if(!$mail->Send()) {
			$error = 'Mail error: '.$mail->ErrorInfo; 
			$this->request($error, $a['numD'],0);
			return;
		}

		$this->course_model->addTemp( $count, $email, $a['unique'] );

		$a['title'] = "MeTEOR | Success";
		$a['temp'] = 1;
		$a['active_nav'] = 'REQUEST';

		//$this->load->view('course/success', $a);
		$this->request( 'Request has been sent', $a['numD'], 1 );
		//if( !$a['numD'] ) $this->load->view('templates/footeradmin');
		//else $this->load->view('templates/footerman');
	}	

	public function approve(){
		$tempId = $_POST['tempId'];

		$tempCourses = $this->participantuser_model->getDB( 'temp_courses', 'id', $tempId, '', '', 0);
		$tempCoursesArray = $tempCourses->result_array();
		$count = $tempCoursesArray[0]['count'];

		$forSending = $this->participantuser_model->getDB( 'forsending', 'tempId', $tempId, '', '', 0);
		$forSendingArray = $forSending->result_array();
		$count2 = count($forSendingArray);

		$data = array(
			'name' => $tempCoursesArray[0]['name'],
			'description' => $tempCoursesArray[0]['description'],
			'start' => $tempCoursesArray[0]['start'],
			'end' => $tempCoursesArray[0]['end'],
			'startTime' => $tempCoursesArray[0]['startTime'], //date('y-m-d', strtotime($tempCoursesArray[0]['startTime']))
			'endTime' => $tempCoursesArray[0]['endTime'],
			'venue' => $tempCoursesArray[0]['venue'],
			'cost' => $tempCoursesArray[0]['cost'],
			'tempId' => $tempId,
			'available' => $count - $count2,
			'paid' => $count2
		);

		$this->db->insert('courses', $data);
		//array('course_id' => $row->course_id, 'user_id' => $row->user_id)

		$courseArray = $this->participantuser_model->getDB( 'courses', 'tempId', $tempId, '', '', 0);
		$courses = $courseArray->result_array();

		foreach ($forSendingArray as $key) {
			$data1 = array(
				'amount' => $tempCoursesArray[0]['cost'],
				'user_id' => $key['user_id'],
				'ornumber' => 0,
				'remarks' => 'free',
				'course_id' => $courses[0]['id'],
				'date' => $key['dateToday']
			);
			$this->db->insert('payment', $data1);
		}

		//$dataCount = count($data1);

		//if($dataCount) $this->db->insert_batch('payment', $data1);
		//else $this->db->insert('payment', $data1);
		$this->db->delete('forsending', array('tempId' => $tempId));

		$data2 = array(
			'approved' => 1
		);

		$this->db->where('id', $tempId);
		$this->db->update('temp_courses', $data2 );

		$this->request('Success Approving',$_POST['pili'],1);
		return;
	}

	public function addQuestions(){
		$belong = $_POST['belong'];
		$manager = $_POST['manager'];
		$arr = $this->participantuser_model->getDB( 'all_questions', 'belong', $belong, '', '', 0 );
		$data = array();

		$data['man'] = $manager;
		$data['belong'] = $belong;
		$data['count'] = 0;
		foreach ($arr->result_array() as $value) {
			$data['questions'][] = $value['questions'];
			$data['type'][] = $value['type'];
			$data['count']++;
		}

		$data['title'] = "MeTEOR | Addition of Questions";
		if( !$manager ) $this->load->view('templates/indexadmin', $data);
		else $this->load->view('templates/indexmanager', $data);

		$this->load->view('course/questionsAll', $data);

		if( !$manager ) $this->load->view('templates/footeradmin');
		else $this->load->view('templates/footerman');
	}

	public function saveQuestions(){
		$belong = $_POST['belong'];
		$title_name = $_POST['title_name'];
		$manS = $_POST['manager'];
		$categoryId = $_POST['categoryId'];

		$this->course_model->saveAllQuestions();
		if(!$belong) $this->viewQuestions("Question(s)  saved",1,$manS,$categoryId,$belong,$title_name);
		else $this->viewQuestions("Question(s) saved",1,$manS,$categoryId,$belong,$title_name);
	}

	public function _data( $all_q, $table, $num )
	{
		$a = array();
		foreach($all_q->result_array() as $key){
			$name = $key['id']."_id";
			$tot1 = $this->course_model->getAvg($table, $name, $num, 0, 1);
			//floatval($tot1[0][$name]) + 0;
			$a[$name]['data'] = array();
			$a[$name]['name'] = $key['questions'];//nl2br($this->myWrap($key['questions'], 40, 2));
			array_push($a[$name]['data'], floatval($tot1) );
		}
		$a['axis'] = array('Questions');//array('Attendance', 'Assignment', 'Devotion', 'Exams');//, 'Portuguese');
		
		return $a;
	}

	public function resultEval( $num, $manS = 0 ){
		include_once('pages.php');
		$me = new pages;
		$survey = $this->course_model->calculateTotal( 0 );
		$me->updateTotal($survey, 0);

		$all_categories = $this->participantuser_model->getDB('categories_questions', 'belong', 0, '', '', 0);
		$rest = $this->participantuser_model->getDB( 'courses', 'id', $num, '', '', 0 );
		$rest = $rest->result_array();
		$serve = $this->participantuser_model->getDB( 'survey', 'course_id', $num, '', '', 0 );
		$b['count'] = 0;
		$b['title_course'] = $rest[0]['name'];

		$c = array();
		foreach($all_categories->result_array() as $value){	
			$high = new Highcharts();	
			$all_q = $this->participantuser_model->getDB('all_questions', 'category_id', $value['id'], 'type', '0', 1);
			$graph_data = $this->_data($all_q, 'survey', $num);

			$high->set_type('column'); // drauwing type
			$high->set_title('Summary Evaluation Scores of Category: '.strtoupper($value['title']), 'Total Response(s): '.count($serve->result_array())); // set chart title: title, subtitle(optional)
			$high->set_axis_titles('', 'Average Scores'); // axis titles: x axis,  y axis
			
			$high->set_xAxis($graph_data['axis']); // pushing categories for x axis labels
			$high->inAllowDecimals('yAxis',TRUE);

			foreach($all_q->result_array() as $key){
				$name = $key['id']."_id";
				$high->set_serie($graph_data[$name]); // the first serie
			}
			$high->display_credit(FALSE);
			$options2 = array(
                'layout' =>'vertical',
                'align' => 'right',
                'verticalAlign' => 'middle',
                'borderWidth' => 0
            );
			$high->set_whatever($options2,'wala','legend',1);

			$high->set_dimensions('',350);
			
			$graph = "graph".$b['count'];
			$high->render_to($graph);
			$c[$graph] = $high->render(); // we render js and div in same time
			$b['count']++;
			//$high->clear();
		}
		$b['all_charts'] = $c;

		$b['name'] = $rest[0]['name'];
		$b['venue'] = $rest[0]['venue'];
		$b['start'] = $rest[0]['start'];
		$b['end'] = $rest[0]['end'];

		$b['set'] = $b['count'];
		$b['man'] = $manS;
		$b['course_id'] = $num;
		$b['pili'] = 0;
		$b['title'] = "MeTEOR | Evaluation Result";
		$b['active_nav'] = 'EVALUATION';

		if( !$manS ){
			$this->load->view('templates/indexadmin', $b);
			$this->load->view('templates/sidebar_admin', $b);
		}
		else{
			$this->load->view('templates/indexmanager', $b);
			$this->load->view('templates/sidebar_manager', $b);
		}

		$this->load->view('course/resultEval2', $b);
		
		//if( !$manS ) $this->load->view('templates/footeradmin');
		//else $this->load->view('templates/footerman');
	}

	public function resultOrigSurvey( $num, $manS = 0 ){
		$arr = $this->participantuser_model->getDB( 'origsurvey', 'course_id', $num, '', '', 0 ); //$db, $col1, $col1Value, $col2, $col2Value, $num
		
		$all_categories = $this->participantuser_model->getDB('categories_questions', 'belong', 1, '', '', 0);
		$rest = $this->participantuser_model->getDB( 'courses', 'id', $num, '', '', 0 );
		$rest = $rest->result_array();
		$serve = $this->participantuser_model->getDB( 'origsurvey', 'course_id', $num, '', '', 0 );
		$b['count'] = 0;
		$b['title_course'] = $rest[0]['name'];

		$c = array();
		foreach($all_categories->result_array() as $value){
			$high = new Highcharts();
			$all_q = $this->participantuser_model->getDB('all_questions', 'category_id', $value['id'], 'type', '0', 1);
			$graph_data = $this->_data($all_q, 'origsurvey', $num);

			$high->set_type('column'); // drauwing type
			$high->set_title('Summary Survey Scores of Category: '.strtoupper($value['title']), 'Total Response(s): '.count($serve->result_array())); // set chart title: title, subtitle(optional)
			$high->set_axis_titles('', 'Average Scores'); // axis titles: x axis,  y axis
			
			$high->set_xAxis($graph_data['axis']); // pushing categories for x axis labels
			
			foreach($all_q->result_array() as $key){
				$name = $key['id']."_id";
				$high->set_serie($graph_data[$name]); // the first serie
			}
			$high->display_credit(FALSE);
			$options2 = array(
                'layout' =>'vertical',
                'align' => 'right',
                'verticalAlign' => 'middle',
                'borderWidth' => 0
            );
			$high->set_whatever($options2,'wala','legend',1);
			$high->inAllowDecimals('yAxis',TRUE);

			$high->set_dimensions('',350);
			
			$graph = "graph".$b['count'];
			$high->render_to($graph);
			$c[$graph] = $high->render(); // we render js and div in same time
			$b['count']++;
		}
		$b['all_charts'] = $c;
		
		$b['name'] = $rest[0]['name'];
		$b['venue'] = $rest[0]['venue'];
		$b['start'] = $rest[0]['start'];
		$b['end'] = $rest[0]['end'];

		$b['set'] = $b['count'];
		$b['man'] = $manS;
		$b['course_id'] = $num;
		$b['pili'] = 1;
		$b['title'] = "MeTEOR | Survey Result";
		$b['active_nav'] = 'SURVEY';

		if( !$manS ){
			$this->load->view('templates/indexadmin', $b);
			$this->load->view('templates/sidebar_admin', $b);
		}
		else{
			$this->load->view('templates/indexmanager', $b);
			$this->load->view('templates/sidebar_manager', $b);
		}

		$this->load->view('course/surveyParticipants2', $b);

		//if( !$manS ) $this->load->view('templates/footeradmin');
		//else $this->load->view('templates/footerman');
		
	}

	public function downloadReports(){
		$this->load->library('excel');
		$sheet = new PHPExcel();

		$belong = $_POST['belonging'];
		$type = $_POST['type'];

		$all_category = $this->participantuser_model->getReports();
		$fields = $all_category->list_fields();
		
		$styleArray = array(
		    'font'  => array(
		        'bold'  => true,
		        'color' => array('rgb' => 'FFFFFF'),
		    ),
		    'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
	    );

		$sheet->setActiveSheetIndex(0);
		$sheet->getActiveSheet()->setTitle('Data Reports');

		$col = 0;
		foreach ($fields as $field) {
			$sheet->getActiveSheet()->setCellValueByColumnAndRow($col, 1, strtoupper($field));
			$sheet->getActiveSheet()->getStyleByColumnAndRow($col,1)->getFont()->setBold(true);
			$col++;
		}

		$row = 2;
		foreach($all_category->result_array() as $key2){
			$col = 0;
			foreach($fields as $field) {
				$sheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ucwords(strtolower($key2[$field])));
				$col++;
			}
			$row++;
		}

		$inputFileType = 'Excel5';
		if($type=="csv"){
			$inputFileType = "CSV";
		}

		$filename = 'Data Reports.'.$type; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache

		$sheet_writer = PHPExcel_IOFactory::createWriter($sheet, $inputFileType);
		$sheet_writer->save('php://output');
		
	}

	public function suffix( $num ){
		if( $num == 1 || $num == 21 || $num == 31 ) return 'st';
		elseif( $num == 2 || $num == 22 ) return 'nd';
		elseif( $num == 3 || $num == 33 || $num == 23 ) return 'rd';
		else return 'th';
	}

	public function seperate( $s1, $s2 ){
		list( $m1, $d1, $y1 ) = explode(" ", $s1);
		list( $m2, $d2, $y2 ) = explode(" ", $s2);

		if( $s1 == $s2 ) return ($d1.$this->suffix($d1)." of ".$m1." ; ".$y1);
		if( (int)$y1 == (int)$y2 ){
			if( $m1 == $m2 ) return ( $d1.$this->suffix($d1)."-".$d2.$this->suffix($d2)." . of ".$m1." ; ".$y1 ); // add .
			else return ( $d1.$this->suffix($d1)." of ".$m1." - ".$d2.$this->suffix($d2)." . of ".$m2." ; ".$y1  );
		} else return ( $d1.$this->suffix($d1)." of ".$m1." ".$y1." - ".$d2.$this->suffix($d2)." . of ".$m2." ; ".$y2  );
	}

	public function second_sift( $r1, $r2 ){
		if( $r1 == $r2 ) return $r1;
		list( $s1, $t1 ) = explode(" ; ", $r1);
		list( $s2, $t2 ) = explode(" ; ", $r2);
		if( $t1 == $t2 ) {
			
			$temp = $this->thirdSift($s1, $s2);
			return $temp." ; ".$t1;
			
			//return ($s1.", ".$s2." ; ".$t1);
		}	
		else return ($s1." ".$t1.", ".$s2." ; ".$t2);
	}

	public function thirdSift( $s1, $s2 ){
		list( $u1, $v1 ) = explode(" . ", $s1); // 15th-17th
		list( $u2, $v2 ) = explode(" . ", $s2); // 29th-31st

		if( $v1 == $v2 ) {
			return $u1.", ".$u2." ".$v1; // 15th-17th, 29th-31st of jul
		}
		else return $u1." ".$v1.", ".$u2." ".$v2; // 15th-17th of jul, 29th-31st of aug
	}

	public function setSurvey(){
		include_once('participant.php');
		$me = new participant;

		$cid = $_POST['course_idDate']; 
		$uid = $_POST['user_id']; 

		$orderByDate = array(); $num = 0; $check = 0;
		foreach ($_POST['endDateCert'] as $key => $value) { // sort the date into ascending order
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
			$me->viewprofile("Please select date(s) of attendance.",'',0);
			return;
		}

		array_multisort($orderByDate, SORT_ASC, $_POST['endDateCert']);
		$start_sift = array(); $i = 0; $full_string = "";

		foreach ($_POST['endDateCert'] as $key => $value) {
			$value = str_replace(",", "", $value);
			list( $s1, $s2 ) = explode(" - ",  $value);
			$last = $s2;
			if( !$i ) $first = $s1;
			$start_sift[$i] = $this->seperate( $s1, $s2 );
			$i++;
		}

		for( $j = 0; $j < $i; $j++ ){
			if( !$j ) $full_string .= $start_sift[$j];
			else $full_string = $this->second_sift( $full_string, $start_sift[$j] );
		}

		$full_string = str_replace(" ;", " ", $full_string);
		$full_string = str_replace(" . ", " ", $full_string);
		//echo $full_string;
		$this->course_model->updater($cid, $uid, $full_string, $last, $first);
		$me->viewprofile('End dates for certificate saved', $uid, 1);
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

	public function listCourseUsers2(){
		$a['count'] = 0;
		$a['array'] = '[';

		$counter = 0;
		$query = $this->db->get('users');

		foreach ($query->result_array() as $row) {
			$first = ucwords(strtolower($row['firstname']));
			$last = ucwords(strtolower($row['lastname']));
			if(!empty($row['middlename']) ){
				$middle = ucwords(strtolower($row['middlename']));
				$a['array'] .= "\"$first\", \"$middle\", \"$last\"";
				$add = 3;
			}else{
				$a['array'] .= "\"$first\", \"$last\"";
				$add = 2;
			}
			
			$a['count'] += $add;
			$counter++;

			if( $counter < count($query->result_array())) $a['array'] .= ', ';
		}

		 $a['array'] .= ']';
			
		return $a;
	}
	
	public function listCourseUsers3(){
		$a['count'] = 0;
		$a['array'] = '[';

		$counter = 0;
		$query = $this->participantuser_model->getDB('users','role',1,'','',0);

		foreach ($query->result_array() as $row) {
			$first = ucwords(strtolower($row['firstname']));
			$last = ucwords(strtolower($row['lastname']));
			if(!empty($row['middlename']) ){
				$middle = ucwords(strtolower($row['middlename']));
				$a['array'] .= "\"$first\", \"$middle\", \"$last\"";
				$add = 3;
			}else{
				$a['array'] .= "\"$first\", \"$last\"";
				$add = 2;
			}
			
			$a['count'] += $add;
			$counter++;

			if( $counter < count($query->result_array())) $a['array'] .= ', ';
		}

		$a['array'] .= ']';
			
		return $a;
	}
	
	public function listCourseUsers(){
		$a['count'] = 0;
		$a['array'] = '[';

		$query = $this->db->get('courses');
		foreach ($query->result_array() as $row) {
			$name = $row['name'];
			$a['array'] .= "\"$name\"";
			if(($a['count']+1) < count($query->result_array())) $a['array'] .= ', ';
			$a['count']++;
		}

		$a['array'] .= ', ';
		$counter = 0;
		$query = $this->db->get('users');

		foreach ($query->result_array() as $row) {
			$first = ucwords(strtolower($row['firstname']));
			$last = ucwords(strtolower($row['lastname']));
			if(!empty($row['middlename']) ){
				$middle = ucwords(strtolower($row['middlename']));
				$a['array'] .= "\"$first\", \"$middle\", \"$last\"";
				$add = 3;
			}else{
				$a['array'] .= "\"$first\", \"$last\"";
				$add = 2;
			}
			
			$a['count'] += $add;
			$counter++;

			if( $counter < count($query->result_array())) $a['array'] .= ', ';
		}

		 $a['array'] .= ']';	
		return $a;
	}

}	

?>