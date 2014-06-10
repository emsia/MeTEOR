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
									DATE_FORMAT(cashpayment.date, '%b %d %Y %h:%i %p') AS date,
									cashpayment.amount,
									cashpayment.ornumber,
									0,
									0 AS flag
							 FROM sessions
							 JOIN cashpayment
							 ON sessions.user_id = cashpayment.user_id
							 JOIN courses
							 ON cashpayment.course_id = courses.id
							 WHERE sessions.token = '".$_COOKIE['name']."'
							 ORDER BY date DESC
							 UNION
							 SELECT courses.id,
									courses.name,
									courses.description,
									DATE_FORMAT(`start`, '%b %d %Y') AS `start`,
									DATE_FORMAT(courses.end, '%b %d %Y') AS end,
									courses.cost,
									courses.venue,
									courses.available,
									courses.reserved,
									courses.paid,
									DATE_FORMAT(bankpayment.date, '%b %d %Y %h:%i %p') AS date,
									bankpayment.bankname,
									bankpayment.bankbranch,
									bankpayment.transaction_id,
									1 AS flag
							 FROM sessions
							 JOIN bankpayment
							 ON sessions.user_id = bankpayment.user_id
							 JOIN courses
							 ON bankpayment.course_id = courses.id
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
