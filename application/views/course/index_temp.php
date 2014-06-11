<script type="text/javascript">
	window.setTimeout("closeHelpDiv();", 3000);
	function closeHelpDiv(){
		document.getElementById("helpdiv").style.display= "none";
	}
</script>

	<div id="myModal2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header palette-nephritis">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h4 class="text-white">Send Invitaion</h4>
	  </div>
	  <?php 
		$this->load->helper('form');
		$class = array('class' => 'form-horizontal');
		if( !$num ) echo form_open('course/sendEmail', $class); 
		else echo form_open('managercourse/sendEmail', $class); 
		?>	
	  <div class="modal-body">
	    	<div class="form-group">
			  <label class="col-sm-5 control-label" for="CourseName">Course Name</label>
			  <div class="controls">
			    <textarea style="white-space:pre-wrap; height: auto! important;" class="input-large" rows="5" type="textarea" id="CourseName" name="CourseName" value="" readonly ></textarea>
			  </div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 control-label" for="ven">Participant's Email</label>
				<div class="controls" id="ven">
			    	<div class="col-md-offset-5" style="padding-bottom:5px">
			    		<input class="input-large" name="add_more[]" type="text" id="part0" placeholder="Required" required />		    	
			    		<button type="button" onclick="add_more_text_box('add_more_div','add_more[]',child());" class="btn btn-success" ><i class="glyphicon glyphicon-plus"></i></button>
			    	</div>
					<div id="add_more_div"></div>
				</div>
			</div>
	  </div>
	  <div class="modal-footer">
	    <input type="hidden" name="course_id" id="course_id" value="" />
	    <input type="hidden" name="CourseName2" id="CourseName2" value="" />
	    <button class="btn btn-success btn-large" type="submit" >Send <i class="glyphicon glyphicon-share"></i></button>
	  </div>

		<?php echo form_close(); ?>
	</div>

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
			    <textarea style="white-space:pre-wrap; height: auto! important;"  rows="4" class ="input-large" type="textarea" id="CourseName" name="CourseName" placeholder="Required" required value="" ></textarea>
			  </div>
			</div>
			<div class="form-group">
			  <label class="col-sm-5 control-label" for="description">Description</label>
			  <div class="controls">
			    <textarea style="white-space:pre-wrap; height: auto! important;" rows="4" class ="input-large" type="textarea" id="description" name="description" placeholder="Required" required value="" ></textarea>
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
		$('.pick').datepicker({
			//minDate: 0,
			//dateFormat: "M d, yy"
			todayBtn: "linked",
		    multidate: false,
		    format: "M d, yyyy",
		    autoclose: true,
		    todayHighlight: true
		});
		$('form').on('click', '.removeVar', function(){
			$(this).parent().remove();
		});
		$('.time').timepicker({
      		pickDate: false,
      		autoclose: true,
			template: 'modal',
		});
    } );

    $(document).on("click", ".choose", function () {
    	$('#myModal2').modal('show');
    	var CourseName = $(this).data('name');
	    var id = $(this).data('id'); //course_id modal-footer
	    $(".modal-body #CourseName").val( CourseName );
	    $(".modal-footer #course_id").val( id );
	    $(".modal-footer #CourseName2").val( CourseName );
	});
</script>

<script>
	function add_more_text_box(parent_id, child_name, child_id)
	{
	  var myTable = document.getElementById(parent_id);
	  var oDiv, oInput, sss, oo, me;
	  oDiv = document.createElement('div');
	  oo = document.createTextNode( "\u00A0" );	
	  oDiv.setAttribute('id', 'part'+ child_id);
	  oDiv.setAttribute('class', 'col-md-offset-5');
	  
	  myTable.appendChild(oDiv);

	  oInput = document.createElement('input');
	  sss = document.createElement('button');
	  sss.setAttribute('type', 'button');
	  sss.setAttribute('class', 'btn btn-danger removeVar');

	  me = document.createElement('i');
	  me.setAttribute('class', 'glyphicon glyphicon-minus');

	  sss.appendChild(me);

	  oInput.setAttribute('type', 'text');
	  oInput.setAttribute('required', true);
	  oInput.setAttribute('name', child_name);
	  oInput.setAttribute('id', child_id);
	  oInput.setAttribute('placeholder', 'Required');
	  oInput.setAttribute('class', 'input-large');
	  oInput.setAttribute('style', 'margin-bottom:5px');

	  oDiv.appendChild(oInput);
	  oDiv.appendChild(oo);
	  oDiv.appendChild(sss);
	} 

	var child_id = 1;
	function child()
	{ 
		return child_id++;
	}	
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
			</div>
		</div>
		<?php echo form_close();?>
		<hr>

		<?php if(!empty($message) && !$error){?>
		<div class="panel panel-danger">
			<div class="panel-heading">Warning!</div>
			<div class="panel-body">
				<p><?php echo $message; ?></p>
			</div>
		</div>
		<?php }?>

		<?php if(!empty($message) && $error){?>
		<div id="helpdiv" class="panel panel-primary">
			<div class="panel-heading">Successful!</div>
			<div class="panel-body">
				<p><?php echo $message; ?></p>
			</div>
		</div>
		<?php }?>

		<?php if($count){ ?>
			<div class="panel panel-success">
			  <div class="panel-heading"><?php if($search){ ?>Search Results<?php }else{ ?>Request Courses<?php } ?></div>
			  <table class="table">
			    <thead>	
					<tr>
						<?php if(!$num){ ?>
							<th style="width: 3%"></th>
							<th style="width: 3%"></th>	
							<th style="width: 17%"><center>Name</center></th>									
							<th style="width: 12%"><center>Start</center></th>
							<th style="width: 12%"><center>End</center></th>
							<th style="width: 15%"><center>Time</center></th>
							<th style="width: 16%"><center>Venue</center></th>
							<th style="width: 15%"><center>Requested By</center></th>
							<th style="width: 7%" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Confirmed Attendees"><center>Count</center></th>
						<?php } else{ ?>
							<th style="width: 3%"></th>
							<th style="width: 12%"><center>Status</center></th>	
							<th style="width: 15%"><center>Name</center></th>									
							<th style="width: 10%"><center>Start</center></th>
							<th style="width: 10%"><center>End</center></th>
							<th style="width: 13%"><center>Time</center></th>
							<th style="width: 15%"><center>Venue</center></th>
							<th style="width: 13%"><center>Requested By</center></th>
							<th style="width: 7%" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Confirmed Attendees"><center>Count</center></th>
						<?php }?>
					</tr>
				</thead>
				<tbody>	
					<?php for( $i = 0; $i < $count; $i++ ): ?>
					<div>
						<tr class="linka">	
							<?php
								$temp = strtotime($start[$i]);
								$var1 = date('M d, Y', $temp).PHP_EOL;
								
								$temp = strtotime($end[$i]);
								$var2 = date('M d, Y', $temp).PHP_EOL;	
								$tag = 0;

								for( $j = 0; $j < $countNotYet; $j++ ){
									if( $id[$i] == $notYet[$j] ){
										$tag = 1;
										break;
									}
								}									
							?>	
							<td class="buttontable">
								<button style='padding: 5px'; data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Send Invitation" data-name="<?php echo $name[$i];?>" data-id="<?php echo $id[$i];?>" class='btn btn-warning choose' type='button' name='submit' ><i class="glyphicon glyphicon-send"></i></button>
							</td>

							<?php if(!$num){ 
								if( $confirmedCount[$i] || $pendingCount[$i] ) $place = base_url().'index.php/course/seeRequest/'.$id[$i]."/".$num."/".$tag;
								else $place = "#";
							?>													
								<?php if( $tag ){ ?>	
								<td class="buttontable">
									<?php 
										$this->load->helper('form');
										echo form_open('course/approve');
									?>
									<input type="hidden" name="tempId" value="<?php echo $id[$i]; ?>" />
									<input type="hidden" name="pili" value="<?php echo $pili; ?>" />
									<button style='padding: 5px'; data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Approve Requested Course" onclick="return confirm('Are you sure you want to approve this request?')" class='btn btn-info' type='submit' name='submit' ><i class="glyphicon glyphicon-retweet"></i></button>
									<?php echo form_close(); ?>
								</td>	
								<?php }else{ ?>	
									<td class="buttontable">
									<button style='padding: 5px'; data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Already Approved" onMouseOut="hideddrivetip()" class='btn btn-success' type="button"><i class="glyphicon glyphicon-ok"></i></button>		
									</td>
							<?php } }else{
								if( $confirmedCount[$i] || $pendingCount[$i] ) $place = base_url().'index.php/managercourse/seeRequest/'.$id[$i]."/".$num."/".$tag;
								else $place = "#";
								if( $tag ){
							?>
								<td class="dataf"><center><span class='badge badge-error'>Not Yet Approved</span></center></td>
							<?php }else{?>
								<td class="dataf"><center><span class='badge badge-success'>Approved</span></center></td>
							<?php }}?>
							<td class="dataf"><a href="<?php echo $place;?>"><center><?php echo $name[$i];?></center></a></td>
							<td class="dataf"><center><?php echo $var1; ?></center></td>
							<td class="dataf"><center><?php echo $var2; ?></center></td>
							<td class="dataf"><center><?php echo $startTime[$i]." - ".$endTime[$i];?></center></td>
							<td class="dataf"><center><?php echo $venue[$i];?></center></td>
							<td class="dataf"><center><?php echo $senderS[$i];?></center></td>
							<td class="dataf"><center><?php echo $confirmedCount[$i]."/".$countS[$i];?></center></td>																	
							
						</tr>
					</div>
					<?php endfor ?>	
				</tbody>
			  </table>
			</div>

		<?php }?>
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