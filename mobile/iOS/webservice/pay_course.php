<?php


	include('functions.php');
	$mysqli = getSQL();					  

	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}

	$token = $_POST['token'];
	$data = array();
	
	//get user id from token		
	$query = 	"SELECT 
					a.user_id
				FROM
					sessions_ios AS a
				WHERE
					a.token = '".$token."'
					";

	if ($result = $mysqli->query($query)) {
		while ($row = $result->fetch_assoc()) {
			$user_id = $row['user_id'];
		}
	}
	//
	
	date_default_timezone_set('Asia/Manila');
	$date = date('Y-m-d h:i:s a', time());	


	
	$exec_delete = 
		"
			DELETE FROM
				reserved
			WHERE
				user_id = '".mysqli_real_escape_string($mysqli, $user_id)."'
				AND
				course_id = '".mysqli_real_escape_string($mysqli, $_POST['course_id'])."';
		";
	
	$exec_insert = "INSERT INTO 
						payment
					(user_id, course_id, date, remarks, amount, ornumber)
					VALUES 
						('".mysqli_real_escape_string($mysqli, $user_id)."',
						'".mysqli_real_escape_string($mysqli, $_POST['course_id'])."',
						'".mysqli_real_escape_string($mysqli, $date)."',
						'".mysqli_real_escape_string($mysqli, $_POST['remarks'])."',
						'".mysqli_real_escape_string($mysqli, $_POST['amount'])."',
						'".mysqli_real_escape_string($mysqli, $_POST['or_number'])."'
						);";
	try {
		$mysqli->autocommit(FALSE);
		$mysqli->query($exec_delete);
		$mysqli->query($exec_insert);
		$data['result'] = $exec_delete;
		$mysqli->commit();
		$data['header'] = 1;
	} 
	catch (Exception $e) {
		$data['header'] = 0;
		$data['result'] = $e;
	}
				

	$mysqli->close();
	$mysqli->autocommit(TRUE);			
	echo json_encode($data);
?>