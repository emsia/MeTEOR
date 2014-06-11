<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class participantprofile extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('course_model','profile_model','participantuser_model','login_model'));
		$this->load->library('session');
		$this->load->helper('url');
		
		if($this->islogged() == false){
			redirect("http://localhost/meteor/index.php/pages");
		}
		if(!$this->login_model->isValid($this->session->userdata('username'))){
			redirect("http://localhost/meteor/index.php/pages/invalid");
		}
	}

	public function index($message=NULL,$error=0,$sucess=0)
	{
		$this->load->helper('url');

		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$b = $this->login_model->getAllUsers_not_you($uid['id']);

		$data = $this->getUser();
		foreach($b->result_array() as $res){
			$data['emails'][] = $res['username'];
		}

		$data['pass_code'] = $data['user']['password'];
		$data['last_name'] = $data['user']['lastname'];
		$data['first_name'] = $data['user']['firstname'];
		$data['middle_name'] = $data['user']['middlename'];

		$data['userid'] = $uid['id'];
		$data['username'] = $data['user']['username'];

		$data['collge_hist'] = $this->participantuser_model->college($data['userid']);
		$details = $this->participantuser_model->profileDetails($data['userid']);
		$data['awards_hist'] = $this->participantuser_model->awards($data['userid']);

		$data['count_awards'] = 0;
		foreach( $data['awards_hist'] as $row ){
			$data['award'][] = $row['award'];			
			$data['institutions'][] = $row['institution'];
			$data['dateAwards'][] = $row['dateGive'];
			$data['count_awards']++;
		}

		if(!empty($details)){
			$data['birthplace'] = $details['birthplace'];
			$data['emp'] = $details['employed'];
			$data['birth_year'] = $details['birth_year'];
			$data['birth_month'] = $details['birth_month'];
			$data['birth_date'] = $details['birth_date'];
			$data['gender'] = $details['gender'];
			$data['civil_status'] = $details['civil_status'];
			$data['country_citizen'] = $details['country_citizen'];
		}

		$data['title'] = 'MeTEOR | Profile';
		$data['address'] = 0;
		$data['prov_address'] = 0;
		$data['message'] = $message;
		$data['error'] = $error;
		$data['sucess'] = $sucess;

		foreach( $data['addr'] as $row ){
			$data['province'] = $row['province'];			
			$data['region'] = $row['region'];
			$data['city'] = $row['city'];
			$data['housing_type'] = $row['type'];
			$data['type'] = $row['complete'];
			$data['address'] = 1;
		}

		foreach( $data['prov_addr'] as $row ){
			$data['prov_province'] = $row['province'];			
			$data['prov_region'] = $row['region'];
			$data['prov_city'] = $row['city'];
			$data['prov_housing_type'] = $row['type'];
			$data['country'] = $row['country'];
			$data['prov_address'] = 1;
		}

		$data['count_col'] = 0;
		foreach( $data['collge_hist'] as $row ){
			$data['institute'][] = $row['institution'];
			$data['local'][] = $row['location'];
			$data['deg'][] = $row['degree'];
			$data['from_date'][] = $row['start'];
			$data['to_date'][] = $row['end'];
			$data['count_col']++;
		}

		$data['mobile'] = $this->participantuser_model->profileMobile($data['userid']);
		$data['count_num'] = 0;
		foreach( $data['mobile'] as $row ){
			$data['number'][] = $row['number'];//$this->format_telephone($row['number']);
			$data['count_num']++;
		}

		$data['landline'] = $this->participantuser_model->profileLandline($data['userid']);
		$data['count_numLine'] = 0;
		foreach( $data['landline'] as $row ){
			$data['numberLine'][] = $row['number'];//$this->format_telephone($row['number']);
			$data['count_numLine']++;
		}

		$data['employment'] = $this->participantuser_model->profileEmp($data['userid']);
		$data['count_employ'] = 0;
		foreach( $data['employment'] as $row ){
			$data['company_emp'][] = $row['company'];//$this->format_telephone($row['number']);
			$data['position_emp'][] = $row['designation'];
			$data['industry'][] = $row['industries'];
			$data['start_emp'][] = $row['start'];
			$data['end_emp'][] = $row['end'];
			$data['count_employ']++;
		}

		foreach( $data['emergency'] as $row ){
			$data['full_name'] = $row['name'];
			$data['relationships'] = $row['relationship'];
			$data['mobile_to'] = $row['mobile_number'];
			$data['landline_to'] = $row['landline'];
			$data['email_to'] = $row['email'];
			$data['address_to'] = $row['address'];
		}

		foreach($data['form'] as $row){
			$data['c_unit'] = $row['c_unit'];
			$data['office'] = $row['office'];
			$data['position'] = $row['position'];
		}

		if(!$data['count_awards']) $data['count_awards']++;
		if(!$data['count_col']) $data['count_col']++;
		if(!$data['count_num']) $data['count_num']++;
		if(!$data['count_numLine']) $data['count_numLine']++;
		if(!$data['count_employ']) $data['count_employ']++;

		$data['active_nav'] = 'PROFILE';
		if(!$uid['role']) $this->load->view('templates/indexadmin', $data);
		elseif($uid['role']==1) $this->load->view('templates/indexmanager', $data);
		else $this->load->view('templates/indexparticipant', $data);

		$this->load->view('templates/sidebar_profile', $data);
		if(!$uid['form'] && $uid['role']==2) $this->load->view('participantprofile/index', $data);
		else $this->load->view('participantprofile/shortForm', $data);
		/*if(!$uid['role']) $this->load->view('templates/footeradmin');
		elseif($uid['role']==1) $this->load->view('templates/footerman');
		else $this->load->view('templates/footerparticipant');*/
	}

	public function getUser(){
		$this->load->helper('url');
		
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		
		$data['userid'] = $uid['id'];
		$data['role'] = $uid['role'];
		$data['user'] = $this->participantuser_model->profileInfo($data['userid']);
		$data['addr'] = $this->participantuser_model->profileAddr($data['userid']);
		$data['prov_addr'] = $this->participantuser_model->profileProvAddr($data['userid']);
		$data['emergency'] = $this->participantuser_model->profileEmergency($data['userid']);
		$data['form'] = $this->participantuser_model->profileShort($data['userid']);

		return $data;
	}

	/*
	public function format_telephone($phone_number)
	{
	    $cleaned = preg_replace('/[^[:digit:]]/', '', $phone_number);
	    preg_match('/(\d{3})(\d{3})(\d{5})/', $cleaned, $matches);
	    return "({$matches[1]}) {$matches[2]} {$matches[3]}";
	}
	*/

	function is_default($str)
	{
	  if($str=="-- Choose your Housing Type --") return FALSE;
	  return TRUE;
	}

	function is_notSet($str)
	{
	  if($str==-1) return FALSE;
	  return TRUE;
	}

	function chooseNot($str){
		if($str=='-- Country --') return FALSE;
		return TRUE;
	}

	function is_notNULL($array){
		if(empty($array)) return FALSE;
		return TRUE;
	}

	function is_gender($str){
		if($str=="Select One"){
			return FALSE;
		}
		return TRUE;
	}

	function is_relationship($str){
		if($str=="-- Relationship --") return FALSE;
		return TRUE;
	}

	public function password(){
		$pword = $this->input->post('new_password');
		if($this->session->userdata('change')) $this->session->unset_userdata('change');
		$this->profile_model->changepass($this->session->userdata('username'),$pword);
		$this->index("New Password Saved",0,1);
	}

	function compareDate($str) {

        for($i=0;$i<count($_POST['from']);$i++){
       		$startDate = strtotime($_POST['from'][$i]);
        	$endDate = strtotime($_POST['to'][$i]);
        	if ($endDate < $startDate) return FALSE;
        }
        return TRUE;
    }

	public function updateDetails(){
		$this->load->helper(array('url', 'form'));
		$this->load->library('form_validation');

		$data['title'] = 'MeTEOR | Profile';
		$lists = array('lastName','firstName','middleName','username','employed_s','year_s','month_s','place','day_s','mobileNum[]','countries_s','houseType','region_s','province_s','municipality_s');
		$list2 = array('inst','loc','degree','from','to');
		$list_perm2 = array('region_s2','province_s2','municipality_s2','houseTypeSame');
		$listNotReq = array('awards', 'inst_awards', 'date_awards');
		$listNotReq2 = array('companies','positions', 'industry_s','date_empStart', 'date_empEnd');
		$list_req = array('fullName','relation_to','mobile_other','email_other','address_other');

		if(!empty($_POST['awards'][0]) || !empty($_POST['inst_awards'][0]) || !empty($_POST['date_awards'][0]) ){
			foreach($listNotReq as $list){
				for($i=0;$i<count($_POST['awards']);$i++) $this->form_validation->set_rules($list.'['.$i.']', $list.'['.$i.']', 'xss_clean|required|callback_is_notNULL');
			}
		}

		foreach($list_req as $list){
			if($list=='relation_to') $this->form_validation->set_rules($list, $list, 'trim|xss_clean|required|callback_is_gender');
			elseif($list=='email_other') $this->form_validation->set_rules($list, $list, 'trim|xss_clean|required|valid_email');
			else $this->form_validation->set_rules($list, $list, 'trim|xss_clean|required');
		}

		if(isset($_POST['employed_s']) && ($_POST['employed_s']!=3) ){
			foreach($listNotReq2 as $list){
				if($list=='industry_s' || $list=='positions'){
					for($i=0;$i<count($_POST['industry_s']);$i++){
						$this->form_validation->set_rules($list.'['.$i.']', $list.'['.$i.']', 'required|callback_is_gender');
					}
				}
				else for($i=0;$i<count($_POST['companies']);$i++) $this->form_validation->set_rules($list.'['.$i.']', $list.'['.$i.']', 'xss_clean|required|call_back_is_notNULL');
			}
		}

		$this->form_validation->set_rules('gender', 'gender', 'trim|required|xss_clean|callback_is_gender');
		$this->form_validation->set_rules('relationship', 'relationship', 'trim|required|xss_clean|callback_is_relationship');

		foreach($lists as $list){
			if($list=="username") $this->form_validation->set_rules($list, $list, 'trim|required|valid_email');
			elseif($list=='houseType') $this->form_validation->set_rules($list, $list, 'trim|required|xss_clean|callback_is_default');
			elseif( $list=='year_s' || $list=='countries_s' || $list=='month_s' || $list=='day_s' || $list=='region_s' || $list=='province_s' || $list=='municipality_s') $this->form_validation->set_rules($list, $list, 'trim|required|xss_clean|callback_is_notSet');
			else $this->form_validation->set_rules($list, $list, 'trim|required|xss_clean');
		}
		foreach($list2 as $list){
			for($i=0;$i<count($_POST['inst']);$i++) $this->form_validation->set_rules($list.'['.$i.']', $list.'['.$i.']', 'required|callback_is_notNULL');
		}
		//houseType == -- Choose your Housing Type --
		//region_s = -1
		//province_s = -1
		//municipality_s = -1

		//$err = 0; $err1 = 0;
		//if($_POST['houseType']=="-- Choose your Housing Type --" || $_POST['region_s']==-1 || $_POST['province_s']==-1 || $_POST['municipality_s']==-1) $err = 1;


		if(!isset($_POST['samePresent'])) {
			if($_POST['region_s2']=="Foreign"){
				$this->form_validation->set_rules('foreign_perm', "Foreign Country", 'trim|required|xss_clean|callback_is_notSet');
				$this->form_validation->set_rules('houseTypeSame', 'houseTypeSame', 'trim|required|xss_clean|callback_is_default');
			}
			else{
				foreach($list_perm2 as $list){
					if($list=='houseTypeSame') $this->form_validation->set_rules($list, $list, 'trim|required|xss_clean|callback_is_default');
					elseif($list=='region_s2' || $list=='province_s2' || $list=='municipality_s2') $this->form_validation->set_rules($list, $list, 'trim|required|xss_clean|callback_is_notSet');
					else $this->form_validation->set_rules($list, $list, 'trim|required|xss_clean');
				}
			}
		}

		$uid = $this->login_model->getuid($this->session->userdata('username'));
		if($this->form_validation->run() == FALSE){
			$b = $this->login_model->getAllUsers_not_you($uid['id']);
			$data = $this->getUser();
			foreach($b->result_array() as $res){
				$data['emails'][] = $res['username'];
			}

			$data['pass_code'] = $data['user']['password'];
			$data['username'] = ($_POST['username']!=='')?$_POST['username']:'';
			$data['last_name'] = $_POST['lastName'];
			$data['first_name'] = $_POST['firstName'];
			$data['middle_name'] = $_POST['middleName'];

			$data['gender'] = $_POST['gender'];
			$data['birth_year'] = $_POST['year_s'];
			$data['birth_month'] = $_POST['month_s'];
			$data['birth_date'] = $_POST['day_s'];
			$data['birthplace'] = ($_POST['place']!=='')?$_POST['place']:'';
			$data['country_citizen'] = $_POST['countries_s'];
			$data['civil_status'] = $_POST['relationship'];

			$data['province'] = $_POST['province_s'];			
			$data['region'] = $_POST['region_s'];
			$data['city'] = $_POST['municipality_s'];
			$data['housing_type'] = $_POST['houseType'];
			$data['address'] = 1;
			if(isset($_POST['employed_s'])) $data['emp'] = $_POST['employed_s'];

			if(!isset($_POST['samePresent'])) {		
				$data['prov_region'] = $_POST['region_s2'];
				$data['prov_housing_type'] = $_POST['houseTypeSame'];
				if($_POST['region_s2']=="Foreign") $data['country'] = $_POST['foreign_perm'];
				else{
					$data['prov_city'] = $_POST['municipality_s2'];
					$data['prov_province'] = $_POST['province_s2'];	
				}
				$data['prov_address'] = 1;
			}

			$data['title'] = 'MeTEOR | Profile';

			$data['message'] = " Please fill up the necessary items. Items with red asterisk are required";
			$data['error'] = 1;

			$data['count_num'] = 0;
			foreach( $_POST['mobileNum'] as $row ){
				$data['number'][] = $row;//$this->format_telephone($row);
				$data['count_num']++;
			}

			$data['count_numLine'] = 0;
			foreach ($_POST['landlineNum'] as $row) {
				$data['numberLine'][] = $row;//$this->format_telephone($row);
				$data['count_numLine']++;
			}

			$data['count_col'] = 0;
			for( $i=0;$i<count($_POST['inst']);$i++){
				$data['institute'][] = $_POST['inst'][$i];
				$data['local'][] = $_POST['loc'][$i];
				$data['deg'][] = $_POST['degree'][$i];
				$data['from_date'][] = $_POST['from'][$i];
				$data['to_date'][] = $_POST['to'][$i];
				$data['count_col']++;
			}

			$data['count_employ'] = 0;
			if(isset($_POST['employed_s']) && ($_POST['employed_s']!=3) ){
				for( $i=0;$i<count($_POST['companies']);$i++ ){
					$data['company_emp'][] = $_POST['companies'][$i];//$this->format_telephone($row['number']);
					$data['position_emp'][] = $_POST['positions'][$i];
					$data['start_emp'][] = $_POST['date_empStart'][$i];
					$data['end_emp'][] = $_POST['date_empEnd'][$i];
					$data['industry'][] = $_POST['industry_s'][$i];
					$data['count_employ']++;
				}
			}

			$data['count_awards'] = 0;
			if(!empty($_POST['awards'][0]) || !empty($_POST['inst_awards'][0]) || !empty($_POST['date_awards'][0]) ){
				for( $i=0;$i<count($_POST['awards']);$i++ ){
					$data['award'][] = $_POST['awards'][$i];//$this->format_telephone($row['number']);
					$data['institutions'][] = $_POST['inst_awards'][$i];
					$data['dateAwards'][] = $_POST['date_awards'][$i];
					$data['count_awards']++;
				}
			}

			$data['full_name'] = $_POST['fullName'];
			$data['relationships'] = $_POST['relation_to'];
			$data['mobile_to'] = $_POST['mobile_other'];
			if(isset($_POST['landline_other'])) $data['landline_to'] = $_POST['landline_other'];
			$data['email_to'] = $_POST['email_other'];
			$data['address_to'] = $_POST['address_other'];

			if(!$data['count_employ']) $data['count_employ']++;
			if(!$data['count_awards']) $data['count_awards']++;

			$data['type'] = (isset($_POST['samePresent'])=='')?0:1;

			$data['active_nav'] = 'PROFILE';
			if(!$uid['role']) $this->load->view('templates/indexadmin', $data);
			elseif($uid['role']==1) $this->load->view('templates/indexmanager', $data);
			else $this->load->view('templates/indexparticipant', $data);

			$this->load->view('templates/sidebar_profile', $data);
			$this->load->view('participantprofile/index', $data);
		}
		else
		{	
			//saving part
			$this->participantuser_model->saveAllDetails();
			$this->index(" Details Saved", 0,1);
		}

	}

	public function updateShortForm(){
		$this->participantuser_model->saveShort();
		$this->index(" Details Saved", 0,1);
	}

}

?>