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
	
	$email = $_POST['email'];
	$pass = sha1($_POST['password']);
	$first_name = $_POST['firstname'];
	$last_name = $_POST['lastname'];

	// $email = "daryll.panaligan@gmail.com";
	// $pass = sha1("test");
	// $first_name = "daryll";
	// $last_name = "panaligan";
	$role = 2;
	$slug = saltgen(25);

		
	//insert user into database
	$exec = "INSERT INTO 
				users
				(username, password, firstname, lastname, role, slug)
			VALUES 
				('".mysqli_real_escape_string($mysqli, $email)."',
				'".mysqli_real_escape_string($mysqli, $pass)."',
				'".mysqli_real_escape_string($mysqli, $first_name)."',
				'".mysqli_real_escape_string($mysqli, $last_name)."',
				'".mysqli_real_escape_string($mysqli, $role)."',
				'".mysqli_real_escape_string($mysqli, $slug)."'
				);";

	$data = array();				

	if(mysqli_query($mysqli, $exec) != 1){
		$data['header'] = 0;
	}
	else{
		//send verification email
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
			$mail->AddAddress($email);

			//message contentss
			$mail->Subject    = "Confirm Registration";
			$mail->AltBody    = ""; // optional, comment out and test

			$link = "http://meteor.upsitf.org/index.php/validate/".$slug;
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
							<div style=' font-size: 25px; font-weight: bold;' >Confirm Registration</div>
							</center>
						</th>
					</div>

					<div style=' padding: 8px 35px 8px 14px;  margin-bottom: 20px; text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5); color: #468847; background-color: #dff0d8; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px;'>	
						
					  <strong>Thank You Registering!</strong><br/>Please click the following link to confirm your registration:<br/>
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
	echo json_encode($data);
?>