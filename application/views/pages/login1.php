

<head>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/styleLogin.css" type="text/css">
</head>



<div id="body_box">
<table id="body_table" border="0">
	<tr>
		
		<?php echo validation_errors();?>
		<td id="signup_box" ><br/>


		SIGNUP <br/>
			<table id="login" border="0" style="vertical-align: top;">
			<?php if( !empty($errors) ){ ?>
					<span style="font: 10px arial; color:red ">
						<?php echo $errors; ?>&nbsp;<br/>
					</span>
			<?php } ?>
			<?php echo form_open('pages/submit');?>
				<span class="label_field">EMAIL</span><input class="textf" type="text" size="35" name ="mail"  value="<?php echo set_value('mail');?>" /><br/>
				<span class="label_field">RETYPE EMAIL</span><input class="textf" type="text" size="35" name ="mailconf" autocomplete="off" value="<?php echo set_value('mailconf');?>" /><br/>
				<span class="label_field">PASSWORD</span><input class="textf" type="password" size="35" name ="pass" autocomplete="off" value="<?php echo set_value('pass');?>" /><br/>
				<span class="label_field">RETYPE PASSWORD</span><input class="textf" type="password" size="35" name ="passconf" autocomplete="off" value="<?php echo set_value('passconf');?>" /><br/>
				<span class="label_field">FIRST NAME</span><input class="textf" type="text" size="35" name ="fname"  value="<?php echo set_value('fname');?>" /><br/>
				<span class="label_field">MIDDLE NAME</span><input class="textf input-xlarge cap" type="text"  name ="mname"  value="<?php echo set_value('mname');?>" /><br/>
				<span class="label_field">LAST NAME</span><input class="textf" type="text" size="35" name ="lname"  value="<?php echo set_value('lname');?>" /><br/>
				<input type="hidden" name="unique" value="<?php echo $unique;?>" />
				<input type="hidden" name="CourseName" value="<?php echo $CourseName;?>" />

				<!-- CAPTCHA -->
				<img id="captcha" src="<?php echo base_url(); ?>securimage/securimage_show.php" alt="CAPTCHA Image" />&nbsp;
				<object type="application/x-shockwave-flash" data="<?php echo base_url(); ?>securimage/securimage_play.swf?bgcol=#ffffff&amp;icon_file=<?php echo base_url(); ?>securimage/images/audio_icon.png&amp;audio_file=<?php echo base_url(); ?>securimage/securimage_play.php" height="40" width="40">
			    	<param name="movie" value="<?php echo base_url(); ?>securimage/securimage_play.swf?bgcol=#ffffff&amp;icon_file=<?php echo base_url(); ?>securimage/images/audio_icon.png&amp;audio_file=<?php echo base_url(); ?>securimage/securimage_play.php" />
			    </object>
			    &nbsp;
			    <a tabindex="-1" style="border-style: none;" href="#" onclick="document.getElementById('captcha').src = '<?php echo base_url(); ?>securimage/securimage_show.php?' + Math.random(); this.blur(); return false"><img src="<?php echo base_url(); ?>securimage/images/refresh.png" alt="Reload Image" onclick="this.blur()" align="bottom" height="40" width="40" border="0"></a>&nbsp;<br />
			    
			    <span class="label_field">ENTER CODE</span><input type="text" class="textf" size="35" name="captcha_code" value="<?php echo set_value('captcha_code');?>" required /><br/>	

				<input class="button_login" type="submit" value="SIGNUP"/>		
			<?php echo form_close();?>
			</table>
		</td>
		
		<td id="ruler"> </td>
		
		<td id="login_box">
		 
		 
		 <!--JAVA SCRIPT -->
		 <script src="<?php echo base_url(); ?>js/script.js"> </script>
		
		
			<?php echo form_open('pages/login_enroll'); ?><br/><br/>
			&nbsp;LOGIN
				<table id="login" border="0" style="vertical-align: top;">
					<tr>
					<td style="font: 10px arial; color:red ">
					<?php echo validation_errors();?> 
					<?php echo $error; ?>
					</td>
					</tr>
					
					<tr  id="one2"><td class="field">
						<input class="textf" type="text" value="EMAIL" size="28" onfocus="changeBox2()" name="user2"/></td></tr>
					<tr  id="two2" style="display:none"><td class="field">
						<input class="textf" id="email" type="text" value=""  name="user" value="<?php echo set_value('user'); ?>" size="28" onBlur="restoreBox2()"/></td></tr>
				
					<tr id="one"><td class="field">
						<input class="textf" value="PASSWORD" type="text" size="28" onfocus="changeBox()" name="password" /></td></tr>
					<tr id="two" style="display:none"><td class="field">
						<input class="textf" id="password" value="" type="password" name="pword" autocomplete="off" value="<?php echo set_value('pword'); ?>" size="28" onBlur="restoreBox()"/></td></tr>
					<?php
						echo "<input type='hidden' name='course_id' value='".$course_id."' />";
						echo "<input type='hidden' name='date' value='".$date."'/>";
					?>
					<tr><td><input class="button_login" type="submit" value="LOGIN" />
					
					<?php echo form_close(); ?>
					<a href="http://localhost/meteor/index.php/temp/forgotpw" class="forgot" value="Forgot Password">Forgot Password</a>
					
					
					</td></tr>
			
		 </table>
		</td>
	</tr>
		
</table>

</div>
