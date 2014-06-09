<head>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/styleGeneral.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/view.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/boots.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/view2.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/flat-ui.css" type="text/css">
<link href="<?php echo base_url(); ?>css/css_recipes.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/datepicker.css" type="text/css">

<link href="<?php echo base_url('css/bootstrap-timepicker.css') ?>" rel="stylesheet">
<script src="<?php echo base_url(); ?>js/jquery.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap-timepicker.js"></script>
<script src="<?php echo base_url(); ?>js/jquery_tablesorter.js"></script> 
<script src="<?php echo base_url(); ?>js/bootstrap.js"></script> 
<script src="<?php echo base_url(); ?>js/bootstrap-modal.js"></script> 


<script>
	$(document).ready(function() 
    { 
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
			<a href="<?php echo base_url().'index.php/course';?>" style="color: #7b1113;">VIEW</a> <br/>
			<a href="<?php echo base_url().'index.php/course/add';?>">ADD</a> <br/>
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
		
			<?php $this->load->helper('form');
				echo form_open('course/search_find'); ?>
				<select name="type" class="textf">
				  <option value="COURSE">COURSE</option>
				  <option value="USER">USER</option> 
				</select>
				<input class ="textf" type="text" name="search" required/>
				<input class="button_login" type="submit" name="submit" value="Search" />
			</form>
			<div id="profileCont">
				
				<div id="profileInfo">
					<table class="viewtable" border="0">					
					<td class="abclink" style="color: red"><center><?php if(!empty($error)) echo $error; ?></center></td>	
					<tr>
						<th style="width: 100%" colspan="5" class=""><center>
						<div style="border:none;background-color: #cccc99; font-size:24px; color: #a42125">
							Course Name:  <a style="color:red"><?php echo $name;?></a>
						</div>
						</center></th>
					</tr>
					</table>
					<table class="viewtable" border="0">
							<?php 
								$class = array('class' => 'form-horizontal');
							echo form_open('course/save', $class);	?>								
								<input type="hidden" name ="course_id"  value="<?php echo $course_id;?>" />
								<input type="hidden" name ="name"  value="<?php echo $name;?>" />	

								<div class="form-group">
									 <label class="col-sm-5 control-label" for="description"> OBJECTIVES</label>
									<div class="controls">
										<input class="textf" type="text" size="35" name ="description" value="<?php echo $description ;?>" /><br/><br/>
									</div>
								</div>

								<div class="form-group">
									 <label class="col-sm-5 control-label" for="start">START</label>
									<div class="controls">
										<input id="0" readonly class="textf pick" type="text" size="35" name ="start"  value="<?php echo date('M d, Y', strtotime($start));?>" /><br><br/>
									</div>
								</div>

								<div class="form-group">
									 <label class="col-sm-5 control-label" for="end">END</label>
									<div class="controls">
										<input id="last0" readonly class="textf pick" type="text" size="35" name ="end"  value="<?php echo date( 'M d, Y', strtotime($end));?>" /><br/><br/>
									</div>
								</div>

								<div class="form-group">
									 <label class="col-sm-5 control-label" for="startTime">START TIME</label>
									<div class="controls">										
										<div class="bootstrap-timepicker ">
											<input id="startTime" readonly class="textf" type="text" name ="startTime"  value="<?php echo $startTime ;?>" /><br/><br/>
										</div>
									</div>
								</div>

								<div class="form-group">
									 <label class="col-sm-5 control-label" for="endTime">END TIME</label>
									<div class="controls">
										<div class="bootstrap-timepicker ">
											<input id="endTime" readonly class="textf" type="text" name ="endTime"  value="<?php echo $endTime;?>" /><br/><br/>
										</div>
									</div>
								</div>

								<div class="form-group">
									 <label class="col-sm-5 control-label" for="venue">VENUE</label>
									<div class="controls">
										<input class="textf" type="text" size="35" name ="venue"  value="<?php echo $venue;?>" /><br/><br/>
									</div>
								</div>

								<div class="form-group">
									 <label class="col-sm-5 control-label" for="cost">COST</label>
									<div class="controls">
										<input class="textf" type="number" size="35" name ="cost"  value="<?php echo $cost;?>" /><br/><br/>
									</div>
								</div>

								<div class="form-group">
									 <label class="col-sm-5 control-label" for="available">SLOT</label>
									<div class="controls">
										<input class="textf" type="number" size="35" name ="available"  value="<?php echo $available;?>" /><br/><br/>
									</div>
								</div>

								<div class="form-group">
									 <label class="col-sm-5 control-label" for="attendees">ATTENDEES</label>
									<div class="controls">
										<input class="textf" type="text" size="35" name ="attendees"  value="<?php echo $attendees;?>" /><br/><br/>
									</div>
								</div>

								<div class="form-group">
									 <label class="col-sm-5 control-label" for="attendeesno">NO. OF ATTENDEES</label>
									<div class="controls">
										<input class="textf" type="number" size="35" name ="attendeesno"  value="<?php echo $attendeesno;?>" /><br/><br/>
									</div>
								</div>

								<div class="form-group">
									 <label class="col-sm-5 control-label" for="foodexp">FOOD EXPENSES</label>
									<div class="controls">
										<input class="textf" type="number" size="35" name ="foodexp"  value="<?php echo $foodexp;?>" /><br/><br/>
									</div>
								</div>

								<div class="form-group">
									 <label class="col-sm-5 control-label" for="transpo">AIR FARE/LAND</label>
									<div class="controls">
										<input class="textf" type="number" size="35" name ="transpo"  value="<?php echo $transpo;?>" /><br/><br/>
									</div>
								</div>

								<div class="form-group">
									 <label class="col-sm-5 control-label" for="accommodation">ACCOMMODATION</label>
									<div class="controls">
										<input class="textf" type="number" size="35" name ="accommodation"  value="<?php echo $accommodation;?>" /><br/><br/>
									</div>
								</div>
							<center>
								<input class="button_login" type="submit" value="SAVE">
								<input class="button_login" type="reset" value="RESET">
								<input class="button_login" type="submit" formmethod="post" formaction="<?php echo base_url();'course/'?>" value="CANCEL">
							</center>
							<?php echo form_close(); ?>
					</table>
				</div>
			</div>					
			<!----PAGE CONTENT BODY NYA------->
			
<!---------------PAGE CONTENT-------------------------->						
		</td>
	</tr>

</table>
</div>	