<?php $list = array( '-- Dept --', 'CM', 'EIS', 'FMIS', 'HARDWARE', 'HRIS', 'IS', 'PS', 'SAIS', 'SPCMIS', 'TRAINING', '-- ALL --'); ?>

<div class="span9" style="margin-left: -30px">
	<div class="content">
		<?php echo form_open('course/reports_search');?>
		<input name="type" type="hidden" value="COURSE" />
		<div class="control-group">
			<div class="controls">
				<input type="text" class="pick" required placeholder="From" name="starting"/>
				<input type="text" class="pick" required placeholder="To" name="ending"/>
				<div class="btn-group btn-input clearfix">
					<select name="dept" class="select">
						<?php for( $i = 0; $i <= 11; $i++ ){ ?>
						<option value="<?php echo $list[$i]; ?>"><?php echo $list[$i]; ?></option>				  
						<?php } ?>
					</select>
				</div>
				<button type="submit" class="btn btn-large btn-success">Search</button>
			</div>
		</div>
		<hr/>
		<?php echo form_close();?>

		<?php 
			if( !empty($users) ) {
		?>
		<div class="panel panel-success">
		  <div class="panel-heading">COURSE NAME & DESCRIPTION</div>
		  <div class="panel-body">
		    <p><?php echo $name;?> : <?php echo $description;?></p>
		  </div>
		  <table class="table table-stripes">
		  		<thead>	
					<tr>
						<th style="width: 21%"><center>Last Name</center></th>
						<th style="width: 21%"><center>First Name</center></th>
						<th style="width: 21%"><center> Email</center></th>
						<th style="width: 21%"><center>Status</center></th>
						<th style="width: 16%"><center>Payment</center></th>
					</tr>
				</thead>
				<tbody>
					<?php for( $i = 0; $i < $count; $i++ ): 
						$cancelledOrNot = 1;
						$set = 0;
						
						for( $j = 0; $j < $decount; $j++ ){
							if( $tagS[$j] == $user_id[$i] ){
								$cancelledOrNot = 0;
								break;
							}
						}
						$cancelledOrNot = 1;
					?>
					<div><a href="#">				
					<tr class="linka">
					<?php if( $cancelledOrNot ){?>
							<?php	
								$var = 0; $var2 = 0;
								$query = $this->db->get_where('users', array('role' => 2));
								$array2 = $query->row_array();
								
								if( !empty($array2['id']) ){
									$set = 1;
									$query1 = $this->db->get_where('cancelled', array('user_id' => $user_id[$i], 'course_id' => $course_id));
									$array1 = $query1->row_array();
									
									if( !empty($array1['id']) && $array1['refunded'] == 1 ){
										echo "<center class='refund'>For Refund</center>";	
										$var = -1;
									}	
									else{
										$query = $this->db->get_where('payment', array( 'course_id' => $course_id, 'user_id' => $user_id[$i]));
										$array3 = $query->row_array();
										
										if( !empty($array3['id']) )
											$var = 1;
										else if( $cancelledOrNot )
											$var = 0;
										if( !empty($array3['remarks'])	&& $array3['remarks'] === "free" )
											$var2 = 1;
									}	
								}
					}?>
					<td class="dataf"><center><?php echo ucwords(strtolower($lastname[$i]));?></center></td>
					<td class="dataf"><center><?php echo ucwords(strtolower($firstname[$i]));?></center></td>
					<td class="dataf"><center><?php echo $username[$i];?><center></td>
					<td class="dataf">
						<?php 											
							if( $set ){
								if( $var == -1 )
									echo "<center style='color:red'>For Refund</center>";	
								else{													
									if( $var == 1 )
										echo "<center style='color:red'>Validated</center>";
									else if( $var == 0 )
										echo "<center style='color:red'>For Validation</center>";
									else{
										echo "<center style='color:red'>FREE RESERVATIONS</center>";
									}
								}	
							}
						?>
					</td>
					<td class="dataf">
						<?php 	
							if( $var == 0 ) echo "<center style='color:red'>Not Yet Paid</center>";	
							else if( $var2 ) echo "<center style='color:red'>Free</center>";	
							else echo "<center style='color:red'>Regular</center>";
						?>
					</td>										
					</tr></a></div>
					<?php endfor ?>	
				</tbody>
		  </table>
		</div>
		<hr>
		<?php echo form_open('course/printOne');?>
			<input type="hidden" name="course_id" value="<?php echo $id;?>"/>
			<input type="hidden" name="name" value="<?php echo $name;?>"/>
			<input type="hidden" name="description" value="<?php echo $description;?>"/>
			<input type="hidden" name="starting1" value="<?php echo $starting1;?>" />
			<input type="hidden" name="ending1" value="<?php echo $ending1;?>" />
			<center><button class="btn btn-large btn-success" name="print" type="submit">Print <i class="glyphicon glyphicon-print"></i></button></center>
		<?php echo form_close();?>
		<?php } ?>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() 
    { 
        $('.pick').datepicker({
			todayBtn: "linked",
		    multidate: false,
		    format: "M d, yyyy",
		    autoclose: true,
		    todayHighlight: true
		});
    });
</script>