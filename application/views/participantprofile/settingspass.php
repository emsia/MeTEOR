<head>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/styleGeneral.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/view.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/boots.css" type="text/css">

<script src="<?php echo base_url(); ?>js/jquery-1.8.3.min.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrapdatepicker.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap.js"></script> 

<script type="text/javascript">
	// close the div in 5 secs
	window.setTimeout("closeHelpDiv();", 2000);

	function closeHelpDiv(){
	document.getElementById("helpdiv").style.display=" none";
	}
</script>

</head>

<div id="body_box">
<table id="body_table" border="0">

	<tr>
	
		<td id="navigation"> 
			<a href="<?php echo base_url('index.php/participantprofile'); ?>" >PROFILE</a> <br/>
			<a href="<?php echo base_url('index.php/participantsettings/forgotform'); ?>" style="color: #7b1113;">PASSWORD</a> <br/>
		</td>
		
		<td id="ruler"></td>
		

		<td id="pagefield">

		<div id="profileCont">
		
		
		<h2 class="title"><?php echo $user['lastname'].", ".$user['firstname']." ".$user['middlename']; ?> </h2>
			
		<hr>
		<div id="profileInfo">	
					<?php echo validation_errors();?>
					<table class="viewtable" border="0">
					
						
						<tr>
							<th style="width: 20%" class=""><div>EMAIL ADDRESS</div></th>
							<td>&nbsp;<?php echo $user['username']; ?> </td>
						</tr>
						<tr>
							<th style="width: 20%" class=""><div>MAILING ADDRESS</div></th>
							<td>&nbsp;
							<?php if(empty($street)) echo '&nbsp';
							else {  ?>
							<?php echo $street; ?>, &nbsp;<?php echo $neighborhood; ?> , <?php echo $city; }?>  																					
							</td>
						</tr>
						<tr>
							<th style="width: 20%" class=""><div>MOBILE NUMBER</div></th>
							<td>
								<?php 
									if( empty( $number ) ) echo "None";
									else echo "&nbsp;".$number;
								?>
							</td>
						</tr>
						
						<tr>
						<!--JAVA SCRIPT -->
						<script src="<?php echo base_url(); ?>js/script.js"> </script>
							<td>
							<?php echo form_open('participantsettings/forgot'); ?>
							<table id="login" border="0" style="vertical-align: top;">
							<tr  id="one2"><td class="field">
							<input class="textf" type="text" value="New Password" size="28" onfocus="changeBox2()" name="user2"/></td></tr>
							<tr  id="two2" style="display:none"><td class="field">
							<input class="textf" id="email" type="password" value=""  name="newpass" value="<?php echo set_value('newpass'); ?>" size="28" onBlur="restoreBox2()"/></td></tr>
							<tr id="one"><td class="field">
							<input class="textf" value="Confirm Password" type="text" size="28" onfocus="changeBox()" name="password" /></td></tr>
							<tr id="two" style="display:none"><td class="field">
							<input class="textf" id="password" value="" type="password" name="pconf" autocomplete="off" value="<?php echo set_value('pconf'); ?>" size="28" onBlur="restoreBox()"/></td></tr>
							<tr><td><center>
								<input class="button_login" type="submit" value="SAVE">
								<input class="button_login" type="reset" value="RESET">
								<input class="button_login" type="submit" formmethod="post" formaction="<?php echo base_url().'index.php/participantsettings/';?>" value="CANCEL">
								</center></td></tr>
							<?php echo form_close(); ?>
							</table>
							</td>
						</tr>
						
					</table>	
			
		</div>
			
		
		</div>
			

<!---------------PAGE CONTENT-------------------------->						
		</td>
	</tr>


</table>

</div>
