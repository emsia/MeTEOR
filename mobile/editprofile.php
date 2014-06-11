<?php

	$db = mysqli_connect("localhost", "meteor", "xpF7mBWqMtvJUpt9", "meteor");

	if (isset($_COOKIE['name'])) {

		mysqli_query($db, "UPDATE users
							SET firstname = '" .$_POST['firstname']. "',
							lastname = '" .$_POST['lastname']. "'
							WHERE id = getuserid('" .$_COOKIE['name']. "');");
		mysqli_query($db, "UPDATE mobilenumbers
							SET number = '" .$_POST['mobilenum']. "'
							WHERE user_id = getuserid('" .$_COOKIE['name']. "');");
		mysqli_query($db, "UPDATE addresses
							SET street = '" .$_POST['street']. "',
							neighborhood = '" .$_POST['barangay']. "',
							city = '" .$_POST['city']. "'
							WHERE user_id = getuserid('" .$_COOKIE['name']. "');");		
		echo mysqli_errno($db);
	
	} else echo 1;

?>
