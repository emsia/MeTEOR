<?php

	$db = mysqli_connect("meteor.upsitf.org", "meteor", "xpF7mBWqMtvJUpt9", "meteor");
	$data = array();
	$data['courses'] = array();

	if (isset($_COOKIE['name'])) {
		$res = mysqli_query($db, 
							"SELECT courses.id,
									courses.name,
									courses.description,
									DATE_FORMAT(`start`, '%b %d %Y') AS `start`,
									DATE_FORMAT(courses.end, '%b %d %Y') AS end,
									courses.cost,
									courses.venue,
									courses.available,
									courses.reserved,
									courses.paid,
									DATE_FORMAT(cancelled.date, '%b %d %Y %h:%i %p') AS date
							 FROM sessions
							 JOIN cancelled
							 ON sessions.user_id = cancelled.user_id
							 JOIN courses
							 ON cancelled.course_id = courses.id
							 WHERE sessions.token = '".$_COOKIE['name']."'
							 AND cancelled.refunded = 1;");
		$data['success'] = 1;
		while ($rec = mysqli_fetch_assoc($res)) {
			array_push($data['courses'], $rec);
		}
	}
	else {
		$data['success'] = 0;
	}
	echo json_encode($data);

?>
