<?php


	include('functions.php'); 
	$mysqli = getSQL();					  

	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}

	//initialize JSON result array
	$data = array();
	$data['courses'] = array();
	
	//get user id from token		
	$token = $_POST['token'];
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
		
	//order by???
	$query = 	"SELECT 
					a.*,
					(SELECT COUNT(*) FROM reserved AS b WHERE b.course_id=a.id) AS reserved,
					(SELECT COUNT(*) FROM payment AS c WHERE c.course_id=a.id) AS paid,
					(SELECT COUNT(*) FROM reserved AS b WHERE b.course_id=a.id AND b.user_id = '".$user_id."') AS user_reserved,
					(SELECT COUNT(*) FROM payment AS c WHERE c.course_id=a.id AND c.user_id = '".$user_id."') AS user_paid
				FROM
					courses AS a
				WHERE
					a.id = '".$_POST['course_id']."'
					";

	$isPaid = FALSE;
	if ($result = $mysqli->query($query)) {
		while ($row = $result->fetch_assoc()) {
			$isPaid = ($row['user_paid']==1) ? TRUE : FALSE;
			array_push($data['courses'], $row);
		}
		$data['success'] = 1;
		$result->free();
	}

	if($isPaid){
		$data['payment_info'] = array();
		$query = 	"SELECT 
						a.*
					FROM
						payment AS a
					WHERE
						a.course_id = '".$_POST['course_id']."'
						AND
						a.user_id = '".$user_id."'
					";	
		if ($result = $mysqli->query($query)) {
			while ($row = $result->fetch_assoc()) {
				array_push($data['payment_info'], $row);
			}
			$result->free();
		}
	}
	
	$mysqli->close();

	echo json_encode($data);
?>