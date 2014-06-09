<?php
	function saltgen($max){
		$characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$i = 0;
		$salt = "";
		while ($i < $max) {
			$salt .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
			$i++;
		}
		return $salt;
	}
	
	require("mailer/class.phpmailer.php");
	include('functions.php'); 
	$mysqli = getSQL();					  
	
	$user = $_POST['email'];
	// $user = "daryll.panaligan@gmail.com";
	$role = 2;
	$rand = saltgen(25);
	$slug = saltgen(25);
		
	$query = 	"SELECT 
					COUNT(*) as COUNT
				FROM
					users
				WHERE
					username = '".$user."'
					";

	if ($result = $mysqli->query($query)) {
		while ($row = $result->fetch_assoc()) {
			$count = $row['COUNT'];
		}
	}		
	
	$data = array();
	if($count==0){
		//no such user
		$data['header'] = 0;
	}
	else{
		$exec = "UPDATE
					users
				SET 
					password = '".$rand."',
					slug = '".$slug."'
				WHERE
					username = '".$user."'
				;";

		$data = array();				

		if(mysqli_query($mysqli, $exec) != 1){
			$data['error'] = $exec;			
			$data['header'] = 0;
		}
		else{
			//send forgot password link
			$mail             = new PHPMailer();
			$mail->IsSMTP(); // telling the class to use SMTP
			$mail->Host       = "ssl://smtp.googlemail.com"; // SMTP server
			$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
													   // 1 = errors and messages
													   // 2 = messages only
			$mail->SMTPAuth   = true;                  // enable SMTP authentication
			$mail->Port       = 465;                    // set the SMTP port for the GMAIL server

			//account info here
			$mail->Username   = "meteor.upitdc@gmail.com"; // SMTP account username
			$mail->Password   = "einstein12322";        // SMTP account password

			//sender info
			$mail->SetFrom('noreply@MeTEOR.com', 'MeTEOR Validator');

			//recipient info
			$mail->AddAddress($user);

			//message contentss
			$mail->Subject    = "Change Password";
			$mail->AltBody    = ""; // optional, comment out and test

			$link = "http://meteor.upsitf.org/index.php/changePassword/".$slug;
			$body = 
			"
				<style>

					h1,
					h2,
					h3 {
					  line-height: 40px;
					}
				</style>

				<div>
					<div style='height: 108px; margin-top: -8px; margin-left: -10px; width: 105%; background-color: #5e0000; background-image: url('http://localhost/css/images/strip.png');background-repeat:repeat-x;'>
									<img src='http://localhost/css/images/pic.png' style='margin-top: -1px;'/> 
					</div>

					<div style='margin-top: 10px; padding: 8px 35px 8px 14px; margin-bottom: 10px; text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5); color: #b94a48; background-color: #f2dede;  -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px;'>		
						<th style='width: 800px'>
							<center>
							<div style=' font-size: 25px; font-weight: bold;' >Password Change</div>
							</center>
						</th>
					</div>

					<div style=' padding: 8px 35px 8px 14px;  margin-bottom: 20px; text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5); color: #468847; background-color: #dff0d8; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px;'>	
						
					  <strong>You have recently changed your password.</strong><br/>Please click the following link to enter MeTEOR, set your new password under settings:<br/>
					  <a style='color: #0088cc; text-decoration: none; font-size: 15px' href='$link'>Click here</a>
					</div>
				</div>

			";
			$mail->MsgHTML($body);

			if(!$mail->Send()){
				$data['header'] = 2;
			}
			else{
				$data['header'] = 1;			
			}
		}
	}
	echo json_encode($data);
?>