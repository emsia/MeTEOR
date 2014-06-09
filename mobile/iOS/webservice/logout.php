<?php
	/*
	Headers:
	0: user not logged in
	1: logout success
	*/
	
	//initialize JSON result array
	$data = array();	
	//connect to database
	include('functions.php');
	$mysqli = getSQL();
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}

	$token = $_POST['session_ID'];
	// $token = "6f649623d99bfafc0e121e3c46d72922276a3aff";	
	
	//delete session
	$exec = "DELETE FROM 
				sessions_ios
			WHERE
				token = '".$token."';";
	mysqli_query($mysqli, $exec);

	$data['header'] = 1;

	$mysqli->close();


	echo json_encode($data);		
?>