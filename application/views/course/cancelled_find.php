<div class="span9" style="margin-left: -30px">
	<div class="content">
		<?php 
			if(!$manager) echo form_open('course/search_cancelled');
			else echo form_open('managercourse/search_cancelled');
		?>
		<div class="control-group">
			<div class="controls">
				<input type="text" autocomplete="off" data-provide='typeahead' data-items='<?php echo $count_All; ?>' data-source='<?php echo $array;?>' required placeholder="Type Here" name="search"/>
				<button type="submit" class="btn btn-large btn-success"><span class="glyphicon glyphicon-saerch"></span>Search</button>
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
					<th style="width: 20%"><center>Name</center></th>
					<th style="width: 20%"><center>Cancelled On</center></th>
					<th style="width: 20%"><center>Venue</center></th>
					<th style="width: 20%"><center>Cost</center></th>
					<th style="width: 20%"><center>For Refund</center></th>
				</tr>
			</thead>
			<tbody>
		<?php for($i=0; $i<$counter; $i++) {?>
			<?php					
				$query = $this->db->get_where('cancelled', array('course_id' => $id[$i]) );
				$array1 = $query->row_array();
				
				$queryDis = $this->db->get_where('dissolved', array('course_id' => $id[$i]) );
				$arrayDis = $queryDis->row_array();
				
				if( empty($array1['id']) && empty($arrayDis['id']) ) continue;
				
				if( empty($arrayDis['id']) ) $var = strtotime($array1['date']);
				else $var = strtotime($arrayDis['date']);
			?>				
			<tr class='linka'> 
			<?php if( $paid[$i] > 0 ){ ?>					
				<td class="dataf"><center><a href="<?php echo base_url().'index.php/course/cancelled/'.$id[$i];?>"></center><?php echo $name[$i]; ?></div></center></a></td>
				<td class="dataf"><center><?php echo date('m-d-Y', $var).PHP_EOL; ?></center></td>
				<td class="dataf"><center><?php echo $venue[$i] ?></center></td>
				<td class="dataf"><center><?php echo $cost[$i]; ?></center></td>
				<td class="dataf"><center><?php echo $paid[$i]; ?></center></td>
			<?php } else {?>
				<td class="dataf"><a href="#"><center><?php echo $name[$i]; ?></center></a></td>
				<td class="dataf"><center><?php echo date('M d, Y', $var).PHP_EOL; ?></center></td>
				<td class="dataf"><center><?php echo $venue[$i] ?></center></td>
				<td class="dataf"><center><?php echo $cost[$i]; ?></center></td>
				<td class="dataf"><center><?php echo $paid[$i]; ?></center></td>
			<?php }?>
			</tr>
			<?php }?>
			</tbody>
		  </table>
		</div>
		<?php }?>
	</div>
</div>