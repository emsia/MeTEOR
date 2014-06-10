<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Surveyform extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('course_model');
		$this->load->library('pagination');
		$this->load->model('participant_model');
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
		
		$letter = $this->uri->segment(3);
		$data['letter'] = substr( $letter, 0 , 1 );
		
		$config = array();
		$config['per_page'] = $this->course_model->record_count();
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0 ;
		
		$data['courses'] = $this->course_model->fetch_courses( $data['letter'], $config['per_page'], $page);
		$data['users'] = $this->course_model->fetch_users( $data['letter'] );
		$data['cancelled'] = $this->course_model->get_cancelledCourses();
		$data['title'] = 'Course';
		
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$data['userid'] = $uid['id'];
		
		$this->load->view('templates/indexadmin', $data);
		$this->load->view('course/index', $data);
		$this->load->view('templates/footeradmin');
		
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
			
		$this->load->view('templates/indexadmin', $data);
		$this->load->view('course/view', $data);
		$this->load->view('templates/footer');
	}
	
	public function search_findTemp($var2){
		$data['search'] = $var2;
	}
		
	public function search_find()
	{
		$data['search'] = $_POST['search'];
		$data['title'] = "Search Results";
		$var = $this->input->post('type');
		$var1 = $this->input->post('search');
		
		if( $var === "USER" )redirect('http://localhost/meteor/index.php/validation/search_results/'.$var1.'');	
		
		$a = array();
		$a['counter']=0;
		
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$data['userid'] = $uid['id'];
		
		$result = $this->course_model->get_results($data, 'courses');

		foreach($result->result() as $row)
		{
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
		
		$this->load->view('templates/indexadmin', $data);
		$this->load->view('course/search_find', $a);
		$this->load->view('templates/footeradmin');
	}
	
	public function search_cancelled(){
		$data['search'] = $_POST['search'];
		$data['title'] = "Search Results";
		$a = array();
		$a['counter']=0;
		
		$result = $this->course_model->get_results($data, 'courses');

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
		
		$this->load->view('templates/indexadmin', $data);
		$this->load->view('course/cancelled_find', $a);
		$this->load->view('templates/footeradmin');
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
		$data['title'] = 'Cancelled Course';	
		
		$this->load->helper('url');
		
		$this->load->view('templates/indexadmin', $data);
		$this->load->view('course/cancelled', $data);
		$this->load->view('templates/footeradmin');
	}
	
	public function seeCancelled( $num ){		
		$data['title'] = 'Refund List';
		$this->load->helper('url');
		$uid = $this->login_model->getuid($this->session->userdata('username'));
		$data['userid'] = $uid['id'];
		
		$data['id'] = $num;
		
		$results = $this->course_model->fetch_cancelled( $num );
		$data['users'] = $results->result_array();
						
		$this->load->view('templates/indexadmin', $data);
		$this->load->view('course/participants1', $data);
		$this->load->view('templates/footeradmin');
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
			$data['courses'] = $this->course_model->fetch_courses( $data['letter'], $config['per_page'], $page);
			$data['title'] = 'Course';
			
			$this->load->view('templates/indexadmin', $data);
			$this->load->view('course/index', $data);
			$this->load->view('templates/footeradmin');
			
		}
		else{
			$data['title'] = 'Participants in a Course';
			$this->load->helper('url');
			
			$data['id'] = $num;
			$a = array();
			
			$results = $this->course_model->fetch_users_reservedCashBank( $data['id'] );
			$data['users'] = $results->result_array();			
		
			$this->load->view('templates/indexadmin', $data);
			$this->load->view('course/participants', $data);
			$this->load->view('templates/footeradmin');
		}	
	}
	
	public function add()
	{		  
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$data['title'] = 'Add Course';	
			
			$this->form_validation->set_rules('name[]', 'Name', 'required');
			$this->form_validation->set_rules('start[]', 'Start', 'required');
			$this->form_validation->set_rules('end[]', 'End', 'required');
			$this->form_validation->set_rules('venue[]', 'Venue', 'required');
			$this->form_validation->set_rules('cost[]', 'Cost', 'required|is_natural');
			$this->form_validation->set_rules('available[]', 'Available', 'required|is_natural');		
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('templates/indexadmin', $data);	
				$this->load->view('course/add');
				$this->load->view('templates/footeradmin');
			}
			else
			{
				$data['title'] = "Success";
				$this->course_model->set_courses();
				$this->load->view('templates/indexadmin', $data);
				$this->load->view('course/success');
				$this->load->view('templates/footeradmin');
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
			$this->load->view('templates/indexadmin', $data);	
			$this->load->view('course/index');
			$this->load->view('templates/footeradmin');
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
		$data['courses'] = $this->course_model->get_courses();
		$data['cancelled'] = $this->course_model->get_cancelledCourses();
			
		$this->load->helper(array('form', 'url'));
		$data['title'] = 'Cancelled Courses';
			
		$this->load->view('templates/indexadmin', $data);	
		$this->load->view('course/cancelled');
		$this->load->view('templates/footeradmin');		
	}
}