<script>
	$(document).ready(function() 
    { 
        $("#addCourse").tablesorter(); 
    } );
</script>

<div id="body_box">
<table id="body_table" border="0">

	<tr>
	
		<td id="navigation"> 
			<a href="<?php echo base_url().'index.php/course';?>">BACK</a> <br/>		
		</td>
		
		<td id="ruler"></td>
		
		<td id="pagefield">
		
<!---------------PAGE CONTENT-------------------------->	

			<!----SEARCH BUTTON | SUBJECT TO CHANGE TO FIT CI FRAMEWORK-------->
			<?php $this->load->helper('form');
				echo form_open('course/search_find'); ?>
				<select name="type" class="textf">
				  <option value="COURSE">COURSE</option>
				  <option value="USER">USER</option> 
				</select>
				<input class ="textf" type="text" name="search" required/>
				<input class="button_login" type="submit" name="submit" value="Search" />
			</form>
			<!----SEARCH BUTTON END-------->
				
			<!----PAGE CONTENT-------->
			<table class="viewtable" border="0">
						
			<tr class="abclink">
					<td style="color: #a42125"><center>SEARCH RESULTS</center></td>
			</tr>
			<tr>
				<td>
					<div id="profileInfo">
						<table class="viewtable" border="0" id="addCourse">
							<thead>	
								<tr>
									<th style="width: 5%"></th>
									<th style="width: 25%"><div> Last Name</div></th>
									<th style="width: 25%"><div> First Name</div></th>
									<th style="width: 25%"><div> Email</div></th>
									<th style="width: 20%"><div> Status</div></th>
								</tr>
							</thead>
							<tbody>
								<?php for($i=0; $i<$counter; $i++) {?>
									<a href = ''><div class="divf"><tr class='linka'>
									<?php
										$set = 1; $setPaid = 1; 
											
										$queryPaid = $this->db->get_where( 'payment', array('user_id' => $id[$i]) );
										$arrayPaid = $queryPaid->row_array();
											
										if( !empty($arrayPaid['id']) ) $setPaid = 0;
											
										if( ($validated[$i] && $refunded[$i]) && ( $setPaid ) ) 
											$set = 0;
									?>
									<td class="dataf"><center>
										<form action="http://localhost/meteor/index.php/validation/validate" method="post">
											<?php echo "<input type='hidden' name='temp' value='".$id[$i]."' />"; ?>
											<?php echo "<input type='hidden' name='cbn' value='0' />"; ?>
											<?php echo "<input type='hidden' name='manager' value='0' />"; ?>
											<?php 	
												if( $set ) {
													if( $validated[$i] == 1 ) echo "<input class='button_smallb' onMouseOver=\"ddrivetip('Validated', '', 60)\"; onMouseOut=\"hideddrivetip()\" type='button' name='submit' value='V' disable />"; 
													else echo "<input class='button_smalla' onMouseOver=\"ddrivetip('For Validation', '', 80)\"; onMouseOut=\"hideddrivetip()\" type='submit' name='submit' value='V' />"; 
												} else {
													echo "<input class='button_smallb' onMouseOver=\"ddrivetip('No Course(s)', '', 100)\"; onMouseOut=\"hideddrivetip()\" type='button' name='submit' value='V' disable/>"; 
												}
											?>
										</form></center>
									</td>
									<td class="dataf"><center><?php echo "<div>$lastname[$i]"; ?></center></div></a></td>
									<td class="dataf"><center><?php echo "<div>$firstname[$i]"; ?></center></div></a></td>
									<td class="dataf"><center><?php echo "<div>$username[$i]"; ?></center></div></a></td>
									<td class="dataf"> 
										<?php 
											$setPaid = 1; 
											
											$queryPaid = $this->db->get_where( 'payment', array('user_id' => $id[$i]) );
											$arrayPaid = $queryPaid->row_array();
											
											if( !empty($arrayPaid['id']) ) $setPaid = 0;
											
											if($validated[$i] == 0 && $refunded[$i] == 0) echo "<center>For Validation<br>Has Refunded Course(s)</center>";
											else if( $validated[$i] == 0 ) echo "<center>For Validation</center>";
											else if($validated[$i] && $refunded[$i] == 0) echo "<center>Validated<br>Has Refunded Course(s)</center>";					
											else if($refunded[$i] == 0) echo "<center>Has Refunded Course(s)</center>";
											else if( ($validated[$i] && $refunded[$i]) && ( $setPaid ) )
												echo "<center>Has No Course(s) Yet</center>";
											else if($validated[$i] == 1) echo "<center>Validated</center>";
										?>
									</td>									
									<td class="dataf"><center>
										<form action="http://localhost/meteor/index.php/" method="post">
											<?php echo "<input type='hidden' name='temp' value='".$id[$i]."' />"; ?>
											<?php echo "<input type='hidden' name='cbn' value='0' />"; ?>
											
										</form>
									</center></td>
									</tr> </div> </a>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</td>
			</tr>
			</table>			
			<!----PAGE CONTENT END------->
			
<!---------------PAGE CONTENT-------------------------->						
		</td>
		
	</tr>

</table>

</div>
<div id="dhtmltooltip"></div>
<script language="javascript" src="<?php echo base_url(); ?>js/tooltip.js" type="text/javascript"></script>