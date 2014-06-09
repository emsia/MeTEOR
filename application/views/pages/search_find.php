<div class="container-fluid" style="padding-top: 48px; padding: 30px;" id="wrap">
	<div class="row-fluid">
		<?php echo form_open('pages/search_find');?>
		<div class="control-group">
			<div class="controls">
				<input type="text" autocomplete="off" data-provide='typeahead' data-items='<?php echo $count_All; ?>' data-source='<?php echo $array;?>' required placeholder="Type Here" name="search"/>
				<button type="submit" class="btn btn-success">Search <i class="glyphicon glyphicon-search"></i></button>
			</div>
		</div>
		<?php echo form_close();?>
		<hr>

		<?php
			$set = 0;
			for($i=0; $i<$counter; $i++) {
				date_default_timezone_set("Asia/Manila");
				$date = date('Y-m-d');	
				if( $start[$i] > $date && $end[$i] > $date ){
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
						<th></th>
						<th><center>Name</center></th>
						<th><center>Description</center></th>
						<th><center>Start</center></th>
						<th><center>End</center></th>
						<th><center>Time</center></th>
						<th><center>Venue</center></th>
						<th><center>Cost</center></th>
						<th data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Reserved | Available | Paid"><center>R | A | P</center></th>			
					</tr>
				</thead>
				<tbody>
			<?php for($i=0; $i<$counter; $i++) {?>
				<?php	
					date_default_timezone_set("Asia/Manila");
					$date = date('Y-m-d');	
					if( $start[$i] > $date && $end[$i] > $date ){
				?>				
				<tr> 
					<td class="buttontable">
						<?php 																						
							$session_name = $this->session->userdata('user');
							$query3 = $this->db->get_where( 'users', array('username' => $session_name) );
							$array3 = $query3->row_array();	
															
							$this->load->helper('date');
							$this->load->helper('form');
												
							date_default_timezone_set("Asia/Manila");
												
							$var1 = date('Y-m-d G:i:s');
												
							echo validation_errors();
							echo form_open('pages/enroll');?>
							<input type='hidden' name='course_id' value='<?php echo $id[$i]; ?>' />
							<input type='hidden' name='user_id' value='<?php echo $array3['id']; ?>'/>
							<input type='hidden' name='date' value='<?php echo $var1; ?>'/>
							<input type='hidden' name='refunded' value='<?php echo $paid[$i]; ?>'/>
							<button style='padding: 7px' data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Enroll" class='btn btn-warning' type='submit' name='submit'><i class="glyphicon glyphicon-pencil"></i></button>					
					</td>
				<?php
					$temp = strtotime($start[$i]);
					$var1 = date('M d, Y', $temp).PHP_EOL;
									
					$temp = strtotime($end[$i]);
					$var2 = date('M d, Y', $temp).PHP_EOL;					
				?>
				<td class="dataf"><center><?php echo $name[$i]; ?></center></td>
				<td class="dataf"><center><?php echo $description[$i]; ?></center></td>
				<td class="dataf"><center><?php echo $var1; ?></center></td>
				<td class="dataf"><center><?php echo $var2; ?></center></td>
				<td class="dataf"><center><?php echo $time[$i] ?></center></td>
				<td class="dataf"><center><?php echo $venue[$i] ?></center></td>
				<td class="dataf"><center><?php echo $cost[$i]; ?></center></td>
				<td class="dataf"><center><?php echo $reserved[$i]?> | <?php echo ($available[$i] - ($reserved[$i]+$paid[$i]) ); ?> | <?php echo $paid[$i]; ?></center></td>
				<?php echo form_close(); } ?>
				</tr>
				<?php }?>
				</tbody>
			  </table>
			</div>
		<?php } ?>
		<?php
			$set = 0;
			for($i=0; $i<$counter; $i++) {
				date_default_timezone_set("Asia/Manila");
				$date = date('Y-m-d');	
				if( $start[$i] <= $date && $end[$i] >= $date ){
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
						<th><center>Name</center></th>
						<th><center>Description</center></th>
						<th><center>Start</center></th>
						<th><center>End</center></th>
						<th><center>Time</center></th>
						<th><center>Venue</center></th>
						<th><center>Cost</center></th>
						<th data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Reserved | Available | Paid"><center>R | A | P</center></th>			
					</tr>
				</thead>
				<tbody>
			<?php for($i=0; $i<$counter; $i++) {?>
				<?php	
					date_default_timezone_set("Asia/Manila");
					$date = date('Y-m-d');	
					if( $start[$i] <= $date && $end[$i] >= $date ){
				?>				
				<tr class='linka'> 				
				<?php
					$temp = strtotime($start[$i]);
					$var1 = date('M d, Y', $temp).PHP_EOL;
									
					$temp = strtotime($end[$i]);
					$var2 = date('M d, Y', $temp).PHP_EOL;					
				?>
				<td class="dataf"><center><?php echo $name[$i]; ?></center></td>
				<td class="dataf"><center><?php echo $description[$i]; ?></center></td>
				<td class="dataf"><center><?php echo $var1; ?></center></td>
				<td class="dataf"><center><?php echo $var2; ?></center></td>
				<td class="dataf"><center><?php echo $time[$i] ?></center></td>
				<td class="dataf"><center><?php echo $venue[$i] ?></center></td>
				<td class="dataf"><center><?php echo $cost[$i]; ?></center></td>
				<td class="dataf"><center><?php echo $reserved[$i]?> | <?php echo $available[$i]; ?> | <?php echo $paid[$i]; ?></center></td>
				<?php	}	?>
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