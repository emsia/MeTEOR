<?php
class course_model extends CI_Model {
	public function __construct()
	{
		$this->load->database();
		$this->load->library('phpmailer');
	}
	
	public function record_count()
	{
		return $this->db->count_all('courses');
	}
	
	public function record_countUpComing()
	{	
		date_default_timezone_set("Asia/Manila");											
		$date = date('d-m-Y');
		
		$sql = "SELECT COUNT(*) as numrows FROM courses WHERE end > '".$date."'";	
		$query = $this->db->query($sql);
		$count = $query->num_rows(); 
		return $count;
	}
	
	public function calculateSurveyTotal( $num ){
		$arr = $this->db->get_where('origsurvey', array('counted' => $num));
		return $arr;
	}
	
	public function getAverage($table, $column, $name, $value,$num=0){
		$this->db->select_avg($column);
		if(!$num) $this->db->where(array($name=>$value, 'type'=>0));
		else $this->db->where($name,$value);
		$sql = $this->db->get($table);

    	return $sql->result_array();
	}

	public function getAvg( $table, $name, $course_id, $val = 2, $num = 0){
		//$select = "AVG('$name')";
		/*
			SELECT AVG(daily_typing_pages)
    		-> FROM employee_tbl;

    		$this->db->where($name, $val);
			$this->db->from($table);
			return $this->db->count_all_results();
			// Produces an integer, like 17

		*/
    	//$this->db->select($select);
    	//$this->db->from($table);
   		
		/*
			$this->db->where('course_id',$course_id);
			$this->db->where($name,$val);
			$this->db->from($table);

			if($this->db->count_all_results()){
				$this->db->select_sum($name);
			}
		*/

   		if( !$num ){
			$this->db->where('course_id',$course_id);
	    	$this->db->where($name,$val);
	    	$this->db->from($table);
	    	//$this->db->group_by(array($name)); 
			//$sql = $this->db->get($table);

	    	//$sql = $this->db->get();
	    	//return $sql->result_array();

	    	return $this->db->count_all_results();
   		}

   		$this->db->select_avg($name);    	
		$this->db->where('course_id',$course_id);
		$this->db->where_not_in($name,$val);
		$sql = $this->db->get($table);

    	$sql = $sql->result_array();
    	return $sql[0][$name];
	}

	public function insert_pic( $starting, $ending, $place , $course_id, $photo2, $num, $type,  $signatory_name1, $signatory_position1, $signatory_name2, $signatory_position2 ){
		$query = $this->db->get_where( 'picture', array('name' => $place) );
		$ans = $query->row_array(); $forId = '';
		
		if( empty($ans['id']) ) {
			$data = array(
				'name'	=> $place
			);
			//print_r($data);
			$this->db->insert( 'picture', $data );
			
			$query = $this->db->get_where( 'picture', array('name' => $place) );
			$ans = $query->row_array();
		}else{
			$query_arr = $query->result_array();
			$temp = $query_arr[0]['count'] + 1;
			$data = array(
				'count' => $temp
			);
			$this->db->where('name', $place);
			$this->db->update( 'picture', $data);
		}

		if( $num ){
			$query1 = $this->db->get_where( 'picture', array('name' => $photo2) );
			$ans1 = $query1->row_array();
			if( empty($ans1['id']) ) {
				$data = array(
					'name'	=> $photo2
				);
				//print_r($data);
				$this->db->insert( 'picture', $data );
			}else{
				$query_arr = $query1->result_array();
				$temp = $query_arr[0]['count'] + 1;
				$data = array(
					'count' => $temp
				);
				$this->db->where('name', $photo2);
				$this->db->update( 'picture', $data);
			}

			$query1 = $this->db->get_where( 'picture', array('name' => $photo2) );
			$ans1 = $query1->row_array();
			$forId = $ans1['id'];			
		}

		$data = array(
			'course_id'	=> $course_id,
			'photo_id'   => $ans['id'],
			'startdate' => $starting,
			'enddate' => $ending,
			'photo_id2' => $forId,
			'name1' => $signatory_name1,
			'position1' => $signatory_position1,
			'name2' => $signatory_name2,
			'position2' => $signatory_position2,
			'type' => $type
		);
		
		$this->db->insert( 'signature', $data );
	}
	
	public function get_reports($place, $num = 0)
	{
		$start_date = $_POST['starting'];
		$end_date = $_POST['ending'];
		
		$temp = strtotime($start_date);
		$var1 = date('Y-m-d', $temp).PHP_EOL;
		
		$temp2 = strtotime($end_date);
		$var2 = date('Y-m-d', $temp2).PHP_EOL;
		
		$where =  "( start between '$var1' AND '$var2')
					AND ( end between '$var1' AND '$var2' ) ";
		//$where = "start >= '$var1' AND end <= '$var2'";
		
		if( !$num ) $this->db->where( 'tempId', 0 );
		$this->db->where($where);
		$query = $this->db->get($place);
		return $query;
	}	
	
	public function getUserRep(){
		$start_date = $_POST['starting'];
		$end_date = $_POST['ending'];
		
		$temp = strtotime($start_date);
		$var1 = date('Y-m-d', $temp).PHP_EOL;
		
		$temp2 = strtotime($end_date);
		$var2 = date('Y-m-d', $temp2).PHP_EOL;
		//echo($var1." ".$var2);
		$select = "SELECT U.id, U.lastname, U.firstname, U.username
				FROM reserved R, users U, courses C
				WHERE (( R.course_id = C.id) AND U.id = R.user_id ) AND ((C.start BETWEEN '$var1' AND '$var2')  AND ( C.end BETWEEN '$var1' AND '$var2'))
				UNION
				SELECT U.id, U.lastname, U.firstname, U.username
				FROM payment P, users U, courses C
				WHERE ((P.course_id = C.id) AND U.id = P.user_id ) AND ( (C.start BETWEEN '$var1' AND '$var2')  AND ( C.end BETWEEN '$var1' AND '$var2') )
				";
		$query = $this->db->query($select);
		return $query;
	}
	
	public function fetch_users_reservedCashBank( $id )
	{
		$sql = "SELECT DISTINCT C.id, C.name, C.description, C.start, C.end, R.user_id, U.username, U.firstname, U.lastname
				FROM courses C, reserved R, payment P, users U
				WHERE C.id = '$id' AND ( ( C.id = R.course_id OR C.id = P.course_id ) 
					AND ( U.id = R.user_id OR U.id = P.user_id) )";
				
		$query = $this->db->query($sql);
		return $query;
	}
	
	public function fetch_All( $id )
	{
		$sql = "SELECT user_id, course_id, date, U.lastname, U.firstname, U.username, C.name, C.description
				FROM reserved R, users U, courses C
				WHERE ( R.course_id = $id AND C.id = $id ) AND U.id = R.user_id
				UNION
				SELECT user_id, course_id, date, U.lastname, U.firstname, U.username, C.name, C.description
				FROM payment P, users U, courses C
				WHERE (P.course_id = $id  AND C.id = $id) AND U.id = P.user_id
				UNION
				SELECT user_id, course_id, date, U.lastname, U.firstname, U.username, C.name, C.description
				FROM cancelled Ca, users U, courses C
				WHERE (Ca.course_id = $id  AND C.id = $id )AND U.id = Ca.user_id";
				
		$query = $this->db->query($sql);
		return $query;
	}
	
	public function change($message){
		$id = $message['course_id'];
		
		if( !empty($message['description']) )	{
			$data = array('description' => $message['description'] );
			$this->db->where('id', $id);
			$this->db->update('courses', $data); 
		}
		if( !empty($message['name']) )	{
			$data = array('name' => $message['name'] );
			$this->db->where('id', $id);
			$this->db->update('courses', $data); 
		}
		if( !empty($message['objectives']) )	{
			$data = array('objectives' => $message['objectives'] );
			$this->db->where('id', $id);
			$this->db->update('courses', $data); 
		}		
		if( !empty($message['startTime']) )	{
			$data = array('startTime' => date('H:i ',strtotime($message['startTime'])) );
			$this->db->where('id', $id);
			$this->db->update('courses', $data); 
		}
		if( !empty($message['endTime']) )	{
			$data = array('endTime' => date('H:i', strtotime($message['endTime'])) );
			$this->db->where('id', $id);
			$this->db->update('courses', $data); 
		}
		if( !empty($message['venue']) )	{
			$data = array('venue' => $message['venue'] );
			$this->db->where('id', $id);
			$this->db->update('courses', $data); 
		}
		if( !empty($message['start']) )	{
			$data = array('start' => $message['start'] );
			$this->db->where('id', $id);
			$this->db->update('courses', $data); 
		}
		if( !empty($message['end']) )	{
			$data = array('end' => $message['end'] );
			$this->db->where('id', $id);
			$this->db->update('courses', $data); 
		}
		if( !empty($message['cost']) )	{
			$data = array('cost' => $message['cost'] );
			$this->db->where('id', $id);
			$this->db->update('courses', $data); 
		}
		if( !empty($message['available']) )	{
			$data = array('available' => $message['available'] );
			$this->db->where('id', $id);
			$this->db->update('courses', $data); 
		}
			
		if( !empty($message['attendees']) )	{
			$data = array('attendees' => $message['attendees'] );
			$this->db->where('id', $id);
			$this->db->update('courses', $data); 
		}	
		if( !empty($message['food']) )	{
			$data = array('food' => $message['food'] );
			$this->db->where('id', $id);
			$this->db->update('courses', $data); 
		}
		if( !empty($message['foodRemarks']) )	{
			$data = array('foodRemarks' => $message['foodRemarks'] );
			$this->db->where('id', $id);
			$this->db->update('courses', $data); 
		}
		if( !empty($message['landTranspo']) )	{
			$data = array('landTranspo' => $message['landTranspo'] );
			$this->db->where('id', $id);
			$this->db->update('courses', $data);
		}
		if( !empty($message['landRemarks']) )	{
			$data = array('landRemarks' => $message['landRemarks'] );
			$this->db->where('id', $id);
			$this->db->update('courses', $data);
		}
		if( !empty($message['accomodation']) )	{
			$data = array('accomodation' => $message['accomodation'] );
			$this->db->where('id', $id);
			$this->db->update('courses', $data); 
			
		}
		if( !empty($message['accomodationRemarks']) )	{
			$data = array('accomodationRemarks' => $message['accomodationRemarks'] );
			$this->db->where('id', $id);
			$this->db->update('courses', $data); 
			
		}
		if( !empty($message['airfare']) )	{
			$data = array('airfare' => $message['airfare'] );
			$this->db->where('id', $id);
			$this->db->update('courses', $data); 
			
		}
		if( !empty($message['airfareRemarks']) )	{
			$data = array('airfareRemarks' => $message['airfareRemarks'] );
			$this->db->where('id', $id);
			$this->db->update('courses', $data); 
			
		}
		if( !empty($message['totalexp']) )	{
			$data = array('totalexp' => $message['totalexp'] );
			$this->db->where('id', $id);
			$this->db->update('courses', $data); 
			
		}		
			
	}
	
	public function getListParticipants($user_id){
		$query = $this->db->get_where('users', array('id' => $user_id));
		return $query;
	}
	
	public function fetch_users( $id )
	{
		$query = $this->db->get_where('reserved', array('course_id' => $id) );
		return $query;
	}
	
	public function fetch_cancelled( $id )
	{	
		$query = $this->db->get_where('cancelled', array('course_id' => $id) );
		return $query;
	}
	
	public function fetch_dissolved( $id )
	{	
		$query = $this->db->get_where('dissolved', array('course_id' => $id) );
		return $query;
	}
	
	public function fetch_courses( $place, $letter, $limit, $start, $num = 0 )
	{
		$where = "name LIKE '$letter%'";
		$this->db->where( $where );
		if( !$num ) $this->db->where(array('tempId' => 0));
		$this->db->order_by( 'name', 'ASC' );
		
		$query = $this->db->get($place, $limit, $start );
		return $query->result_array();
	}
	
	public function fetch_courses_cancelled( $letter, $limit, $start )
	{
		$select = "C.id, C.name, C.description, C.start, C.end, C.paid, C.available, C.venue, C.cost";
		$from = "courses C, cancelled Ca";
		$where = "C.name LIKE '$letter%' AND C.id = Ca.course_id";
		$this->db->select( $select );
		$this->db->from( $from );
		$this->db->where( $where );		
		$this->db->order_by( 'C.name', 'ASC' );
		
		$query = $this->db->get();//'', $limit, $start );
		return $query->result_array();
	}
	
	public function get_courses( $slug = 0 )
	{	
		if( !$slug ) $query = $this->db->get_where( 'courses', array('tempId' => $slug) );
		else $query = $this->db->get('courses');
		return $query->result_array();
	}

	public function get_managers( $slug = FALSE )
	{
		if ($slug === FALSE)
		{
			$query = $this->db->get_where('users', array('role' => 1));
			return $query->result_array();
		}
		
		$query = $this->db->get_where('users', array('slug' => $slug));
		return $query->row_array();
	}
	
	public function get_cancelledCourses( $slug = FALSE )
	{
		if ($slug === FALSE)
		{
			$query = $this->db->get('cancelled');
			return $query->row_array();
		}
		
		$query = $this->db->get_where('cancelled', array('slug' => $slug));
		return $query->row_array();
	}
	
	public function get_dissolved( $slug = FALSE )
	{
		if ($slug === FALSE)
		{
			$query = $this->db->get('dissolved');
			return $query->row_array();
		}
		
		$query = $this->db->get_where('dissolved', array('slug' => $slug));
		return $query->row_array();
	}
	
	public function get_reservedCourses( $slug = FALSE )
	{
		if ($slug === FALSE)
		{
			$query = $this->db->get('reserved');
			return $query->row_array();
		}
		
		$query = $this->db->get_where('reserved', array('slug' => $slug));
		return $query->row_array();
	}
	
	public function set_courses()
	{
		$this->load->helper('url');
		$slug = url_title($this->input->post('title'), 'dash', TRUE);
		
		//INSERT INTO `courses`(`name`, `description`, `cost`, `start`, `end`, `available`, `reserved`, `paid`) 
		//VALUES ('CS191', 'Software Engineering ', '3000', '12-12-12', '12-03-13', 1, 1, 1);
		
		$start = $_POST['startDate'];
		$start = date('Y-m-d', strtotime($start));

		$end = $_POST['endDate'];
		$end = date('Y-m-d', strtotime($end));
		
		$total = 0;
		$total = $_POST['food'] + $_POST['transport'] + $_POST['air'] + $_POST['accoms'];
		$data = array(
			'name' 			=> $_POST['name'],
			'start' 		=> $start,
			'end' 			=> $end,
			'venue'			=> $_POST['venue'],
			'cost' 			=> $_POST['cost'],
			'available'		=> $_POST['available'],
			'objectives'	=> $_POST['objectives'],
			'description'	=> $_POST['description'],
			'startTime'		=> date("H:i:s", strtotime($_POST['startTime'])), //$time = date("H:i:s", strtotime($_POST['startTime'][$j]));
			'endTime'		=> date("H:i:s", strtotime($_POST['endTime'])),
			'attendees'		=> $_POST['attendess'],
			'landTranspo'	=> $_POST['transport'],
			'landRemarks'	=> $_POST['transpoRemarks'],
			'food'			=> $_POST['food'],
			'foodRemarks'		=> $_POST['foodRemarks'],
			'accomodation'		=> $_POST['accoms'],
			'accomodationRemarks'		=> $_POST['accomRemarks'],
			'airfare'		=> $_POST['air'],
			'airfareRemarks' => $_POST['airRemarks'], 
			'totalexp'		=> $total
			
		);
		
		$this->db->insert('courses', $data);
		/*$query = $this->db->get_where('courses', array('name' => $_POST['name']));
		$array = $query->row_array();
			
		$this->db->set('desc', "ADD");
		$this->db->set('course', $array['id']);
		$this->db->set('date', $var1);
		$this->db->set('status', 2);
		$this->db->insert('recentactivities');*/
		return ''; 
	}
	
	public function addpending($course_id, $email){
		include_once('participantuser_model.php');
		$me = new participantuser_model;

		$pending = $me->getDB('pending', 'email', $email, '', '', 0 );
		$pending = $pending->result_array();
		if( !count($pending) ){
			$data = array(
				'email' => $email,
				'course_id' => $course_id
			);
			$this->db->insert('pending', $data);
		}
	}

	public function removePending($email, $temp_id){
		$this->db->delete('pending', array('email' => $email , 'course_id' => $temp_id) );	
	}

	public function set_cancelledStatus()
	{
		$this->load->helper('url');
		$slug = url_title($this->input->post('title'), 'dash', TRUE);
				
		$query = $this->db->get_where('cancelled', array('course_id' => $_POST['course_id']));
		$array = $query->row_array();
		
		$queryDis = $this->db->get_where('dissolved', array('course_id' => $_POST['course_id']));
		$arrayDis = $queryDis->row_array();
		
		if( empty( $array['id']) && empty( $arrayDis['id']) ){
			$continue = FALSE; $continue1 = FALSE;
			if( !$this->check_paid( $_POST['course_id'] ) ) $continue = TRUE;
			if( !$this->check_reserved( $_POST['course_id'] ) ) $continue1 = TRUE;
			if( $continue && $continue1 ){
				$data = array(
					'course_id' => $this->input->post('course_id'),
					'user_id' 	=> $this->input->post('user_id'),
					'date'		=> $this->input->post('date')
				);
				$this->db->insert('dissolved', $data);	
				$data = array(
					'course_id' => $this->input->post('course_id'),
					'user_id' 	=> $this->input->post('user_id'),
					'date'		=> $this->input->post('date'),
					'refunded'	=> -1
				);
				$this->db->insert('cancelled', $data);	
			}
			$query1 = $this->db->get_where('courses', array('id' => $_POST['course_id']));
			$array1 = $query1->row_array();
				
			date_default_timezone_set("Asia/Manila");											
			$var1 = date('Y-m-d G:i:s');
				
			$data1 = array(
				'course' 	=> $array1['id'],
				'desc' 		=> "DELETE",
				'date'		=> $var1,
				'status'	=> 2
			);
			$this->db->insert('recentactivities', $data1);	

			if( $array1['tempId'] != 0 ){
				$this->removeRequest( $array1['tempId'], $array1['name'] );
			}	
		}	
		return;
	}
	
	private function check_paid( $data )
	{
		$query = $this->db->get_where('payment', array('course_id' => $data));
		$array1 = $query->row_array();
		
		if( !empty( $array1['id'] ) ){	
			if( !empty( $array1['id']) ) $this->paid( $query );
			return TRUE;
		}
		return FALSE;
	}
	
	private function paid( $data ){
		foreach( $data->result() as $row ){
		
			$this->db->set('course_id', $row->course_id);
			$this->db->set('user_id', $row->user_id);
			$this->db->set('date', $this->input->post('date'));
			$this->db->set('refunded', 1); // refunded = 1 means paid
			$this->db->insert('cancelled');	
			
			$this->db->delete('payment', array('course_id' => $row->course_id , 'user_id' => $row->user_id) );	
		}
	}
	
	public function get_results($data, $place, $num = 0)
	{
		$search = $data['search'];
		if( $place === 'courses' ){ 
			$where = "(id LIKE '%$search%' OR name LIKE '%$search%' OR description LIKE '%$search%' 
			OR venue LIKE '%$search%' OR start LIKE '%$search%' OR end LIKE '%$search%' OR cost LIKE '%$search%' )";
			if( !$num ) $this->db->where( 'tempId', 0 );
		} else{
			$where = "(id LIKE '%$search%' OR name LIKE '%$search%' OR venue LIKE '%$search%' 
			OR start LIKE '%$search%' OR end LIKE '%$search%' OR cost LIKE '%$search%' ) ";
		}

		$this->db->where($where);
		$this->db->order_by('name', 'ASC');
		$query = $this->db->get($place);
				
		return $query;
	}
	
	private function check_reserved( $data )
	{
		$query = $this->db->get_where('reserved', array('course_id' => $data));
		$array1 = $query->row_array();
		if( !empty( $array1['id']) ){				
			foreach( $query->result() as $row ){
				$query1 = $this->db->get_where('cancelled', array( 'course_id' => $row->course_id, 'user_id' => $row->user_id));
				$array = $query1->row_array();				
				if( empty( $array['id'] ) ){
					$this->db->set('course_id', $row->course_id);
					$this->db->set('user_id', $row->user_id);
					$this->db->set('date', $this->input->post('date'));
					$this->db->insert('dissolved');	
				}
				$this->db->delete('reserved', array('course_id' => $row->course_id, 'user_id' => $row->user_id) );
			}
			return TRUE;
		}
		return FALSE;
	}
	
	public function updater( $course_id, $user_id, $full, $last, $first ){
		$query = $this->db->get_where('completed', array( 'course_id' => $course_id, 'user_id' => $user_id ));
		$array = $query->result_array();

		date_default_timezone_set("Asia/Manila");
		$date = date('Y-m-d');

		$this->db->set('user_id', $user_id); 
		$this->db->set('course_id', $course_id); 
		$this->db->set('date', $date); 
		$this->db->set('string', $full); 
		$this->db->set('last', $last); 
		$this->db->set('first', $first); 

		if( empty($array[0]['id']) )
			$this->db->insert('completed');
		else {
			$this->db->where('id', $array[0]['id'] );
			$this->db->update('completed');
		}	
	}

	public function saveAllQuestions(){
		$this->load->dbforge();
		$belong = $_POST['belong'];
		$categoryId = $_POST['categoryId'];

		$questions = $_POST['QE'];

		$this->db->where('category_id', $categoryId);
		$this->db->delete('all_questions');

		$cert = $_POST['cert'];
		$i = 1;

		foreach($questions as $question){
			if($question != NULL){
				$this->db->set('belong', $belong);
				$this->db->set('id', $i.$belong.$categoryId);
				$this->db->set('questions', $question);
				$this->db->set('category_id', $categoryId); 
				$type = ($cert[$i-1]=='Radio Button')?0:1;
				$this->db->set('type', $type); 
				$i++;
				$this->db->insert('all_questions');	
			}
		}

		if(!$belong){
			//$this->dbforge->drop_table('survey');
			$this->delQuestions($categoryId, $belong);
			$arr = $this->participantuser_model->getDB( 'all_questions', 'category_id', $categoryId, '', '', 0 );
			$fields = array(
				'id' => array(
					'type' => 'int',
					'auto_increment' => TRUE
				),
				'userid' => array(
					'type' => 'int',
				),
				'course_id' => array(
					'type' => 'int',
				),
				'total' => array(
					'type' => 'int',
				),
				'certOk' => array(
					'type' => 'int',
				),
				'counted' => array(
					'type' => 'int',
				),
				'permission' => array(
					'type' => 'int',
				),
				'todate TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
			);
			$this->dbforge->add_key('id', TRUE); 

			$this->dbforge->add_column($fields);
			//$this->dbforge->create_table('survey');

			foreach($arr->result_array() as $value){
				$pangalan = $value['id']."_id";
				if(!$value['type']){
					$fields2 = array(
	                        $pangalan => array('type' => 'int')
					);
				}else{
					$fields2 = array(
	                        $pangalan => array(
	                        	'type' => 'VARCHAR',
                                'constraint' => '255',
                            )
					);
				}
				$this->dbforge->add_column('survey', $fields2);
			}
			//$fields = array('preferences' => array('type' => 'TEXT'));
		}else{
			//$this->dbforge->drop_table('origsurvey');
			$this->delQuestions($categoryId, $belong);
			$arr = $this->participantuser_model->getDB( 'all_questions', 'category_id', $categoryId, '', '', 0 );
			$fields = array(
				'id' => array(
					'type' => 'int',
					'auto_increment' => TRUE
				),
				'userid' => array(
					'type' => 'int',
				),
				'course_id' => array(
					'type' => 'int',
				),
				'todate TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
			);
			$this->dbforge->add_key('id', TRUE);

			$this->dbforge->add_column($fields);
			//$this->dbforge->create_table('origsurvey');

			foreach($arr->result_array() as $value){
				$pangalan = $value['id']."_id";
				if(!$value['type']){
					$fields2 = array(
	                        $pangalan => array('type' => 'int')
					);
				}else{
					$fields2 = array(
	                        $pangalan => array(
	                        	'type' => 'VARCHAR',
                                'constraint' => '255',
                            )
					);
				}
				$this->dbforge->add_column('origsurvey', $fields2);
			}
		}
	}

	public function updateOldCourses($date1, $userid){
		
		$query = $this->db->get_where('signature');
		$array = $query->result_array();
		
		foreach( $array as $row ){
			if( $row['startdate'] > $row['enddate'] ){
				for( $i = 1; $i <= 2; $i++ ){
					if( $i == 2 ) $name = 'photo_id2';
					else $name = 'photo_id';
					$queryPic = $this->db->get_where('picture', array('id' => $row[$name]) );
					$arrayPic = $queryPic->result_array();
					
					foreach( $arrayPic as $err ){
						$my_file = $_SERVER['DOCUMENT_ROOT']."/upload/".$err['name'];
						unlink($my_file);
					}	
				}
				$data = array( 'photo_id' => $row['photo_id'] );
				$this->db->delete( 'signature', $data );
				
				$data = array( 'id' => $row['photo_id'] );
				$this->db->delete( 'picture', $data );

				if( $row['photo_id2'] ){
					$data = array( 'id' => $row['photo_id2'] );
					$this->db->delete( 'picture', $data );
				}
			}
		}
	}
	
	public function courseGet( $num, $temp = 0 ){
		if( !$temp ) $query = $this->db->get_where('courses', array('id' => $num ) );
		else $query = $this->db->get_where('courses', array('tempId' => $num ) );
		$array = $query->result_array();
		return $array;
	}

	public function calculateTotal( $num ){
		$arr = $this->db->get_where('survey', array('counted' => $num));
		return $arr;
	}

	public function getSurvey( $search ){	
		$select = "DISTINCT C.id AS course_id, C.name, C.description, C.venue, C.cost";
		$from = "courses C";		
		$where = "(C.name LIKE '%$search%' OR C.description LIKE '%$search%' OR C.venue = '%$search%' OR C.cost = '%$search%' )";
		
		//$this->db->select($select);
		$this->db->from($from);
		$this->db->where($where);
		
		$query = $this->db->get();
		return $query;
	}

	public function completed_course(){
		date_default_timezone_set("Asia/Manila");
		$today = date('Y-m-d');	

		$this->db->where('courses.end <', $today);  //moved the >
		$sql = $this->db->get( 'courses' );
		return $sql;
	}

	public function getAvgByUser($table, $name, $course_id, $user_id){
		$this->db->select($name);    	
		$this->db->where('course_id',$course_id);
		$this->db->where('userid',$user_id);
		$sql = $this->db->get($table);

    	//$sql = $this->db->get();
    	return $sql->result_array();
	}

	public function addCategories(){
		$questions = $_POST['Cat'];
		$belong = $_POST['belong'];
		foreach($questions as $question){
			if($question != NULL){
				$this->db->set('title', $question);
				$this->db->set('belong', $belong);
				$this->db->insert('categories_questions');	
			}
		}
	}

	public function editCategories(){
		$title = $this->input->post('editTitle');
		$id = $this->input->post('id_tit');

		$data = array(
			'title' => $title
		);
		$this->db->where('id', $id);
		$this->db->update('categories_questions', $data);
	}

	public function delCategory(){
		$this->load->dbforge();
		$belong = $this->input->post('belong_2');
		$id = $this->input->post('id_del');
		$this->delQuestions($id,$belong);
		
		$this->db->where('category_id', $id);
		$this->db->delete('all_questions');

		$this->db->where('id', $id);
		$this->db->delete('categories_questions');
	}

	public function delQuestions($id, $belong){
		$this->load->dbforge();

		$arr = $this->participantuser_model->getDB('all_questions', 'category_id', $id, '', '', 0 );
		foreach($arr->result_array() as $value){
			$pangalan = $value['id']."_id";
			if(!$belong) $table = 'survey';
			else $table = 'origsurvey';

			if($this->db->field_exists($pangalan, $table)) $this->dbforge->drop_column($table, $pangalan);
			$fields_count = count($this->db->list_fields($table));

			//emptying a table
			if($fields_count==8 || $fields_count==4) $this->db->empty_table($table);
		}
	}

	public function getTemp(){
		$query = $this->db->get('temp_courses');
		return $query->result_array();
	}

	public function addTemp( $countS, $mail, $unique ){	
		$name = $_POST['requested_by'];
		//$mail = $_POST['email'];	
		$CourseName = $_POST['CourseName'];
		$department = $_POST['department'];
		$description = $_POST['description'];
		$start = $_POST['startDate'];
		$startDate = date('Y-m-d', strtotime($start)); //date('y-m-d', strtotime($_POST['startDate']))
		$end = $_POST['endDate'];
		$endDate = date('Y-m-d', strtotime($end)); //date('y-m-d', strtotime($_POST['endDate']))
		$startTime = $_POST['startTime'];
		$startTime = date("H:i:s", strtotime($startTime));
		$endTime = $_POST['endTime'];
		$endTime = date("H:i:s", strtotime($endTime));
		$venue = $_POST['venue'];

		$data = array(
			'name' => $CourseName,
			'email' => $mail,
			'department' => $department,
			'sender' => $name,
			'description' => $description,
			'start' => $startDate,
			'end' => $endDate,
			'startTime' => $startTime,
			'endTime' => $endTime,
			'venue' => $venue,
			'count' => $countS,
			'code' => $unique
		);

		$this->db->insert('temp_courses', $data);
	}

	public function removeRequest( $tempId, $name ){
		$a = array();

		include_once('participantuser_model.php');
		$me = new participantuser_model;

		$forsending = $me->getDB('forsending', 'tempId', $tempId, '', '', 0 );

		$mail = new PHPMailer();  // create a new object
		$mail->IsSMTP(); // enable SMTP
		$mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true;  // authentication enabled
		$mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587; 
		$mail->Username = 'meteor.upitdc@gmail.com';  
		$mail->Password = 'meteor123';  
		$mail->Subject = '[MeTEOR] Automatic Requested-Course Disapproval';
		$mail->SetFrom('noreply@localhost/meteor', 'MeTEOR Notification');
		$a['numS'] = 4;
		$a['kind'] = "Course Disapproval";
		$a['CourseName'] = $name;

		$mail->Body = $this->load->view('pages/sendFile', $a, TRUE);
		$tag = 0;
		foreach ($forsending->result_array() as $key) {
			$users = $me->getDB('users', 'id', $key['user_id'], '', '', 0 );
			$usersArray = $users->result_array();

			$mail->AddAddress($usersArray[0]['username']);
			$tag = 1;
		}

		$mail->IsHTML(true);
		if( $tag && !$mail->Send()) {
			$error = 'Mail error: '.$mail->ErrorInfo; 
			return $error;
		}

		$this->db->delete('forsending', array('tempId' => $tempId));
		$this->db->delete('temp_courses', array('id' => $tempId));
		return '';
	}

	public function get_tempCourses( $num = 0 ){
		/*$sql = "SELECT DISTINCT C.id, C.name, C.description, C.start, C.end, C.cost, C.venue, C.
				FROM courses C, reserved R, payment P, users U
				WHERE C.id = '$id' AND ( ( C.id = R.course_id OR C.id = P.course_id ) 
					AND ( U.id = R.user_id OR U.id = P.user_id) )";
		*/
		$start_date = $_POST['starting'];
		$end_date = $_POST['ending'];
		$dept = $_POST['dept'];
		//echo $dept;
		$temp = strtotime($start_date);
		$var1 = date('Y-m-d', $temp).PHP_EOL;
		//echo $var1."<br/>";
		$temp2 = strtotime($end_date);
		$var2 = date('Y-m-d', $temp2).PHP_EOL;
		//echo $var2;
		$select = "T.id, T.name, T.description, T.start, T.end, T.cost, C.reserved, C.paid, T.venue, C.startTime, C.endTime, T.department, T.facilitator, T.count";
		$from = "courses C, temp_courses T";
		if( !$num ) $where = "(C.tempId = T.id AND T.department = '$dept' ) AND ( (T.start between '$var1' AND '$var2') AND ( T.end between '$var1' AND '$var2' ) )";
		else $where = "(C.tempId = T.id) AND ( (T.start between '$var1' AND '$var2') AND ( T.end between '$var1' AND '$var2' ) )";

		$this->db->select($select);	
		$this->db->from($from);	
		$this->db->where($where);	

		$query = $this->db->get();		
		return $query;
	}
}