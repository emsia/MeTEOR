<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Emailer extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $config = array(
            'hostname' => 'localhost',
            'username' => 'meteor',
            'password' => 'xpF7mBWqMtvJUpt9',
            'database' => 'meteor',
            'dbdriver' => 'mysql',
            'db_debug' => TRUE,
            'char_set' => 'utf8'
        );
        $this->load->database($config);    
        $this->load->model(array('login_model'));
        $this->load->helper('url');
    }

    public function send() {
        if ($this->input->post('email')) {
            $email = $this->input->post('email');
            $this->db->select('slug');
            $query = $this->db->get_where('users', array('username' => $email));
            $result = $query->row_array();
            $this->login_model->sendvalid($result['slug'], $email); 
            echo "Success";           
        }
        else echo "No email!";
        
    }

    public function forgot() {
        if ($this->input->post('email')) {
            $email = $this->input->post('email');
            $this->login_model->forgot($email);
            echo "Success";
        }
        else echo "No email!";
    }
}

?>