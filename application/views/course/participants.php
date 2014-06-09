<div class="span9" style="margin-left: -30px">
	<div class="content">
		<?php 
			$this->load->helper('form');
			if(!$man) echo form_open('course/search_find');
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
		<hr/>
		<?php echo form_close();?>

		<?php 
			if( !empty($users) ) {
		?>
			<div class="panel panel-success">
			  <div class="panel-heading">COURSE NAME & DESCRIPTION</div>
			  <div class="panel-body">
			    <p><?php echo $users[0]['name'];?> : <?php echo $users[0]['description'];?></p>
			  </div>

			  <table class="table table-striped">
			  	<thead>	
					<tr>
						<th style="width: 3%"></th>
						<th style="width: 3%"></th>
						<th style="width: 21%"><div><center>Last Name</center></div></th>
						<th style="width: 21%"><div><center>First Name</center></div></th>
						<th style="width: 31%"><div><center>Email</center></div></th>
						<th style="width: 21%" ><div><center>Status</center></div></th>
					</tr>
				</thead>	
				<tbody>
					<?php foreach( $users as $participant_item ): ?>
					<?php
						$var = 0; $var2 = 0; $cont = 0;
						if( $countRes > 0 ){
							for( $j = 0; $j < $countRes; $j++ ){
								if( $participant_item['user_id'] == $tagR[$j] ){
									$var = 1; $cont = 1;
									break;
								}
							}
						}
						
						if( $countPaid > 0 ){
							for( $j = 0; $j < $countPaid; $j++ ){
								if( $participant_item['user_id'] == $tagP[$j] ){
									$var2 = 1; $cont = 1;
									break;
								}
							}
						}
						if( $cont ){
					?>
					<div><a href="#"><tr class="linka">
						<td class="buttontable">
							<?php	
								if($var2 == 1){	?>						
									<button style='padding: 5px'; data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Validated" class='btn btn-success' type='button' name='submit' ><i class="glyphicon glyphicon-ok"></i></button>												
								<?php }	
								else if( $var == 1 ) {
									$this->load->helper('form');									
									echo validation_errors(); 
									echo form_open('validation/validate');
									echo "<input type='hidden' name='temp' value='".$participant_item['user_id']."' />";
									echo "<input type='hidden' name='cbn' value='0' />";	
									if(!$man) echo "<input type='hidden' name='manager' value='0' />";
									else echo "<input type='hidden' name='manager' value='1' />"; ?>
									<button style='padding: 5px'; data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="For Validation" class='btn btn-warning' type='submit' name='submit' ><i class="glyphicon glyphicon-asterisk"></i></button>
									<?php echo"</form>";
									$cont = 1;
								}												
							?>
						</td>
						<td class="buttontable">
							<?php
								$this->load->helper('form');
								echo form_open('validation/removeStudent');
								echo "<input type='hidden' name='temp' value='".$participant_item['user_id']."' />";
								echo "<input type='hidden' name='course_id' value='".$id."' />";
								echo "<input type='hidden' name='tempId' value='".$temporary."' />";	
								if(!$man) echo "<input type='hidden' name='manager' value='0' />";
								else echo "<input type='hidden' name='manager' value='1' />"; ?>
								<button style='padding: 5px'; data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Remove Participant" onclick="return confirm('Are you sure you want to remove this participant from this course?')" class='btn btn-danger' type='submit' name='submit' ><i class="glyphicon glyphicon-minus"></i></button>
								<?php echo form_close();
							?>
						</td>
					<td class="dataf"><div><center><?php echo ucwords(strtolower($participant_item['lastname'])); ?></center></div></td>
					<td class="dataf"><div><center><?php echo ucwords(strtolower($participant_item['firstname'])); ?></center></div></td>
					<td class="dataf"><div><center><?php echo $participant_item['username']?> <center></div></td>
					<td class="dataf">
						<?php 				
							if( $var2 == 1 ) echo "<center><span class='badge badge-success'>Validated</span></center>";
							else if( $var == 1 ) echo "<center><span class='badge badge-error'>For Validation</span></center>";
						?>
					</td>									
					</tr></a></div>
					<?php }endforeach ?>	
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
