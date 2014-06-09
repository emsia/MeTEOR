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
							<td><br/><br/>
							<?php echo form_open('participantsettings/change')?>
							MAILING ADDRESS:
								STREET:<input class="textf" type="text" size="35" name ="street"  value="<?php if( !empty($street) ){ echo $street;} else echo"";?>" /><br/>
								NEIGHBORHOOD:<input class="textf" type="text" size="35" name ="neighborhood"  value="<?php if( !empty($neighborhood) ){ echo $neighborhood;} else echo "";?>" /><br/>
								CITY:<input class="textf" type="text" size="35" name ="city"  value="<?php if( !empty($city) ) {echo $city;} else echo "";?>" /><br/>
							MOBILE NUMBER:<input class="textf" type="text" size="35" name ="number"  value="<?php if( !empty($number) ){ echo $number;} else "";?>" /><br/>
							<center><br/>
								<input class="button_login" type="submit" value="SAVE">
								<input class="button_login" type="reset" value="RESET">
								<input class="button_login" type="submit" formmethod="post" formaction="<?php echo base_url().'index.php/participantsettings';?>" value="CANCEL">
								</center>
							<?php echo form_close(); ?>
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
