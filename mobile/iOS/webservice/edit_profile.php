<?php
	include('functions.php'); 
	$mysqli = getSQL();					  

	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}

	//initialize JSON result array
	$data = array();

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

	$exec = "UPDATE 
				users
			SET
				firstname = '".$_POST['firstname']."',
				lastname = '".$_POST['lastname']."'
			WHERE
				id = '".$user_id."'";
	mysqli_query($mysqli, $exec);

	
	$query = 	"SELECT 
					COUNT(*) AS mobile_present
				FROM
					mobilenumbers AS b						
				WHERE
					b.user_id = '".$user_id."'";

	if ($result = $mysqli->query($query)) {
		while ($row = $result->fetch_assoc()) {
			$mobile_present = $row['mobile_present'];
		}
	}
		
	if($mobile_present>0){
		$exec = "UPDATE 
					mobilenumbers 
				SET
					number = '".$_POST['mobile']."'
				WHERE
					user_id = '".$user_id."'";
		mysqli_query($mysqli, $exec);
	}else{
		$exec = "INSERT INTO
					mobilenumbers 
					(user_id,number)
				VALUES
					('".mysqli_real_escape_string($mysqli, $user_id)."',
					'".mysqli_real_escape_string($mysqli, $_POST['mobile'])."')";
		mysqli_query($mysqli, $exec);	
	}

	$query = 	"SELECT 
					COUNT(*) AS address_present
				FROM
					addresses AS b						
				WHERE
					b.user_id = '".$user_id."'";

	if ($result = $mysqli->query($query)) {
		while ($row = $result->fetch_assoc()) {
			$address_present = $row['address_present'];
		}
	}
	
	if($address_present>0){
		$exec = "UPDATE 
					addresses
				SET
					street = '".$_POST['street']."',
					neighborhood = '".$_POST['neighborhood']."',
					city = '".$_POST['city']."'
				WHERE
					user_id = '".$user_id."'";
		mysqli_query($mysqli, $exec);
	}else{
		$exec = "INSERT INTO
					addresses
					(user_id,street,neighborhood,city)
				VALUES
					('".mysqli_real_escape_string($mysqli, $user_id)."',
					'".mysqli_real_escape_string($mysqli, $_POST['street'])."',
					'".mysqli_real_escape_string($mysqli, $_POST['neighborhood'])."',
					'".mysqli_real_escape_string($mysqli, $_POST['city'])."')";
		mysqli_query($mysqli, $exec);
	}	
	
	$data['header'] = 1;
	echo json_encode($data);
?>