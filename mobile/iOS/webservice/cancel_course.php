<?php

	//add checking if cookie set
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
	
	$exec = "DELETE FROM 
				reserved
			WHERE 
				user_id = '".mysqli_real_escape_string($mysqli, $user_id)."'
				AND
				course_id = '".mysqli_real_escape_string($mysqli, $_POST['course_id'])."';";
				
	$data['header'] = mysqli_query($mysqli, $exec);

	$mysqli->close();

	echo json_encode($data);
?>