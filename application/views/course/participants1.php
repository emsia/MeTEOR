<div class="span9" style="margin-left: -30px">
	<div class="content">
		<?php 
			if(!$manager) echo form_open('course/search_cancelled');
			else echo form_open('managercourse/search_cancelled');
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
			if( !empty($users) ) {
		?>
		<div class="panel panel-success">
		  <div class="panel-heading">Participants</div>
		  <table class="table table-striped">
		  	<thead>
			    <tr>
					<th style="width: 3%"></th>
					<th style="width: 20%"><center>Last Name</center></th>
					<th style="width: 20%"><center>First Name</center></th>
					<th style="width: 20%"><center>Middle Name</center></th>
					<th style="width: 20%"><center>Email</center></th>
					<th style="width: 17%"><center>Status</center></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach( $users as $participant_item ): ?>
				<?php if( isset( $participant_item ) ){ 
					$ask = $participant_item['user_id'];
					$ask2 = $participant_item['course_id'];
					$cancelledOrNot = 0;
					
					$query = $this->db->get_where('reserved', array('course_id' => $ask2, 'user_id' => $ask) );
					$array = $query->row_array();
					if( !empty($array['id']) ){
						$select = "U.username, U.firstname, U.lastname, U.id, U.middlename";
						$from = "reserved R, courses C, users U";
						$where = "U.id = $ask AND R.user_id = $ask AND R.course_id = $ask2";
						
						$this->db->select( $select );
						$this->db->from( $from );
						$this->db->where( $where );
						$cancelledOrNot = 1; // 1 = meaning not cancelled
					}
					else{
						$select = "U.username, U.firstname, U.lastname, U.id, U.middlename";
						$from = "cancelled Ca, courses C, users U";
						$where = "U.id = $ask AND Ca.user_id = $ask AND Ca.course_id = $ask2";
						
						$this->db->select( $select );
						$this->db->from( $from );
						$this->db->where( $where );
					}
					$query = $this->db->get();
					$array = $query->row_array();	
				?>				
				<tr class="linka">
				<td class="buttontable">
					<?php 
						$this->load->helper('form');
						echo form_open('course/untagRefund');
					?>
					<input type="hidden" name="genId" value="<?php echo $id; ?>" />
					<input type="hidden" name="user_id" value="<?php echo $ask; ?>" />
					<input type="hidden" name="course_id" value="<?php echo $ask2; ?>" />
					<?php
						$query1 = $this->db->get_where('cancelled', array('user_id' => $participant_item['user_id'], 'course_id' => $ask2));
						$array1 = $query1->row_array();
						if( !empty($array1['id']) && $array1['untag'] == 1 ){
					?>
						<button data-toggle="tooltip" style='padding: 5px'; data-trigger="hover" data-placement="top" title data-original-title="Untagged Already" class='btn btn-success choose' type='button' name='submit' ><i class="glyphicon glyphicon-ok"></i></button>
					<?php } else {?>
					<button style='padding: 5px'; data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Untag" onclick="return confirm('Are you sure you want to proceed?')" class='btn btn-info choose' type='submit' name='submit'><i class="glyphicon glyphicon-magnet"></i></button>
					<?php }echo form_close(); ?>
				</td>
				<td class="dataf"><center><?php echo ucwords(strtolower($array['lastname'])); ?></center></td>
				<td class="dataf"><center><?php echo ucwords(strtolower($array['firstname'])); ?></center></td>
				<td class="dataf"><center><?php echo ucwords(strtolower($array['middlename'])); ?></center></td>
				<td class="dataf"><center><?php echo $array['username']?> <center></td>
				<td class="dataf">
					<?php 
						$var = 0;
						$query = $this->db->get_where('users', array('role' => 2));
						$array2 = $query->row_array();
						
						if( !empty($array2['id']) ){
							$query1 = $this->db->get_where('cancelled', array('user_id' => $participant_item['user_id'], 'course_id' => $ask2));
							$array1 = $query1->row_array();
							if( !empty($array1['id']) && $array1['untag'] == 1 ){
								echo "<center><span class='badge badge-success'>Untagged</span></center>";
								$var = 1;
							}
							elseif( !empty($array1['id']) && $array1['refunded'] == 1 ){
								echo "<center><span class='badge badge-error'>For Refund</span></center>";	
								$var = -1;
							}	
							else{
								$query = $this->db->get_where('bankpayment', array( 'course_id' => $ask2, 'user_id' => $participant_item['user_id']));
								$array3 = $query->row_array();
								
								$query1 = $this->db->get_where('payment', array( 'course_id' => $ask2, 'user_id' => $participant_item['user_id']));
								$array1 = $query1->row_array();
								
								if( !empty($array3['id']) || !empty($array1['id'])){
									echo "<center><span class='badge badge-success'>Validated</span></center>";
									$var = 1;
								}	
								else if( $cancelledOrNot ){
									echo "<center><span class='badge badge-warning'>Reserved</span></center>";
									$var = 0;
								}	
								else{
									echo "<center><span class='badge badge-info'>Free Reservations</span></center>";
								}
							}	
						}
					?>
				</td>
				<?php }?>
				</tr>
				
				<?php endforeach ?>
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