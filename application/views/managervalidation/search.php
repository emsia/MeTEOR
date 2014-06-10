<head>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/styleGeneral.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/view.css" type="text/css">
</head>

<div id="body_box">
<table id="body_table" border="0">

	<tr>
	
		<td id="navigation"> 
			<a href="#">VIEW</a> <br/>		
		</td>
		
		<td id="ruler"></td>
		
		<td id="pagefield">
		
<!---------------PAGE CONTENT-------------------------->	

			<!----SEARCH BUTTON | SUBJECT TO CHANGE TO FIT CI FRAMEWORK------->
			<form action="http://localhost/meteor/index.php/validation/search_results" method="post">
				<input class ="textf" type="text" name="search" required/>
				<input class="button_login" type="submit" name="submit" value="Search" />
			</form>
			<!----SEARCH BUTTON END------->
			
			<!----PAGE CONTENT------->
			<table class="viewtable" border="0">
							<tr>
								<th  style="width: 10%"><div> ID</div></th>
								<th  style="width: 40%"><div> Name</div></th>
								<th  style="width: 30%"><div> Email</div></th>
								<th  style="width: 15%"><div> Status</div></th>
							</tr>
			
			<?php for($i=0; $i<$counter; $i++) {?>
				<a href = ''><div class="divf"><tr class='linka'> 
				<td class="dataf"><?php echo "<div>$id[$i]"; ?></div></a></td>
				<td class="dataf"><?php echo "<div>$lastname[$i], $firstname[$i]"; ?></div></a></td>
				<td class="dataf"><?php echo "<div>$username[$i]"; ?></div></a></td>
				<td class="dataf"> 
					<?php 
					if($validated[$i] == 0 && $refunded[$i] == 1) echo "For Validation";
					else if($validated[$i] == 1 && $refunded[$i] == 0) echo "For Refund";
					else if($validated[$i] == 0 && $refunded[$i] == 0)  echo "For Validation <br> For Refund";
					else echo "Complete"
					?>
				
				</td>
				<td class="dataf"> <center>
					<form action="../validation/validate" method="post">
						<?php echo "<input type='hidden' name='temp' value='".$id[$i]."' />"; ?>
						<?php echo "<input type='hidden' name='cbn' value='0' />"; ?>
						<?php 
						if($validated[$i] == 1) echo "<input class='button_smallb' type='submit' name='submit' value='V' disabled />"; 
						else echo "<input class='button_smalla' type='submit' name='submit' value='V' />"; 
						?>
					</form>
				</center></td>
				</tr> </div> </a>
			<?php } ?>
			
			</table>			
			<!----PAGE CONTENT END------->
			
<!---------------PAGE CONTENT-------------------------->						
		</td>
		
	</tr>

</table>

</div>