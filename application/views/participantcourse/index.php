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

			<table border="0">
	
			
			<tr>
				<td>	
					<table class="viewtable" border="0" id="coursesorter">
					
					<thead>
						<tr>
							<th style="width: 35%" class="" onclick=""><div>Name</div></th>
							<th style="width: 15%" class=""title="Month - Day - Year"><div>Start</div></th>
							<th style="width: 15%" title="Month - Day - Year"><div>End</div></th>
							<th style="width: 15%" class=""><div>Venue</div></th>
							<th style="width: 10%" class=""><div>Cost</div></th>
							<th style="width: 10%" title="RESERVED | AVAILABLE | PAID"><div>R | A | P</div></th>			
						</tr>
					</thead>
					<tbody>
							<?php foreach( $courses as $course_item ): ?>
							
							<?php
								$query1 = $this->db->get_where( 'courses', array('id' => $course_item['id']) );
								$array1 = $query1->row_array();
								
								$query2 = $this->db->get_where('reserved', array('course_id' => $array1['id'], 'user_id' => $userid  ) );
								$array2 = $query2->row_array();	
									
								if( !empty( $array2['id'] ) ){
								$course_item['tag'] = 0;

								
								$queryk = $this->db->get_where('reserved',array('user_id' => $userid ));
									$arrayk = $queryk->result_array();
								
								
								foreach($arrayk as $item){
									$queryz = $this->db->get_where('courses',array('id' => $item['course_id']));
									$arrayz = $queryz->result_array();
									
									echo "<div style='padding: 2px;'>";
									foreach($arrayz as $itemx){
										if($itemx['start'] > $course_item['start'] && $itemx['end'] < $course_item['end']){
											$course_item['tag'] = 1;
											echo "Warning! " . $course_item['name'] . " has conflict with " . $itemx['name'];
											echo "<br/>";
											}
										if($itemx['start'] < $course_item['start'] && $itemx['end'] > $course_item['end']){
											$course_item['tag'] = 1;
										} 
									}
									echo "</div>";
									
								}
								
							?>
							
							<a href="#"><div class="divf">
								<?php
									$temp = strtotime($course_item['start']);
									$var1 = date('m-d-Y', $temp).PHP_EOL;
													
									$temp = strtotime($course_item['end']);
									$var2 = date('m-d-Y', $temp).PHP_EOL;
									
								?>
								<tr class="linka">
								<?php if($course_item['tag']) echo '<td class="dataj">';
								else echo '<td class="dataf">';?><a href="#"><div><?php echo $course_item['name']?></div></a> </td>
								<?php if($course_item['tag']) echo '<td class="dataj">';
								else echo '<td class="dataf">';?><a href="#"><div><?php echo $var1?></div></a></td>
								<?php if($course_item['tag']) echo '<td class="dataj">';
								else echo '<td class="dataf">';?><a href="#"><div><?php echo $var2?></div></a></td>
								<?php if($course_item['tag']) echo '<td class="dataj">';
								else echo '<td class="dataf">';?><a href="#"><div><?php echo $course_item['venue']?></div></a></td>
								<?php if($course_item['tag']) echo '<td class="dataj">';
								else echo '<td class="dataf">';?><a href="#"><div><?php echo $course_item['cost']?></div></center></a></td>
								<?php if($course_item['tag']) echo '<td class="dataj">';
								else echo '<td class="dataf">';?><a href="#"><div><?php echo $course_item['reserved']?> | <?php echo $course_item['available']?> | <?php echo $course_item['paid']?></div></a></td>
								<td class="buttontable">
								
								<?php
								
								$this->load->helper('date');
								$this->load->helper('form');
								
								date_default_timezone_set("Asia/Manila");											
								$date = date('Y-m-d G:i:s');
								
								$querya = $this->db->get_where('reserved', array('course_id' => $course_item['id'], 'user_id' => $userid ) );
								$arraya= $querya->row_array();
									
									if( empty( $arraya['id'] ) ){			
										$this->load->helper('form');									
										echo validation_errors(); 
										echo form_open('participantcourse/reserved' );
								
											echo "<input type='hidden' name='user_id' value='".$userid."' />";			
											echo "<input type='hidden' name='course_id' value='".$course_item['id']."' />";
											echo "<input type='hidden' name='date' value='".$date."' />";
											echo "<input class='button_smalla' type='submit' name='submit' value='R' title='reserve course' /> ";
																
										echo"</form>";	
									}
									else{
										$this->load->helper('form');									
										echo validation_errors(); 
										echo form_open('participantcourse/unreservedres' );
								
											echo "<input type='hidden' name='user_id' value='".$userid."' />";			
											echo "<input type='hidden' name='course_id' value='".$course_item['id']."' />";
											echo "<input type='hidden' name='date' value='".$date."' />";
											echo "<input onclick=\"return confirm('Are you sure you want to proceed?')\" class='button_smallb' title='cancel course' type='submit' name='submit' value='C' /> ";
																
										echo"</form>";	
									
									}
									
									?>
								
								</td>
							</tr></div></a>
							
							<?php } endforeach ?>
					</tbody>
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
