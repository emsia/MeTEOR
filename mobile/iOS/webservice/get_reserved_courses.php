<?php

	//add checking if cookie set

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
	
	$query = 	"SELECT 
					a.id,
					a.name,
					a.description,
					a.cost,
					a.start,
					a.available AS slots, 
					(SELECT COUNT(*) FROM reserved AS b WHERE b.course_id=a.id) AS reserved,
					(SELECT COUNT(*) FROM payment AS c WHERE c.course_id=a.id) AS paid
				FROM
					courses AS a,
					reserved AS d
				WHERE
					a.id = d.course_id 
					AND
					d.user_id = '".$user_id."'
					";

	date_default_timezone_set('Asia/Manila');						
	$today = date("Y-m-d");  					
					
	if ($result = $mysqli->query($query)) {
		while ($row = $result->fetch_assoc()) {
			//show only future courses
			// if($row['start']>$today)
				array_push($data['courses'], $row);
		}
		$data['success'] = 1;
		$result->free();
	}

	$mysqli->close();

	echo json_encode($data);
?>