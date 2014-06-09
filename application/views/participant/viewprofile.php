<noscript>Please Enable javascript to view this Page Correctly.</noscript>

<script type="text/javascript">
	window.setTimeout("closeHelpDiv();", 3000);
	function closeHelpDiv(){
		document.getElementById("helpdiv").style.display= "none";
	}
</script>

	<div id="myModal2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header palette-carrot">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h4 class="text-white">Set End Date(s) for Certificate</h4>
	  </div>
		<?php 
			$this->load->helper('form');
			$class = array('class' => 'form-horizontal');
			if(!$manager) echo form_open('course/setSurvey', $class); 
			else echo form_open('managercourse/setSurvey', $class); 
		?>
	  <div class="modal-body">
    	<div class="form-group">
		  <label class="col-sm-5 control-label">Course Name</label>
		  <div class="controls">
		    <textarea style="white-space:pre-wrap; height: auto! important;" rows="5" class="input-large" type="textarea" id="CourseNameDate" name="CourseName" value="" readonly ></textarea>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-sm-5 control-label">End Date(s)</label>
		  <div class="controls">
		  	<div class="col-md-offset-5" style="padding-bottom:5px">
	            <input type="text" class="input-large pick" id="endDateCert" required name="endDateCert[]" placeholder="Required" value="<?php echo set_value('endDateCert');?>" required readonly />
	            <button type="button" onclick="add_more_text_box('add_more_div','endDateCert[]',child(), endDateCert);" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i></button>
		  	</div>
		  	<div id="add_more_div"></div>
		  </div>
		</div>			
	  </div>
	  <div class="modal-footer">
	    <input type="hidden" id="course_idDate" name="course_idDate" value="" />
	    <input type="hidden" id="user_id" name="user_id" value="" />
	    <button class="btn btn-warning btn-large" type="submit">Save <i class="glyphicon glyphicon-ok"></i></button>
	  </div>

		<?php echo form_close(); ?>
	</div>

<div class="span9" style="margin-left: -30px">
	<div class="content">
		<div class="panel panel-info">
		  <div class="panel-heading"><?php echo ucwords(strtolower($user['lastname'].", ".$user['firstname']." ".$user['middlename'])); ?></div>
		  <ul class="list-group">
		    <li class="list-group-item"><b style="color:red">E-Mail Address</b> : <?php echo $user['username']; ?></li>
		    <li class="list-group-item"><b style="color:red">Mailing Address</b> : 
		    	<?php 
		    		if(empty($region)) echo 'None';
					else echo $region.", ".ucwords(strtolower($province)).", ".ucwords(strtolower($city));			
				?>
			</li>
		    <li class="list-group-item"><b style="color:red">Mobile Number</b> : 
		    	<?php 
					if( !count( $number ) ) echo "None";
					else{
						for($i=0;$i<$countNnum;$i++){
							echo $number[$i];
							if($countNnum>1) echo ", ";
						}
					}
				?>
		    </li>
		  </ul>
		</div>
		<hr>

		<?php 
			$set = 0;
			foreach( $courses as $course_item ){													
				$query1 = $this->db->get_where( 'courses', array('id' => $course_item['id']) );
				$array1 = $query1->row_array();
								
				$query2 = $this->db->get_where('reserved', array('course_id' => $array1['id'], 'user_id' => $user['id']) );
				$array2 = $query2->row_array();	
								
				if( !empty( $array2['id'] ) ){
					$set = 1;
					break;
				}
			}
			if( $set ){
		?>
		<div class="panel panel-success">
		  <div class="panel-heading">Reservations</div>
		  <table class="table">
		  	<thead>
			    <tr>
					<th style="width: 25%"><center>Name</center></th>
					<th style="width: 29%"><center>Start | End</center></th>
					<th style="width: 25%"><center>Venue</center></th>
					<th style="width: 21%"><center>Cost</center></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach( $courses as $course_item ): 													
					$query1 = $this->db->get_where( 'courses', array('id' => $course_item['id']) );
					$array1 = $query1->row_array();
					
					$query2 = $this->db->get_where('reserved', array('course_id' => $array1['id'], 'user_id' => $user['id']) );
					$array2 = $query2->row_array();	
					
					if( !empty( $array2['id'] ) ){
				?>
				<div>					
					<tr class="linka">
						<td class="dataf"><center><?php echo $course_item['name']?></center></td>
						<td class="dataf"><center><?php echo date('M d, Y', strtotime($course_item['start'])); ?> | <?php echo date('M d, Y', strtotime($course_item['end'])); ?><center></td>
						<td class="dataf"><center><?php echo $course_item['venue']?></center></td>
						<td class="dataf"><center><?php echo $course_item['cost']?></center></td>
					</tr>
				</div>
				<?php } endforeach ?>
			</tbody>
		  </table>
		</div>
		<?php } ?>

		<?php 
			$set = 0;
			foreach( $courses as $course_item ){
				$this->load->helper('date');
				$this->load->helper('form');
				date_default_timezone_set("Asia/Manila");
				$date = date('Y-m-d');
				
				$query1 = $this->db->get_where( 'courses', array('id' => $course_item['id']) );
				$array1 = $query1->row_array();
								
				$queryPaid = $this->db->get_where('payment', array('course_id' => $array1['id'], 'user_id' => $user['id'] ) );
				$arrayPaid = $queryPaid->row_array();	
							
				//check if the user has paid courses that are older than today
				if( ( !empty( $arrayPaid['id'] ) ) && $course_item['end'] < $date  ){
					$set = 1;
					break;
				}
			}
			if( $set ){
		?>
		<div class="panel panel-success">
		  <div class="panel-heading">Completed Courses</div>
		  <table class="table">
		  	<thead>
			    <tr>
					<th style="width: 25%"><center>Name</center></th>
					<th style="width: 29%"><center>Start | End</center></th>
					<th style="width: 25%"><center>Venue</center></th>
					<th style="width: 21%"><center>Cost</center></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach( $courses as $course_item ):										
					$date = date('Y-m-d');
				
					$query1 = $this->db->get_where( 'courses', array('id' => $course_item['id']) );
					$array1 = $query1->row_array();
					
					$queryPaid = $this->db->get_where('payment', array('course_id' => $array1['id'], 'user_id' => $user['id'] ) );
					$arrayPaid = $queryPaid->row_array();		
					
					//check if the user has paid courses that are older than today
					if( ( !empty( $arrayPaid['id'] ) ) && $course_item['end'] < $date  ){ 
				?>				
				<tr class="linka">	
					<td class="dataf"><center><?php echo $course_item['name']?></center></td>
					<td class="dataf"><center><?php echo date('M d, Y', strtotime($course_item['start'])); ?> | <?php echo date('M d, Y', strtotime($course_item['end'])); ?><center></td>
					<td class="dataf"><center><?php echo $course_item['venue']?></center></td>
					<td class="dataf"><center><?php echo $course_item['cost']?></center></td>
				</tr>
				<?php } endforeach ?>
			</tbody>	
		  </table>
		</div>
		<?php }?>

		<?php 
			$set = 0;
			foreach( $courses as $course_item ){
				$this->load->helper('date');
				$this->load->helper('form');
				date_default_timezone_set("Asia/Manila");
				$date = date('Y-m-d');
				
				$query1 = $this->db->get_where( 'courses', array('id' => $course_item['id']) );
				$array1 = $query1->row_array();
							
				$query2 = $this->db->get_where('cancelled', array('course_id' => $array1['id'], 'user_id' => $user['id'] ) );
				$array2 = $query2->row_array();	
							
							
				if( !empty( $array2['id']) ){ //check if the user has courses for refund.
					$set = 1;
					break;
				}
			}
			if( $set ){
		?>
		<div class="panel panel-success">
		  <div class="panel-heading">Cancelled Courses</div>
		  <table class="table">
		    <thead>
			    <tr>
					<th style="width: 25%"><center>Name</center></th>
					<th style="width: 29%"><center>Start | End</center></th>
					<th style="width: 25%"><center>Venue</center></th>
					<th style="width: 21%"><center>Cost</center></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach( $courses as $course_item ): 										
					$date = date('Y-m-d');
				
					$query1 = $this->db->get_where( 'courses', array('id' => $course_item['id']) );
					$array1 = $query1->row_array();
					
					$query2 = $this->db->get_where('cancelled', array('course_id' => $array1['id'], 'user_id' => $user['id'] ) );
					$array2 = $query2->row_array();	
					
					
					if( !empty( $array2['id']) ){ //check if the user has courses for refund.
				?>					
				<tr class="linka">	
					<td class="dataf"><center><?php echo $course_item['name']?></center></td>
					<td class="dataf"><center><?php echo date('M d, Y', strtotime($course_item['start'])); ?> | <?php echo date('M d, Y', strtotime($course_item['end'])); ?><center></td>
					<td class="dataf"><center><?php echo $course_item['venue']?></center></td>
					<td class="dataf"><center><?php echo $course_item['cost']?></center></td>
				</tr>
				<?php } endforeach ?>
		  </table>
		</div>
		<?php } ?>

		<?php if(!empty($message) && !$error){ ?>
			<div class="panel panel-danger">
			  <div class="panel-heading">Warning!</div>
			  <div class="panel-body">
			    <p><?php echo $message; ?></p>
			  </div>
			</div>
		<?php }?>

		<?php if(!empty($message) && $error){ ?>
			<div id="helpdiv" class="panel panel-info">
			  <div class="panel-heading">Successful!</div>
			  <div class="panel-body">
			    <p><?php echo $message; ?></p>
			  </div>
			</div>
		<?php }?>

		<?php 
			$set = 0;
			foreach( $courses as $course_item ){
				$this->load->helper('date');
				$this->load->helper('form');
				date_default_timezone_set("Asia/Manila");
				$date = date('Y-m-d');
				
				$query1 = $this->db->get_where( 'courses', array('id' => $course_item['id']) );
				$array1 = $query1->row_array();
								
				$queryPaid = $this->db->get_where('payment', array('course_id' => $array1['id'], 'user_id' => $user['id'] ) );
				$arrayPaid = $queryPaid->row_array();	
							
				//check if the user has paid courses that are older than today
				if( !empty( $arrayPaid['id'] ) ){
					$set = 1;
					break;
				}
			}
			if( $set ){
		?>
		<div class="panel panel-success">
		  <div class="panel-heading">Paid Courses</div>
		  <table class="table">
		  	<thead>
			    <tr>
					<th style="width: 3%"></th>
					<th style="width: 25%"><center>Name</center></th>
					<th style="width: 30%"><center>Expected Attendance</center></th>
					<th style="width: 21%"><center>Venue</center></th>
					<th style="width: 21%"><center>Cost</center></th>
				</tr>
			</thead>
			<tbody>
				<?php for( $i = 0; $i < $count; $i++ ):										
					$date = date('Y-m-d');
				
					$query1 = $this->db->get_where( 'courses', array('id' => $id[$i]) );
					$array1 = $query1->row_array();
					
					$queryPaid = $this->db->get_where('payment', array('course_id' => $id[$i], 'user_id' => $user['id'] ) );
					$arrayPaid = $queryPaid->row_array();		
					
					//check if the user has paid courses that are older than today
					if( !empty( $arrayPaid['id'] )  ){
				?>								
				<tr class="linka">
					<td class="button_table">
						<button type="button" class="btn btn-warning setDate" style="padding: 5px" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Set End Date for Certificate" data-name="<?php echo $name[$i]?>" data-userid="<?php echo $user['id']; ?>" data-id="<?php echo $id[$i]; ?>"><i class="glyphicon glyphicon-calendar"></i></button>
					</td>
					<td class="dataf"><center><?php echo $name[$i]?></center></td>
					<td class="dataf"><center><?php echo $expected[$i]?><center></td>
					<td class="dataf"><center><?php echo $venue[$i]?></center></td>
					<td class="dataf"><center><?php echo $cost[$i]?></center></td>
				</tr>
				<?php } endfor ?>
			</tbody>
		  </table>
		</div>
		<?php }?>
	</div>
</div>

<script type="text/javascript">

	$(document).ready(function() 
    { 
        $('.pick').datepicker({
			todayBtn: "linked",
		    multidate: true,
		    format: "M d, yyyy",
		    autoclose: true,
		    todayHighlight: true,
			multidateSeparator: ' - ',
		});
    } );

	$(document).ready(function() 
    { 
		$('form').on('click', '.removeVar', function(){
				$(this).parent().remove();
		});
	} );	

	$(document).on("click", ".setDate", function () {
		$('#myModal2').modal('show');
	    var CourseName = $(this).data('name');
	    var user_id = $(this).data('userid');
	    var id = $(this).data('id'); //course_id modal-footer userid
	    $(".modal-body #CourseNameDate").val( CourseName );
	    $(".modal-footer #course_idDate").val( id );
	    $(".modal-footer #user_id").val( user_id );
	});

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
	  oInput.setAttribute('id', "endDateCert"+child_id);
	  oInput.setAttribute('placeholder', 'Required');
	  oInput.setAttribute('class', 'input-large');
	  oInput.setAttribute('readonly', 'true');
	  oInput.setAttribute('style', 'margin-bottom:5px');

	  oDiv.appendChild(oInput);
	  oDiv.appendChild(oo);
	  oDiv.appendChild(sss);

	  oInput.find('.pick3').datepicker();
	} 

	var child_id = 0;
	function child()
	{ 
		return child_id++;
	}

	 $(function() {
	    var tooltips = $( "[title]" ).tooltip();
	    $(document)(function() {
	    	tooltips.tooltip( "open" );
	    })
    });
</script>