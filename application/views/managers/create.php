<head>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/styleGeneral.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/view.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/boots.css" type="text/css">

<style>
	.alert-error {
	    color: #E74C3C;
	    border-color: #E74C3C;
	    box-shadow: none;
	}
	.alert-error .input:focus{
	  border-color: #e74c3c;
	  -webkit-box-shadow: none;
	  -moz-box-shadow: none;
	  box-shadow: none;
	}
	.cap{
		text-transform: capitalize;
	}
</style>
</head>

<div id="body_box">
<table id="body_table" border="0">

	<tr>
	
		<td id="navigation"> 
			<a href="<?php echo base_url().'index.php/managers' ;?>" >VIEW</a> <br/>		
			<a href="<?php echo base_url().'index.php/managers/create' ;?> " style="color:#7b1113;">ADD</a> <br/>	
		</td>
		
		<td id="ruler"></td>
		

		<td id="pagefield">
				
				<table class="viewtable" border="0">
			
			
				<tr  style="font: 10px arial; color:red ">
				<td colspan="4">
				</td>
				</tr>
			
				<tr>
					<th style="width: 25%" class=""><div> Firstname </div></th>
					<th style="width: 25%" class=""><div> Lastname </div></th>
					<th style="width: 30%" class=""> <div>Email </div></th>
					<th class="width: 20%"><div> Password </div></th>
				</tr>
				
			
				<?php echo form_open('managers/create') ?>
				<?php for($i=0; $i<5; $i++){ ?>
				<tr>
					<?php
						$class1=(form_error('firstname['.$i.']')!=='')?'alert-error':'';
						$class2=(form_error('lastname['.$i.']')!=='')?'alert-error':'';
						$class3=(form_error('email['.$i.']')!=='')?'alert-error':'';
						$class4=(form_error('password['.$i.']')!=='')?'alert-error':'';
					?>
					<td>
						<input class="<?php echo "cap addf ".$class1; ?>" type="input" name="firstname[<?php $i ?>]" value="<?php echo set_value('firstname['.$i.']'); ?>" /><br />
					</td>					
					<td>
						<input class="<?php echo "cap addf ".$class2; ?>" type="input" name="lastname[<?php $i ?>]" value="<?php echo set_value('lastname['.$i.']'); ?>" /><br />
					</td>					
					<td>
						<input class="<?php echo "addf ".$class3; ?>" type="input" name="email[<?php $i ?>]" value="<?php echo set_value('email['.$i.']'); ?>" /><br />
					</td>	
					<td>
						<input class="<?php echo "addf ".$class4; ?>" type="password" name="password[<?php $i ?>]" value="<?php echo set_value('password['.$i.']'); ?>" /><br />
					</td>
					
				</tr>
				<?php } ?>

				<tr>
					<td colspan="3"> </td>
					<td ><center>
					<input class="button_login" type="submit" name="submit" value="Add Manager" /> 
					</center>
					</td>
				</tr>
				</form>
				
				
				
				</tr>	
				
				</table>

			<!----PAGE CONTENT END------->
			

<!---------------PAGE CONTENT-------------------------->						
		</td>
	</tr>


</table>

</div>

