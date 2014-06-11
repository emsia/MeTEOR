

<head>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/styleLogin.css" type="text/css">
<style>
	.cap{
		text-transform: capitalize;
	}
	.red {
		color: red;
		font-size: 14px;
	}
	.alert-error {
	  color: #e74c3c;
	  border: 2px solid #e74c3c !important;
	  -webkit-box-shadow: none;
	  box-shadow: none;
	}
</style>

<?php if($reset){ ?>
	<script type="text/javascript">
		$(window).load(function () {
		$('#resetModal').modal('show');
	});
</script>
<?php } ?>

<?php if($ver){ ?>
	<script type="text/javascript">
		$(window).load(function () {
		$('#verModal').modal('show');
	});
</script>
<?php } ?>

</head>

<div id="body_box">
<table id="body_table" border="0">
	<tr>
		
	
		<td id="signup_box" >


		SIGNUP <br/>
			<table id="login" border="0" style="vertical-align: top;">

			<?php echo form_open('pages/submit');?>
				<?php $class=(form_error('mail')!=='')?'alert-error':''; ?>
				<span class="label_field">EMAIL</span><input class="<?php echo 'input-xlarge '.$class; ?>" required style="margin-right:3px" type="text"  name ="mail"  id="signMail" value="<?php echo set_value('mail');?>" /><br/>
				<span class="label_field">RETYPE EMAIL</span><input required class="input-xlarge" style="margin-right:3px" type="text"  name ="mailconf" autocomplete="off" id="signMail2" value="<?php echo set_value('mailconf');?>" /><br/>
				
				<?php $class=(form_error('pass')!=='')?'alert-error':''; ?>
				<span class="label_field">PASSWORD</span><input required class="<?php echo 'input-xlarge '.$class;?>" style="margin-right:3px" type="password"  id="pass1" name ="pass" autocomplete="off" value="<?php echo set_value('pass');?>" /><br/>
				<?php $class=(form_error('passconf')!=='')?'alert-error':''; ?>
				<span class="label_field">RETYPE PASSWORD</span><input required class="<?php echo 'input-xlarge '.$class; ?>" style="margin-right:3px" type="password" id="pass2" name ="passconf" autocomplete="off" value="<?php echo set_value('passconf');?>" /><br/>
				<span class="label_field">FIRST NAME</span><input required class="input-xlarge cap" style="margin-right:3px" type="text"  name ="fname"  value="<?php echo set_value('fname');?>" /><br/>
				<span class="label_field">MIDDLE NAME</span><input required class="input-xlarge cap" style="margin-right:3px" type="text"  name ="mname"  value="<?php echo set_value('mname');?>" /><br/>
				<span class="label_field">LAST NAME</span><input required class="input-xlarge cap" style="margin-right:3px" type="text"  name ="lname"  value="<?php echo set_value('lname');?>" /><br/>
				<input type="hidden" name="unique" value="<?php echo $unique;?>" />
				<input type="hidden" name="CourseName" value="<?php echo $CourseName;?>" />

				<!-- CAPTCHA -->
				<?php 
					if(!empty($errors)) $class = 'alert-error';
					else $class = '';
				?>
				<div style="padding-top:6px">
				<img style="margin-right:3px" class="codes" id="captcha" src="<?php echo base_url(); ?>securimage/securimage_show.php" alt="CAPTCHA Image" /><br/>
				<object class="code1" type="application/x-shockwave-flash" data="<?php echo base_url(); ?>securimage/securimage_play.swf?bgcol=#ffffff&amp;icon_file=<?php echo base_url(); ?>securimage/images/audio_icon.png&amp;audio_file=<?php echo base_url(); ?>securimage/securimage_play.php" height="30" width="30">
			    	<param name="movie" value="<?php echo base_url(); ?>securimage/securimage_play.swf?bgcol=#ffffff&amp;icon_file=icon-volume-up&amp;audio_file=<?php echo base_url(); ?>securimage/securimage_play.php" />
			    </object>
			    <button style="margin-top: -1px" class="btn btn-success" tabindex="-1" href="#" onclick="document.getElementById('captcha').src = '<?php echo base_url(); ?>securimage/securimage_show.php?' + Math.random(); this.blur(); return false"><i class="glyphicon glyphicon-repeat"></i></button>&nbsp;<br />
				    
				</div>
			    <span class="label_field">ENTER CODE</span><input type="text" class="<?php echo 'input-xlarge '.$class; ?>" style="margin-right:3px" name="captcha_code" value="<?php echo set_value('captcha_code');?>" required /><br/>	

				<input class="btn btn-success btn-sm" type="submit" onclick="return checkErrors()" style="margin-right:3px; width: 90px; margin-top: 3px" value="SIGNUP"/>		
			<?php echo form_close();?>
			</table>
		</td>
		
		<td id="ruler"> </td>
		
		<td id="login_box">
		 
		 
		 <!--JAVA SCRIPT -->
		 <script src="<?php echo base_url(); ?>js/script.js"> </script>
		
		&nbsp;LOGIN
			<?php 
				if(empty($enroll)) echo form_open('pages/login');
				else echo form_open('pages/login_enroll');
			?>
				<table id="login" border="0" style="vertical-align: top;">
					
					<tr>
					<td style="font: 10px arial; color:red ">
					<?php 
						if(!empty($error)) $class = 'alert-error';
						else $class = '';
						echo $error;
					?>

					</td>
					</tr>
			
					<tr  id="one2"><td class="field">
						<input class="<?php echo 'input-xlarge '.$class ?>" style="margin-left:3px" type="text" value="EMAIL" size="28" onfocus="changeBox2()" name="user2"/></td></tr>
					<tr  id="two2" style="display:none"><td class="field">
						<input class="<?php echo 'input-xlarge '.$class ?>" style="margin-left:3px" id="email" type="text" value=""  name="user" value="<?php echo set_value('user'); ?>" size="28" onBlur="restoreBox2()"/></td></tr>
				
					<tr id="one"><td class="field">
						<input class="<?php echo 'input-xlarge '.$class ?>" style="margin-left:3px" value="PASSWORD" type="text" size="28" onfocus="changeBox()" name="password" /></td></tr>
					<tr id="two" style="display:none"><td class="field">
						<input class="<?php echo 'input-xlarge '.$class ?>" style="margin-left:3px" id="password" value="" type="password" name="pword" autocomplete="off" value="<?php echo set_value('pword'); ?>" size="28" onBlur="restoreBox()"/></td></tr>
					
					<input type="hidden" name="unique" value="<?php echo $unique;?>" />
					<input type="hidden" name="CourseName" value="<?php echo $CourseName;?>" />
					<input type='hidden' name='course_id' value='<?php echo $course_id; ?>' />
					<input type='hidden' name='date' value='<?php echo $date; ?>'/>
					<tr>
						<td><input class="btn btn-success" style="margin-left:3px; margin-top: 3px; width: 90px" type="submit" value="LOGIN" />
						
						<?php echo form_close(); ?>
						<a href="#forgotModal" data-toggle="modal" class="forgot" value="Forgot Password">Forgot Password</a>
						
						
						</td>
					</tr>
				</table>
		</td>
	</tr>
</table>

<?php
	foreach($emails as $email){
?>
	<input type="hidden" name="mails[]" value="<?php echo $email; ?>" />
<?php }?>

<div id="resetModal" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header palette-alizarin">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="text-white">Password Reset</h4>
  </div>	
  	<div class="modal-body">
  		<p><center><?php if(!empty($message)) echo $message; ?></center></p>
  	</div>
</div>

<div id="verModal" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header palette-orange">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="text-white">Email Verification</h4>
  </div>	
  	<div class="modal-body">
  		<p><center><?php if(!empty($message)) echo $message; ?></center></p>
  	</div>
</div>

<div id="forgotModal" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header palette-wisteria">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="text-white">Forgot Password</h4>
  </div>
  		<?php 
		$this->load->helper('form');
		$class = array('class' => 'form-horizontal');
		echo form_open_multipart('pages/submitPass', $class); ?>	
  	<div class="modal-body">
  		<p><center>Enter your email address to send you new password.</center></p>
  		<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">Email</label>
		  <div class="controls" id="CourseName">
		    <input type="text" class="input-xlarge" autocomplete="off" name="mail" id="myEmail" value="<?php echo set_value('mail');?>" />
		    <div class="red col-sm-6 col-md-offset-5" style="display:none" id="invalid">Please enter a valid Email<br/></div>
		    <div class="red col-sm-6 col-md-offset-5" style="display:none" id="notSeen">Your email is not yet registered</div>
		  </div>
		</div>
  	</div>
  	<div class="modal-footer">
		<button class="btn btn-danger" style="background: #8E44AD" type="submit" onclick="return checkMail()" >Send <i class="glyphicon glyphicon-send"></i></button>
	</div>
  	<?php echo form_close(); ?>
</div>
  	
<div id="errorModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header palette-alizarin">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="text-white">Error</h4>
  </div>	
  	<div class="modal-body">
  		<div id="validEmail" style="display:none"><center>Please enter a valid E-mail</center></div>
  		<div id="emailMatch" style="display:none"><center>E-mails did not matched</center></div>
  		<div id="takenEmail" style="display:none"><center>Your E-mail has already taken</center></div>
  		<div id="passKulang" style="display:none"><center>Password minimum length is 6</center></div>
  		<div id="passMatch" style="display:none"><center>Passwords did not matched</center></div>
  	</div>
</div>

</div>

<script type="text/javascript">
	function checkErrors(){
		var err1 = 1; var err2 = 1; var err3 = 1; var err4 = 1; var err5 = 1; var show = 0;
		var mail = document.getElementById('signMail');
		var mail2 = document.getElementById('signMail2');
		var pass1 = document.getElementById('pass1');
		var pass2 = document.getElementById('pass2')

		var name1 = 'validEmail';
		var name2 = 'takenEmail';
		var name3 = 'passKulang';
		var name4 = 'passMatch';
		var name5 = 'emailMatch';

		if(!validateForm('signMail') || !validateForm('signMail2')){
			mail.setAttribute('class', 'input-xlarge alert-error');
			mail2.setAttribute('class', 'input-xlarge alert-error');
			document.getElementById(name1).style.display = '';
			document.getElementById(name2).style.display = 'none';
			document.getElementById(name3).style.display = 'none';
			document.getElementById(name4).style.display = 'none';
			document.getElementById(name5).style.display = 'none';
			err1 = 1;
		}else{
			document.getElementById(name1).style.display = 'none';
			mail.setAttribute('class', 'input-xlarge');
			mail2.setAttribute('class', 'input-xlarge');
			err1 = 0;
		}

		if(!err1 && (mail.value.trim().length >0 && mail2.value.trim().length>0)){
			if(mail.value.trim() != mail2.value.trim()){
				mail.setAttribute('class', 'input-xlarge alert-error');
				mail2.setAttribute('class', 'input-xlarge alert-error');
				document.getElementById(name1).style.display = 'none';
				document.getElementById(name2).style.display = 'none';
				document.getElementById(name3).style.display = 'none';
				document.getElementById(name4).style.display = 'none';
				document.getElementById(name5).style.display = '';
				err5 = 1;
			}else{
				document.getElementById(name5).style.display = 'none';
				mail.setAttribute('class', 'input-xlarge');
				mail2.setAttribute('class', 'input-xlarge');
				err5 = 0;
			}
		}

		if(!err5 && !err1){
			if(checkExist(mail.value)){
				mail.setAttribute('class', 'input-xlarge alert-error');
				mail2.setAttribute('class', 'input-xlarge alert-error');
				document.getElementById(name1).style.display = 'none';
				document.getElementById(name2).style.display = '';
				document.getElementById(name3).style.display = 'none';
				document.getElementById(name4).style.display = 'none';
				document.getElementById(name5).style.display = 'none';
				err2 = 1;
			}else{
				document.getElementById(name2).style.display = 'none';
				mail.setAttribute('class', 'input-xlarge');
				mail2.setAttribute('class', 'input-xlarge');
				err2 = 0;
			}
		}

		if(pass1.value.trim().length <6 || pass2.value.trim().length <6){
			pass1.setAttribute('class', 'input-xlarge alert-error');
			pass2.setAttribute('class', 'input-xlarge alert-error');
			document.getElementById(name3).style.display = '';
			document.getElementById(name4).style.display = 'none';
			err3 = 1;
		}else{
			document.getElementById(name3).style.display = 'none';
			pass1.setAttribute('class', 'input-xlarge');
			pass2.setAttribute('class', 'input-xlarge');
			err3 = 0;
		}

		if(!err3){
			if(pass1.value.trim() != pass2.value.trim()){
				pass1.setAttribute('class', 'input-xlarge alert-error');
				pass2.setAttribute('class', 'input-xlarge alert-error');
				document.getElementById(name3).style.display = 'none';
				document.getElementById(name4).style.display = '';
				err4 = 1;
			}else{
				document.getElementById(name4).style.display = 'none';
				pass1.setAttribute('class', 'input-xlarge');
				pass2.setAttribute('class', 'input-xlarge');
				err4 = 0;
			}
		}
		//alert(mail.value.trim().length);
		if(err4 || err2 || err1 || err3 || err5){
			$('#errorModal').modal('show');
			return false;
		}	
		return true;
	}

	function checkMail(){
		var err = 0; var err2 = 0;
		var name = document.getElementById('myEmail').value;

		if(!validateForm('myEmail')){
			document.getElementById('invalid').style.display = '';
			err = 1;
		}
		else{
			document.getElementById('invalid').style.display = 'none';
			err = 0;
		}

		if(!err){
			if(!checkExist(name)){
				document.getElementById('notSeen').style.display = '';
				err2 = 1;
			}else{
				document.getElementById('notSeen').style.display = 'none';
				err2 = 0;
			}
		}

		var mess = false;
		if(!err && !err2) mess = true;
		return mess;
	}

	function checkExist(compare){
		var boxes = body_box.getElementsByTagName("input");
		for( i = 0; i < boxes.length; i++ ){
			myType = boxes[i].getAttribute("type");
			myvalue = boxes[i].value;

			if( myType == "hidden" ) {
				if(compare.trim()==myvalue.trim()) return true;
			}	
		}
		return false;
	}

	function validateForm(name)
	{
		var x = document.getElementById(name).value;
		var atpos = x.indexOf("@");
		var dotpos = x.lastIndexOf(".");
		if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length){
		  return false;
		}
		return true;
	}
</script>
