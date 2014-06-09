<?php

	$db = mysqli_connect("localhost", "meteor", "xpF7mBWqMtvJUpt9", "meteor");
	$data = array();
	$data['courses'] = array();

	if (isset($_COOKIE['name'])) {
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
								  LEFT JOIN (
								  	SELECT *
								  	FROM notupcoming
								  	WHERE user_id = getuserid('".$_COOKIE['name']."')) AS nu
								  ON courses.id = nu.course_id
								  WHERE nu.user_id IS NULL
								  AND `start` >= CURDATE()
								  OR nu.user_id != getuserid('".$_COOKIE['name']."');");
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
