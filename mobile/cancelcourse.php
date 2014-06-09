<?php

	$db = mysqli_connect("localhost", "meteor", "xpF7mBWqMtvJUpt9", "meteor");
	$data = array();
	
	if (isset($_COOKIE['name'])) {
		mysqli_query($db, "DELETE FROM reserved
								WHERE user_id = getuserid('".mysqli_real_escape_string($db, $_COOKIE['name'])."')
								AND course_id = '".mysqli_real_escape_string($db, $_POST['course_id'])."';");
		echo mysqli_errno($db);
	}
	else echo 1;


?>
