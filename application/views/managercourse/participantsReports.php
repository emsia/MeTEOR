<head>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/styleGeneral.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/view.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/boot.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/view2.css" type="text/css">
<link href="<?php echo base_url(); ?>css/css_recipes.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/anytime.css" type="text/css"  />

<script src="<?php echo base_url(); ?>js/jquery.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap-timepicker.js"></script>
<script src="<?php echo base_url(); ?>js/jquery_tablesorter.js"></script> 
<script src="<?php echo base_url(); ?>js/bootstrap.js"></script> 
<script src="<?php echo base_url(); ?>js/bootstrap-modal.js"></script> 


<link href="<?php echo base_url('css/bootstrap-datepicker.css') ?>" rel="stylesheet">
<link href="<?php echo base_url('css/bootstrap-timepicker.css') ?>" rel="stylesheet">
</head>

<div id="body_box">
<table id="body_table" border="0">

	<tr>
	
		<td id="navigation">
			<a href="<?php echo base_url().'index.php/managercourse';?>">VIEW</a> <br/>
			<a href="<?php echo base_url().'index.php/managercourse/cancelled';?>">CANCEL</a> <br/>
			<a href="<?php echo base_url().'index.php/managercourse/reports';?>" style="color: #7b1113;">EVENT FORMS</a> <br/>
			<a href="<?php echo base_url().'index.php/course/reports_chart';?>">REPORTS</a> <br/>
			<a href="<?php echo base_url().'index.php/managercourse/upload';?>">UPLOAD</a> <br/>
			<a href="<?php echo base_url().'index.php/managercourse/SURVEY';?>">EVALUATION RESULTS</a> <br/>	
			<a href="<?php echo base_url().'index.php/managercourse/origsurveyResult';?>">SURVEY RESULTS</a> <br/>
			<a href="<?php echo base_url().'index.php/managercourse/request';?>">REQUEST</a> <br/>
		</td>
		
		<td id="ruler"></td>

		<td id="pagefield">

		
			<?php $this->load->helper('form');
				echo form_open('managercourse/reports_search'); ?>				
				&nbsp;&nbsp;<b style="font-size: 19px;" >FROM</b>&nbsp;
				<input id="start" class="textf input-medium pick" type="text" placeholder="Required" name ="starting"  value="<?php echo set_value('start');?>" readonly />
				&nbsp;<b style="font-size: 19px;">TO</b>
				<input id="end" class="textf input-medium pick" type="text" placeholder="Required" size="15" name ="ending"  value="<?php echo set_value('end');?>" readonly />
				&nbsp;&nbsp;&nbsp;
				<b style="font-size: 19px;">FILTER BY</b>
				<select name="type" class="textf">
				  <option value="COURSE">COURSE</option>
				  <option value="USER">USER</option> 
				</select>
				&nbsp;&nbsp;
				<?php $list = array( '-- Dept --', 'CM', 'EIS', 'FMIS', 'HARDWARE', 'HRIS', 'IS', 'PS', 'SAIS', 'SPCMIS', 'TRAINING', '-- ALL --'); ?>
				<select name="dept" class="textf">
					<?php for( $i = 0; $i <= 11; $i++ ){ ?>
					<option value="<?php echo $list[$i]; ?>"><?php echo $list[$i]; ?></option>				  
					<?php } ?>
				</select>
				&nbsp;&nbsp;&nbsp; 	
				<input class="button_login" type="submit" name="submit" value="Search" />
			<?php echo form_close();?>

			<table border="0">	
				<?php 
					if( !empty($users) ) {
				?>	
			<div id="profileInfo">	
				<table class="viewtable" border="0">
					<tr>
						<th style="width: 100%" colspan="5" class=""><div style="border:none;background-color: #cccc99; color: #a42125">COURSE NAME & DESCRIPTION</div></th>
					</tr>
					<div>
						<tr>
							<td class="dataf" ><center><div ><?php echo $name;?> : <?php echo $description;?></div></center></td>
						</tr>
					</div>
				<tr>
					<td>
						<div id="profileInfo">
							<table class="viewtable" border="0" id="addCourse">
								<thead>	
									<tr>
										<th style="width: 21%" class=""><div>Last Name</div></th>
										<th style="width: 21%" class=""><div>First Name</div></th>
										<th style="width: 21%" class=""><div> Email</div></th>
										<th style="width: 21%" ><div>Status</div></th>
										<th style="width: 16%" ><div>Payment</div></th>
										<th> </th>
									</tr>
								</thead>	
								<tbody>
									<?php for( $i = 0; $i < $count; $i++ ): 
										$cancelledOrNot = 1;
										$set = 0;
										
										for( $j = 0; $j < $decount; $j++ ){
											if( $tag[$j] == $user_id[$i] ){
												$cancelledOrNot = 0;
												break;
											}
										}	
									?>
									<div><a href="#">				
									<tr class="linka">
									<?php if( $cancelledOrNot ){?>
											<?php	
												$var = 0; $var2 = 0;
												$query = $this->db->get_where('users', array('role' => 2));
												$array2 = $query->row_array();
												
												if( !empty($array2['id']) ){
													$set = 1;
													$query1 = $this->db->get_where('cancelled', array('user_id' => $user_id[$i], 'course_id' => $course_id));
													$array1 = $query1->row_array();
													
													if( !empty($array1['id']) && $array1['refunded'] == 1 ){
														echo "<center class='refund'>For Refund</center>";	
														$var = -1;
													}	
													else{
														$query = $this->db->get_where('payment', array( 'course_id' => $course_id, 'user_id' => $user_id[$i]));
														$array3 = $query->row_array();
														
														if( !empty($array3['id']) )
															$var = 1;
														else if( $cancelledOrNot )
															$var = 0;
														if( !empty($array3['remarks'])	&& $array3['remarks'] === "free" )
															$var2 = 1;
													}	
												}
									}?>
									<td class="dataf"><a href="#"><div><center><?php echo $lastname[$i];?></center></div></a></td>
									<td class="dataf"><a href="#"><div><center><?php echo $firstname[$i];?></center></div></a></td>
									<td class="dataf"><a href="#"><div><center><?php echo $username[$i];?> <center></div></a></td>
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
									<td class="dataf">
										<?php 											
											if( $var2 ){
												echo "<center class='refund'>Free</center>";	
											}else echo "<center>Regular</center>";
										?>
									</td>										
									</tr></a></div>
									<?php endfor ?>	
								</tbody>
							</table>							
						</div>
						<?php echo form_open('managercourse/printOne');?>
						<input type="hidden" name="course_id" value="<?php echo $id;?>"/>
						<input type="hidden" name="name" value="<?php echo $name;?>"/>
						<input type="hidden" name="description" value="<?php echo $description;?>"/>
						<input type="hidden" name="starting1" value="<?php echo $starting1;?>" />
						<input type="hidden" name="ending1" value="<?php echo $ending1;?>" />
						<center><button class="button_login" name="print" type="submit">Print</button></center>
						<?php echo form_close();?>
					</td>
				</tr>
			</table>
		
			</div>
				
			<?php } ?>
			</table>					
		</td>
	</tr>

</table>

<script>
	$(document).ready(function() 
    { 
        $("#addCourse").tablesorter(); 
		$('.pick').datepicker({
			dateFormat: "M d, yy"
		});
		$('#startTime').timepicker();
        $('#endTime').timepicker();
    } );
</script>

</div>
<div id="dhtmltooltip"></div>
<script language="javascript" src="<?php echo base_url(); ?>js/tooltip.js" type="text/javascript"></script>
