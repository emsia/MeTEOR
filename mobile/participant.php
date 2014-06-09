<?php
	
	$db = mysqli_connect("localhost", "meteor", "xpF7mBWqMtvJUpt9", "meteor");
	$data = array();
	
	//$yes = "SELECT id, verified FROM users WHERE username = '". mysqli_real_escape_string($db, $_POST['username']) ."' 
	//		AND password = sha1(concat('". mysqli_real_escape_string($db, $_POST['password']) ."', salt)) AND role = 2;";
	
	$yes = "SELECT id, verified
			FROM users
			WHERE username = '". mysqli_real_escape_string($db, $_POST['username']) ."' 
			AND password = sha1('". mysqli_real_escape_string($db, $_POST['password']) ."') 
			AND role = 2;";

	$res = mysqli_query($db, $yes);


	//$res = mysqli_query($db, "SELECT id, verified FROM users WHERE username = 'user@email.com' AND password = sha1('password' + salt) AND role = 2;");
	
	$rec = mysqli_fetch_assoc($res);
	if(count($rec) != 0) {
		$hash = sha1(mt_rand());
		$blah = "INSERT INTO sessions (date, user_id, token, expired) VALUES (NOW(), '".$rec['id']."', '" . $hash . "', 0);";
		setcookie("name", $hash);
		$data['verified'] = $rec['verified'];
		$data['success'] = 1;
		mysqli_query($db, $blah);
	}
	else {
		$data['success'] = 0;
		$data['verified'] = 0;
	}
	
	echo json_encode($data);
	
?>
