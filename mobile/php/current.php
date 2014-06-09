<?php

	$db = mysqli_connect("meteor.upsitf.org", "meteor", "xpF7mBWqMtvJUpt9", "meteor");
	$data = array();
	$data['courses'] = array();

	$res = mysqli_query($db, "SELECT courses.id, 
									courses.name,
									courses.description,
									DATE_FORMAT(`start`, '%b %d %Y') AS `start`,
									DATE_FORMAT(courses.end, '%b %d %Y') AS end,
									courses.cost,
									courses.venue,
									courses.available,
									courses.reserved,
									courses.paid
								  FROM courses
								  WHERE `start` >= CURDATE();");
	$data['success'] = 1;						  
	while ($rec = mysqli_fetch_assoc($res)) {
		array_push($data['courses'], $rec);
	}

	echo json_encode($data);
	
?>
