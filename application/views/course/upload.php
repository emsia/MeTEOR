<head>
<script>
	$(document).ready(function() {
		$('.checkall').change(function() {
			var checkboxes = $(this).closest('div').find(':checkbox');
			var checkboxes_label = $(this).closest('div').find('.checkbox');
			if($(this).is(':checked')) {
				checkboxes.attr('checked', 'checked');
				checkboxes_label.attr('class', 'checkbox checked');
				setTrue( 1 );
			} else {
				checkboxes.removeAttr('checked');
				checkboxes_label.attr('class', 'checkbox');
				setTrue( 0 );
			}
		});		
	 });
	 
	$(document).on("click", ".showMe", function () {
		var CourseName = $(this).data('name');
	    var id = $(this).data('id'); //course_id modal-footer
	    $(".modal-body #CourseName").val( CourseName );
	    $(".modal-footer #course_id").val( id );

		$('#myModal').modal('show');
	});	

	function setOne(){
		var boxes = bodyMe.getElementsByTagName("input");
		for( i = 0; i < boxes.length; i++ ){
			myType = boxes[i].getAttribute("type");
			myId = boxes[i].getAttribute("id");
			tag = 0;
			if( myType == "checkbox" ) {
				if( boxes[i].checked == 1 && myId == 'hehe'){
					hideIt( 1 ); tag = 1;
					$('#hideYou').removeAttr('required');
					$('#hideName').removeAttr('required');
					$('#hidePosition').removeAttr('required');
					break;
				}
			}	
		}
		if( !tag ){ 
			hideIt(0);
			$('#hideYou').attr('required', 'true');
		}	
	}

	function setTrue( opt ){
		if(opt==0)
			document.getElementById('SetOkay').disabled = true;
		if(opt==1)
			document.getElementById('SetOkay').disabled = false;
	}
	function setIt(chkState){
		var boxes = bodyMe.getElementsByTagName("input");
		var count = 0; var count_checkd = 0;
		for( i = 0; i < boxes.length; i++ ){
			myType = boxes[i].getAttribute("type");
			myId = boxes[i].getAttribute("id");

			if( myType == "checkbox" && myId!='hehe' && myId!='Capital') {
				if( boxes[i].checked == 1 ){
					setTrue( 1 );
					count_checkd++;
				}
				count++;
			}	
		}

		if( count==count_checkd ){
			document.getElementById('labelAll').setAttribute('class', 'checkbox checked');
			document.getElementById('Capital').setAttribute('checked', 'checked');
		}
		if( !count_checkd ){
			setTrue( 0 );
			document.getElementById('labelAll').setAttribute('class', 'checkbox');
		}
		for( i = 0; i < boxes.length; i++ ){
			myType = boxes[i].getAttribute("id");
			if( myType == "Capital" ) {
				if( boxes[i].checked == 1 ){
					document.getElementById('labelAll').setAttribute('class', 'checkbox');
					boxes[i].checked = 0;
					break;
				}
			}	
		}
		return;
	}

	function hideIt( num ){
		if( num == 1 ) document.getElementById('hideMe').style.display = 'none';
		else document.getElementById('hideMe').style.display = '';
	}

	window.setTimeout("closeHelpDiv_2();", 3000);
	function closeHelpDiv_2(){
		document.getElementById("helpdiv_2").style.display= "none";
	}
</script>
<noscript>Please Enable javascript to view this Page Correctly.</noscript>
</head>

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

    $(document).on("click", ".button_smalla", function () {
	    var CourseName = $(this).data('name');
	    var id = $(this).data('id'); //course_id modal-footer
	    $(".modal-body #CourseName").val( CourseName );
	    $(".modal-footer #course_id").val( id );
	});
</script>

<div id="bodyMe" class="span9" style="margin-left: -30px">
	<div class="content">
		<?php
			$this->load->helper('form');
			if(!$man) echo form_open('course/search_upload');
			else echo form_open('managercourse/search_upload');
		?>
		<div class="control-group">
			<div class="controls">
				<input type="text" autocomplete="off" data-provide='typeahead' data-items='<?php echo $count_All; ?>' data-source='<?php echo $array;?>' required placeholder="Type Here" name="search"/>
				<button type="submit" class="btn btn-large btn-success">Search</button>
			</div>
		</div>
		<?php echo form_close(); ?>
		
		<hr>

		<?php 
			if(!$man) echo form_open_multipart('course/upSig'); 
			else echo form_open_multipart('managercourse/upSig'); 
		?>

		<?php if(!empty($message) && !$error){ ?>
		<div class="panel panel-danger">
		  <div class="panel-heading">Warning!</div>
		  <div class="panel-body">
		    <?php echo $message; ?>
		  </div>
		</div>		
		<?php } ?>

		<?php if(!empty($message) && $error){ ?>
		<div id="helpdiv_2" class="panel panel-info">
		  <div class="panel-heading">Successful!</div>
		  <div class="panel-body">
		    <?php echo $message; ?>
		  </div>
		</div>		
		<?php } ?>

		<?php if( $certDownload ) {?>
			<div class="panel panel-success">
			  <div class="panel-heading">CERTIFICATE DOWNLOAD</div>
			  <table class="table table-striped">
			  	<thead>	
					<tr>										
						<th style="width: 3%"></th>
						<th style="width: 21%"><center>Name</center></th>
						<th style="width: 19%"><center>Description</center></th>										
						<th style="width: 15%"><center>Start</center></th>
						<th style="width: 15%"><center>End</center></th>
						<th style="width: 12%"><center>Venue</center></th>
						<th style="width: 7%"><center>Cost</center></th>
						<th style="width: 8%" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Participants Count" ><center>Count</center></th>
					</tr>
				</thead>
				<tbody>
					<?php for( $k = 0; $k < $certDownload; $k++ ){ ?>
					<?php
							$temp = strtotime($Certstart[$k]);
							$var5 = date('M d Y', $temp).PHP_EOL;
							$var0 = date('M d, Y', $temp).PHP_EOL;
							
							$temp = strtotime($Certend[$k]);
							$var3 = date('M d, Y', $temp).PHP_EOL;

							date_default_timezone_set("Asia/Manila");
							$date = date('Y-m-d');

							$startCERT = strtotime($Certstart[$k]);
							$endCERT = strtotime($date);
							$end_s = strtotime($Certend[$k]);
							$diff = round(($endCERT - $startCERT)/86400);
							$diff2 = round(($end_s - $startCERT)/86400);

							$startCERT = $diff * -1;
							$endCERT = $startCERT + $diff2;

							$place = '#';
							$var4 = date('M d Y', $temp).PHP_EOL;
							if( ($Certpaid[$k]) > 0 ) $place = base_url().'index.php/course/downloadBatch/'.$certID[$k]; //trueStart
						?>	
					<div>
						<tr class="linka">
							<td class="buttontable"><button data-name="<?php echo $Certname[$k]?>" data-id="<?php echo $certID[$k]; ?>" style='padding: 5px'; data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Edit Signature File" type="button" class='btn showMe btn-warning' name="edit" ><i class="glyphicon glyphicon-pencil"></i></button></td>
							<td class="dataf"><a href="<?php echo $place;?>" class="" data-start="<?php echo $var5?>" data-name2="<?php echo $var4?>" data-name="<?php echo $Certname[$k]?>" data-id="<?php echo $certID[$k]; ?>"><center><div><?php echo $Certname[$k];?></div></center></a></td>
							<td class="dataf"><center><div><?php echo $Certdescription[$k];?></div></center></a></td>
							<td class="dataf"><center><?php echo $var0; ?></center></td>
							<td class="dataf"><center><?php echo $var3; ?></center></td>
							<td class="dataf"><center><?php echo $venue[$k];?></center></td>
							<td class="dataf"><center><?php echo $cost[$k];?></center></td>
							<td class="dataf"><center><?php echo $Certpaid[$k];?></center></td>
						</tr>
					</div>
					<?php } ?>
				</tbody>
			  </table>
			</div>
		<?php }?>

		<?php if($counter){ ?>
			<div class="panel panel-success">
			  <div class="panel-heading">ALL COURSES</div>
			  <table class="table">
			  	<thead>	
					<tr>
						<th style="width: 3%">
							<center>
								<label id="labelAll" class="checkbox" style="margin-left: 13px; margin-bottom: 0px" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Check All">
									<input type="checkbox" data-toggle="checkbox" style="width: 17px" class="checkall" id="Capital" />
								</label>
							</center>
						</th>
						<th style="width: 25%"><center>Name</center></th>
						<th style="width: 19%"><center>Description</center></th>										
						<th style="width: 16%"><center>Start</center></th>
						<th style="width: 16%"><center>End</center></th>
						<th style="width: 12%"><center>Venue</center></th>
						<th style="width: 9%"><center>Cost</center></th>
					</tr>
				</thead>
				<tbody>	
					<?php for( $i = 0; $i < $counter; $i++ ): ?>
					<div>
						<tr class="linka">	
							<?php
								$temp = strtotime($start[$i]);
								$var1 = date('M d, Y', $temp).PHP_EOL;
								$temp = strtotime($end[$i]);
								$var2 = date('M d, Y', $temp).PHP_EOL;
							?>
							<td class="dataf">
								<center>
									<input type="hidden" name="<?php echo "course[]";?>" value ="<?php echo "$id[$i]";?>" >	
									<label class="checkbox" style="margin-left: 13px; margin-bottom: 0px" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Check">
										<input data-toggle="checkbox" type="checkbox" id="hindi" style="width: 17px" name="check[]" onchange="setIt()" value="<?php echo "$i";?>" />
									</label>
								</center>
							</td>													
							<td class="dataf"><a href="#"><center><?php echo $name[$i];?></center></a></td>
							<td class="dataf"><center><?php echo $description[$i];?></center></td>
							<td class="dataf"><center><?php echo $var1; ?></center></td>
							<td class="dataf"><center><?php echo $var2; ?></center></td>
							<td class="dataf"><center><?php echo $venue[$i];?></center></td>
							<td class="dataf"><center><?php echo $cost[$i];?></center></td>							
						</tr>
					</div>
					<?php endfor ?>	
				</tbody>
			  </table>
			</div>
			<hr>
			<center>
			<div class="control-group">
				<div class="controls">
					<input type="text" class="pick" id="ending" name="ending" value="<?php echo set_value('ending'); ?>" placeholder="Required" required readonly />
					<label>Choose Certificate Type</label>
					<div class="btn-group btn-input clearfix">
						<select id="cert" name="cert" class="select" value="<?php echo set_value('cert');?>" >
							<option value="Attendance" >Attendance</option>
							<option value="Appearance" >Appearance</option>
							<option value="Participation">Participation</option>
							<option value="Recognition">Recognition</option>
						</select>
					</div>				
				</div>
			</div>
			<div class="form-group">
				<div class="controls">
					<label class="checkbox col-md-offset-5" >						
						<input type="checkbox" data-toggle="checkbox" style="width: 17px" id="hehe" name="signee" onchange="setOne()" value="1">					
						<label data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="One Signee Only"  class="pull-left">One Signee Only</label>
					</label>
					<div class="fileupload fileupload-new" data-provides="fileupload">
						<span class="btn btn-file"><span class="fileupload-new">Select file 1</span>
						<span class="fileupload-exists">Change</span><input id="photo" name="photo" type="file" required /></span>
						<span class="fileupload-preview"></span>
						<a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
						<input type="text" name="CompName1" required placeholder="Complete Name" />
						<input type="text" name="position1" required placeholder="Position" />
					</div>
				</div>
			</div>
			<div id="hideMe" class="control-group">
				<div class="controls">
					<div class="fileupload fileupload-new" data-provides="fileupload">
						<span class="btn btn-file"><span class="fileupload-new">Select file 2</span>
						<span class="fileupload-exists">Change</span><input name="photo2" id="hideYou" type="file" required/></span>
						<span class="fileupload-preview"></span>
						<a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>					
						<input type="text" name="CompName2"  id="hideName" required placeholder="Complete Name" />
						<input type="text" name="position2" id="hidePosition" required placeholder="Position" />
					</div>
				</div>
			</div>
			</center>
			<center><button type="submit" class="btn btn-success btn-large" id="SetOkay" name="uploadSig" disabled >UPLOAD <i class="glyphicon glyphicon-share"></i></button></center>
		<?php }?>
		<?php echo form_close();?>
	</div>
</div>

<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header palette-alizarin">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="text-white">Signature Edit</h4>
  </div>
  		<?php 
		$this->load->helper('form');
		$class = array('class' => 'form-horizontal');
		echo form_open_multipart('course/editSig', $class); ?>	
  <div class="modal-body">	
    	<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">Course Name</label>
		  <div class="controls">
		    <textarea style="white-space:pre-wrap; height: auto! important;" rows="5" class ="textg input input-large" type="textarea" id="CourseName" name="CourseName" value="" readonly ></textarea>
		  </div>
		</div>
		<div class="form-group">
		   <label class="col-sm-5 control-label" for="endDate">End Date</label>
		  <div class="controls">
		    <input class ="textg input input-large pick" type="text" id="endDate" name="endDate" required placeholder="Required" value="<?php echo set_value('endDate');?>" required readonly />
		  </div>
		</div>			
		<div class="form-group">
		   <label class="col-sm-5 control-label" for="cert">Certificate Type</label>
		  <div class="controls">
		  	<div class="btn-group btn-input clearfix">
			    <select class="select" name='cert' value="<?php echo set_value('cert');?>" >
					<option value="Attendance" >Attendance</option>
					<option value="Appearance" >Appearance</option>
					<option value="Participation">Participation</option>
					<option value="Recognition">Recognition</option>
				</select>
			</div>
		  </div>
		</div>
		<div class="form-group">
			<label class="col-sm-5 control-label" for="photoEdit">Signature1 Uploader</label>
			<div class="controls">
					<div class="fileupload fileupload-new" data-provides="fileupload">
						<span class="btn btn-file"><span class="fileupload-new">Select file 1</span>
						<span class="fileupload-exists">Change</span><input id="photoEdit" name="photoEdit" type="file" required /></span>
						<span class="fileupload-preview"></span>
						<a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
					</div>
					<div style="margin-left: 41.51%; margin-top:5px;">
						<input type="text" id="name1" class ="textg input input-large" name="name1" placeholder="Complete Name" required /><br/>
						<input type="text" style="margin-top:10px" class ="textg input input-large" id="position1" name="position1" placeholder="Position" required />
					</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-5 control-label" for="photoEdit2">Signature2 Uploader</label>
			<div class="controls">
				<div class="fileupload fileupload-new" data-provides="fileupload">
					<span class="btn btn-file"><span class="fileupload-new">Select file 2</span>
					<span class="fileupload-exists">Change</span><input id="photoEdit2" name="photoEdit2" type="file" /></span>
					<span class="fileupload-preview"></span>
					<a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
				</div>
				<div style="margin-left: 41.51%; margin-top:5px;">
					<input type="text" id="name2" class="textg input input-large" name="name2" placeholder="Complete Name" /><br/>
					<input type="text" style="margin-top:10px" class ="textg input input-large" id="position2" name="position2" placeholder="Position" />
				</div>
			</div>
		</div>
  </div>
  <div class="modal-footer">
    <!--button class="button_login" data-dismiss="modal" aria-hidden="true">Close</button-->
    <input type="hidden" id="course_id" name="course_id" value="" />
    <button class="btn btn-danger" type="submit" >Save <i class="glyphicon glyphicon-ok"></i></button>
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
</script>


<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-fileupload.css" type="text/css"  />
<script src="<?php echo base_url(); ?>js/bootstrap-fileupload.js"></script> 