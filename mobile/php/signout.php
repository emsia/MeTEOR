<?php

	$db = mysqli_connect("meteor.upsitf.org", "meteor", "xpF7mBWqMtvJUpt9", "meteor");
	$data = array();
	
	if(isset($_COOKIE['name'])) {
		$res = mysqli_query($db, "DELETE FROM sessions
									WHERE token = '".$_COOKIE['name']."';");
		$data['success'] = 1;
	}
	else {
		$data['success'] = 0;
	}

	echo json_encode($data);
	
?>