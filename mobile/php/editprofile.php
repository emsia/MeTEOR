<?php

	$db = mysqli_connect("meteor.upsitf.org", "meteor", "xpF7mBWqMtvJUpt9", "meteor");

	if (isset($_COOKIE['name'])) {

		mysqli_query($db, "UPDATE users
							SET firstname = '" .$_POST['firstname']. "',
							lastname = '" .$_POST['lastname']. "'
							WHERE id = getuserid('" .$_COOKIE['name']. "');");

		echo mysqli_errno($db);
	
	} else echo 1;

?>
