<div class="span9" style="margin-left: -30px">
	<div class="content">
		<?php
			$this->load->helper('form');
			if(!$manager) echo form_open('course/search_find');
			else echo form_open('managercourse/search_find');
		?>
		<div class="control-group">
			<div class="controls">
				<input type="text" reuired placeholder="Type Here" name="search"/>
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

		<div class="panel panel-success">
		  <div class="panel-heading">Cash payment for the following</div>
		  <table class="table table-stiped">
		  	<thead>
			  	<tr>
					<th style="width: 30%"><div>Name</div></th>
					<th style="width: 22%"><div>Start</div></th>
					<th style="width: 22%"><div>End</div></th>
					<th style="width: 14%"><div>Venue</div></th>
					<th style="width: 12%"><div>Cost</div></th>
				</tr>
			</thead>	
			<?php foreach($cid as $a):
					$query = $this->db->get_where( 'courses', array('id' => $a) );
					$row = $query->row_array();
			?>
			
			<div class="divf">					
				<tr class="linka">
					<td class="dataf"><div><?php echo $row['name']?></div></td>
					<td class="dataf"><div><?php echo date('M d, Y',strtotime($row['start'])); ?></div></td>
					<td class="dataf"><div><?php echo date('M d, Y', strtotime($row['end'])); ?></div></td>
					<td class="dataf"><div><?php echo $row['venue']?></div></td>
					<td class="dataf"><div><?php echo $row['cost']?></div></td>
				</tr>
			</div>			
			<?php endforeach ?>
		  </table>
		  <div class="panel-footer">Total Cost: P<?php if( !empty($total) ) echo "<i style='color:red'>".$total.".00</i>"; ?></div>
		</div>

		<?php
			$this->load->helper('form');
			echo form_open('validation/pkCash'); 
		?>
		<?php $i=0; 
			foreach($cid as $temp){
				echo "<input type='hidden' name='temp[$i]' value='".$temp."' />";
				$i = $i+1;
			}
		?>
		<input type='hidden' name='uid' value='<?php echo $id?>' />
		<input type='hidden' name='manager' value='<?php echo $manager?>' />
		<input type='hidden' name='total' value='<?php echo $total?>' />

		<div class="control-group">
			<div class="controls">
				<input type="text" reuired placeholder="OR Number" name="ornumber"/>
				<input type="text" placeholder="Remarks(Optional)" name="remarks"/>
				<button type="submit" class="btn btn-large btn-success">Validate <i class="glyphicon glyphicon-shopping-cart"></i></button>
			</div>
		</div>
		<?php echo form_close();?>

	</div>
</div>
