<?php

	$db = mysqli_connect("meteor.upsitf.org", "meteor", "xpF7mBWqMtvJUpt9", "meteor");
	$data = array();
	
	if (isset($_COOKIE['name'])) {
		mysqli_query($db, "INSERT INTO reserved (user_id, course_id, date) VALUES (
								getuserid('".mysqli_real_escape_string($db, $_COOKIE['name'])."'),
								'".mysqli_real_escape_string($db, $_POST['course_id'])."',
								NOW());");
		echo mysqli_errno($db);
	}
	else echo 1;


?>
