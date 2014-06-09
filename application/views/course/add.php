<head>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/styleGeneral.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/view.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/boots.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/view2.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/flat-ui.css" type="text/css">
<link href="<?php echo base_url(); ?>css/css_recipes.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/datepicker.css" type="text/css">

<link href="<?php echo base_url('css/bootstrap-datetimepicker.css') ?>" rel="stylesheet">

<script src="<?php echo base_url(); ?>js/jquery.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrapdatepicker.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap-timepicker.js"></script>
<script src="<?php echo base_url(); ?>js/jquery_tablesorter.js"></script> 
<script src="<?php echo base_url(); ?>js/bootstrap.js"></script> 
<script src="<?php echo base_url(); ?>js/bootstrap-modal.js"></script> 

<style>
#myInput::-webkit-input-placeholder {
  color: red;
}
#myInput:-moz-placeholder {
  color: red;
}
#myInput:-ms-input-placeholder {
  color: red;
}
</style>

<script>
	$(document).ready(function() 
    { 
        $("#addCourse").tablesorter(); 
		$('.pick').datepicker({
			minDate: 0,
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
</script>

</head>

<div id="body_box">
<table id="body_table" border="0">

	<tr>
		<td id="navigation">
			<a href="<?php echo base_url().'index.php/course';?>">VIEW</a> <br/>
			<a href="<?php echo base_url().'index.php/course/add';?>" style="color: #7b1113;">ADD</a> <br/>
			<a href="<?php echo base_url().'index.php/course/cancelled';?>">CANCEL</a> <br/>
			<a href="<?php echo base_url().'index.php/course/reports';?>">EVENT FORMS</a> <br/>
			<a href="<?php echo base_url().'index.php/course/reports_chart';?>">REPORTS</a> <br/>
			<a href="<?php echo base_url().'index.php/course/upload';?>">UPLOAD</a> <br/>
			<a href="<?php echo base_url().'index.php/course/SURVEY';?>">EVALUATION RESULTS</a> <br/>
			<a href="<?php echo base_url().'index.php/course/origsurveyResult';?>">SURVEY RESULTS</a> <br/>			
			<a href="<?php echo base_url().'index.php/course/request';?>">REQUEST</a> <br/>
		</td>	
		
		<td id="ruler"></td>
		
		<td id="pagefield">
		<!--------------------- Big CONTENTS ---------------------->
			
			<!--------------------- Contents ---------------------->	
			<table border="0">				
				<?php echo form_open('course/addition');?>	
				<tr class="abclink">
					<?php if( !empty( $error ) ) { ?><td style="list-style: none; color: red"><center><?php echo $error;?></center></td><?php } ?>
				</tr>
					
				<tr style"padding-left: 150px">
					<td >
						<table class="viewtable" border="0" >
							<thead>
							</thead>	
							<tbody  id="addCourse">	
								<tr>
									<th style="width: 15%" class=""><div>Course Name: </div></th>
									<?php $class = (form_error('name') !== '') ? 'textf-error' : 'textf'; ?>
									<td>
									<input type="text" placeholder="required" class="<?php echo $class;?>" name="name" style="width: 469px;" value="<?php echo set_value('name'); ?>" required /><br/>
									</td>
								</tr>
								<tr>
									<th style="width: 15%" class=""><div>Description: </div></th>
									<?php $class = (form_error('description') !== '') ? 'textareaMe-error' : 'textareaMe'; ?>
									<td>
									<textarea class="<?php echo $class;?>" name="description" required placeholder="Required"></textarea>
									<!---- input type="text" placeholder="required" class="<?php echo $class;?>" name="objectives" style="width: 469px;" value="<?php echo set_value('objectives'); ?>" required /><br---->
									</td>		
								</tr>
								<tr>
									<th style="width: 15%" class=""><div>Objectives: </div></th>
									<?php $class = (form_error('objectives') !== '') ? 'textareaMe-error' : 'textareaMe'; ?>
									<td>
									<textarea class="<?php echo $class;?>" name="objectives" required placeholder="Required"></textarea>
									<!---- input type="text" placeholder="required" class="<?php echo $class;?>" name="objectives" style="width: 469px;" value="<?php echo set_value('objectives'); ?>" required /><br---->
									</td>		
								</tr>
								<tr>
									<th style="width: 15%" class=""><div>Start Date: </div></th>
									<?php $class = (form_error('start') !== '') ? 'textf-error pick' : 'textf pick'; ?>
									<td>
									<input type="text" placeholder="required" class="<?php echo $class;?>" id="startDate" name="start" style="width: 469px;" value="<?php echo set_value('start'); ?>" required readonly /><br/>
									</td>
								</tr>
								<tr>
									<th style="width: 15%" class=""><div>End Date: </div></th>
									<?php $class = (form_error('end') !== '') ? 'textf-error pick' : 'textf pick'; ?>								
									<td>
									<input type="text" placeholder="required" class="<?php echo $class;?>" id="endDate" name="end" style="width: 469px;" value="<?php echo set_value('end'); ?>" required readonly /><br/>
									</td>
								</tr>
								<tr>
									<th style="width: 15%" class=""><div>Start Time: </div></th>
									<?php $class = (form_error('startTime') !== '') ? 'textf-error' : 'textf'; ?>
									<td>
										<div class="bootstrap-timepicker">
											<input class="time textf" type="text" placeholder="required" class="<?php echo $class;?>" name="startTime" style="width: 469px;" value="<?php echo set_value('startTime'); ?>" required readonly /><br/>
										</div>
									</td>
								</tr>
								<tr>
									<th style="width: 15%" class=""><div>End Time: </div></th>
									<?php $class = (form_error('endTime') !== '') ? 'textf-error' : 'textf'; ?>
									<td>
										<div class="bootstrap-timepicker">
											<input class="textf time" type="text" placeholder="required" class="<?php echo $class;?>" name="endTime" style="width: 469px;" value="<?php echo set_value('endTime'); ?>" required readonly /><br/>
										</div>
									</td>
								</tr>
								<tr>
									<th style="width: 15%" class=""><div>Venue: </div></th>
									<?php $class = (form_error('venue') !== '') ? 'textf-error' : 'textf'; ?>
									<td>
									<input type="text" placeholder="required" class="<?php echo $class;?>" name="venue" style="width: 469px;" value="<?php echo set_value('venue'); ?>" required /><br/>
									</td>
								</tr>
								<tr>
									<th style="width: 15%" class=""><div>Attendees: </div></th>
									<?php $class = (form_error('attendees') !== '') ? 'textareaMe-error' : 'textareaMe'; ?>
									<td>
									<textarea class="<?php echo $class;?>" name="attendees" required placeholder="Required"></textarea>
									</td>
								</tr>
								<tr>
									<th style="width: 15%" class=""><div>No. Of Attendees: </div></th>
									<?php $class = (form_error('available') !== '') ? 'textf-error' : 'textf'; ?>
									<td>
									<input type="number" min="0" placeholder="required" class="<?php echo $class;?>" style="width: 469px;" name="available" value="<?php echo set_value('available'); ?>" size="50" /><br/>
									</td>
								</tr>
								
								<tr>
									<th style="width: 15%" class=""><div>Cost: </div></th>
									<?php $class = (form_error('cost') !== '') ? 'textf-error' : 'textf'; ?>
									<td>
									<input type="number" min="0" placeholder="required" class="<?php echo $class;?>" style="width: 469px;" name="cost" value="<?php echo set_value('cost'); ?>" required /><br/>
									</td>
								</tr>
								<tr>
									<th style="width: 15%" class=""><div>Food Expenses: </div></th>
									<?php $class = (form_error('food') !== '') ? 'textf-error' : 'textf'; ?>
									<td>
									<input type="number" min="0" placeholder="Total Expenses" class="<?php echo $class;?>" style="width: 469px;" name="food" value="<?php echo set_value('food'); ?>" required /><br/>
									<textarea class="textareaMe" name="food_notes" required placeholder="Remarks"></textarea>
									</td>
								</tr>
								<tr>
									<th style="width: 15%" class=""><div>Land Transportation: </div></th>
									<?php $class = (form_error('landTranspo') !== '') ? 'textf-error' : 'textf'; ?>
									<td>
									<input type="number" min="0" placeholder="Total Expenses" class="<?php echo $class;?>" style="width: 469px;" name="landTranspo" value="<?php echo set_value('landTranspo'); ?>" size="50" /><br/>
									<textarea class="textareaMe" name="landTranspo_notes" required placeholder="Remarks"></textarea>
									</td>
								</tr>
								<tr>
									<th style="width: 15%" class=""><div>Accomodation: </div></th>
									<?php $class = (form_error('accomodation') !== '') ? 'textf-error' : 'textf'; ?>
									<td>
									<input type="number" min="0" placeholder="Total Expenses" class="<?php echo $class;?>" style="width: 469px;" name="accomodation" value="<?php echo set_value('accomodation'); ?>" size="50" /><br/>
									<textarea class="textareaMe" name="accomodation_notes" required placeholder="Remarks"></textarea>
									</td>
								</tr>
								<tr>
									<th style="width: 15%" class=""><div>Airfare: </div></th>
									<?php $class = (form_error('airfare') !== '') ? 'textf-error' : 'textf'; ?>
									<td>
									<input type="number" min="0" placeholder="Total Expenses" class="<?php echo $class;?>" style="width: 469px;" name="airfare" value="<?php echo set_value('airfare'); ?>" size="50" /><br/>
									<textarea class="textareaMe" name="airfare_notes" required placeholder="Remarks"></textarea>
									</td>
								</tr>
							</tbody>
						</table >
						<table class="viewtable" border="0" >
							<td colspan="5" align="center" >									
								<input class="button_login" type="submit" name="Submit" value="Add Course" />								
							</td>
						</table>						
					</td>
				</tr>							
				</form>	
			</table>
			<!--------------------- Content End --------------------->
		</td>
		
	<!--------------------- Big Content End --------------------->
	</tr>
	
</table>
</div>
