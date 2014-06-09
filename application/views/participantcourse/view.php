<head>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/styleGeneral.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/view.css" type="text/css">
</head>

<div id="body_box">
<table id="body_table" border="0">

	<tr>
	
		<td id="navigation"> 
			<a href="http://localhost/meteor/index.php/participantcourse/">RESERVATION</a> <br/>		
			<a href="http://localhost/meteor/index.php/participantcourse/upcoming">UPCOMING</a> <br/>	
			<a href="http://localhost/meteor/index.php/participantcourse/completed">COMPLETED</a> <br/>	
			<a href="http://localhost/meteor/index.php/participantcourse/view" style="color:#7b1113;">VIEW</a> <br/>	
		</td>
		
		<td id="ruler"></td>		

		<td id="pagefield">
<!---------------PAGE CONTENT-------------------------->	


			<!----SEARCH BUTTON | SUBJECT TO CHANGE TO FIT CI FRAMEWORK------->
			<form action="<?php echo base_url().'index.php/participantcourse/search_find';?>" method="post">
				<input class ="textf" type="text" name="search" required/>
				<input class="button_login" type="submit" name="submit" value="Search" />
			</form>
			<!----SEARCH BUTTON END------->
			
			
			<!----PAGE CONTENT------->

			<table border="0">

			<tr class="abclink">
				<td style="list-style: none;"><center></center></td>
			</tr>	
			
			<tr>
				<td>	
					<table class="viewtable" border="0">
					
						<tr>
							<th style="width: 15%" class=""><div>Name</div></th>
							<th style="width: 25%" class=""><div>Description</div></th>
							<th style="width: 25%" class=""><div>Start | End</div></th>
							<th style="width: 20%" class=""><div>Venue</div></th>
							<th style="width: 15%" class=""><div>Cost</div></th>					
						</tr>
			
							<?php foreach( $courses as $course_item ): ?>
							<?php
								$temp = strtotime($course_item['start']);
								$var1 = date('M d, Y', $temp).PHP_EOL;
													
								$temp = strtotime($course_item['end']);
								$var2 = date('M d, Y', $temp).PHP_EOL;
								
								$query = $this->db->get_where( 'cancelled', array('course_id' => $course_item['id']) );
								$can = $query->row_array();
								if( !empty( $can['id'] ) ) continue;
							?>						
						 			
							<tr class="linkb">
							<td class="dataf"><center><div><?php echo $course_item['name']?></div></center></td>
							<td class="dataf"><center><div><?php echo $course_item['description']?></div></center></td>
							<td class="dataf"><div><center><?php echo $var1?> | <?php echo $var2?></center></div> </td>
							<td class="dataf"><div><center><?php echo $course_item['venue']?></center></div> </td>
							<td class="dataf"><center><div><?php echo $course_item['cost']?></div></center> </td>
							
							</tr> 
							
							<?php  endforeach ?>
							
					</table>			
				</td>
				
			
			</tr>
			</table>
			
			
			<!----PAGE CONTENT END------->
				
			
		
		
			

<!---------------PAGE CONTENT-------------------------->						
		</td>
	</tr>


</table>

</div>
