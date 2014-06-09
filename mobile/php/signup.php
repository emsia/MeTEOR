<?php

	$db = mysqli_connect("meteor.upsitf.org", "meteor", "xpF7mBWqMtvJUpt9", "meteor");
	$data = array();
	/*
	mysqli_query($db, "INSERT INTO users (salt, username, password, firstname, lastname, role, verified) VALUES (
								sha1(rand()),
								'".mysqli_real_escape_string($db, $_POST['username'])."',
								sha1(concat('".mysqli_real_escape_string($db, $_POST['password'])."', salt)),
								'".mysqli_real_escape_string($db, $_POST['firstname'])."',
								'".mysqli_real_escape_string($db, $_POST['lastname'])."',
								2,
								1);");
	*/
	mysqli_query($db, "INSERT INTO users (salt, username, password, firstname, lastname, role, verified) VALUES (
							sha1(rand()),
							'".mysqli_real_escape_string($db, $_POST['username'])."',
							sha1('".mysqli_real_escape_string($db, $_POST['password'])."'),
							'".mysqli_real_escape_string($db, $_POST['firstname'])."',
							'".mysqli_real_escape_string($db, $_POST['lastname'])."',
							2,
							1);");

	echo mysqli_errno($db);
?>
