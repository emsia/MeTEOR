	<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	   <div class="modal-header palette-nephritis">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h4 class="text-white">Add Request</h4>
	  </div>
	  <?php 
		$this->load->helper('form');
		$class = array('class' => 'form-horizontal');
		echo form_open('course/addRequest', $class); ?>	
	  <div class="modal-body">
			<div class="form-group">
			  <label class="col-sm-5 control-label" for="requested_by">Requested By</label>
			  <div class="controls">
			    <input class ="textg input input-large" type="text" name="requested_by" value="<?php echo set_value('requested_by')?>" placeholder="Full Name" required />
			  </div>
			</div>
			<div class="form-group">
			  <label class="col-sm-5 control-label" for="email">Email</label>
			  <div class="controls">
			    <input class ="textg input input-large" type="text" name="email" value="<?php echo set_value('email[]')?>" placeholder="Mail of Requestor" required />
			  </div>
			</div>	
	    	<div class="form-group">
			  <label class="col-sm-5 control-label" for="CourseName">Course Name</label>
			  <div class="controls">
			    <textarea style="white-space:pre-wrap; height: auto! important;"  rows="4" class ="textg input input-large" type="textarea" id="CourseName" name="CourseName" placeholder="Required" required value="<?php echo set_value('CourseName');?>" ></textarea>
			  </div>
			</div>
			<div class="form-group">
			  <label class="col-sm-5 control-label" for="description">Description</label>
			  <div class="controls">
			    <textarea style="white-space:pre-wrap; height: auto! important;" rows="4" class ="textg input input-large" type="textarea" id="description" name="description" placeholder="Required" required value="<?php echo set_value('description');?>" ></textarea>
			  </div>
			</div>
			<div class="form-group">
			  <label class="col-sm-5 control-label" for="department">Department</label>
			  <div class="controls">
			    <input class ="textg input input-large" type="text" name="department" value="<?php echo set_value('department')?>" placeholder="Required" required />
			  </div>
			</div>		
			<div class="form-group">
			  <label class="col-sm-5 control-label" for="startDate">Start Date</label>
			  <div class="controls">
			    <input class ="textg input input-large pick" type="text" id="startDate" name="startDate" placeholder="Required" value="<?php echo set_value('startDate');?>" required readonly />
			  </div>
			</div>
			<div class="form-group">
			  <label class="col-sm-5 control-label" for="endDate">End Date</label>
			  <div class="controls">
			    <input class ="textg input input-large pick" type="text" id="endDate" name="endDate" placeholder="Required" value="<?php echo set_value('endDate');?>" required readonly />
			  </div>
			</div>
			<div class="form-group">
			  <label class="col-sm-5 control-label" for="startTime">Start Time</label>
			  <div class="controls">
			    <div class="bootstrap-timepicker">
					<input class="textg input input-large time" type="text" name="startTime" placeholder="Required" value="<?php echo set_value('startTime');?>" readonly />					
				</div>
			  </div>
			</div>
			<div class="form-group">
			  <label class="col-sm-5 control-label" for="endTime">End Time</label>
			  <div class="controls">
			     <div class="bootstrap-timepicker">
					<input class="textg input input-large time" type="text" name="endTime" placeholder="Required" value="<?php echo set_value('endTime');?>" readonly />					
				</div>
			  </div>
			</div>
			<div class="form-group">
			  <label class="col-sm-5 control-label" for="venue">Venue</label>
			  <div class="controls">
			    <input class ="textg input input-large" type="text" name="venue" value="<?php echo set_value('venue')?>" placeholder="Required" required />
			  </div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 control-label" for="venue">No. of Participants</label>
				<div class="controls">
			    	<input class ="textg input input-large" type="number" min="0" value="<?php echo set_value('count') ?>" name="count" placeholder="Required" required />
			  	</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 control-label" for="venue">Enter Code</label>
				<div class="controls">
					<img id="captcha" src="<?php echo base_url(); ?>securimage/securimage_show.php" alt="CAPTCHA Image" /><br/>
					<center>
						<object type="application/x-shockwave-flash" data="<?php echo base_url(); ?>securimage/securimage_play.swf?bgcol=#ffffff&amp;icon_file=<?php echo base_url(); ?>securimage/images/audio_icon.png&amp;audio_file=<?php echo base_url(); ?>securimage/securimage_play.php" height="40" align="center" width="40">
					    	<param name="movie" value="<?php echo base_url(); ?>securimage/securimage_play.swf?bgcol=#ffffff&amp;icon_file=<?php echo base_url(); ?>securimage/images/audio_icon.png&amp;audio_file=<?php echo base_url(); ?>securimage/securimage_play.php" />
					    </object>
					    &nbsp;
					    <a tabindex="-1" style="border-style: none;" href="#" onclick="document.getElementById('captcha').src = '<?php echo base_url(); ?>securimage/securimage_show.php?' + Math.random(); this.blur(); return false"><img src="<?php echo base_url(); ?>securimage/images/refresh.png" alt="Reload Image" onclick="this.blur()" align="center" height="35" width="35" border="0"></a>
			    	<input class ="textg input input-large" type="text" value="<?php echo set_value('captcha_code') ?>" name="captcha_code" placeholder="Required" required /></center>
			  	</div>
			</div>
	  </div>
	  <div class="modal-footer">
	    <input type="hidden" name="num" value="<?php echo $num; ?>" />
	    <button type="submit" class="btn btn-success" >Save <i class="glyphicon glyphicon-ok"></i></button>
	  </div>

		<?php echo form_close(); ?>
	</div>

<script>
	$(document).ready(function() 
    { 
        $("#addCourse").tablesorter(); 
		$('.pick').datepicker({
			//minDate: 0,
			//dateFormat: "M d, yy"
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

<script>
function add_more_text_box(parent_id, child_name, child_id)
{
  var myTable = document.getElementById(parent_id);
  var oDiv, oInput, sss;
  oDiv = document.createElement('div');
  oDiv.setAttribute('id', 'part'+ child_id);
  
  oDiv.setAttribute('class', 'control-group');
  myTable.appendChild(oDiv);

  oInput = document.createElement('input');
  oInput.setAttribute('type', 'text');
  oInput.setAttribute('required', true);
  oInput.setAttribute('name', child_name);
  oInput.setAttribute('id', child_id);
  oInput.setAttribute('placeholder', 'Required');
  oInput.setAttribute('class', 'textf input-large');
  oDiv.appendChild(oInput);
} 

var child_id = 1;
function child()
{ 
	return child_id++;
}	
</script>

<script>
    $(document).on("click", ".delMe", function () {
	    var CourseName = $(this).data('course');
	    var tag = $(this).data('tag');
	    var man = $(this).data('man');

	    var url = $(this).data('base');

    	var form = $('<form></form>');
    	form.attr("method", "post");
    	form.attr("action", url);

    	var field = $('<input></input>');
	    field.attr("type", "hidden");
	    field.attr("name", 'temporary');
        field.attr("value", CourseName);
		form.append(field);

		var field1 = $('<input></input>');
	    field1.attr("type", "hidden");
	    field1.attr("name", 'tag');
        field1.attr("value", tag);
		form.append(field1);

		var field2 = $('<input></input>');
	    field2.attr("type", "hidden");
	    field2.attr("name", 'man');
        field2.attr("value", man);
		form.append(field2);

		$(document.body).append(form);
	    form.submit();
	});
</script>

<div class="span9" style="margin-left: -30px">
	<div class="content">
		<?php
			$this->load->helper('form');
			$class = array('class' => 'form-inline');
			if( !$num ) echo form_open('course/search_request', $class); 
			else echo form_open('managercourse/search_request', $class); 
		?>
		<div class="control-group">
			<div class="controls">
				<input type="text" autocomplete="off" data-provide='typeahead' data-items='<?php echo $count_All; ?>' data-source='<?php echo $array;?>' required placeholder="Type Here" name="search"/>
				<button type="submit" class="btn btn-large btn-success">Search</button>
				<a href="#myModal" data-toggle="modal"><button type="button" class="btn btn-info btn-large">Request Course</button></a>
				<?php if($count_pending){ ?><button data-man="<?php echo $manager; ?>" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Delete Pending Emails" data-tag="<?php echo $tag; ?>" type="button" class="btn btn-warning delMe" data-base="<?php echo base_url('index.php/course/deletePending'); ?>" data-course="<?php echo $temporary; ?>" ><i class="glyphicon glyphicon-trash"></i></button><?php }?>
			</div>
		</div>
		<?php echo form_close();?>
		<hr>

		<?php if( $set ){?>
			<div class="panel panel-success">
			  <div class="panel-heading">Participants of <?php echo $name;?></div>
			  <table class="table">
			    <thead>	
					<tr>
						<th style="width: 3%"></th>
						<th style="width: 3%"></th>
						<th style="width: 24%"><center>Last Name</center></th>
						<th style="width: 24%"><center>First Name</center></th>
						<th style="width: 24%"><center>Middle Name</center></th>
						<th style="width: 22%"><center>UserName</center></th>
					</tr>
				</thead>
				<tbody>	
					<?php for( $i = 0; $i < $count; $i++ ): ?>
					<div>
						<tr class="linka">
							<td class="buttontable">
								<?php
									$this->load->helper('form');
									echo form_open('validation/removeStudent'); ?>
									<input type='hidden' name='temp' value='<?php echo $user_id[$i]; ?>' />
									<input type='hidden' name='course_id' value='<?php echo $course_id; ?>' />
									<input type='hidden' name='tempId' value='<?php echo $temporary; ?>' />
									
									<input type='hidden' name='manager' value='<?php echo $manager; ?>' />
									
									<input type='hidden' name='tag' value='<?php echo $tag; ?>' />
									<button style='padding: 5px' class='btn btn-danger' data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Remove Student" onclick="return confirm('Are you sure you want to remove this participant from this course?')" type='submit' name='submit' ><i class="glyphicon glyphicon-minus"></i></button>
								<?php echo form_close(); ?>
							</td>
							<td class="buttontable">
								<?php
									$this->load->helper('form');
									echo form_open('validation/changeForms'); ?>
									<input type='hidden' name='temp' value='<?php echo $user_id[$i]; ?>' />
									<input type='hidden' name='course_id' value='<?php echo $course_id; ?>' />
									<input type='hidden' name='tempId' value='<?php echo $temporary; ?>' />
									<input type='hidden' name='email' value='<?php echo $username[$i]; ?>' />

									<input type='hidden' name='manager' value='<?php echo $manager; ?>' />
									
									<input type='hidden' name='tag' value='<?php echo $tag; ?>' />
									<?php if($form[$i]==0){ ?><button style='padding: 5px' class='btn btn-warning' data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Short Form" type='submit' name='submit' ><i class="glyphicon glyphicon-flash"></i></button><?php }else{?>
									<button style='padding: 5px' class='btn btn-info' data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Complete Form" type='submit' name='submit' ><i class="glyphicon glyphicon-th-list"></i></button>
									<?php }?>
									<?php echo form_close(); ?>
							</td>					
							<td class="dataf"><center><?php echo ucwords(strtolower($lastname[$i]));?></center></td>								
							<td class="dataf"><center><?php echo ucwords(strtolower($firstname[$i]));?></center></td>
							<td class="dataf"><center><?php echo ucwords(strtolower($middlename[$i]));?></center></td>
							<td class="dataf"><center><?php echo $username[$i]; ?></center></td>									
						</tr>
					</div>
					<?php endfor ?>	
				</tbody>
			  </table>
			</div>
		<?php }?>

		<?php if($count_pending){ ?>
			<div class="panel panel-success">
			  <div class="panel-heading">Pending Emails</div>
			  <table class="table">
			    <thead>	
					<tr>
						<th style="width: 3px"></th>
						<th><center>UserName</center></th>
					</tr>
				</thead>
				<tbody>	
					<?php for( $i = 0; $i < $count_pending; $i++ ): ?>
						<div>
						<tr class="linka">
							<td class="dataf">
								<?php
									$this->load->helper('form');
									echo form_open('course/changeForms_pending'); ?>
									<input type='hidden' name='temp' value='<?php echo $id[$i]; ?>' />
									<input type='hidden' name='course_id' value='<?php echo $course_id; ?>' />
									<input type='hidden' name='tempId' value='<?php echo $temporary; ?>' />
									
									<input type='hidden' name='manager' value='<?php echo $manager; ?>' />
									
									<input type='hidden' name='tag' value='<?php echo $tag; ?>' />
									<?php if(!$forms[$i]){ ?><button style='padding: 5px' class='btn btn-warning' data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Short Form" type='submit' name='submit' ><i class="glyphicon glyphicon-flash"></i></button><?php }else{?>
									<button style='padding: 5px' class='btn btn-info' data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Complete Form" type='submit' name='submit' ><i class="glyphicon glyphicon-th-list"></i></button>
									<?php }?>
								<?php echo form_close(); ?>
							</td>
							<td class="dataf"><center><?php echo $email_pending[$i];?></center></td>										
						</tr>
					</div>
					<?php endfor ?>	
				</tbody>
			  </table>
			</div>
		<?php } ?>
	</div>
</div>

<script>
    $(function() {
	    var tooltips = $( "[title]" ).tooltip();
	    $(document)(function() {
	    	tooltips.tooltip( "open" );
	    })
    });
</script>