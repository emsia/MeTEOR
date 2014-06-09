<?php
class participantuser_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function reservedCourse()
	{
		$this->load->helper('url');
		
		$query = $this->db->get_where('courses', array('id' => $_POST['course_id']));
		$data = $query->row_array();
		
		include_once('login_model.php');
		$me = new login_model;

		$a = $me->counting( 'course_id', 'reserved', $_POST['course_id'] );
		$b = $me->counting( 'course_id', 'payment', $_POST['course_id'] );

		$c = $a + $b;
		if( $c+1 > $data['available'] ){ 
			print "<script type=\"text/javascript\">alert('No More Available Slot.');</script>";
			return 0;	
		}
		else $a++;
		
		$data1 = array(
           'reserved' => $a
        );

		$this->db->where('id' , $_POST['course_id']);
		$this->db->update('courses', $data1);
		
		
		$this->db->set('user_id',  $_POST['user_id']); 
		$this->db->set('course_id', $_POST['course_id']); 
		$this->db->set('date', $_POST['date']); 
		$this->db->insert('reserved');	
		
		return 1;
	}
	
	public function getInfo($name){
		$items = "";
	//	echo $name;
		if(!empty($_POST['check'])){
			//echo "fsdfsd".$_POST['info']."true";
			foreach($_POST['check'] as $item){
				$items = $_POST['rrr'][$item];
				echo $items;
			}
		}
		return $items;
	}

	public function getReports(){
		$select =  'DISTINCT(U.lastname), U.firstname, U.middlename, A.region, A.city, C.institution AS school, employment_history.industries, employment_history.designation, D.age';
		$from = 'details D, college_history C, addresses A, users U';
		$table = 'employment_history';
		//join($table, $cond, $type = '')
		$cond = 'employment_history.user_id = U.id';
		$where = '(( A.user_id = U.id AND D.user_id = U.id ) AND ( C.user_id = U.id )) AND U.role = 2';
		$order_by = 'U.lastname ASC';

		$this->db->select($select);
		$this->db->from($from);
		$this->db->join($table, $cond, 'LEFT');
		$this->db->where($where)->order_by($order_by);

		$query = $this->db->get();

		return $query;
	}

	public function addPartSurvey( $uid ){
		$course_id = $_POST['course_id'];
		$arr = $this->participantuser_model->getDB( 'all_questions', 'belong', '1', '', '', 0 );

		$data = array(
			'userid' 	=> $uid,
			'course_id' => $course_id,			
		);

		foreach($arr->result_array() as $key) :
			$pangalan = $key['id']."_id";
			$info = array($pangalan=>htmlentities($_POST[$pangalan]),);
			$data = array_merge($data, $info);
		endforeach;

		//var_dump($data)."<br/>";
		
		//getDB( $db, $col1, $col1Value, $col2, $col2Value, $num ){
		$exsists = $this->getDB('origsurvey', 'course_id', $course_id, 'userid', $uid, 1);
		$ex = $exsists->row_array();

		if( empty($ex['id']) )
			$this->db->insert('origsurvey', $data);
	}
	
	public function addPart( $uid ){
		$course_id = $_POST['course_id'];

		$arr = $this->participantuser_model->getDB( 'all_questions', 'belong', '0', '', '', 0 );
		$data = array(
			'userid' 		=> $uid,
			'course_id' 	=> $course_id,
		);

		foreach($arr->result_array() as $key) :
			$pangalan = $key['id']."_id";
			$info = array($pangalan=>htmlentities($_POST[$pangalan]),);
			$data = array_merge($data, $info);
		endforeach;

		$exsists = $this->getDB('survey', 'course_id', $course_id, 'userid', $uid, 1);
		$ex = $exsists->row_array();
		
		if( empty($ex['id']) )
			$this->db->insert('survey', $data);
	}
	
	public function getDB( $db, $col1, $col1Value, $col2, $col2Value, $num ){
		if($num) $query = $this->db->order_by('id', 'ASC')->get_where( $db, array($col1 => $col1Value, $col2 => $col2Value ) );
		else{
			$query = $this->db->order_by('id', 'ASC')->get_where( $db, array($col1 => $col1Value ) );
		}
		return $query;
	}
	
	public function getCount($table, $column_name, $key){
		//$select = "COUNT(*)";
		//$this->db->select( $select );

		$sql = "SELECT COUNT(*) as numrows FROM $table WHERE role = 2 AND $column_name = '".$key."'";	
		$query = $this->db->query($sql);

		//$query = $this->db->get_where($table, array($column_name => $key,'role'=>2) );
		return $query->result_array();
	}

	public function selectDistinct($table,$column){
		$select = "DISTINCT($column)";
		$from = "$table";
		$where = "role = 2";

		$this->db->select( $select );
		$this->db->from( $from );
		$this->db->where( $where );
		$this->db->order_by( $column );

		$query = $this->db->get();
		return $query;
	}

	public function getCan( $ask, $ask2 ){
		$select = "U.username, U.firstname, U.lastname, U.id";
		$from = "cancelled Ca, courses C, users U";
		$where = "U.id = $ask AND Ca.user_id = $ask AND Ca.course_id = $ask2";
		
		$this->db->select( $select );
		$this->db->from( $from );
		$this->db->where( $where );
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function unreservedCourse()
	{
		$this->load->helper('url');
		
		
		$this->db->delete('reserved', array('user_id'=>  $_POST['user_id'], 'course_id' => $_POST['course_id'])); 
		
		$query = $this->db->get_where('courses', array('id' => $_POST['course_id']));
		$data = $query->row_array();
		
		include_once('login_model.php');
		$me = new login_model;

		$a = $me->counting( 'course_id', 'reserved', $_POST['course_id'] );
		if( $a-1 < 0  ) $a = 0;
		else $a--;
		
		$data1 = array(
           'reserved' => $a
        );

		$this->db->where('id', $_POST['course_id']);
		$this->db->update('courses', $data1);
	}
	
	public function profileInfo( $userid )
	{
		$query = $this->db->get_where('users', array('id' => $userid ));
		return $query->row_array();			
	}
	
	public function profileDetails( $userid )
	{
		$query = $this->db->get_where('details', array('user_id' => $userid ));
		return $query->row_array();			
	}

	public function profileProvAddr( $userid )
	{
		$query = $this->db->get_where('provincial_addresses', array('user_id' => $userid ));
		return $query->result_array();			
	}

	public function profileAddr( $userid )
	{
		$query = $this->db->get_where('addresses', array('user_id' => $userid ));
		return $query->result_array();			
	}
	
	public function profileMobile( $userid )
	{	
		$query = $this->db->get_where('mobilenumbers', array('user_id' => $userid ));
		return $query->result_array();			
	}
	
	public function profileLandline($userid){
		$query = $this->db->get_where('landline', array('user_id' => $userid ));
		return $query->result_array();	
	}

	public function profileEmp($userid){
		$query = $this->db->get_where('employment_history', array('user_id' => $userid ));
		return $query->result_array();	
	}

	public function profileEmergency($userid){
		$query = $this->db->get_where('contact_emergency', array('user_id' => $userid ));
		return $query->result_array();
	}

	public function profileShort($userid){
		$query = $this->db->get_where('shortForm_all', array('user_id' => $userid ));
		return $query->result_array();
	}

	public function college($userid)
	{
		$query = $this->db->get_where('college_history', array('user_id' => $userid ));
		return $query->result_array();	
	}

	public function awards($userid)
	{
		$query = $this->db->get_where('awards', array('user_id' => $userid ));
		return $query->result_array();	
	}

	public function reservesCourse( $id, $Cid){
		$query = $this->db->get_where( 'reserved', array('user_id' => $id, 'course_id' => $Cid ) );
		return $query;
	}

	private function log($uname, $role){
		$this->session->set_userdata('logged',true);
		$this->session->set_userdata('username',$uname);
		$this->session->set_userdata('role', $role);
	}
	
	public function saveAllDetails(){
		$uid1 = $this->login_model->getuid($this->session->userdata('username'));
		$this->log($_POST['username'], $uid1['role']);
		$uid = $uid1['id'];

		$data = array( 'username' => $_POST['username'], 'lastname' => ucwords(strtolower($_POST['lastName'])), 'firstname' => ucwords(strtolower($_POST['firstName'])), 'middlename' => ucwords(strtolower($_POST['middleName'])) );
		$this->db->where('id', $uid);
		$this->db->update('users', $data);


		//check details table if user already exists
		$query = $this->db->get_where( 'details', array('user_id' => $uid) );
		$ans = $query->row_array();
		
		//compute birthday
		$dateToday = strtotime(date("M-d"));
		$year = date('Y');
		$birthdate = strtotime(substr($_POST['month_s'],0,3)."-".$_POST['day_s']);
		$age = $year-$_POST['year_s'];
		if($dateToday < $birthdate) $age--;

		$data = array(
			'gender' => $_POST['gender'],
			'birthplace' => ucwords(strtolower($_POST['place'])),
			'country_citizen' => $_POST['countries_s'],
			'civil_status' => $_POST['relationship'],
			'birth_year' => $_POST['year_s'],
			'birth_month' => $_POST['month_s'],
			'birth_date' => $_POST['day_s'],
			'employed' => $_POST['employed_s'],
			'age' => $age,
			'role' => $uid1['role'],
			'user_id' => $uid,
		);

		if( empty($ans['id']) ){
			$this->db->insert( 'details', $data );
		}
		else{
			$this->db->where('user_id', $uid);
			$this->db->update('details', $data);
		}

		//delete existence of user in mobilenumbers table
		if(isset($_POST['mobileNum'])){
			$this->db->where('user_id', $uid);
			$this->db->delete('mobilenumbers');

			foreach($_POST['mobileNum'] as $row){
				$data = array(
					'user_id' => $uid,
					'number' => $row,
				);
				$this->db->insert( 'mobilenumbers', $data );
			}
		}	

		//delete existence of user in landline table
		if(isset($_POST['landlineNum'])){
			$this->db->where('user_id', $uid);
			$this->db->delete('landline');

			foreach($_POST['landlineNum'] as $row){
				$data = array(
					'user_id' => $uid,
					'number' => $row,
				);
				$this->db->insert( 'landline', $data );
			}
		}

		//check existence of user in addresses table
		$query = $this->db->get_where('addresses', array('user_id' => $uid) );
		$ans = $query->row_array();
		
		$same = (isset($_POST['samePresent'])=='')?0:1;
		$data = array(
			'type' => $_POST['houseType'],
			'region' => $_POST['region_s'],
			'province' => $_POST['province_s'],
			'city' => $_POST['municipality_s'],
			'complete' => $same,
			'role' => $uid1['role'],
			'user_id' => $uid,
		);

		if( empty($ans['id']) ){
			$this->db->insert( 'addresses', $data );
		}else{
			$this->db->where('user_id', $uid);
			$this->db->update('addresses', $data);
		}

		//check the existence of user in provincial_addresses
		if(!isset($_POST['samePresent'])) {
			$query = $this->db->get_where('provincial_addresses', array('user_id' => $uid) );
			$ans = $query->row_array();
			
			if($_POST['region_s2']!=="Foreign"){
				$province = $_POST['province_s2'];
				$city = $_POST['municipality_s2'];
				$foreign = '';
			}else{
				$province = '';
				$city = '';
				$foreign = $_POST['foreign_perm'];
			}

			$data = array(
				'type' => $_POST['houseTypeSame'],
				'region' => $_POST['region_s2'],
				'city' => $city,
				'province' => $province,
				'country' => $foreign,
				'role' => $uid1['role'],
				'user_id' => $uid,
			);

			if( empty($ans['id']) ){
				$this->db->insert( 'provincial_addresses', $data );
			}else{
				$this->db->where('user_id', $uid);
				$this->db->update('provincial_addresses', $data);
			}
		}else{
			$this->db->where('user_id', $uid);
			$this->db->delete('provincial_addresses');
		}

		//check existence of user in college_history table
		$this->db->where('user_id', $uid);
		$this->db->delete('college_history');


		for($i=0;$i<count($_POST['inst']);$i++){
			$data = array(
				'user_id' => $uid,
				'institution' => ucwords(strtolower($_POST['inst'][$i])),
				'location' => ucwords(strtolower($_POST['loc'][$i])),
				'degree' => ucwords($_POST['degree'][$i]),
				'start' => $_POST['from'][$i],
				'role' => $uid1['role'],
				'end' => $_POST['to'][$i],
			);
			$this->db->insert( 'college_history', $data );
		}

		//delete existence of user in employment history
		$this->db->where('user_id', $uid);
		$this->db->delete('employment_history');
		if(isset($_POST['employed_s']) && ($_POST['employed_s']!=3) ){
			for($i=0;$i<count($_POST['companies']);$i++){
				$data = array(
					'user_id' => $uid,
					'company' => ucwords(strtolower($_POST['companies'][$i])),
					'designation' => ucwords(strtolower($_POST['positions'][$i])),
					'industries' => $_POST['industry_s'][$i],
					'role' => $uid1['role'],
					'start' => $_POST['date_empStart'][$i],
					'end' => $_POST['date_empEnd'][$i],
				);
				$this->db->insert( 'employment_history', $data );
			}
		}

		//delete existence of user in awards
		$this->db->where('user_id', $uid);
		$this->db->delete('awards');
		if(!empty($_POST['awards'][0])){
			for($i=0;$i<count($_POST['awards']);$i++){
				$data = array(
					'user_id' => $uid,
					'award' => ucwords(strtolower($_POST['awards'][$i])),
					'institution' => ucwords(strtolower($_POST['inst_awards'][$i])),
					'dateGive' => $_POST['date_awards'][$i],
				);
				$this->db->insert('awards', $data );
			}
		}

		$query = $this->db->get_where('contact_emergency', array('user_id' => $uid) );
		$ans = $query->row_array();
		
		$data = array(
			'relationship' => $_POST['relation_to'],
			'name' => ucwords($_POST['fullName']),
			'mobile_number' => $_POST['mobile_other'],
			'landline' => $_POST['landline_other'],
			'email' => $_POST['email_other'],
			'address' => $_POST['address_other'],
			'user_id' => $uid,
		);

		if( empty($ans['id']) ){
			$this->db->insert( 'contact_emergency', $data );
		}else{
			$this->db->where('user_id', $uid);
			$this->db->update('contact_emergency', $data);
		}

	}

	public function saveShort(){
		$uid1 = $this->login_model->getuid($this->session->userdata('username'));
		$this->log($_POST['username'], $uid1['role']);
		$uid = $uid1['id'];

		$data = array( 'username' => $_POST['username'], 'lastname' => ucwords(strtolower($_POST['lastName'])), 'firstname' => ucwords(strtolower($_POST['firstName'])), 'middlename' => ucwords(strtolower($_POST['middleName'])) );
		$this->db->where('id', $uid);
		$this->db->update('users', $data);

		if(isset($_POST['mobileNum'])){
			$this->db->where('user_id', $uid);
			$this->db->delete('mobilenumbers');

			foreach($_POST['mobileNum'] as $row){
				$data = array(
					'user_id' => $uid,
					'number' => $row,
				);
				$this->db->insert( 'mobilenumbers', $data );
			}
		}	

		//delete existence of user in landline table
		if(isset($_POST['landlineNum'])){
			$this->db->where('user_id', $uid);
			$this->db->delete('landline');

			foreach($_POST['landlineNum'] as $row){
				$data = array(
					'user_id' => $uid,
					'number' => $row,
				);
				$this->db->insert( 'landline', $data );
			}
		}

		$query = $this->db->get_where( 'shortForm_all', array('user_id' => $uid) );
		$ans = $query->row_array();

		$data = array(
			'c_unit' => $_POST['c_unit'],
			'office' => $_POST['office'],
			'position' => $_POST['position'],
			'user_id' => $uid,
		);

		if( empty($ans['id']) ){
			$this->db->insert( 'shortForm_all', $data );
		}
		else{
			$this->db->where('user_id', $uid);
			$this->db->update('shortForm_all', $data);
		}
	}
}

