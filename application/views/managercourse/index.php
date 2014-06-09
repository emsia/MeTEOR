<div class="span9" style="margin-left: -30px">
	<div class="content">
		<?php 
		$this->load->helper('form');
		echo form_open('managercourse/search_find');?>
		<div class="control-group">
			<div class="controls">
				<input type="text" autocomplete="off" data-provide='typeahead' data-items='<?php echo $count_All; ?>' data-source='<?php echo $array;?>' required placeholder="Type Here" name="search"/>
				<div class="btn-group btn-input clearfix">
					<select name="type" class="select">
					  <option value="COURSE">COURSE</option>
					  <option value="USER">USER</option> 
					</select>
				</div>
				<button type="submit" class="btn btn-large btn-success">Search</button>
			</div>
		</div>
		<?php echo form_close();?>
		<hr>
		
		<?php
			$set = 0;
			for( $i = 0; $i < $count; $i++ ){
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
			  <div class="panel-heading"><?php if(isset($search)){ ?>Search Results -- <?php }?>Upcoming Courses</div>
			  <table class="table table-striped">
			    <thead>	
					<tr>
						<th style="width: 20%"><center>Name</center></th>
						<th style="width: 20%"><center>Description</center></th>										
						<th style="width: 13%"><center>Start</center></th>
						<th style="width: 13%"><center>End</center></th>
						<th style="width: 12%"><center>Venue</center></th>
						<th style="width: 10%"><center>Cost</center></th>
						<th style="width: 12%" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Reserved | Available | Paid"><center>R | A | P</center></th>
					</tr>
				</thead>
				<tbody>	
					<?php for( $i = 0; $i < $count; $i++ ): ?>
					<?php
						date_default_timezone_set("Asia/Manila");
						$date = date('Y-m-d');															
						if( $start[$i] > $date && $end[$i] > $date ){											
					?>
					<div><a href="#">
					<tr  class="linka">	
						<?php
							$temp = strtotime($start[$i]);
							$var1 = date('M d, Y', $temp).PHP_EOL;
							
							$temp = strtotime($end[$i]);
							$var2 = date('M d, Y', $temp).PHP_EOL;
							if( $reserved[$i] > 0 || $paid[$i] > 0){ 										
						?>								
						<td class="dataf"><a href="<?php echo base_url().'index.php/managercourse/process/'.$id[$i];?>"><center><?php echo $name[$i];?></center></a></td>								
						<td class="dataf"><center><?php echo $description[$i];?></center></td>								
						<td class="dataf"><center><?php echo $var1; ?></center></td>
						<td class="dataf"><center><?php echo $var2; ?></center></td>
						<td class="dataf"><center><?php echo $venue[$i];?></center></td>
						<td class="dataf"><center><?php echo $cost[$i];?></center></td>
						<td class="dataf"><center><?php echo $reserved[$i];?> | <?php echo ($available[$i] - ($reserved[$i]+$paid[$i]) );?> | <?php echo $paid[$i];?></center></td>							
						<?php }
							else{
						?>														
						<td class="dataf"><a href="#"><center><?php echo $name[$i];?></center></a></td>
						<td class="dataf"><center><?php echo $description[$i];?></center></td>
						<td class="dataf"><center><?php echo $var1; ?></center></td>
						<td class="dataf"><center><?php echo $var2; ?></center></td>
						<td class="dataf"><center><?php echo $venue[$i];?></center></td>
						<td class="dataf"><center><?php echo $cost[$i];?></center></td>
						<td class="dataf"><center><?php echo $reserved[$i];?> | <?php echo ($available[$i] - ($reserved[$i]+$paid[$i]) );?> | <?php echo $paid[$i];?></center></td>	
						<?php }?>
						
					</tr></a></div>
					<?php echo form_close(); ?>
					<?php }?>
					<?php endfor ?>	
				</tbody>	
			  </table>
			</div>
		<?php }?>

		<?php 
			$set = 0; $set2 = 0;
			for( $i = 0; $i < $count; $i++ ){
				date_default_timezone_set("Asia/Manila");
				$date = date('Y-m-d');
											
				if( $start[$i] <= $date && $end[$i] >= $date ){
					$set2 = 1;
					if( date('h:m:s',time()) < date('h:m:s', strtotime($endTime[$i])) ){
						$set = 1;							
						break;
					}
				}
			}
			if( $set || $set2 ){
		?>
			<div class="panel panel-success">
			  <div class="panel-heading"><?php if(isset($search)){?>Search Results -- <?php }?>Ongoing Courses</div>
			  <table class="table table-striped">
			    <thead>	
					<tr>
						<th style="width: 20%"><center>Name</center></th>
						<th style="width: 20%"><center>Description</center></th>										
						<th style="width: 13%"><center>Start</center></th>
						<th style="width: 13%"><center>End</center></th>
						<th style="width: 12%"><center>Venue</center></th>
						<th style="width: 10%"><center>Cost</center></th>
						<th style="width: 12%" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Reserved | Available | Paid"><center>R | A | P</center></th>
					</tr>
				</thead>
				<tbody>	
					<?php for( $i = 0; $i < $count; $i++ ): 
						date_default_timezone_set("Asia/Manila");
						$date = date('Y-m-d');
						$set1 = 0; $set3 = 0;											
						if( $start[$i] <= $date && $end[$i] >= $date ){
							$set1 = 1;
							if( date('h:m:s',time()) < date('h:m:s', strtotime($endTime[$i])) ){
								$set3 = 1;
							}
						}
						if($set1 || $set3){						
					?>
						<tr class="linka" >
						<?php 
							
							$temp = strtotime($start[$i]);
							$var1 = date('M d, Y', $temp).PHP_EOL;
							
							$temp = strtotime($end[$i]);
							$var2 = date('M d, Y', $temp).PHP_EOL;
							if( $reserved[$i] > 0 || $paid[$i] > 0){ 
						
						?>								
						<td class="dataf"><a href="<?php echo base_url().'index.php/managercourse/process/'.$id[$i];?>"><center><div><?php echo $name[$i];?></div></center></a></td>								
						<td class="dataf"><center><div><?php echo $description[$i];?></div></center></td>								
						<td class="dataf"><center><div><?php echo $var1; ?></div></center></td>
						<td class="dataf"><center><div><?php echo $var2; ?></div></center></td>
						<td class="dataf"><center><div><?php echo $venue[$i];?></div></center></td>
						<td class="dataf"><center><div><?php echo $cost[$i];?></div></center></td>
						<td class="dataf"><center><div><?php echo $reserved[$i];?> | <?php echo ($available[$i] - ($reserved[$i]+$paid[$i]) );?> | <?php echo $paid[$i];?></div></center></td>							
						<?php }
							else{
						?>														
						<td class="dataf"><a href="#"><center><div><?php echo $name[$i];?></div></center></a></td>
						<td class="dataf"><center><div><?php echo $description[$i];?></div></center></td>
						<td class="dataf"><center><div><?php echo $var1; ?></div></center></td>
						<td class="dataf"><center><div><?php echo $var2; ?></div></center></td>
						<td class="dataf"><center><div><?php echo $venue[$i];?></div></center></td>
						<td class="dataf"><center><div><?php echo $cost[$i];?></div></center></td>
						<td class="dataf"><center><div><?php echo $reserved[$i];?> | <?php echo ($available[$i] - ($reserved[$i]+$paid[$i]) );?> | <?php echo $paid[$i];?></div></center></td>	
						<?php }?>
						<?php
							echo "</form>";
							} 
						?>
					<?php endfor ?>	
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