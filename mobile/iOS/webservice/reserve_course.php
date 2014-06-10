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


	$query = 	"SELECT 
					a.available,
					(SELECT COUNT(*) FROM reserved AS b WHERE b.course_id=a.id) AS reserved,
					(SELECT COUNT(*) FROM payment AS c WHERE c.course_id=a.id) AS paid
				FROM
					courses AS a
				WHERE
					a.id = '".$_POST['course_id']."'
					";
	
	$exec = "INSERT INTO 
				reserved
				(user_id, course_id, date)
			VALUES 
				('".mysqli_real_escape_string($mysqli, $user_id)."',
				'".mysqli_real_escape_string($mysqli, $_POST['course_id'])."',
				'".mysqli_real_escape_string($mysqli, $date)."'
				);";

	//start transaction
	//check if there is an available slot
	//reserve if there is
	try {
		// First of all, let's begin a transaction
		$mysqli->autocommit(FALSE);
		$hasSlot = false;
		// A set of queries; if one fails, an exception should be thrown
		
		if($result = $mysqli->query($query)) {
			while ($row = $result->fetch_assoc()) {
				//check if there are still available slots
				if(($row['available']-$row['reserved']-$row['paid'])>0){
					$hasSlot = true;
				}
			}
			$result->free();
		}
		
		if($hasSlot){
			$mysqli->query($exec);
			// If we arrive here, it means that no exception was thrown and there are still slots left
			// i.e. no query has failed, and we can commit the transaction
			$mysqli->commit();
			$data['header'] = 1;
		}
		else{
			// no slots left (ie. someone has reserved before you while you were still viewing the course info
			$data['header'] = 0;		
		}

	} 
	catch (Exception $e) {
		$data['header'] = 0;
	}
				

	$mysqli->close();
	$mysqli->autocommit(TRUE);			
	echo json_encode($data);
?>