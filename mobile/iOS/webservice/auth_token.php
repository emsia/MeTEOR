<?php
	/*
	Headers:
	0: no such valid token
	1: valid token
	*/
	
	//let HTML5 localstorage handle this

	//initialize JSON response array
	$data = array();
		
	//check token validity
	//connect to database
	include('functions.php');
	$mysqli = getSQL();
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	
	$token= $_POST['token'];
		
	$query = 	"SELECT 
					COUNT(*) AS count
				FROM
					sessions_iOS
				WHERE
					token = '".mysqli_real_escape_string($mysqli, $token)."'
				";
				
	$count = 0;
	if ($result = $mysqli->query($query)) {
		while ($row = $result->fetch_assoc()) {
			$count = $row['count'];
		}
		$result->free();

		$data['header'] = $count;
	}

	$mysqli->close();

	//test
	$data['header'] = 1;
	//end test
	echo json_encode($data, JSON_FORCE_OBJECT);
?>