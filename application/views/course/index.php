
<style type="text/css">
	.red {
		color: red;
		font-size: 14px;
		margin-left: 233px; margin-top:5px; 
	}
</style>

<script type="text/javascript">
	window.setTimeout("closeHelpDiv();", 3000);
	function closeHelpDiv(){
		document.getElementById("helpdiv").style.display= "none";
	}

	window.setTimeout("closeHelpDiv_2();", 3000);
	function closeHelpDiv_2(){
		document.getElementById("helpdiv_2").style.display= "none";
	}
</script>

<div id="editModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header palette-nephritis">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="text-white">Edit Course</h4>
  </div>
  		<?php 
		$this->load->helper('form');
		$class = array('class' => 'form-horizontal');
		echo form_open_multipart('course/save', $class); ?>	
  	<div class="modal-body">	
    	<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">Course Name</label>
		  <div class="controls">
		    <textarea style="white-space:pre-wrap; height: auto! important;" required placeholder="Required" type="textarea" id="name" name="name" value="" ></textarea>
		  </div>
		</div>
		<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">Description</label>
		  <div class="controls">
		    <textarea style="white-space:pre-wrap; height: auto! important;" required placeholder="Required" type="textarea" id="description" name="description" value="" ></textarea>
		  </div>
		</div>
		<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">Objectives</label>
		  <div class="controls">
		    <textarea style="white-space:pre-wrap; height: auto! important;" required placeholder="Required" type="textarea" id="objectives" name="objectives" value="" ></textarea>
		  </div>
		</div>
		<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">Start Date</label>
		  <div class="controls">
		    <input class ="pick" type="text" id="startDate" name="startDate" required placeholder="Required" value="<?php echo set_value('startDate');?>" required readonly />
		    <div id="error_date" class="red" style="display:none">Start Date should before End Date</div>
		  </div>
		</div>
		<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">End Date</label>
		  <div class="controls">
		    <input class ="pick" type="text" id="endDate" name="endDate" required placeholder="Required" value="<?php echo set_value('endDate');?>" required readonly />
		  </div>
		</div>
		<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">Start Time</label>
		  <div class="controls">
		    <div class="bootstrap-timepicker">
				<input class="time" type="text" name="startTime" id="startTime" required placeholder="Required" value="<?php echo set_value('startTime');?>" readonly />
				<div id="error_time" class="red" style="display:none">Start Time should before End Time</div>				
			</div>
		  </div>
		</div>
		<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">End Time</label>
		  <div class="controls">
		    <div class="bootstrap-timepicker">
				<input class="time" type="text" name="endTime" id="endTime" required placeholder="Required" value="<?php echo set_value('endTime');?>" readonly />					
			</div>
		  </div>
		</div>
		<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">Venue</label>
		  <div class="controls">
		    <textarea style="white-space:pre-wrap; height: auto! important;" placeholder="Required" required type="textarea" id="venue" name="venue" value="" ></textarea>
		  </div>
		</div>
		<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">Attendees</label>
		  <div class="controls">
		    <textarea style="white-space:pre-wrap; height: auto! important;" required placeholder="Required" type="textarea" id="attendees" name="attendees" value="" ></textarea>
		  </div>
		</div>
		<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">Available</label>
		  <div class="controls">
		    <input type="number" min="0" id="available" required placeholder="Required" name="available" value="" />
		  </div>
		</div>
		<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">Cost</label>
		  <div class="controls">
		    <input type="number" min="0" id="cost" required placeholder="Required" name="cost" value="" />
		  </div>
		</div>
		<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">Food Expenses</label>
		  <div class="controls">
		  	<input type="number" min="0" id="food" name="food" required placeholder="Required" value="" />
		    <textarea style="white-space:pre-wrap; height: auto! important; margin-left: 41.51%; margin-top:5px; " required placeholder="Required" rows="5" id="foodRemarks" name="foodRemarks" value="" ></textarea>
		  </div>
		</div>
		<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">Land Transportation</label>
		  <div class="controls">
		  	<input type="number" min="0" id="transport" name="transport" required placeholder="Required" value="" />
		    <textarea style="white-space:pre-wrap; height: auto! important; margin-left: 41.51%; margin-top:5px; " required placeholder="Required" rows="5" id="transpoRemarks" name="transpoRemarks" value="" ></textarea>
		  </div>
		</div>
		<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">Accomodation</label>
		  <div class="controls">
		  	<input type="number" min="0" id="accoms" name="accoms" required placeholder="Required" value="" />
		    <textarea style="white-space:pre-wrap; height: auto! important; margin-left: 41.51%; margin-top:5px; " required placeholder="Required" rows="5" type="textarea" id="accomRemarks" name="accomRemarks" value="" ></textarea>
		  </div>
		</div>
		<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">Airfare</label>
		  <div class="controls">
		  	<input type="number" min="0" id="air" name="air" required placeholder="Required" value="" />
		    <textarea style="white-space:pre-wrap; height: auto! important; margin-left: 41.51%; margin-top:5px; " required placeholder="Required" rows="5" type="textarea" id="airRemarks" name="airRemarks" value="" ></textarea>
		  </div>
		</div>
 	</div>
  <div class="modal-footer">
    <input type="hidden" id="course_id" name="course_id" value="" />
    <button class="btn btn-success" type="submit" onClick="return checkDateMe()">Save <i class="glyphicon glyphicon-ok"></i></button>
  </div>

	<?php echo form_close(); ?>
</div>

<script type="text/javascript">
	function checkDateMe(){
		var start = document.getElementById('startDate');
    	var end = document.getElementById('endDate');
    	var s_time = document.getElementById('startTime');
    	var e_time = document.getElementById('endTime');
    	var name1 = 'error_date';
    	var name2 = 'error_time';
    	var err = 0;
    	var err2 = 0;

    	if(Date.parse(start.value) > Date.parse(end.value)){
    		document.getElementById(name1).style.display = '';
    		err = 1;
    	}else{
    		document.getElementById(name1).style.display = 'none';
    		err = 0;
    	}

    	if(mil(s_time.value) > mil(e_time.value)){
    		document.getElementById(name2).style.display = '';
    		err2 = 1;
    	}else{
    		document.getElementById(name2).style.display = 'none';
    		err2 = 0;
    	}

    	if( !err && !err2 ) return true;
    	return false;
	}

	function mil(str) {
	  var t = str.split(':')
	  var hh = parseInt(t[0],10);
	  var mm = parseInt(t[1],10)
	  hh += (str.toLowerCase().indexOf('pm')!=-1)?12:0;
	  var d = new Date(2007,0,1,hh,mm,00); // just a date not around daylightsaving
	  return d.getTime();
	}
</script>

<div class="span9" style="margin-left: -30px">
	<div class="content">
		<?php echo form_open('course/search_find');?>
		<div class="control-group">
			<div class="controls">
				<input type="text" autocomplete="off" data-provide='typeahead' data-items='<?php echo $count_All; ?>' data-source='<?php echo $array;?>' required placeholder="Type Here" name="search"/>
				<div class="btn-group btn-input clearfix">
					<select name="type" class="select">
					  <option value="COURSE">COURSE</option>
					  <option value="USER">USER</option> 
					</select>
				</div>
				<button type="submit" class="btn btn-large btn-success">Search</button>
				<?php if(empty($manager) || !$manager){ ?><button type="button" data-toggle="modal" href="#addModal" class="btn btn-large btn-info"><span class="glyphicon glyphicon-saerch"></span>Add Course</button><?php }?>
			</div>
		</div>
		<?php echo form_close();?>
		<hr>
		
		<?php if(!empty($message) && !$error){ ?>
		<div id="helpdiv_2" class="panel panel-danger">
		  <div class="panel-heading">Warning!</div>
		  <div class="panel-body">
		    <?php echo $message; ?>
		  </div>
		</div>
		<?php } ?>

		<?php if(!empty($message) && $error){ ?>
		<div id="helpdiv" class="panel panel-primary">
		  <div class="panel-heading">Successful!</div>
		  <div class="panel-body">
		    <?php echo $message; ?>
		  </div>
		</div>
		<?php } ?>

		<?php
			$set = 0;
			for( $i = 0; $i < $count; $i++ ){
				date_default_timezone_set("Asia/Manila");
				$date = date('Y-m-d');
				if( $start[$i] > $date && $end[$i] > $date ){	
					$set = 1;
					break;
				}
			}
			if( $set ){
		?>
			<div class="panel panel-success">
			  <div class="panel-heading"><?php if(isset($search)){ ?>Search Results -- <?php }?>Upcoming Courses</div>

			  <table class="table table-striped">
			    <thead>	
					<tr>
						<th style="width: 3%"></th>
						<th style="width: 3%"></th>
						<th style="width: 17%"><div><center>Name</center></div></th>
						<th style="width: 17%" ><div><center>Description</center></div></th>										
						<th style="width: 13%"><div><center>Start</center></div></th>
						<th style="width: 13%"><div><center>End</center></div></th>
						<th style="width: 12%"><div><center>Venue</center></div></th>
						<th style="width: 10%"><div><center>Cost</center></div></th>
						<th style="width: 12%" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Reserved | Available | Paid"><div><center>R | A | P</center></div></th>
					</tr>
				</thead>
				<tbody>	
					<?php for( $i = 0; $i < $count; $i++ ): ?>
					<?php
						date_default_timezone_set("Asia/Manila");
						$date = date('Y-m-d');															
						if( $start[$i] > $date && $end[$i] > $date ){											
					?>
					<div><a href="#">
					<tr  class="linka">	
						<td class="buttontable">
							<button style='padding: 6px';
								data-course="<?php echo $id[$i]; ?>"
								data-name="<?php echo $name[$i]; ?>" 
								data-description="<?php echo $description[$i]; ?>"
								data-starttime="<?php echo date('h:i A', strtotime($startTime[$i])); ?>"
								data-objectives="<?php echo $objectives[$i]; ?>"
								data-endtime="<?php echo date('h:i A', strtotime($endTime[$i])); ?>"
								data-reserved="<?php echo $reserved[$i]; ?>"
								data-venue="<?php echo $venue[$i]; ?>"
								data-start="<?php echo date('M d, Y', strtotime($start[$i])); ?>"
								data-end="<?php echo date('M d, Y', strtotime($end[$i])); ?>"
								data-cost="<?php echo $cost[$i]; ?>"
								data-available="<?php echo $available[$i]; ?>"
								data-attendees="<?php echo $attendees[$i]; ?>"
								data-food="<?php echo $food[$i]; ?>"
								data-foodrem="<?php echo $foodRemarks[$i]; ?>"
								data-transpo="<?php echo $landTranspo[$i]; ?>"
								data-land="<?php echo $landRemarks[$i]; ?>"
								data-air="<?php echo $airfare[$i]; ?>"
								data-airremarks="<?php echo $airfareRemarks[$i]; ?>"
								data-accommodations="<?php echo $accommodation[$i]; ?>"
								data-accommorem="<?php echo $accommodationRemarks[$i]; ?>"

							data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Edit" class='btn btn-mini showMe btn-warning getAll' type='submit' name='submit'><i class="glyphicon glyphicon-pencil"></i></button>
							
						</td>
						<td class="buttontable">
							<?php 		
									$this->load->helper('date');
									$this->load->helper('form');
									
									date_default_timezone_set("Asia/Manila");
									$var1 = date('Y-m-d G:i:s');
									
									echo validation_errors();
									echo form_open('course/cancelledStatus');
										echo "<input type='hidden' name='course_id' value='".$id[$i]."' />";
										echo "<input type='hidden' name='user_id' value='".$userid."'/>";
										echo "<input type='hidden' name='date' value='".$var1."'/>";
										echo "<input type='hidden' name='refunded' value='".$paid[$i]."'/>";												
							?>
							<button style='padding: 5px'; data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Cancel" onclick="return confirm('Are you sure you want to proceed?')" class='btn btn-mini btn-danger' type='submit' name='submit'><i class="glyphicon glyphicon-remove"></i></button>								 					
							
						</td>
						<?php
							$temp = strtotime($start[$i]);
							$var1 = date('M d, Y', $temp).PHP_EOL;
							
							$temp = strtotime($end[$i]);
							$var2 = date('M d, Y', $temp).PHP_EOL;
							if( $reserved[$i] > 0 || $paid[$i] > 0){ 										
						?>								
						<td class="dataf"><a href="<?php echo base_url().'index.php/course/process/'.$id[$i];?>"><center><div><?php echo $name[$i];?></div></center></a></td>								
						<td class="dataf"><center><div><?php echo $description[$i];?></div></center></td>								
						<td class="dataf"><center><div><?php echo $var1; ?></div></center></td>
						<td class="dataf"><center><div><?php echo $var2; ?></div></center></td>
						<td class="dataf"><center><div><?php echo $venue[$i];?></div></center></td>
						<td class="dataf"><center><div><?php echo $cost[$i];?></div></center></td>
						<td class="dataf"><center><div><?php echo $reserved[$i];?> | <?php echo ($available[$i] - ($reserved[$i]+$paid[$i]) );?> | <?php echo $paid[$i];?></div></center></td>							
						<?php }
							else{
						?>														
						<td class="dataf"><a href="#"><center><div><?php echo $name[$i];?></div></center></a></td>
						<td class="dataf"><center><div><?php echo $description[$i];?></div></center></td>
						<td class="dataf"><center><div><?php echo $var1; ?></div></center></td>
						<td class="dataf"><center><div><?php echo $var2; ?></div></center></td>
						<td class="dataf"><center><div><?php echo $venue[$i];?></div></center></td>
						<td class="dataf"><center><div><?php echo $cost[$i];?></div></center></td>
						<td class="dataf"><center><div><?php echo $reserved[$i];?> | <?php echo ($available[$i] - ($reserved[$i]+$paid[$i]) );?> | <?php echo $paid[$i];?></div></center></a></td>	
						<?php }?>
						
					</tr></a></div>
					<?php
						echo "</form>";
						}
					?>
					<?php endfor ?>	
				</tbody>
			  </table>
			</div>
		<?php }?>

		<?php
			$set = 0; $set2 = 0;
			for( $i = 0; $i < $count; $i++ ){
				date_default_timezone_set("Asia/Manila");
				$date = date('Y-m-d');
											
				if( $start[$i] <= $date && $end[$i] >= $date ){
					$set2 = 1;
					if( date('h:m:s',time()) < date('h:m:s', strtotime($endTime[$i])) ){
						$set = 1;							
						break;
					}
				}
			}
			if( $set || $set2 ){
		?>
			<div class="panel panel-success">
			  <div class="panel-heading"><?php if(isset($search)){ ?>Search Results -- <?php }?>Ongoing Courses</div>
			  <table class="table table-striped">
			    <thead>	
					<tr>
						<th style="width: 3%"></th>
						<th style="width: 3%"></th>
						<th style="width: 17%"><div><center>Name</center></div></th>
						<th style="width: 17%" ><div><center>Description</center></div></th>										
						<th style="width: 13%"><div><center>Start</center></div></th>
						<th style="width: 13%"><div><center>End</center></div></th>
						<th style="width: 12%"><div><center>Venue</center></div></th>
						<th style="width: 10%"><div><center>Cost</center></div></th>
						<th style="width: 12%" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Reserved | Available | Paid"><div><center>R | A | P</center></div></th>
					</tr>
				</thead>
				<tbody>	
					<?php for( $i = 0; $i < $count; $i++ ): 
						date_default_timezone_set("Asia/Manila");
						$date = date('Y-m-d');
						$set1 = 0; $set3 = 0;											
						if( $start[$i] <= $date && $end[$i] >= $date ){
							$set1 = 1;
							if( date('h:m:s',time()) < date('h:m:s', strtotime($endTime[$i])) ){
								$set3 = 1;
							}
						}
						if($set1 || $set3){						
					?>
					
					<tr class="linka" >
						<td>
							<button style='padding: 5px'; 
								data-course="<?php echo $id[$i]; ?>"
								data-name="<?php echo $name[$i]; ?>" 
								data-description="<?php echo $description[$i]; ?>"
								data-starttime="<?php echo date('h:i A', strtotime($startTime[$i])); ?>"
								data-objectives="<?php echo $objectives[$i]; ?>"
								data-endtime="<?php echo date('h:i A', strtotime($endTime[$i])); ?>"
								data-reserved="<?php echo $reserved[$i]; ?>"
								data-venue="<?php echo $venue[$i]; ?>"
								data-start="<?php echo date('M d, Y', strtotime($start[$i])); ?>"
								data-end="<?php echo date('M d, Y', strtotime($end[$i])); ?>"
								data-cost="<?php echo $cost[$i]; ?>"
								data-available="<?php echo $available[$i]; ?>"
								data-attendees="<?php echo $attendees[$i]; ?>"
								data-food="<?php echo $food[$i]; ?>"
								data-foodrem="<?php echo $foodRemarks[$i]; ?>"
								data-transpo="<?php echo $landTranspo[$i]; ?>"
								data-land="<?php echo $landRemarks[$i]; ?>"
								data-air="<?php echo $airfare[$i]; ?>"
								data-airremarks="<?php echo $airfareRemarks[$i]; ?>"
								data-accommodations="<?php echo $accommodation[$i]; ?>"
								data-accommorem="<?php echo $accommodationRemarks[$i]; ?>"
							data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Edit" class='btn btn-mini showMe btn-warning getAll' type='button' name='submit' ><i class="glyphicon glyphicon-pencil"></i></button>									 					
							
						</td>
						<td class="buttontable">
							<?php 		
									$this->load->helper('date');
									$this->load->helper('form');
									
									date_default_timezone_set("Asia/Manila");
									$var1 = date('Y-m-d G:i:s');
									
									echo validation_errors();
									echo form_open('course/cancelledStatus');
										echo "<input type='hidden' name='course_id' value='".$id[$i]."' />";
										echo "<input type='hidden' name='user_id' value='".$userid."'/>";
										echo "<input type='hidden' name='date' value='".$var1."'/>";
										echo "<input type='hidden' name='refunded' value='".$paid[$i]."'/>";												
							?>
							<button style='padding: 5px'; data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Cancel" onclick="return confirm('Are you sure you want to proceed?')" class='btn btn-mini btn-danger' type='submit' name='submit' ><i class="glyphicon glyphicon-remove"></i></button>									 																
						</td>
						<?php 
							
							$temp = strtotime($start[$i]);
							$var1 = date('M d, Y', $temp).PHP_EOL;
							
							$temp = strtotime($end[$i]);
							$var2 = date('M d, Y', $temp).PHP_EOL;
							if( $reserved[$i] > 0 || $paid[$i] > 0){ 
						
						?>								
						<td class="dataf"><a href="<?php echo base_url().'index.php/course/process/'.$id[$i];?>"><center><div><?php echo $name[$i];?></div></center></a></td>								
						<td class="dataf"><center><div><?php echo $description[$i];?></div></center></td>								
						<td class="dataf"><center><div><?php echo $var1; ?></div></center></td>
						<td class="dataf"><center><div><?php echo $var2; ?></div></center></td>
						<td class="dataf"><center><div><?php echo $venue[$i];?></div></center></td>
						<td class="dataf"><center><div><?php echo $cost[$i];?></div></center></td>
						<td class="dataf"><center><div><?php echo $reserved[$i];?> | <?php echo ($available[$i] - ($reserved[$i]+$paid[$i]) );?> | <?php echo $paid[$i];?></div></center></td>							
						<?php }
							else{
						?>														
						<td class="dataf"><a href="#"><center><div><?php echo $name[$i];?></div></center></a></td>
						<td class="dataf"><center><div><?php echo $description[$i];?></div></center></td>
						<td class="dataf"><center><div><?php echo $var1; ?></div></center></td>
						<td class="dataf"><center><div><?php echo $var2; ?></div></center></td>
						<td class="dataf"><center><div><?php echo $venue[$i];?></div></center></td>
						<td class="dataf"><center><div><?php echo $cost[$i];?></div></center></td>
						<td class="dataf"><center><div><?php echo $reserved[$i];?> | <?php echo ($available[$i] - ($reserved[$i]+$paid[$i]) );?> | <?php echo $paid[$i];?></div></center></td>	
						<?php }?>
						<?php
							echo "</form>";
							} 
						?>
					</tr>
					<?php endfor ?>	
				</tbody>
			  </table>
			</div>


		<?php }?>
	</div>
</div>
<script>
	$(document).ready(function() 
    { 
        $('.pick').datepicker({
			todayBtn: "linked",
		    multidate: false,
		    format: "M d, yyyy",
		    autoclose: true,
		    todayHighlight: true
		});
		$('.time').timepicker({
      		pickDate: false,
      		autoclose: true,
			template: 'modal',
		});
    } );

   $(document).on("click", ".showMe", function () {
		$('#editModal').modal('show');
	});	

    $(document).on("click", ".getAll", function () {
	    var course_id = $(this).data('course');
	    var coursename = $(this).data('name');
	    var desc = $(this).data('description');
	    var stime = $(this).data('starttime');
	    var objectives = $(this).data('objectives');
	    var etime = $(this).data('endtime');
	    var res = $(this).data('reserved');
	    var ven = $(this).data('venue');
	    var start_s = $(this).data('start');
	    var end_s = $(this).data('end');
	    var cost_s = $(this).data('cost');
	    var avail = $(this).data('available');
	    var atten = $(this).data('attendees');
	    var food_s = $(this).data('food');
	    var foodRem = $(this).data('foodrem');
	    var trans = $(this).data('transpo');
	    var land = $(this).data('land');
	    var air = $(this).data('air');
	    var airremarks = $(this).data('airremarks');
	    var accom_s = $(this).data('accommodations');
	    var accommorem = $(this).data('accommorem');

	    $(".modal-footer #course_id").val( course_id );
	    document.getElementById("name").value = coursename;
	    document.getElementById("description").value = desc;
	    document.getElementById("objectives").value = objectives;
	    $(".modal-body #startDate").val( start_s );
	    $(".modal-body #endDate").val( end_s );
	    $(".modal-body #startTime").val( stime );
	    $(".modal-body #endTime").val( etime );
	    document.getElementById("venue").value = ven;
	    document.getElementById("attendees").value = atten;
	    $(".modal-body #available").val( avail );
	    $(".modal-body #cost").val( cost_s );
	    $(".modal-body #food").val( food_s );
	    document.getElementById("foodRemarks").value = foodRem;
	    $(".modal-body #transport").val( trans );
	    document.getElementById("transpoRemarks").value = land;
	    $(".modal-body #accoms").val( accom_s );
	    document.getElementById("accomRemarks").value = accommorem;
	    $(".modal-body #air").val( air );
	    document.getElementById("airRemarks").value = airremarks;
	});
</script>
</div>
<div id="addModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header palette-wisteria">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="text-white">Add Course</h4>
  </div>
  		<?php 
		$this->load->helper('form');
		$class = array('class' => 'form-horizontal');
		echo form_open_multipart('course/addition', $class); ?>	
  	<div class="modal-body">	
    	<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">Course Name</label>
		  <div class="controls">
		    <textarea style="white-space:pre-wrap; height: auto! important;" required placeholder="Required" type="textarea" name="name" value="" ></textarea>
		  </div>
		</div>
		<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">Description</label>
		  <div class="controls">
		    <textarea style="white-space:pre-wrap; height: auto! important;" required placeholder="Required" type="textarea" name="description" value="" ></textarea>
		  </div>
		</div>
		<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">Objectives</label>
		  <div class="controls">
		    <textarea style="white-space:pre-wrap; height: auto! important;" required placeholder="Required" type="textarea" name="objectives" value="" ></textarea>
		  </div>
		</div>
		<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">Start Date</label>
		  <div class="controls">
		    <input class ="pick" type="text" id="add_start" name="startDate" required placeholder="Required" value="<?php echo set_value('startDate');?>" required readonly />
		    <div id="length_error_date" class="red" style="display:none">Start Date should before End Date</div>
		  </div>
		</div>
		<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">End Date</label>
		  <div class="controls">
		    <input class ="pick" type="text" id="add_end" name="endDate" required placeholder="Required"  value="<?php echo set_value('endDate');?>" required readonly />
		  </div>
		</div>
		<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">Start Time</label>
		  <div class="controls">
		    <div class="bootstrap-timepicker">
				<input class="time" type="text" id="add_startTime" name="startTime" required placeholder="Required"  value="<?php echo set_value('startTime');?>" readonly />
				<div id="length_error_time" class="red" style="display:none">Start Time should before End Time</div>					
			</div>
		  </div>
		</div>
		<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">End Time</label>
		  <div class="controls">
		    <div class="bootstrap-timepicker">
				<input class="time" type="text" id="add_endTime" name="endTime" required placeholder="Required" value="<?php echo set_value('endTime');?>" readonly />					
			</div>
		  </div>
		</div>
		<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">Venue</label>
		  <div class="controls">
		    <textarea style="white-space:pre-wrap; height: auto! important;" required placeholder="Required" type="textarea" name="venue" value="" ></textarea>
		  </div>
		</div>
		<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">Attendees</label>
		  <div class="controls">
		    <textarea style="white-space:pre-wrap; height: auto! important;" required placeholder="Required" type="textarea" name="attendees" value="" ></textarea>
		  </div>
		</div>
		<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">Available</label>
		  <div class="controls">
		    <input type="number" min="0" name="available" required placeholder="Required" value="" />
		  </div>
		</div>
		<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">Cost</label>
		  <div class="controls">
		    <input type="number" min="0" name="cost" required placeholder="Required" value="" />
		  </div>
		</div>
		<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">Food Expenses</label>
		  <div class="controls">
		  	<input type="number" min="0" name="food" required placeholder="Required" value="" />
		    <textarea style="white-space:pre-wrap; height: auto! important; margin-left: 41.51%; margin-top:5px; " required placeholder="Required" rows="5" name="foodRemarks" value="" ></textarea>
		  </div>
		</div>
		<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">Land Transportation</label>
		  <div class="controls">
		  	<input type="number" min="0" name="transport" value="" required placeholder="Required" />
		    <textarea style="white-space:pre-wrap; height: auto! important; margin-left: 41.51%; margin-top:5px; " required placeholder="Required" rows="5" name="transpoRemarks" value="" ></textarea>
		  </div>
		</div>
		<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">Accomodation</label>
		  <div class="controls">
		  	<input type="number" min="0" name="accoms" value="" required placeholder="Required" />
		    <textarea style="white-space:pre-wrap; height: auto! important; margin-left: 41.51%; margin-top:5px; " required placeholder="Required" rows="5" type="textarea" name="accomRemarks" value="" ></textarea>
		  </div>
		</div>
		<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">Airfare</label>
		  <div class="controls">
		  	<input type="number" min="0" name="air" value="" required placeholder="Required" />
		    <textarea style="white-space:pre-wrap; height: auto! important; margin-left: 41.51%; margin-top:5px; " required placeholder="Required" rows="5" type="textarea" name="airRemarks" value="" ></textarea>
		  </div>
		</div>
 	</div>
  <div class="modal-footer">
    <input type="hidden" id="course_id" name="course_id" value="" />
    <button class="btn" style="background: #8e44ad" type="submit" onClick="return checkDate_add()" >Save <i class="glyphicon glyphicon-plus"></i></button>
  </div>

	<?php echo form_close(); ?>
</div>

<script>
    $(function() {
	    var tooltips = $( "[title]" ).tooltip();
	    $(document)(function() {
	    	tooltips.tooltip( "open" );
	    })
    });

    function checkDate_add(){
    	var start = document.getElementById('add_start');
    	var end = document.getElementById('add_end');
    	var s_time = document.getElementById('add_startTime');
    	var e_time = document.getElementById('add_endTime');
    	var name1 = 'length_error_date';
    	var name2 = 'length_error_time';
    	var err = 0;
    	var err2 = 0;

    	if(Date.parse(start.value) > Date.parse(end.value)){
    		document.getElementById(name1).style.display = '';
    		err = 1;
    	}else{
    		document.getElementById(name1).style.display = 'none';
    		err = 0;
    	}

    	if(mil(s_time.value) > mil(e_time.value)){
    		document.getElementById(name2).style.display = '';
    		err2 = 1;
    	}else{
    		document.getElementById(name2).style.display = 'none';
    		err2 = 0;
    	}

    	if( !err && !err2 ) return true;
    	return false;
    }

</script>
