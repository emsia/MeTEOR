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
			<?php if( !$man ){ ?>
				<a href="<?php echo base_url().'index.php/course';?>" >VIEW</a> <br/>
				<a href="<?php echo base_url().'index.php/course/add';?>">ADD</a> <br/>
				<a href="<?php echo base_url().'index.php/course/cancelled';?>">CANCEL</a> <br/>
				<a href="<?php echo base_url().'index.php/course/reports';?>"style="color: #7b1113;">EVENT FORMS</a> <br/>
				<a href="<?php echo base_url().'index.php/course/reports_chart';?>">REPORTS</a> <br/>
				<a href="<?php echo base_url().'index.php/course/upload';?>">UPLOAD</a> <br/>
				<a href="<?php echo base_url().'index.php/course/SURVEY';?>">EVALUATION RESULTS</a> <br/>
				<a href="<?php echo base_url().'index.php/course/origsurveyResult';?>">SURVEY RESULTS</a> <br/>
				<a href="<?php echo base_url().'index.php/course/request';?>">REQUEST</a> <br/>
			<?php } else {?>
				<a href="<?php echo base_url().'index.php/managercourse';?>" >VIEW</a> <br/>
				<a href="<?php echo base_url().'index.php/managercourse/cancelled';?>">CANCEL</a> <br/>
				<a href="<?php echo base_url().'index.php/managercourse/reports';?>"style="color: #7b1113;">EVENT FORMS</a> <br/>
				<a href="<?php echo base_url().'index.php/course/reports_chart';?>">REPORTS</a> <br/>
				<a href="<?php echo base_url().'index.php/managercourse/upload';?>">UPLOAD</a> <br/>
				<a href="<?php echo base_url().'index.php/managercourse/surveyResult';?>">EVALUATION RESULTS</a> <br/>
				<a href="<?php echo base_url().'index.php/managercourse/origsurveyResult';?>">SURVEY RESULTS</a> <br/>	
				<a href="<?php echo base_url().'index.php/managercourse/request';?>">REQUEST</a> <br/>
			<?php }?>
		</td>
		
		<td id="ruler"></td>
		
		<td id="pagefield">
		
<!---------------PAGE CONTENT-------------------------->	

			<!----SEARCH BUTTON | SUBJECT TO CHANGE TO FIT CI FRAMEWORK------->
			<?php $this->load->helper('form');
				echo form_open('course/reports_search'); ?>				
				<!--<input class ="textf" type="text" name="search" required/>-->
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
				&nbsp;&nbsp;&nbsp; 	
				<input class="button_login" type="submit" name="submit" value="Search" />
			<?php echo form_close();?>
			<!----SEARCH BUTTON END------->
			<br/>

			<!----PAGE CONTENT------->
			<table class="viewtable" border="0">
						
			<tr class="abclink">
				<?php if( !empty( $error ) ) { ?><td style="color: red"><center><?php echo $error;?></center></td><?php }else{?>
				<td style="color: #a42125"><center>SEARCH RESULTS</center></td><?php }?>
			</tr>
			<tr>
				<td>
					<div id="profileInfo">
						<table class="viewtable" border="0" id="addCourse">
							<thead>	
								<tr>
									<th style="width: 21%"><div>Last Name</div></th>
									<th style="width: 21%"><div>First Name</div></th>
									<th style="width: 21%"><div>Email</div></th>
									<th style="width: 21%"><div>Status</div></th>
									<th style="width: 16%"><div>Payment</div></th>
									<th> </th>
								</tr>
							</thead>
							<tbody>
								<?php for($i=0; $i<$counter; $i++) {?>
									<div><a href = "#"><tr class="linka">
									<?php
										$set = 1; $setPaid = 1; $tag2 = 0; $var = 1; $did = 0;
																
										$queryPaid = $this->db->get_where( 'payment', array('user_id' => $id[$i]) );
										$arrayPaid = $queryPaid->result_array();
										
										foreach( $arrayPaid as $row1 ){
											$did = 1;
											if( !empty($row1['remarks']) && strtolower($row1['remarks']) == "free" )
												continue;
											else if( !empty($row1['remarks']) ){
												$tag2 = 1;
												break;
											}	
										}
										
										if( $did ) $setPaid = 0;
									?>									
									<td class="dataf"><a href="#"><div><center><?php echo $lastname[$i];?></center></div></a></td>
									<td class="dataf"><a href="#"><div><center><?php echo $firstname[$i];?></center></div></a></td>
									<td class="dataf"><a href="#"><div><center><?php echo $username[$i];?> <center></div></a></td>
									<td class="dataf"> 
										<?php 														
											if($validated[$i] == 0 && $refunded[$i] == 0){ echo "<center>For Validation<br>Has Refunded Course(s)</center>"; $var = 0;}
											else if( $validated[$i] == 0 ){ echo "<center>For Validation</center>"; $var = 0;}
											else if($validated[$i] && $refunded[$i] == 0) echo "<center>Validated<br>Has Refunded Course(s)</center>";					
											else if($refunded[$i] == 0) echo "<center>Has Refunded Course(s)</center>";
											else if( ($validated[$i] && $refunded[$i]) && ( $setPaid ) )
												echo "<center>Has No Course(s) Yet</center>";
											else if($validated[$i] == 1) echo "<center>Validated</center>";
										?>
									</td>
									<td class="dataf">
										<?php 	
											if( $var == 0 ) echo "<center>Not Yet Paid</center>";	
											else if( !$tag2 ) echo "<center class='refund'>Free</center>";	
											else echo "<center>Regular</center>";
										?>
									</td>
									</tr></a></div> 
								<?php } ?>
							</tbody>
						</table>
					</div><?php echo form_open('course/printUsers');?>
							<input type="hidden" name="starting" value="<?php echo $starting1;?>" />
							<input type="hidden" name="ending" value="<?php echo $ending1;?>" />
							<center><button class="button_login" name="print" type="submit">Print</button></center>
							<?php echo form_close();?>					
				</td>
			</tr>
			</table>			
			<!----PAGE CONTENT END------->
			
<!---------------PAGE CONTENT-------------------------->						
		</td>
		
	</tr>

</table>
<script>
	$(document).ready(function() 
    { 
        $("#addCourse").tablesorter(); 
		$('.pick').datepicker({
			dateFormat: "m-d-yy"
		});
		$('#startTime').timepicker();
        $('#endTime').timepicker();
    } );
</script>
</div>
<div id="dhtmltooltip"></div>
<script language="javascript" src="<?php echo base_url(); ?>js/tooltip.js" type="text/javascript"></script>