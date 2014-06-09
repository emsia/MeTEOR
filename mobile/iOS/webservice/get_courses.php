<?php

	//add checking if cookie set

		include('functions.php'); 
		$mysqli = getSQL();					  

	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}

	$token = $_POST['token'];
//	$token = "cce7bf8e814a1b8c044172548a225bb982ca3b36";
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
	
	//initialize JSON result array
	$data = array();
	$data['courses'] = array();
		
	//order by???
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
					courses AS a
				WHERE
					a.id NOT IN (SELECT course_id FROM reserved WHERE user_id = '".$user_id."')
					AND
					a.id NOT IN (SELECT course_id FROM payment WHERE user_id = '".$user_id."')
				";

	date_default_timezone_set('Asia/Manila');						
	$today = date("Y-m-d");  					
					
	if ($result = $mysqli->query($query)) {
		while ($row = $result->fetch_assoc()) {
			if($row['start']>$today)
				array_push($data['courses'], $row);
		}
		$data['success'] = 1;
		$result->free();
	}

	$mysqli->close();

	echo json_encode($data);
?>