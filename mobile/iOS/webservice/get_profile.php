<?php
	//given session token, queries database for users information

	//initialize JSON response array
	$data = array();

	//connect to database
	include('functions.php');
	$mysqli = getSQL();
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}		
	
	$token = $_POST['token'];
	
	//test
	//$token = "7b67d8d7c438f6a05eafdf8ddc6efa8cf9e6c450";
	//end test
	
		
	$query = 	"SELECT 
					a.id, a.firstname, a.lastname, a.username,
					b.number,
					c.street, c.neighborhood, c.city
				FROM
					users AS a
				INNER JOIN 
					sessions_ios AS d ON a.id = d.user_id
				LEFT JOIN 
					mobilenumbers AS b						
				ON
					a.id = b.user_id
				LEFT JOIN 
					addresses AS c
				ON
					a.id = c.user_id
				WHERE
					d.token = '".$token."'
				LIMIT 1";

	if ($result = $mysqli->query($query)) {
		$data['response'] = array();	
		while ($row = $result->fetch_assoc()) {
			$ID = $row['id'];
			array_push($data['response'], $row['firstname']);
			array_push($data['response'], $row['lastname']);
			array_push($data['response'], $row['username']);
			
			array_push($data['response'], $row['number']);
			
			array_push($data['response'], $row['street']);
			array_push($data['response'], $row['neighborhood']);
			array_push($data['response'], $row['city']);					
		}
	}
	$result->free();
	$mysqli->close();
			
	echo json_encode($data, JSON_FORCE_OBJECT);
?>