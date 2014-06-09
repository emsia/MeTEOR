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
			
			<!----PAGE CONTENT------>
			
			<?php echo "<h1><font style='text-transform: uppercase;'> $lastname, $firstname</font>"; ?>
			<?php echo "<br><small>$id </small></h1>"; ?>			
			
			<table class="viewtable" border="0">
				<tr>
					<th class="idf"><div> CID</div></th>
					<th class="cnamef"><div> Name</div></th>
					<th class="descf"><div> Description</div></th>
					<th class="costf"><div> Cost</div></th>
					<th class="datesf"><div> Dates</div></th>
					<th class="rapf"><div> R | A | P </div></th>
				</tr>
			
			<?php for($i=0; $i<$counter; $i++) {?>
				
				<div class="divf"><tr class='linka'> 
				<td class="dataf"><?php echo "<center><div>$cid[$i]"; ?></div></td>
				<td class="dataf"><?php echo "<center><div>$name[$i]"; ?></div></td>
				<td class="dataf"><?php echo "<center><div>$description[$i]"; ?></div></td>
				<td class="dataf"><?php echo "<center><div>$cost[$i]"; ?></div></td>
				<td class="dataf"><?php echo "<center><div>$start[$i] to<br /> $end[$i]"; ?></div></td>
				<td class="dataf"><?php echo "<center><div>$reserved[$i] | $available[$i] | $paid[$i] "; ?></div></td>
				</tr> </div> 
				
			<?php } ?>
				
			
			</table>					
			
			
			<?php echo "<table> <tr> <td class='namef'> <div><h3>Payment</h3></div> </td> <td>"; ?>
			<form action="http://localhost/meteor/index.php/validation/payment" method="post">
				<?php echo "<input type='hidden' name='temp' value='".$id."' />"; ?>
				<?php echo "<input type='hidden' name='cbn' value='1' />"; ?>
				<?php echo "<input class='button_login' type='submit' name='submit' value='CASH' /> </td> <td>"; ?>
			</form>
			<form action="http://localhost/meteor/index.php/validation/payment" method="post">
				<?php echo "<input type='hidden' name='temp' value='".$id."' />"; ?>
				<?php echo "<input type='hidden' name='cbn' value='2' />"; ?>
				<?php echo "<input class='button_login' type='submit' name='submit' value='BANK' />"; ?>
			</form>
				<?php echo "</td> </tr> </table>"; ?>
						
			<!----PAGE CONTENT END------->
			
<!---------------PAGE CONTENT-------------------------->						
		</td>
		
	</tr>

</table>

</div>