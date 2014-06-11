<div class="span9" style="margin-left: -30px">
	<div class="content">
		<?php 
			$this->load->helper('form');
			if(!$manager) echo form_open('course/search_find');
			else echo form_open('managercourse/search_find');
		?>
		<div class="control-group">
			<div class="controls">
				<input type="text" autocomplete="off" data-provide='typeahead' data-items='<?php echo $count_All; ?>' data-source='<?php echo $array;?>' required placeholder="Type Here" name="search"/>
				<div class="btn-group btn-input clearfix">
					<select name="type" class="select">
					  <option value="COURSE">COURSE</option>
					  <option value="USER">USER</option> 
					</select>
				</div>
				<button type="submit" class="btn btn-large btn-success"><span class="glyphicon glyphicon-saerch"></span>Search</button>
			</div>
		</div>
		<?php echo form_close(); ?>
		<hr/>

		<div class="panel panel-success">
			<div class="panel-heading">SEARCH RESULTS</div>
			<table class="table table-striped">
				<thead>	
					<tr>
						<th style="width: 5%"></th>
						<th style="width: 25%"><center>Last Name</center></th>
						<th style="width: 25%"><center>First Name</center></th>
						<th style="width: 25%"><center>Email</center></th>
						<th style="width: 20%"><center>Status</center></th>
					</tr>
				</thead>
				<tbody>
					<?php for($i=0; $i<$counter; $i++) {?>
						<div class="divf"><tr class='linka'>
						<?php
							$set = 1; $setPaid = 1; 
								
							$queryPaid = $this->db->get_where( 'payment', array('user_id' => $id[$i]) );
							$arrayPaid = $queryPaid->row_array();
								
							if( !empty($arrayPaid['id']) ) $setPaid = 0;
								
							if( ($validated[$i] && $refunded[$i]) && ( $setPaid ) ) 
								$set = 0;
						?>
						<td class="dataf"><center>
							<?php echo form_open('validation/validate')?>
								<?php echo "<input type='hidden' name='temp' value='".$id[$i]."' />"; ?>
								<?php echo "<input type='hidden' name='cbn' value='0' />"; ?>
								<input type='hidden' name='manager' value="<?php echo $manager ?>" />
								<?php 	
									if( $set ) {
										if( $validated[$i] == 1 ){ ?> <button data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Validated" class='btn btn-success' type='button' name='submit' ><i class="glyphicon glyphicon-ok"></i></button><?php }
										else { ?> <button class='btn btn-warning' data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="For Validation" type='submit' name='submit' ><i class="glyphicon glyphicon-asterisk"></i></button><?php }
									} else { ?>
										<button class='btn btn-danger' data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="No Course(s)" type='button' name='submit' ><i class="glyphicon glyphicon-minus"></i></button> 
									<?php }
								?>
								<?php echo form_close();?>
							</center>
						</td>
						<td class="dataf"><center><?php echo "<div>$lastname[$i]"; ?></center></td>
						<td class="dataf"><center><?php echo "<div>$firstname[$i]"; ?></center></td>
						<td class="dataf"><center><?php echo "<div>$username[$i]"; ?></center></td>
						<td class="dataf"> 
							<?php 
								$setPaid = 1; 
								
								$queryPaid = $this->db->get_where( 'payment', array('user_id' => $id[$i]) );
								$arrayPaid = $queryPaid->row_array();
								
								if( !empty($arrayPaid['id']) ) $setPaid = 0;
								
								if($validated[$i] == 0 && $refunded[$i] == 0) echo "<center><span class='badge badge-error'>For Validation and Has Refunded Course(s)</span></center>";
								else if( $validated[$i] == 0 ) echo "<center><span class='badge badge-error'>For Validation</span></center>";
								else if($validated[$i] && $refunded[$i] == 0) echo "<center><span class='badge badge-error'>Validated and Has Refunded Course(s)</span></center>";					
								else if($refunded[$i] == 0) echo "<center><span class='badge badge-error'>Has Refunded Course(s)</span></center>";
								else if( ($validated[$i] && $refunded[$i]) && ( $setPaid ) )
									echo "<center><span class='badge badge-warning'>Has No Course(s) Yet</span></center>";
								else if($validated[$i] == 1) echo "<center><span class='badge badge-success'>Validated</span></center>";
							?>
						</td>
						</tr> </div>
					<?php } ?>
				</tbody>
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