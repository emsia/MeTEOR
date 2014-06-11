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

		<?php if(count($cancelled)){ ?>
			<div class="panel panel-success">
			  <div class="panel-heading">Cancelled Courses</div>
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
					
				<?php foreach( $courses as $cancelled_item ): ?>
						<?php 
							$query = $this->db->get_where('cancelled', array('course_id' => $cancelled_item['id']) );
							$array1 = $query->row_array();
							
							$queryDis = $this->db->get_where('dissolved', array('course_id' => $cancelled_item['id']) );
							$arrayDis = $queryDis->row_array();
							
							if( empty( $array1['id'] ) && empty($arrayDis['id']) ) continue;
							
							if( !empty( $array1['id'] ) ) $query1 = $this->db->get_where('courses', array('id' => $array1['course_id']));
							else $query1 = $this->db->get_where('courses', array('id' => $arrayDis['course_id']));
							$array = $query1->row_array();
							
							$paid_list = $this->db->get_where( 'payment', array('course_id' => $row['id']));
							$paid_list = $paid_list->result_array();

							if( !empty( $array1['id'] ) ) $var = strtotime($array1['date']);
							else $var = strtotime($arrayDis['date']);
						?>		
						<div class="divf">
							<tr class="linka">	
								<?php if( $array['paid'] > 0 ){ ?>										
								<td class="dataf"><a href="<?php echo base_url().'index.php/course/cancelled/'.$cancelled_item['id'];?>"><center><?php echo $array['name'];?></center></a></td>										
								<td class="dataf"><center><?php echo date('M d, Y', $var).PHP_EOL; ?></center></td>
								<td class="dataf"><center><?php echo $array['venue'];?></center></td>
								<td class="dataf"><center><?php echo $array['cost'];?></center></td>
								<td class="dataf"><center><?php echo $array['paid'];?></center></td>							
								<?php } else{ ?>													
								<td class="dataf"><center><a href="#"><?php echo $array['name'];?></a><center></td>
								<td class="dataf"><center><?php echo date('M d, Y', $var).PHP_EOL; ?></center></td>
								<td class="dataf"><center><?php echo $array['venue'];?></center></td>
								<td class="dataf"><center><?php echo $array['cost'];?></center></td>
								<td class="dataf"><center><?php echo $array['paid'];?></center></td>							
								<?php }?>
							</tr>
						</div>
				<?php endforeach ?>
				</tbody>
			  </table>
			</div>
		<?php }?>
	</div>
</div>
