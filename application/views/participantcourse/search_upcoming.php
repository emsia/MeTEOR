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

		<?php if( $counter > 0 ) { ?>
			<?php
				$set = 0;
				for($i=0; $i<$counter; $i++) {
					$temp = strtotime($start[$i]);
					$var1 = date('m-d-Y', $temp).PHP_EOL;
													
					$temp = strtotime($end[$i]);
					$var2 = date('m-d-Y', $temp).PHP_EOL;	
									
					date_default_timezone_set("Asia/Manila");											
					$date = date('Y-m-d');	
									
					$query2 = $this->db->get_where('reserved', array('course_id' => $id[$i], 'user_id' => $userid) );
					$array2 = $query2->row_array();		
									
					$queryCash = $this->db->get_where('payment', array('course_id' => $id[$i], 'user_id' => $userid) );
					$arrayCash = $queryCash->row_array();	
										
					$query3 = $this->db->get_where('cancelled', array('course_id' => $id[$i]) );
					$array = $query3->row_array();	
									
					$queryDis = $this->db->get_where('dissolved', array('course_id' => $id[$i]) );
					$arrayDis = $queryDis->row_array();
											
					if( ( empty($array['id']) && empty($arrayDis['id']) ) && $start[$i] > $date){							
						$set = 1;
						break;
					}
				}
				if( $set ){
			?>

			<div class="panel panel-success">
			  <div class="panel-heading">Search Results -- Upcoming Courses</div>
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
				<?php for($i=0; $i<$counter; $i++) {?>
					<?php					
						$temp = strtotime($start[$i]);
						$var1 = date('M d, Y', $temp).PHP_EOL;
										
						$temp = strtotime($end[$i]);
						$var2 = date('M d, Y', $temp).PHP_EOL;	
						
						date_default_timezone_set("Asia/Manila");											
						$date = date('Y-m-d');	
						
						$query2 = $this->db->get_where('reserved', array('course_id' => $id[$i], 'user_id' => $userid) );
						$array2 = $query2->row_array();		
						
						$queryCash = $this->db->get_where('payment', array('course_id' => $id[$i], 'user_id' => $userid) );
						$arrayCash = $queryCash->row_array();	
							
						$query3 = $this->db->get_where('cancelled', array('course_id' => $id[$i]) );
						$array = $query3->row_array();	
						
						$queryDis = $this->db->get_where('dissolved', array('course_id' => $id[$i]) );
						$arrayDis = $queryDis->row_array();

						if( ( empty($array['id']) && empty($arrayDis['id']) ) ){
							if( $start[$i] > $date ){
					?>				
					<tr> 
					<td class="buttontable">
						<?php 								
							$this->load->helper('date');
							$this->load->helper('form');
												
							date_default_timezone_set("Asia/Manila");
							$date = date('Y-m-d G:i:s');
							
							if( empty( $array2['id'] ) && $start[$i] > $date ){			
								$this->load->helper('form');									
								echo validation_errors(); 
								echo form_open('participantcourse/reserved' ); ?>
									<input type='hidden' name='user_id' value='<?php echo $userid; ?>' />		
									<input type='hidden' name='course_id' value='<?php echo $id[$i]; ?>' />
									<input type='hidden' name='date' value='<?php echo $date; ?>' />
									<button class='btn btn-info' style="padding: 5px" type='submit' name='submit' data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Reserved Course" ><i class="glyphicon glyphicon-map-marker"></i></button>					
								<?php echo form_close(); ?>
							<?php }
							else if( !empty($array2['id']) ){
								$this->load->helper('form');									
								echo validation_errors(); 
								echo form_open('participantcourse/unreservedres' ); ?>
									<input type='hidden' name='user_id' value='<?php echo $userid; ?>' />		
									<input type='hidden' name='course_id' value='<?php echo $id[$i]; ?>' />
									<input type='hidden' name='date' value='<?php echo $date; ?>' />
									<button onclick="return confirm('Are you sure you want to proceed?')" class='btn btn-danger' type='submit' style="padding: 5px" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Cancel Course" name='submit'><i class="glyphicon glyphicon-minus"></i></button>				
								<?php echo form_close(); ?>
							<?php }?>
					</td>
					<td class="dataf"><center><?php echo $name[$i]; ?></center></td>
					<td class="dataf"><center><?php echo $description[$i]; ?></center></td>
					<td class="dataf"><center><?php echo $var1; ?></center></td>
					<td class="dataf"><center><?php echo $var2; ?></center></td>
					<td class="dataf"><center><?php echo $venue[$i] ?></center></td>
					<td class="dataf"><center><?php echo $cost[$i]; ?></center></td>
					<td class="dataf"><center><?php echo $reserved[$i]?> | <?php echo $available[$i]; ?> | <?php echo $paid[$i]; ?></center></td>
					</tr>
					<?php }?>
				<?php }}?>
				</tbody>
			  </table>
			</div>
			<?php }?>

			<?php
				$set = 0;
				for($i=0; $i<$counter; $i++) {
					$temp = strtotime($start[$i]);
					$var1 = date('m-d-Y', $temp).PHP_EOL;
													
					$temp = strtotime($end[$i]);
					$var2 = date('m-d-Y', $temp).PHP_EOL;	
									
					date_default_timezone_set("Asia/Manila");											
					$date = date('Y-m-d');	
									
					$query2 = $this->db->get_where('reserved', array('course_id' => $id[$i], 'user_id' => $userid) );
					$array2 = $query2->row_array();		
									
					$queryCash = $this->db->get_where('payment', array('course_id' => $id[$i], 'user_id' => $userid) );
					$arrayCash = $queryCash->row_array();	
										
					$query3 = $this->db->get_where('cancelled', array('course_id' => $id[$i]) );
					$array = $query3->row_array();	
									
					$queryDis = $this->db->get_where('dissolved', array('course_id' => $id[$i]) );
					$arrayDis = $queryDis->row_array();

					if( ( $start[$i] <= $date && $end[$i] >= $date ) && ( empty($array['id']) && empty($arrayDis['id']) ) ){							
						$set = 1;
						break;
					}
				}
				if( $set ){
			?>
			<div class="panel panel-success">
				<div class="panel-heading">Search Results -- Ongoing Courses</div>
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
					<?php for($i=0; $i<$counter; $i++) { ?>
						<?php
							$temp = strtotime($start[$i]);
							$var1 = date('M d, Y', $temp).PHP_EOL;
											
							$temp = strtotime($end[$i]);
							$var2 = date('M d, Y', $temp).PHP_EOL;	
							
							date_default_timezone_set("Asia/Manila");											
							$date = date('Y-m-d');	
							
							$query2 = $this->db->get_where('reserved', array('course_id' => $id[$i], 'user_id' => $userid) );
							$array2 = $query2->row_array();		
							
							$queryCash = $this->db->get_where('payment', array('course_id' => $id[$i], 'user_id' => $userid) );
							$arrayCash = $queryCash->row_array();	
								
							$query3 = $this->db->get_where('cancelled', array('course_id' => $id[$i]) );
							$array = $query3->row_array();	
							
							$queryDis = $this->db->get_where('dissolved', array('course_id' => $id[$i]) );
							$arrayDis = $queryDis->row_array();
									
							if( ( $start[$i] <= $date && $end[$i] >= $date ) && ( empty($array['id']) && empty($arrayDis['id']) ) ){
						?>				
						<tr> 
							<td class="dataf"><center><?php echo $name[$i]; ?></center></td>
							<td class="dataf"><center><?php echo $description[$i]; ?></center></td>
							<td class="dataf"><center><?php echo $var1; ?></center></td>
							<td class="dataf"><center><?php echo $var2; ?></center></td>
							<td class="dataf"><center><?php echo $venue[$i] ?></center></td>
							<td class="dataf"><center><?php echo $cost[$i]; ?></center></td>
						</tr>
					<?php }} ?>
					</tbody>
				</table>
			</div>
			<?php }?>
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