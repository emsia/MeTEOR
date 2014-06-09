

<head>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/styleLogin.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/boot.css" type="text/css">
<script src="<?php echo base_url(); ?>js/jquery.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap.js"></script> 
</head>



<div id="body_box">
<table id="body_table" border="0">
	<tr>		
		<td></td>
		<td id="ruler"> </td>
		
		<td id="login_box">
		 
		 
		 <!--JAVA SCRIPT -->
		 <script src="<?php echo base_url(); ?>js/script.js"> </script>
		
			<?php echo form_open('pages/login'); ?><br/><br/>
		&nbsp;LOGIN
				<table id="login" border="0" style="vertical-align: top;">
					
					<tr  id="one2"><td class="field">
						<input class="textf" type="text" value="EMAIL" size="28" onfocus="changeBox2()" name="user2"/></td></tr>
					<tr  id="two2" style="display:none"><td class="field">
						<input class="textf" id="email" type="text" value=""  name="user" value="<?php echo set_value('user'); ?>" size="28" onBlur="restoreBox2()"/></td></tr>
				
					<tr id="one"><td class="field">
						<input class="textf" value="PASSWORD" type="text" size="28" onfocus="changeBox()" name="password" /></td></tr>
					<tr id="two" style="display:none"><td class="field">
						<input class="textf" id="password" value="" type="password" name="pword" autocomplete="off" value="<?php echo set_value('pword'); ?>" size="28" onBlur="restoreBox()"/></td></tr>

					<tr><td><input class="button_login" type="submit" value="LOGIN" /></td></tr>
			<?php echo form_close(); ?>
					<tr>
						<td style="font: 10px arial; color:red ">
						<?php echo validation_errors();?> 
						<?php echo $error; ?>
					</td>
					</tr>
					<tr><td><?php $this->load->helper('form'); echo form_open('pages/submitPass');?>
					<span class="label_field">EMAIL</span><br/>
					<input class="textf" type="text" size="28" name ="mail"  value="<?php echo set_value('mail');?>" /><br/>
					<input class="button_login" type="submit" value="SEND"/>
					<?php echo form_close();?>
					</td></tr>
					
		 </table>
		</td>
	</tr>
		
</table>

</div>
