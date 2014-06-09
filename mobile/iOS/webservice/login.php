<?php
	/*
	Headers:
	0: no such user found
	1: user found, login success
	2: account not yet verified
	3: sql/database error
	*/
	
	//let HTML5 localstorage handle this

	//initialize JSON response array
	$data = array();

		//check if call to function is for login checking only
		if($_POST['login_check'] == 1){
			$data['header'] = 0;
		}
		else{
			//connect to database
			include('functions.php');
			$mysqli = getSQL();
			if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				// $data['header'] = 3;				
				// echo json_encode($data, JSON_FORCE_OBJECT);
				exit();
			}
			
			$email = $_POST['email'];
			$password = sha1($_POST['password']);
			
			
			//test
			 // $email = "mariaerikasantos@gmail.com";
			 // $password = sha1("password");
			//end test
				
				
			$query = 	"SELECT 
							a.id,a.firstname,a.lastname,a.verified,
							b.number,
							c.street,c.neighborhood,c.city
						FROM
							users AS a
						LEFT JOIN 
							mobilenumbers AS b						
						ON
							a.id = b.user_id
						LEFT JOIN 
							addresses AS c
						ON
							a.id = c.user_id
						WHERE
							a.username = '".mysqli_real_escape_string($mysqli, $email)."'
							AND
							a.password = '".mysqli_real_escape_string($mysqli, $password)."'
						";

			if ($result = $mysqli->query($query)) {
				$user_exists = FALSE;
				$data['response'] = array();					
				while ($row = $result->fetch_assoc()) {
					$ID = $row['id'];
					$verified = $row['verified'];
					$user_exists = TRUE;
				}
				$result->free();
				
				if($user_exists){
					if($verified == 1){
						//delete previous tokens if they exist
						$exec = "DELETE FROM
									sessions_ios
								WHERE
									user_id = '".mysqli_real_escape_string($mysqli, $ID)."';";
						mysqli_query($mysqli, $exec);
						
						//generate token using sha1 hash of userID and timestamp
						date_default_timezone_set('Asia/Manila');
						$date = date('Y-m-d h:i:s a', time());
						$token = sha1($date.$ID);
						
						//insert into sessions_iOS table
						$exec = "INSERT INTO 
									sessions_ios
									(date, user_id, token)
								VALUES 
									('".mysqli_real_escape_string($mysqli, $date)."',
									'".mysqli_real_escape_string($mysqli, $ID)."',
									'".mysqli_real_escape_string($mysqli, $token)."'
									);";
						$data['header'] = mysqli_query($mysqli, $exec);
						array_push($data['response'], $token);
					}
					else{
						$data['header'] = 2;					
					}
				}
				else{
					$data['header'] = 0;
				}
			}
			else{	
				$data['header'] = 3;
			}

			$mysqli->close();
		}

	
	echo json_encode($data, JSON_FORCE_OBJECT);
?>