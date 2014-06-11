<?php

	$db = mysqli_connect("meteor.upsitf.org", "meteor", "xpF7mBWqMtvJUpt9", "meteor");
	
	if (isset($_COOKIE['name'])) {
		$res = mysqli_query($db, "SELECT firstname, lastname, username
								FROM users
								WHERE id = getuserid('".$_COOKIE['name']."');");
		$data['success'] = 1;
		$rec = mysqli_fetch_assoc($res);
		$data['firstname'] = $rec['firstname'];
		$data['lastname'] = $rec['lastname'];
		$data['username'] = $rec['username'];
	} else {
		$data['success'] = 0;
	}

	echo json_encode($data);
	
?>