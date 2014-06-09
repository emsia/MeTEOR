<div class="span9" style="margin-left: -30px">
	<div class="content">
		<?php
			$this->load->helper('form');
			$class = array('class' => 'form-inline');
			if(!$manager) echo form_open('participant/search_users', $class); 
			else echo form_open('managerparticipant/search_users', $class); 
		?>
		<div class="control-group">
			<div class="controls">
				<input type="text" autocomplete="off" data-provide='typeahead' data-items='<?php echo $count_All; ?>' data-source='<?php echo $array;?>' required placeholder="Type Here" name="search"/>
				<button type="submit" class="btn btn-large btn-success">Search</button>
			</div>
		</div>
		<?php echo form_close();?>
		<hr>

		<?php 
			if( $counter > 0 ) {
		?>
			<div class="panel panel-success">
			  <div class="panel-heading">Search Results</div>
			  <table class="table table-striped">
			    <thead>	
					<tr>
						<th style="width: 3%"></th>
						<th style="width: 3%"></th>
						<th style="width: 19%"><center>Last Name</center></th>
						<th style="width: 19%"><center>First Name</center></th>
						<th style="width: 19%"><center>Middle Name</center></th>
						<th style="width: 19%"><center>Email</center></th>
						<th style="width: 18%"><center>Status</center></th>
					</tr>
				</thead>
				<tbody>
					<?php for($i=0; $i<$counter; $i++) {?>
						<tr class="linka">
							<td class="buttontable">
								<?php
									$setCancelled = 1; $setPaid = 1; $setRes = 1;
									$queryPaid = $this->db->get_where( 'payment', array('user_id' => $id[$i]) );
									$arrayPaid = $queryPaid->row_array();
												
									$queryCancelled = $this->db->get_where( 'cancelled', array('user_id' => $id[$i]) );
									$arrayCancelled= $queryCancelled->row_array();
												
									$queryRes = $this->db->get_where( 'reserved', array('user_id' => $id[$i]) );
									$arrayRes = $queryRes->row_array();
												
									if( !empty($arrayCancelled['id']) ) $setCancelled = 0;
									if( !empty($arrayRes['id']) ) $setRes = 0;
									if( !empty($arrayPaid['id']) ) $setPaid= 0;
								?>
								<?php
								$this->load->helper('form');									
								echo validation_errors(); 
								if(!$manager) echo form_open('participant/viewprofile' );
								else echo form_open('managerparticipant/viewprofile' );
								?>
									<input type='hidden' name='user_id' value='<?php echo $id[$i]; ?>' />			
									<button class='btn btn-success' style="padding: 5px" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="View Profile" type='submit' name='submit'><i class="glyphicon glyphicon-picture"></i></button> 
								<?php echo form_close(); ?>
							</td>
							<td>
								<?php
									$this->load->helper('form');									
										echo validation_errors(); 
										echo form_open('participant/printAttendance' );?>
											<input type='hidden' name='user_id' value='<?php echo $id[$i]; ?>' />
											<input type='hidden' name='fullname' value='<?php echo $lastname[$i].", ".$firstname[$i]; ?>' />
										<?php if( ($setRes && $setCancelled) && ( $setPaid ) ){?><button class='btn btn-danger' style="padding: 5px" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="No Course(s) Yet" type='button' name='submit'><i class="glyphicon glyphicon-file"></i></button>
										<?php }else{ ?>
											<button class='btn btn-info' style="padding: 5px" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Print Attendance" type='submit' name='submit'><i class="glyphicon glyphicon-file"></i></button>
										<?php }?>
										<?php echo form_close(); ?>
							</td>
							<td class="dataf"><center><?php echo $lastname[$i]?></center></td>
							<td class="dataf"><center><?php echo $firstname[$i]?></center></td>
							<td class="dataf"><center><?php echo $middlename[$i]?></center></td>
							<td class="dataf"><center><?php echo $username[$i]?></center></td>
							<td class="dataf"><center>
								<?php			
									if( $setRes == 0 && $setCancelled == 0 ) echo "<center><span class='badge badge-error'>For Validation and Has Refunded Course(s)</span></center>";
									else if( $setRes == 0 ) echo "<center><span class='badge badge-info'>For Validation</span></center>";
									else if( ( $setPaid == 0 ) && $setCancelled == 0 ) echo "<center><span class='badge badge-error'>Validated and Has Refunded Course(s)</span></center>";					
									else if( $setCancelled == 0 ) echo "<center><span class='badge badge-error'>Has Refunded Course(s)</span></center>";
									else if( ($setRes && $setCancelled) && ( $setPaid ) ) echo "<center><span class='badge badge-warning'>Has No Course(s) Yet</span></center>";
									else echo "<center><span class='badge badge-success'>Validated</span></center>";
								?>
								</center>
							</td>
						</tr>
					<?php }?>
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