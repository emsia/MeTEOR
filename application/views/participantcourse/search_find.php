<head>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/styleGeneral.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/view.css" type="text/css">
</head>

<div id="body_box">
<table id="body_table" border="0">

	<tr>
	
		<td id="navigation"> 
			<a href="http://localhost/meteor/index.php/participantcourse/upcoming">UPCOMING</a> <br/>	
			<a href="http://localhost/meteor/index.php/participantcourse/" style="color:#7b1113;">RESERVATION</a> <br/>		

			<a href="http://localhost/meteor/index.php/participantcourse/completed">COMPLETED</a> <br/>	
			
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
			<table class="viewtable" border="0">
				<?php 
					if( $counter > 0 ) {
				?>	
				<tr class="abclink">
					<td style="list-style: none;"><center></center></td>
				</tr>
				
			<tr>
				<td>
				<div id="profileInfo">
			<table class="viewtable" border="0">
				<tr>
					<th style="width: 13%" class=""><div>Name</div></th>
					<th style="width: 25%" class=""><div>Description</div></th>
					<th style="width: 25%" class=""><div>Start | End</div></th>
					<th style="width: 15%" class=""><div>Venue</div></th>
					<th style="width: 10%" class=""><div>Cost</div></th>
					<th style="width: 12%" ><div>R|A|P</div></th>	
				</tr>
	
			<?php for($i=0; $i<$counter; $i++) {?>
				<?php
					$session_name = $this->session->userdata('user');
					$query3 = $this->db->get_where( 'users', array('username' => $session_name) );
					$array3 = $query3->row_array();	
					
					$temp = strtotime($start[$i]);
					$var1 = date('M d, Y', $temp).PHP_EOL;
									
					$temp = strtotime($end[$i]);
					$var2 = date('M d, Y', $temp).PHP_EOL;
								
					$query2 = $this->db->get_where('reserved', array('course_id' => $id[$i], 'user_id' => $userid  ) );
					$array2 = $query2->row_array();	
									
					if( !empty( $array2['id'] ) ){
				?>				
				<a href = ''><div class="divf"><tr class='linka'> 
				<td class="dataf"><a href="#"><center><div><?php echo $name[$i]; ?></div></center></a></td>
				<td class="dataf"><a href="#"><center><div><?php echo $description[$i]; ?></center></div></a></td>
				<td class="dataf"><a href="#"><center><div><?php echo $var1; ?> | <?php echo $var2; ?></div></center></a></td>
				<td class="dataf"><a href="#"><center><div><?php echo $venue[$i] ?></div></center></a></td>
				<td class="dataf"><a href="#"><center><div><?php echo $cost[$i]; ?></div></center></a></td>
				<td class="dataf"><a href="#"><center><div><?php echo $reserved[$i]?> | <?php echo $available[$i]; ?> | <?php echo $paid[$i]; ?></div></center></a></td>
				<td class="buttontable">
					<?php 								
						$this->load->helper('date');
						$this->load->helper('form');
											
						date_default_timezone_set("Asia/Manila");
											
						$var1 = date('Y-m-d G:i:s');					
						$querya = $this->db->get_where('reserved', array('course_id' => $id[$i], 'user_id' => $userid ) );
						$arraya= $querya->row_array();
						
						if( empty( $arraya['id'] ) ){	
							$this->load->helper('form');									
							echo validation_errors(); 
							echo form_open('participantcourse/reserved' );
							
							echo "<input type='hidden' name='user_id' value='".$array3['id']."' />";			
							echo "<input type='hidden' name='course_id' value='".$id[$i]."' />";
							echo "<input type='hidden' name='date' value='".$var1."' />";
							echo "<input class='button_smalla' type='submit' name='submit' value='R' /> ";
															
							echo"</form>";	
						}	
						else{
							$this->load->helper('form');									
							echo validation_errors(); 
							echo form_open('participantcourse/unreserved' );
							
							echo "<input type='hidden' name='user_id' value='".$array3['id']."' />";			
							echo "<input type='hidden' name='course_id' value='".$id[$i]."' />";
							echo "<input type='hidden' name='date' value='".$var1."' />";
							echo "<input class='button_smallb' type='submit' name='submit' value='R' /> ";
															
							echo"</form>";
						}
					}	
					?>
				</td>
				</tr> </div> </a>
					<?php }?>
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
