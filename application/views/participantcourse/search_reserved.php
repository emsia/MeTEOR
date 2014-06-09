<head>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/styleGeneral.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/view.css" type="text/css">
<script src="<?php echo base_url(); ?>js/jquery-latest.js"></script> 
<script src="<?php echo base_url(); ?>js/jquery_tablesorter.js"></script> 
</head>

<script>
	$(document).ready(function() 
    { 
        $("#coursesorter").tablesorter(); 
    } ); 
</script>

<div id="body_box">
<table id="body_table" border="0">

	<tr>
	
		<td id="navigation"> 
			<div style="font-size:50px; border-bottom: 0px solid #810c14;">
			<?php echo $user['firstname']; ?>
			</div>
			<div style="height: 6px;"></div>
			<a href="http://localhost/meteor/index.php/participantcourse/upcoming">UPCOMING</a> <br/>	
		
			<a href="http://localhost/meteor/index.php/participantcourse/" style="color:#7b1113;">RESERVATION</a> <br/>		
			
			<a href="http://localhost/meteor/index.php/participantcourse/completed">COMPLETED</a> <br/>	
		</td>
		
		<td id="ruler"></td>

		<td id="pagefield">
<!---------------PAGE CONTENT-------------------------->	

		
			<!----SEARCH BUTTON | SUBJECT TO CHANGE TO FIT CI FRAMEWORK------->
			<form action="<?php echo base_url().'index.php/participantcourse/search_reserved';?>" method="post">
				<input class ="textf" type="text" name="search" required/>
				<input class="button_login" type="submit" name="submit" value="Search" />
			</form>
			<!----SEARCH BUTTON END------->
			
			<!----PAGE CONTENT------->
			<table class="viewtable" border="0">
				<?php 
					if( $counter > 0 ) {
				?>

				<tr class="abclink">
					<td style="color: #a42125"><center>SEARCH RESULTS</center></td>
				</tr>
			<tr>
				<td>
				<div id="profileInfo">
			<table class="viewtable" border="0" id="coursesorter">
			<thead>
				<tr>
					<th style="width: 35%" class=""onclic=""><div>Name</div></th>
					<th style="width: 15%" class=""title="Month - Day - Year"><div>Start</div></th>
					<th style="width: 15%" title="Month - Day - Year"><div>End</div></th>
					<th style="width: 15%" class=""><div>Venue</div></th>
					<th style="width: 10%" class=""><div>Cost</div></th>
					<th style="width: 10%" ><div>R|A|P</div></th>
				</tr>
			</thead>
			<tbody>
			<?php for($i=0; $i<$counter; $i++) {?>
				<?php					
					$temp = strtotime($start[$i]);
					$var1 = date('M d, Y', $temp).PHP_EOL;
									
					$temp = strtotime($end[$i]);
					$var2 = date('M d, Y', $temp).PHP_EOL;
					
					$query1 = $this->db->get_where( 'courses', array('id' => $id[$i]) );
					$array1 = $query1->row_array();
								
					$query2 = $this->db->get_where('reserved', array('course_id' => $array1['id'], 'user_id' => $userid  ) );
					$array2 = $query2->row_array();	
					
					if( !empty( $array2['id'] ) ) {	
				?>				
				<a href = "#"><div class="divf"><tr class='linka'> 
				<td class="dataf"><a href="#"><div><?php echo $name[$i]; ?></div></a></td>
				<td class="dataf"><a href="#"><div><?php echo $var1; ?></div></a></td>
				<td class="dataf"><a href="#"><div><?php echo $var2; ?></div></a></td>
				<td class="dataf"><a href="#"><div><?php echo $venue[$i] ?></div></a></td>
				<td class="dataf"><a href="#"><div><?php echo $cost[$i]; ?></div></a></td>
				<td class="dataf"><a href="#"><div><?php echo $reserved[$i]?> | <?php echo $available[$i]; ?> | <?php echo $paid[$i]; ?></div></a></td>
				<td class="buttontable">
					<?php 								
						$this->load->helper('date');
						$this->load->helper('form');
											
						date_default_timezone_set("Asia/Manila");											
						$date = date('Y-m-d G:i:s');	
						
						$this->load->helper('form');									
						echo validation_errors(); 
						echo form_open('participantcourse/unreserved' );
							
						echo "<input type='hidden' name='user_id' value='".$userid."' />";			
						echo "<input type='hidden' name='course_id' value='".$id[$i]."' />";
						echo "<input type='hidden' name='date' value='".$date."' />";
						echo "<input class='button_smallb' type='submit' name='submit' value='R' /> ";
															
						echo"</form>";	
					?>
				</td>
				</tr> </div> </a>
					<?php }}?>
					</tbody>
					</table>
				</div>
				</td>
				
				
			</tr>
			<?php }?>
			</table>		
			<!----PAGE CONTENT END------->
			
<!---------------PAGE CONTENT-------------------------->						
		</td>
		
	</tr>

</table>

</div>
