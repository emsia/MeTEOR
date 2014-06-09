<?php
class Validation_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_letters($data)
	{
		$search = $data['search'];
		
		$this->db->like('role', 2);
		$this->db->like('firstname', $search, 'both');
		$this->db->like('role', 2);
		$this->db->or_like('lastname', $search, 'after');
		
		$query = $this->db->get('users');
		return $query;		
	}
	
	public function get_results($data)
	{
		$search = $data['search'];
		
		$this->db->like('role', 2);
		$this->db->where('id', $search);
		$this->db->like('role', 2);
		$this->db->or_like('username', $search, 'after');
		$this->db->like('role', 2);
		$this->db->or_like('firstname', $search, 'both');
		$this->db->like('role', 2);
		$this->db->or_like('lastname', $search, 'after');
		
		$query = $this->db->get('users');
		return $query;
	}
	

	public function get_courses($e)
	{		
		$search = $e['id'];
		$this->db->where('id', $search);
		$query = $this->db->get('courses');
		
		return $query;
	}
	
	public function get_mobile($data)
	{	
		$search = $data['search'];
		$select = "M.number";
		$from = "users U, mobilenumbers M";
		$where = "u.id = $search AND u.id = m.user_id";
		
		$this->db->select($select);	
		$this->db->from($from);
		$this->db->where($where);
		
		$query = $this->db->get();
		
		return $query;	
	}
	
	public function get_reserved($param)
	{	
		$search = $param['id'];
		$select = "C.id, C.name, C.description, C.cost, C.start, C.end, C.reserved, C.available, C.paid";
		$from = "courses C, reserved R, users U";
		$where = "U.id = $search AND U.id = R.user_id AND C.id = R.course_id";
		
		$this->db->select($select);	
		$this->db->from($from);
		$this->db->where($where);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_payment($param)
	{
		$search = $param['id'];
		$select = "C.id, C.name, C.description, C.cost, C.start, C.end, C.reserved, C.available, C.paid";
		$from = "courses C, payment P, users U";
		$where = "U.id = $search AND U.id = P.user_id AND C.id = P.course_id";
		
		$this->db->select($select);	
		$this->db->from($from);
		$this->db->where($where);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_refund($param)
	{
		$search = $param['id'];
		$select = "C.course_id";
		$from = "cancelled C";
		$where = "C.user_id = $search AND C.refunded = 1";
		
		$this->db->select($select);	
		$this->db->from($from);
		$this->db->where($where);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function make_payment($data)
	{
		$cbn = $data['cbn'];
		
		if($cbn == 1)
		{
			$this->db->set('user_id', $data['user_id']);
			$this->db->set('course_id', $data['course_id']);
			$this->db->set('ornumber', $data['ornumber']);
			$this->db->set('amount', $data['amount']);		
			$this->db->insert('payment');
		}
		else
		{
			$this->db->set('user_id', $data['user_id']);
			$this->db->set('course_id', $data['course_id']);
			$this->db->set('bankname', $data['bankname']);
			$this->db->set('bankbranch', $data['bankbranch']);
			$this->db->set('transaction_id', $data['transaction_id']);
			$this->db->insert('bankpayment');
		}
		
		$a = $data['reserved'];
		$b = $data['paid'];
		$c = $data['course_id'];
		$a--;
		$b++;
		
		$data = array('reserved' => $a, 'paid' => $b);
		
		$this->db->where('id', $c);
		$this->db->update('courses', $data); 
	}
	
	public function pCash($num,$cid,$uid, $remarks){
		
		$query = $this->db->get_where( 'courses', array('id' => $cid) );
		$row = $query->row_array();
		
		date_default_timezone_set("Asia/Manila");											
		$var1 = date('Y-m-d G:i:s');
		
		if( !empty($remarks) && $remarks == "free" )
			$row['cost'] = 0;
		
		$data = array(
			'ornumber' => $num,
			'course_id' => $cid,
			'remarks' => $remarks,
			'user_id' => $uid,
			'amount' => $row['cost'],
			'date' => $var1
		);
		
		$this->db->insert('payment',$data);
		
		$b = $row['paid'];
		$b++;
		$c = $row['reserved'];
		$c--;
		
		$data = array('paid' => $b, 'reserved' => $c);
		
		$this->db->where('id', $cid);
		$this->db->update('courses', $data); 		
		$this->unreserved( $cid, $uid );
	}
	
	public function pBank($num,$name,$branch,$cid,$uid){
	//transaction id, bank name, bank branch, courseid(s), userid
	//wait lang po sa amount/date
	
		$query = $this->db->get_where( 'courses', array('id' => $cid) );
		$row = $query->row_array();
		
		date_default_timezone_set("Asia/Manila");											
		$var1 = date('Y-m-d G:i:s');
		
		$data = array(
			'transaction_id' => $num,
			'bankname' =>$name,
			'bankbranch' => $branch,
			'course_id' => $cid,
			'user_id' => $uid,
			'date' => $var1
		);		
		$this->db->insert('bankpayment',$data);
		
		$b = $row['paid'];
		$b++;
		
		$data = array('paid' => $b);
		
		$this->db->where('id', $cid);
		$this->db->update('courses', $data); 
		$this->unreserved( $cid, $uid );
	}
	
	public function unreserved( $cid, $uid ){
		$this->db->delete('reserved', array('course_id' => $cid, 'user_id' => $uid));	
	}

	public function removeStudent( $course_id, $user_id, $temp_id ){
		$this->db->delete('payment', array('course_id' => $course_id , 'user_id' => $user_id) );
		$this->db->delete('forsending', array('user_id' => $user_id , 'tempId' => $temp_id) );
	}
}
