<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class managers extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('manager_model');
		$this->load->model('login_model');
		$this->load->library('session');
		$this->load->helper('url');
		
		if($this->islogged() == false){
			redirect("http://localhost/meteor/csu/index.php/pages");
		}
		if(!$this->login_model->isValid($this->session->userdata('username'))){
			redirect("http://localhost/meteor/csu/index.php/pages/invalid");
		}
	}

	public function index( $error=0, $message='' )
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

		$r = $me->listCourseUsers3();
		$a = array();
		$a['array'] = $r['array'];
		$a['count_All'] = $r['count'];
		
		$b = $this->login_model->getAllUsers();
		foreach($b->result_array() as $res){
			$a['emails'][] = $res['username'];
		}

		$a['title'] = 'MeTEOR | Managers';
		$a = $this->managers($a);
		$a['error'] = $error;
		$a['message'] = $message;

		$this->load->helper('url');
		$a['active_nav'] = 'VIEW';

		$this->load->view('templates/indexadmin', $a);
		$this->load->view('templates/sidebar_man', $a);
		$this->load->view('managers/index', $a);
		//$this->load->view('templates/footeradmin');
	}

	public function delete(){
		$user_id = $_POST['id'];
		$this->db->where('user_id', $user_id);
		$this->db->delete('managers');

		$this->db->where('id', $user_id);
		$this->db->delete('users');

		$this->index(1,'Manager Successfully deleted.');
		return;
	}

	public function search_results() 
	{
		include_once('course_temp.php');
		$me = new course_temp;

		$r = $me->listCourseUsers3();
		$a = array();
		$a['array'] = $r['array'];
		$a['count_All'] = $r['count'];
		
		$a['title'] = 'MeTEOR | Managers';
		if( !isset($_POST['search']) ) {
			redirect('http://localhost/meteor/index.php/managers');
			return;
		}	
		$data['search'] = $_POST['search'];
		
		$a['counter'] = 0;
		
		//$a = $this->managers($a);
		$result = $this->manager_model->get_results($data);
		
		foreach($result->result() as $row)
		{
			$a['id'][] = $row->user_id;
			$a['username'][] = $row->username;
			$a['firstname'][] = $row->firstname;
			$a['lastname'][] = $row->lastname;			
			$a['status'][] = $row->status;
			$a['role'][] = $row->role;
			$a['counter']++;
		}
		
		$b = $this->login_model->getAllUsers();
		foreach($b->result_array() as $res){
			$a['emails'][] = $res['username'];
		}
		
		$a['active_nav'] = 'VIEW';
		$a['search'] = 1;
		$this->load->view('templates/indexadmin', $a);
		$this->load->view('templates/sidebar_man', $a);
		$this->load->view('managers/index', $a);
		//$this->load->view('templates/footer');
			
	}
	
	public function create()
	{
		 
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$data['title'] = 'MeTEOR | Add Manager';
		$data['managers'] = $this->manager_model->get_managers();		
		
		$this->load->helper('url');
		$config = array(
			array(
				'field'   => 'firstname', 
                'label'   => 'First name', 
                'rules'   => 'required'
            ),
            array(
				'field'   => 'lastname', 
				'label'   => 'Last name', 
				'rules'   => 'required'
            ),
            array(
				'field'   => 'email', 
				'label'   => 'Email', 
				'rules'   => 'required|valid_email|is_unique[users.username]'
            ),
			array(
				'field'   => 'password', 
				'label'   => 'Password', 
				'rules'   => 'required|min_length[6]'
            )
        );
		$this->form_validation->set_rules($config);

		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('templates/indexadmin', $data);	
			$this->load->view('managers/create');
			$this->load->view('templates/footeradmin');
			
		}
		else
		{
			$error = $this->manager_model->set_managers();
			if( !empty($error) ) { 
				$this->index($error);
				return;
			}	
			$this->index();
		}	
	}
	
	public function status()
	{
		$this->manager_model->set_managerstatus();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$a = array();
		 
		$a['title'] = 'MeTEOR | Manager Status';
		$a = $this->managers($a);
		
		$b = $this->login_model->getAllUsers();
		foreach($b->result_array() as $res){
			$a['emails'][] = $res['username'];
		}

		$this->load->helper('url');				
		
		$a['active_nav'] = 'VIEW';
		$this->load->view('templates/indexadmin', $a);	
		$this->load->view('templates/sidebar_man', $a);	
		$this->load->view('managers/index', $a);
		//$this->load->view('templates/footeradmin');
	}
	
	public function promote()
	{
		$this->manager_model->set_managerpromotion(); 
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$a['title'] = 'MeTEOR | Manager Status';
		$a = $this->managers($a);
		
		$b = $this->login_model->getAllUsers();
		foreach($b->result_array() as $res){
			$a['emails'][] = $res['username'];
		}
		
		$this->load->helper('url');
		$a['active_nav'] = 'VIEW';
		$this->load->view('templates/indexadmin', $a);	
		$this->load->view('templates/sidebar_man', $a);	
		$this->load->view('managers/index', $a);
		//$this->load->view('templates/footeradmin');
	}
	
	public function managers( $a ){
		$managers = $this->manager_model->get_managers();		
			
		$a['counter'] = 0;
		$managerLists = array();
			
		foreach( $managers->result() as $row ){
			$managerLists = $this->manager_model->get_managerLists($row->id);
			foreach( $managerLists as $value ){
				$a['role'][] = $row->role;
				$a['id'][] = $value['user_id'];
				$a['lastname'][] = $row->lastname;
				$a['firstname'][] = $row->firstname;
				$a['username'][] = $row->username;
				$a['status'][] = $value['status'];
				$a['counter']++;
			}
		}
		
		return $a;
	}
}