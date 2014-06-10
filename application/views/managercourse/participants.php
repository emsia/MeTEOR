<head>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/styleGeneral.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/view.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/view2.css" type="text/css">
<link href="<?php echo base_url(); ?>css/css_recipes.css" rel="stylesheet" type="text/css">

<script src="<?php echo base_url(); ?>js/jquery-latest.js"></script> 
<script src="<?php echo base_url(); ?>js/jquery_tablesorter.js"></script>

<script>
	$(document).ready(function() 
    { 
        $("#addCourse").tablesorter(); 
    } );
</script>
</head>

<div id="body_box">
<table id="body_table" border="0">

	<tr>
	
		<td id="navigation"> 
			<a href="<?php echo base_url().'index.php/managercourse';?>">BACK</a> <br/>		
		</td>
		
		<td id="ruler"></td>

		<td id="pagefield">
			<?php $this->load->helper('form');
				echo form_open('managercourse/search_find'); ?>
				<select name="type" class="textf">
				  <option value="COURSE">COURSE</option>
				  <option value="USER">USER</option> 
				</select>
				<input class ="textf" type="text" name="search" required/>
				<input class="button_login" type="submit" name="submit" value="Search" />
			</form>
			<table border="0">	
				<?php 
					if( !empty($users) ) {
				?>	
			<div id="profileInfo">	
				<table class="viewtable" border="0">
					<tr>
						<th style="width: 100%" colspan="5" class=""><div style="border:none;background-color: #cccc99; color: #a42125">COURSE NAME & DESCRIPTION</div></th>
					</tr>
					<?php 
						foreach( $users as $participant_item ){
							$ask2 = $participant_item['course_id'];
							$query = $this->db->get_where('courses', array('id' => $ask2) );
							$array = $query->row_array();
					?>
					<div>
						<tr>
							<td class="dataf" ><center><div ><?php echo $array['name'];?> : <?php echo $array['description'];?></div></center></td>
						</tr>
					</div>
					<?php break; }?>
				<tr>
					<td>
						<div id="profileInfo">
							<table class="viewtable" border="0" id="addCourse">
								<thead>	
									<tr>
										<th style="width: 5%" class=""></th>
										<th style="width: 20%" class=""><div>Last Name</div></th>
										<th style="width: 20%" class=""><div>First Name</div></th>
										<th style="width: 30%" class=""><div> Email</div></th>
										<th style="width: 25%" ><div> Status</div></th>
										<th> </th>
									</tr>
								</thead>	
								<tbody>
									<?php foreach( $users as $participant_item ): 
										if( isset( $participant_item ) ){ 
										$ask = $participant_item['user_id'];
										$ask2 = $participant_item['course_id'];
										$cancelledOrNot = 0;
										
										$query4 = $this->db->get_where('cancelled', array('course_id' => $ask2, 'user_id' => $ask) );
										$array4 = $query4->row_array();
										
										if( !empty($array4['id']) ){
											$select = "U.username, U.firstname, U.lastname, U.id";
											$from = "cancelled Ca, courses C, users U";
											$where = "U.id = $ask AND Ca.user_id = $ask AND Ca.course_id = $ask2";
											
											$this->db->select( $select );
											$this->db->from( $from );
											$this->db->where( $where );
											
											$query = $this->db->get();
											$array = $query->row_array();
										}
										else{
											$cancelledOrNot = 1; // 1 = meaning not cancelled
											$query = $this->db->get_where('users', array('id' => $ask) );
											$array = $query->row_array();
										}	
									?>
									<div><a href="#">						
									<tr class="linka">
									<?php if( $cancelledOrNot ){?>
									<td class="buttontable">
											<?php	
												$var = 0;
												$query = $this->db->get_where('users', array('role' => 2));
												$array2 = $query->row_array();
												$set = 0;
												
												if( !empty($array2['id']) ){
													$set = 1;
													$query1 = $this->db->get_where('cancelled', array('user_id' => $participant_item['user_id'], 'course_id' => $ask2));
													$array1 = $query1->row_array();
													if( !empty($array1['id']) && $array1['refunded'] == 1 ){
														echo "<center class='refund'>For Refund</center>";	
														$var = -1;
													}	
													else{
														$query = $this->db->get_where('payment', array( 'course_id' => $ask2, 'user_id' => $participant_item['user_id']));
														$array3 = $query->row_array();
														
														if( !empty($array3['id']) )
															$var = 1;
														else if( $cancelledOrNot )
															$var = 0;
													}	
												}
											
												if($var == 1){										
													echo "<input style='padding: 0px'; onMouseOver=\"ddrivetip('Validated', '', 60)\"; onMouseOut=\"hideddrivetip()\" class='button_smallb' type='submit' name='submit' value='V' disable/>";
												}	
												else {
													$this->load->helper('form');									
													echo validation_errors(); 
													echo form_open('validation/validate');
													echo "<input type='hidden' name='temp' value='".$array['id']."' />";
													echo "<input type='hidden' name='cbn' value='0' />";	
													echo "<input type='hidden' name='manager' value='1' />";
													echo "<input style='padding: 0px'; onMouseOver=\"ddrivetip('For Validation', '', 80)\"; onMouseOut=\"hideddrivetip()\" class='button_smalla' type='submit' name='submit' value='V'/>";
													echo"</form>";
												}
											}
											?>
									</td>
									<?php }?>			
									<td class="dataf"><a href="#"><div><center><?php echo $array['lastname']?></center></div></a></td>
									<td class="dataf"><a href="#"><div><center><?php echo $array['firstname']?></center></div></a></td>
									<td class="dataf"><a href="#"><div><center><?php echo $array['username']?> <center></div></a></td>
									<td class="dataf">
										<?php 											
											if( $set ){
												if( $var == -1 )
													echo "<center class='refund'>For Refund</center>";	
												else{													
													if( $var == 1 )
														echo "<center>Validated</center>";
													else if( $var == 0 )
														echo "<center>For Validation</center>";
													else{
														echo "<center>FREE RESERVATIONS</center>";
													}
												}	
											}
										?>
									</td>	
									</tr></a></div>
									<?php endforeach ?>	
								</tbody>
							</table>
						</div>
					</td>
				</tr>
			</table>
		
			</div>
				
			<!----PAGE CONTENT END------->
			<?php } ?>
			</table>
<!---------------PAGE CONTENT-------------------------->						
		</td>
	</tr>

</table>

</div>
<div id="dhtmltooltip"></div>
<script language="javascript" src="<?php echo base_url(); ?>js/tooltip.js" type="text/javascript"></script>
