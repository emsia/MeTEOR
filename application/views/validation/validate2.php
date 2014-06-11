<script>	
 	$(document).ready(function() {
		$('#checkall').change(function() {
			var checkboxes = $(this).closest('form').find(':checkbox');
			var checkboxes_label = $(this).closest('form').find('.checkbox');
			if($(this).is(':checked')) {
				checkboxes.attr('checked', 'checked');
				checkboxes_label.attr('class', 'checkbox checked');
				setTrue( 1 );
			} else {
				checkboxes.removeAttr('checked');
				checkboxes_label.attr('class', 'checkbox');
				setTrue( 0 );
			}
		});
	 });

	function setTrue( opt ){
		if(opt==0)	document.getElementById('SetOkay').disabled = true;
		if(opt==1)	document.getElementById('SetOkay').disabled = false;
	}
	
	function setIt(){
		var boxes = messs.getElementsByTagName("input");
		for( i = 0; i < boxes.length; i++ ){
			myType = boxes[i].getAttribute("type");
			if( myType == "checkbox" ) {
				if( boxes[i].checked == 1 ){
					setTrue( 1 );
					break;
				}
			}	
		}
		if( i == boxes.length ) setTrue( 0 );
		return;
	}
	
</script>
<noscript>Please Enable javascript to view this Page Correctly.</noscript>

<div class="span9" id="messs" style="margin-left: -30px">
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

		 <?php 
			echo form_open('validation/template'); 
		  ?>
		<div class="panel panel-success">
		  <div class="panel-heading"><?php echo $lastname.", ".$firstname." ".$middlename;?></div>
		   <table class="table table-striped">
		    <thead>
				<tr>
					<th style="width: 5%">
						<center>
							<label class="checkbox" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Check All">
								<input data-toggle="checkbox" type="checkbox" style="width: 17px" id="checkall" />
							</label>
						</center>
					</th>
					<th style="width: 25%"><center><div>Name</div></center></th>
					<th style="width: 21%"><center><div>Start</div></center></th>
					<th style="width: 21%"><center><div>End</div></center></th>
					<th style="width: 18%"><center><div>Venue</div></center></th>
					<th style="width: 10%"><center><div>Cost</div></center></th>
				</tr>
			</thead>
				<tbody>
					<?php for($i=0; $i<$counter; $i++) {?>				
				<tr>
					<td class="dataf">
						<center>
							<label class="checkbox" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Check">
								<input data-toggle="checkbox" type="checkbox" style="width: 17px" onchange="setIt()" name="check[]" value="<?php echo "$i";?>">
							</label>
						</center>
					</td>
					<td class="dataf"><center><?php echo $name[$i]; ?></td>
					<td class="dataf"><center><?php echo date('M d, Y', strtotime($start[$i])); ?></td>
					<td class="dataf"><center><?php echo date('M d, Y', strtotime($end[$i])); ?></td>
					<td class="dataf"><center><?php echo $venue[$i]; ?></td>
					<td class="dataf"><center><?php echo $cost[$i]; ?></td>
					<input type="hidden" name="<?php echo "name[]";?>" value ="<?php echo "$name[$i]";?>" >
					<input type="hidden" name="<?php echo "course[]";?>" value ="<?php echo "$cid[$i]";?>" >
					<input type="hidden" name="<?php echo "user";?>" value ="<?php echo "$id";?>" >
					<input type="hidden" name="<?php echo "cost[]";?>" value ="<?php echo "$cost[$i]";?>" >
				</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>

		  <hr>
				<input type="hidden" name="<?php echo "manager";?>" value ="<?php echo "$manager";?>" >
		  <center><button class="btn btn-success btn-large" id="SetOkay" type="submit" name="cash" value="Validate" disabled >Enter Payment <i class="glyphicon glyphicon-tags"></i></button></center>
		  <?php echo form_close(); ?>
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