<script type="text/javascript">
	window.setTimeout("closeHelpDiv();", 3000);
	function closeHelpDiv(){
		document.getElementById("helpdiv").style.display= "none";
	}
</script>
<div class="span9" style="margin-left: -30px">
	<div class="content">
		<?php 
			$this->load->helper('form');
			echo form_open('participantcourse/search_upcoming');
		?>
		<div class="control-group">
			<div class="controls">
				<input type="text" autocomplete="off" data-provide='typeahead' data-items='<?php echo $count_All; ?>' data-source='<?php echo $array;?>' required placeholder="Type Here" name="search"/>
				<button type="submit" class="btn btn-large btn-success">Search</button>
			</div>
		</div>
		<?php echo form_close();?>
		<hr>

		<?php if(!empty($message)){?>
			<?php if(!$error){ ?>
			<div class="panel panel-danger">
			  <div class="panel-heading">Warning!</div>
			<?php }else{ ?>
			<div id="helpdiv" class="panel panel-info">
			  <div class="panel-heading">Successful!</div>
			<?php }?>
			  <div class="panel-body">
			    <p><?php echo $message; ?></p>
			  </div>
			</div>
		<?php } ?>

		<?php 
			$query2 = $this->db->get_where('reserved', array('user_id' => $userid  ) );
			$array2 = $query2->row_array();
			
			if( !empty($array2['id']) ){
		?>
			<div class="panel panel-success">
			  <div class="panel-heading">Reservations</div>
			  <table class="table table-striped">
			    <thead>
					<tr>
						<th style="width: 5%"></th>
						<th style="width: 20%"><center>Name</center></th>
						<th style="width: 15%"><center>Description</center></th>
						<th style="width: 14%"><center>Start</center></th>
						<th style="width: 14%"><center>End</center></th>
						<th style="width: 14%"><center>Venue</center></th>
						<th style="width: 8%"><center>Cost</center></th>
						<th style="width: 10%" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Reserved | Available | Paid"><center>R | A | P</center></th>			
					</tr>
				</thead>
				<tbody>
					<?php foreach( $courses as $course_item ): ?>
						
						<?php
							$query1 = $this->db->get_where( 'courses', array('id' => $course_item['id']) );
							$array1 = $query1->row_array();
							
							$query2 = $this->db->get_where('reserved', array('course_id' => $array1['id'], 'user_id' => $userid  ) );
							$array2 = $query2->row_array();	
								
							if( !empty( $array2['id'] ) ){
							$course_item['tag'] = 0;

							
							$queryk = $this->db->get_where('reserved',array('user_id' => $userid ));
								$arrayk = $queryk->result_array();
							
							
							foreach($arrayk as $item){
								$queryz = $this->db->get_where('courses',array('id' => $item['course_id']));
								$arrayz = $queryz->result_array();
								
								foreach($arrayz as $itemx){
									if($itemx['start'] > $course_item['start'] && $itemx['end'] < $course_item['end']){
										$course_item['tag'] = 1;
										echo "Warning! " . $course_item['name'] . " has conflict with " . $itemx['name'];
										
										}
									if($itemx['start'] < $course_item['start'] && $itemx['end'] > $course_item['end']){
										$course_item['tag'] = 1;
									} 
								}								
							}
							
						?>
						
							<?php
								$temp = strtotime($course_item['start']);
								$var1 = date('M d, Y', $temp).PHP_EOL;
												
								$temp = strtotime($course_item['end']);
								$var2 = date('M d, Y', $temp).PHP_EOL;
								
							?>
							<tr class="linka">
							<td class="buttontable">
							
							<?php
							
							$this->load->helper('date');
							$this->load->helper('form');
							
							date_default_timezone_set("Asia/Manila");											
							$date = date('Y-m-d G:i:s');
							
							$querya = $this->db->get_where('reserved', array('course_id' => $course_item['id'], 'user_id' => $userid ) );
							$arraya= $querya->row_array();
								
								if( empty( $arraya['id'] ) ){			
									$this->load->helper('form');									
									echo validation_errors(); 
									echo form_open('participantcourse/reserved' ); ?>
										<input type='hidden' name='user_id' value='<?php echo $userid; ?>' />		
										<input type='hidden' name='course_id' value='<?php echo $course_item['id']; ?>' />
										<input type='hidden' name='date' value='<?php echo $date; ?>' />
										<button class='btn btn-info' style="padding: 5px" type='submit' name='submit' data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Reserved Course" ><i class="glyphicon glyphicon-map-marker"></i></button>					
									<?php echo form_close(); ?>
								<?php }
								else{
									$this->load->helper('form');									
									echo validation_errors(); 
									echo form_open('participantcourse/unreservedres' ); ?>
										<input type='hidden' name='user_id' value='<?php echo $userid; ?>' />		
										<input type='hidden' name='course_id' value='<?php echo $course_item['id']; ?>' />
										<input type='hidden' name='date' value='<?php echo $date; ?>' />
										<button onclick="return confirm('Are you sure you want to proceed?')" class='btn btn-danger' type='submit' style="padding: 5px" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Cancel Course" name='submit'><i class="glyphicon glyphicon-minus"></i></button>				
									<?php echo form_close(); ?>
								<?php }?>
							</td>
							<?php if($course_item['tag']) echo '<td class="dataj">';
							else echo '<td class="dataf">';?><center><?php echo $course_item['name']?></center></td>
							<?php if($course_item['tag']) echo '<td class="dataj">';
							else echo '<td class="dataf">';?><center><?php echo $course_item['description']?></center></td>
							<?php if($course_item['tag']) echo '<td class="dataj">';
							else echo '<td class="dataf">';?><center><?php echo $var1?></center></td>
							<?php if($course_item['tag']) echo '<td class="dataj">';
							else echo '<td class="dataf">';?><center><?php echo $var2?></center></td>
							<?php if($course_item['tag']) echo '<td class="dataj">';
							else echo '<td class="dataf">';?><center><?php echo $course_item['venue']?></center></td>
							<?php if($course_item['tag']) echo '<td class="dataj">';
							else echo '<td class="dataf">';?><center><?php echo $course_item['cost']?></center></td>
							<?php if($course_item['tag']) echo '<td class="dataj">';
							else echo '<td class="dataf">';?><center><?php echo $course_item['reserved']?> | <?php echo ($course_item['available']-($course_item['paid']+$course_item['reserved']));?> | <?php echo $course_item['paid']?></center></td>
							
							</tr>
						
						<?php } endforeach ?>
				</tbody>
			  </table>
			</div>
		<?php } ?>

		<?php
			date_default_timezone_set("Asia/Manila");											
			$date = date('Y-m-d');	
			$query1 = $this->db->get( 'courses' );
			$true = 0;
			
			foreach( $query1->result_array() as $rowAns ){
				$query2 = $this->db->get_where('reserved', array('course_id' => $rowAns['id'], 'user_id' => $userid) );
				$array2 = $query2->row_array();	
										
				$query3 = $this->db->get_where('cancelled', array('course_id' => $rowAns['id']) );
				$array = $query3->row_array();	

				$query4 = $this->db->get_where('dissolved', array('course_id' => $rowAns['id']) );
				$array4 = $query4->row_array();
				
				$queryCash = $this->db->get_where('payment', array('course_id' => $rowAns['id'], 'user_id' => $userid) );
				$arrayCash = $queryCash->row_array();	
				
				if( empty( $arrayCash['id'] ) && empty( $array4['id'])  && (empty( $array['id'] ) && empty( $array2['id'] )) && ( $rowAns['start'] > $date && $rowAns['end'] > $date ) ){
					if( !$rowAns['tempId'] ){
						$true = 1;
						break;
					}
				}
			}
			if( $true === 1 ){
		?>
			<div class="panel panel-success">
			  <div class="panel-heading">Upcoming Courses</div>
			  <table class="table table-striped">
			    <thead>
					<tr>
						<th style="width: 5%"></th>
						<th style="width: 20%"><center>Name</center></th>
						<th style="width: 15%"><center>Description</center></th>
						<th style="width: 14%"><center>Start</center></th>
						<th style="width: 14%"><center>End</center></th>
						<th style="width: 14%"><center>Venue</center></th>
						<th style="width: 8%"><center>Cost</center></th>
						<th style="width: 10%" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Reserved | Available | Paid"><center>R | A | P</center></th>			
					</tr>
				</thead>
				<tbody>	
					<?php foreach( $courses as $course_item ): ?>
						
						<?php 
						$this->load->helper('date');
						$this->load->helper('form');
																
						$date = date('Y-m-d');	
						$query1 = $this->db->get_where( 'courses', array('id' => $course_item['id']) );
						$array1 = $query1->row_array();
							
						$query2 = $this->db->get_where('reserved', array('course_id' => $array1['id'], 'user_id' => $userid) );
						$array2 = $query2->row_array();	
						
						$queryCash = $this->db->get_where('payment', array('course_id' => $array1['id'], 'user_id' => $userid) );
						$arrayCash = $queryCash->row_array();		
						
						$query3 = $this->db->get_where('cancelled', array('course_id' => $array1['id']) );
						$array = $query3->row_array();	
						
						$queryDis = $this->db->get_where('dissolved', array('course_id' => $array1['id']) );
						$arrayDis = $queryDis->row_array();
							
						if( empty( $arrayCash['id'] ) && ( (empty( $array['id'] ) && empty( $array2['id'] )) && empty($arrayDis['id'])) && ( $course_item['start'] > $date&& $course_item['end'] > $date ) ){
						?>
						
						<?php
							$temp = strtotime($course_item['start']);
							$var1 = date('M d, Y', $temp).PHP_EOL;
												
							$temp = strtotime($course_item['end']);
							$var2 = date('M d, Y', $temp).PHP_EOL;
						?>	
						<tr class="linka">
						<td>
						
						<?php
						
						$this->load->helper('date');
						$this->load->helper('form');
						$now = time();
						$date = unix_to_human($now, TRUE, 'us');
													
													
						$querya = $this->db->get_where('reserved', array('course_id' => $course_item['id'], 'user_id' => $userid ) );
							$arraya= $querya->row_array();
							
							if( empty( $arraya['id'] ) ){			
								$this->load->helper('form');									
								echo validation_errors(); 
								echo form_open('participantcourse/reserved' ); ?>
									<input type='hidden' name='user_id' value='<?php echo $userid ?>' />	
									<input type='hidden' name='course_id' value='<?php echo $course_item['id'] ?>' />
									<input type='hidden' name='date' value='<?php echo $date ?>' />
									<button class='btn btn-info' style="padding: 5px" type='submit' name='submit' data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Reserved Course" ><i class="glyphicon glyphicon-map-marker"></i></button>					
								<?php echo form_close(); ?>
							<?php }
							else{
								$this->load->helper('form');									
								echo validation_errors(); 
								echo form_open('participantcourse/unreserved' ); ?>
									<input type='hidden' name='user_id' value='<?php echo $userid ?>' />	
									<input type='hidden' name='course_id' value='<?php echo $course_item['id'] ?>' />
									<input type='hidden' name='date' value='<?php echo $date ?>' />
									<button onclick="return confirm('Are you sure you want to proceed?')" class='btn btn-danger' type='submit' style="padding: 5px" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Cancel Course" name='submit'><i class="glyphicon glyphicon-minus"></i></button>				
								<?php echo form_close(); ?>
							<?php }?>
						</td>
						<td class="dataf"><center><?php echo $course_item['name']?></center></td>
						<td class="dataf"><center><?php echo $course_item['description']; ?></center></td>
						<td class="dataf"><center><?php echo $var1?></center></td>
						<td class="dataf"><center><?php echo $var2?></center></td>
						<td class="dataf"><center><?php echo $course_item['venue']?></center></td>
						<td class="dataf"><center><?php echo $course_item['cost']?></center></td>
						<td class="dataf"><center><?php echo $course_item['reserved']?> | <?php echo ($course_item['available'] - ($course_item['reserved']+$course_item['paid']) );?> | <?php echo $course_item['paid']?></center></td>
						
						</tr>
						
						<?php } endforeach ?>
					</tbody>
			  </table>
			</div>
		<?php } ?>

		<?php
			$queryCash = $this->db->get_where('payment', array('user_id' => $userid) );
			$arrayCash = $queryCash->row_array();	

			if( !empty($arrayCash['id']) ){
		?>
		<div class="panel panel-success">
			<div class="panel-heading">Paid Courses</div>
			<table class="table table-striped">
				<thead>
					<tr>
						<th style="width: 16%"><center>Name</center></th>
						<th style="width: 20%"><center>Description</center></th>
						<th style="width: 12%"><center>Start</center></th>
						<th style="width: 12%"><center>End</center></th>
						<th style="width: 16%"><center>Time</center></th>
						<th style="width: 14%"><center>Venue</center></th>
						<th style="width: 10%"><center>Cost</center></th>
					</tr>
				</thead>
				<tbody>
					<?php 
						foreach( $pay as $course_item ):
							$queryCourse = $this->db->get_where( 'courses', array('id' => $course_item['id']) );
							$arrayCourse = $queryCourse->row_array();
							
							$queryCash = $this->db->get_where('payment', array('course_id' => $arrayCourse['id'], 'user_id' => $userid) );
							$arrayCash = $queryCash->row_array();	
							
							$start_time = date_create($arrayCourse['startTime']);
							$start_time = date_format($start_time, 'g:i A');

							$end_time = date_create($arrayCourse['endTime']);
							$end_time = date_format($end_time, 'g:i A');//$startTimes." - ".$endTimes

							$temp = strtotime($arrayCourse['start']);
							$var1 = date('M d, Y', $temp).PHP_EOL;
												
							$temp = strtotime($arrayCourse['end']);
							$var2 = date('M d, Y', $temp).PHP_EOL;									
							if( !empty($arrayCash['id']) ){ ?>										
						<tr>	
								<td class="dataf"><center><?php echo $arrayCourse['name']; ?></center></td>
								<td class="dataf"><center><?php echo $arrayCourse['description']; ?></center></td>
								<td class="dataf"><center><?php echo $var1; ?></center></td>
								<td class="dataf"><center><?php echo $var2; ?></center></td>
								<td class="dataf"><center><?php echo $start_time." - ".$end_time; ?></center></td>
								<td class="dataf"><center><?php echo $arrayCourse['venue']; ?></center></td>
								<td class="dataf"><center><?php echo $arrayCourse['cost']; ?></center></td>
							<?php } ?>
						</tr>
						<?php endforeach ?>
				</tbody>
			</table>
		</div>
		<?php }?>

		<?php
			$queryCash = $this->db->get_where('cancelled', array('user_id' => $userid) );
			$arrayCash = $queryCash->row_array();	

			if( !empty($arrayCash['id']) ){
		?>
		<div class="panel panel-success">
		  <div class="panel-heading">Refunded Courses</div>
		  <table class="table table-striped">
		    <thead>
				<tr>
					<th style="width: 25%"><center>Name</center></th>
					<th style="width: 20%"><center>Description</center></th>
					<th style="width: 15%"><center>Start</center></th>
					<th style="width: 15%"><center>End</center></th>
					<th style="width: 15%"><center>Venue</center></th>
					<th style="width: 10%"><center>Cost</center></th>
				</tr>
			</thead>
			<tbody>
				<?php 
					foreach( $courses as $course_item ):
						$queryCourse = $this->db->get_where( 'courses', array('id' => $course_item['id']) );
						$arrayCourse = $queryCourse->row_array();
						
						$queryCash = $this->db->get_where('cancelled', array('course_id' => $arrayCourse['id'], 'user_id' => $userid) );
						$arrayCash = $queryCash->row_array();	
						
						$temp = strtotime($arrayCourse['start']);
						$var1 = date('M d, Y', $temp).PHP_EOL;
											
						$temp = strtotime($arrayCourse['end']);
						$var2 = date('M d, Y', $temp).PHP_EOL;									
						if( !empty($arrayCash['id']) ){ ?>										
					<tr>	
							<td class="dataf"><center><?php echo $arrayCourse['name']; ?></center></td>
							<td class="dataf"><center><?php echo $arrayCourse['description']; ?></center></td>
							<td class="dataf"><center><?php echo $var1; ?></center></td>
							<td class="dataf"><center><?php echo $var2; ?></center></td>
							<td class="dataf"><center><?php echo $arrayCourse['venue']; ?></center></td>
							<td class="dataf"><center><?php echo $arrayCourse['cost']; ?></center></td>
						<?php } ?>
					</tr>
					<?php endforeach ?>
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
