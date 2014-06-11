<head>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/styleGeneral.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/view.css" type="text/css">
</head>

<div id="body_box">
<table id="body_table" border="0">

	<tr>
	
		<td id="navigation"> 
			
		</td>
		
		<td id="ruler"></td>
		

		<td id="pagefield">
<!---------------PAGE CONTENT-------------------------->	

		<div id="profileCont">
		
		
		<div id="profileName"><?php echo $user['firstname']; ?>  <?php echo $user['lastname']; ?> </div>
				
		<div id="profileInfo">	
					<?php echo validation_errors();?>
					<table class="viewtable" border="0">
					
						
						<tr>
							<th style="width: 20%" class=""><div>EMAIL ADDRESS</div></th>
							<td>&nbsp;<?php echo $user['username']; ?> </td>
						</tr>
						<tr>
							<th style="width: 20%" class=""><div>MAILING ADDRESS</div></th>
							<td>
							<?php if(empty($street)) echo '&nbsp;None';
							else {  ?>
							<?php echo $street; ?>, &nbsp;<?php echo $neighborhood; ?> , <?php echo $city; }?>  																					
							</td>
						</tr>
						<tr>
							<th style="width: 20%" class=""><div>MOBILE NUMBER</div></th>
							<td>
								<?php 
									if( empty( $number ) ) echo "&nbsp;None";
									else echo "&nbsp;".$number;
								?>
							</td>
						</tr>
						<tr>
							<td>
							<?php echo form_open('participantsettings/changeform');?>
							<input type="hidden" name="street" value="<?php if(!empty($street) ){ echo $street; } else echo ""; ?>" />
							<input type="hidden" name="neighborhood" value="<?php if(!empty($neighborhood)){ echo $neighborhood;} else echo ""; ?>" />
							<input type="hidden" name="city" value="<?php if( !empty($city) ){ echo $city;} else echo ""; ?>" />
							<input type="hidden" name="number" value="<?php if( !empty($number) ){ echo $number;} else echo "";?>" />																
							<input class="button_login" type="submit"  value="Edit Info" />
							<?php echo form_close();?>
							</td>
							<td>
							<form action="http://localhost/meteor/index.php/changepword">
							<input class="button_login" type="submit" value="Change Password">
							</form>
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
