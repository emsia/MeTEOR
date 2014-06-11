<?php
	//echo "Before insert";
	
	$db = mysqli_connect("localhost", "meteor", "xpF7mBWqMtvJUpt9", "meteor");
	$data = array();

	//echo "Inserting";

	mysqli_query($db, "INSERT INTO users (slug, username, password, firstname, lastname, role, verified) VALUES (
							sha1(rand()),
							'".mysqli_real_escape_string($db, $_POST['username'])."',
							sha1('".mysqli_real_escape_string($db, $_POST['password'])."'),
							'".mysqli_real_escape_string($db, $_POST['firstname'])."',
							'".mysqli_real_escape_string($db, $_POST['lastname'])."',
							2,
							0);");

	//echo mysqli_errno($db);

	$id = mysqli_insert_id($db);
	
	if (mysqli_errno($db) == 0) {
		//echo "Successful insert ";
		
		mysqli_query($db, "INSERT INTO mobilenumbers (user_id, number) VALUES (
								'".mysqli_real_escape_string($db, $id)."',
								'".mysqli_real_escape_string($db, $_POST['mobilenum'])."');");
		
		mysqli_query($db, "INSERT INTO addresses (user_id, street, neighborhood, city) VALUES (
								 	'".mysqli_real_escape_string($db, $id)."',
								 	'".mysqli_real_escape_string($db, $_POST['street'])."',
								 	'".mysqli_real_escape_string($db, $_POST['barangay'])."',
								 	'".mysqli_real_escape_string($db, $_POST['city'])."');");
		
		echo mysqli_errno($db);
		
	}
	else {
		echo mysqli_errno($db);
	}
	
?>