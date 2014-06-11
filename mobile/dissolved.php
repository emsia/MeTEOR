<?php

	$db = mysqli_connect("localhost", "meteor", "xpF7mBWqMtvJUpt9", "meteor");
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
									DATE_FORMAT(dissolved.date, '%b %d %Y %h:%i %p') AS date
							 FROM sessions
							 JOIN dissolved
							 ON sessions.user_id = dissolved.user_id
							 JOIN courses
							 ON dissolved.course_id = courses.id
							 WHERE sessions.token = '".$_COOKIE['name']."'
							 ORDER BY date DESC;");
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
