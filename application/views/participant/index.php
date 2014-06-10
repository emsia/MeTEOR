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

		<div class="panel panel-success">
		  <div class="panel-heading">Participants List</div>
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
				<?php foreach($participant as $participant_item): ?>
					<?php if( isset( $participant_item ) ){ ?>				
				<tr class="linka">
				<td>
					<?php
						$this->load->helper('form');									
							echo validation_errors(); 
							if(!$manager) echo form_open('participant/viewprofile' ); 
							else echo form_open('managerparticipant/viewprofile' ); 
						?>
							<input type='hidden' name='user_id' value='<?php echo $participant_item['id']; ?>' />			
							<button class='btn btn-success' style="padding: 5px" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="View Profile" type='submit' name='submit'><i class="glyphicon glyphicon-picture"></i></button> 
					<?php echo form_close(); ?>
				</td>
				<td>
				<?php 
					$setCancelled = 1; $setPaid = 1; $setRes = 1;
						$queryPaid = $this->db->get_where( 'payment', array('user_id' => $participant_item['id']) );
						$arrayPaid = $queryPaid->row_array();
															
						$queryCancelled = $this->db->get_where( 'cancelled', array('user_id' => $participant_item['id']) );
						$arrayCancelled= $queryCancelled->row_array();
						
						$queryRes = $this->db->get_where( 'reserved', array('user_id' => $participant_item['id']) );
						$arrayRes = $queryRes->row_array();
						
						if( !empty($arrayCancelled['id']) ) $setCancelled = 0;
						if( !empty($arrayRes['id']) ) $setRes = 0;
						if( !empty($arrayPaid['id']) ) $setPaid= 0;
				?>
				<?php 
					if( ($setRes && $setCancelled) && ( $setPaid ) ){
				?>
					<button class='btn btn-danger' style="padding: 5px" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="No Course(s) Yet" type='button' name='submit'><i class="glyphicon glyphicon-file"></i></button>
				<?php }else{ ?>
				<?php
					$this->load->helper('form');									
						echo validation_errors(); 
						echo form_open('participant/printAttendance' ); 
					?>
							<input type='hidden' name='user_id' value='<?php echo $participant_item['id']; ?>' />		
							<input type='hidden' name='fullname' value='<?php echo $participant_item['lastname'].", ".$participant_item['firstname']; ?>' />
							<button class='btn btn-info' style="padding: 5px" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Print Attended Course(s)" type='submit' name='submit'><i class="glyphicon glyphicon-file"></i></button>
					<?php echo form_close(); ?>
				<?php }?>
				</td>
				<td class="dataf"><center><?php echo ucwords(strtolower($participant_item['lastname'])); ?></center></td>
				<td class="dataf"><center><?php echo ucwords(strtolower($participant_item['firstname'])); ?></center></td>
				<td class="dataf"><center><?php echo ucwords(strtolower($participant_item['middlename'])); ?></center></td>
				<td class="dataf"><center><?php echo $participant_item['username']?></center></td>
				<td>
					<?php
						if( $setRes == 0 && $setCancelled == 0 ) echo "<center><span class='badge badge-error'>For Validation </span><br style='margin-bottom: 5px' /><span class='badge badge-error'>Has Refunded Course(s)</span></center>";
						else if( $setRes == 0 ) echo "<center style='color:#3498db'><span class='badge badge-info'>For Validation</span></center>";
						else if( ( $setPaid == 0 ) && $setCancelled == 0 ) echo "<center><span class='badge badge-success'>Validated </span><br style='margin-bottom: 5px' /><span class='badge badge-error'>Has Refunded Course(s)</span></center>";					
						else if( $setCancelled == 0 ) echo "<center><span class='badge badge-error'>Has Refunded Course(s)</span></center>";
						else if( ($setRes && $setCancelled) && ( $setPaid ) ) echo "<center><span class='badge badge-warning'>Has No Course(s) Yet</span></center>";
						else echo "<center><span class='badge badge-success'>Validated</span></center>";
					?>
				</td>
				</tr>
				
					<?php }?>
				<?php endforeach ?>
			<tbody>	
		  </table>
		</div>
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