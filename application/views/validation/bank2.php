<head>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/styleGeneral.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/view.css" type="text/css">
</head>

<div id="body_box">
<table id="body_table" border="0">

	<tr>
	
		<td id="navigation"> 
			<a href="<?php 
				if( !$manager )	echo base_url().'index.php/course';
				else echo base_url().'index.php/managercourse';
			?>">BACK</a> <br/>		
		</td>
		
		<td id="ruler"></td>
		
		<td id="pagefield">
		
<!---------------PAGE CONTENT-------------------------->	
			
			<!----PAGE CONTENT------>
			<div id="profileInfo">	
				<table class="viewtable" border="0">
				
				<tr>
					<th style="width: 100%" colspan="5" class=""><div style="border:none;background-color: #cccc99; color: black">Bank payment for the following:</div></th>
				</tr>
				<tr>
					<th style="width: 50%" class=""><div class="small">Name</div></th>
					<th style="width: 20%" class=""><div class="small">Start | End</div></th>
					<th style="width: 15%" class=""><div class="small">Venue</div></th>
					<th style="width: 15%" class=""><div class="small">Cost</div></th>
				</tr>		
				<?php foreach($cid as $a):
						$query = $this->db->get_where( 'courses', array('id' => $a) );
						$row = $query->row_array();
				?>
				
				<a href="#"><div class="divf">					
				<tr class="linka">
					<td class="dataf"> <a href="#"><center><div><?php echo $row['name']?></div></center></a> </td>
					<td class="dataf"><a href="#"><div><center><?php echo $row['start']?> | <?php echo $row['end']?><center></div></a></td>
					<td class="dataf"> <a href="#"><div><center><?php echo $row['venue']?></center></div></a></td>
					<td class="dataf"><a href="#"><center><div><?php echo $row['cost']?></div></center></a></td>
				</tr>
				</div></a>				
				<?php endforeach ?>
				<tr>
					<th style="width: 100%" colspan="5" class=""><div style="border:none;background-color: #cccc99; color:red ">Total Cost: P <?php echo $total; ?>.00</div></th>
				</tr>
				
				<?php echo "<table> <tr> <td> <h2> Bank name </h2> </td>"; ?>			
				<form action="http://localhost/meteor/index.php/validation/pkbank" method=post>
					<?php $i=0; 
						foreach($cid as $temp){
						echo "<input type='hidden' name='temp[$i]' value='".$temp."' />";
						$i = $i+1;
						}
					?>
					<?php echo "<input type='hidden' name='manager' value='".$manager."' />"; ?>
					<?php echo "<input type='hidden' name='uid' value='".$id."' />"; ?>
					<?php echo "<td> <input class ='textf' type='text' name='bankname' required /> </td> </tr>"; ?>			
					<?php echo "<tr> <td> <h2> Bank branch </h2> </td>"; ?>
					<?php echo "<td> <input class ='textf' type='text' name='bankbranch' required /> </td> </tr>"; ?>
					<?php echo "<tr> <td> <h2> Transaction ID </h2> </td>"; ?>
					<?php echo "<td> <input class ='textf' type='text' name='transaction_id' required /> </td> </tr>"; ?>
					<?php echo "<tr align='right'> <td></td><td> <input class='button_login' type='submit' value='Validate' /> </form> </td> </tr> </table>"; ?>
				</table>		
			</div>				
			<!----PAGE CONTENT END------->
			
<!---------------PAGE CONTENT-------------------------->						
		</td>
		
	</tr>

</table>

</div>
