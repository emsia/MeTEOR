<?php

	$db = mysqli_connect("localhost", "meteor", "xpF7mBWqMtvJUpt9", "meteor");
	
	if (isset($_COOKIE['name'])) {
		$res = mysqli_query($db, "SELECT firstname, lastname, username, number, street, neighborhood, city
								FROM users
								JOIN mobilenumbers
								ON users.id = mobilenumbers.user_id
								JOIN addresses
								ON users.id = addresses.user_id
								WHERE users.id = getuserid('".$_COOKIE['name']."');");
		$data['success'] = 1;
		$rec = mysqli_fetch_assoc($res);
		$data['firstname'] = $rec['firstname'];
		$data['lastname'] = $rec['lastname'];
		$data['username'] = $rec['username'];
		$data['mobilenum']  = $rec['number'];
		$data['street'] = $rec['street'];
		$data['barangay'] = $rec['neighborhood'];
		$data['city'] = $rec['city'];
	} else {
		$data['success'] = 0;
	}

	echo json_encode($data);
	
?>