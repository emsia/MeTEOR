<script type="text/javascript">
    function addrow(text) {
        var table = document.getElementById(text);
        var count = document.getElementById('Count').value;
        
		if (!table) return

		var newRow = table.rows[1].cloneNode(true);

		  // Now get the inputs and modify their names 
		var inputs = newRow.getElementsByTagName('input');

		for (var i=0, iLen=inputs.length; i<iLen; i++) {
			inputs[i].value = ''
		}

		  // Add the new row to the tBody (required for IE)
		var table2
		if(count>0) table2 = document.getElementById('admin');
		else table2 = document.getElementById('admin2');

		var tBody = table2.tBodies[0];
		tBody.insertBefore(newRow, tBody.lastChild);

		var tooltips = $( "[title]" ).tooltip();
	    $(document)(function() {
	    	tooltips.tooltip( "open" );
	    })
    }

    function deleteRow(row)
	{
		var count = document.getElementById('Count').value;
		var table2;

		if(count>0) table2 = 'admin';
		else table2 = 'admin2';

		var rows = document.getElementById(table2).getElementsByTagName("tbody")[0].getElementsByTagName("tr").length;		

	    var i=row.parentNode.parentNode.rowIndex;
	    if(rows > 1)
	    	document.getElementById(table2).deleteRow(i);
	}
</script>

<script type="text/javascript">
	window.setTimeout("closeHelpDiv();", 3000);
	function closeHelpDiv(){
		document.getElementById("helpdiv").style.display=" none";
	}
</script>

<script>

	$(document).on("click", ".EditData", function () {
		document.getElementById('SetOkay').style.display = '';
		document.getElementById('del').style.display = '';
		var rows = document.getElementById('admin').getElementsByTagName("tbody")[0].getElementsByTagName("tr").length;
		
		for(var i=0; i<rows;i++){
			var name = 't_'+i;
			document.getElementById(name).style.display = '';
		}

		document.getElementById('AddNew').style.display = '';
		document.getElementById('editME').style.display = 'none';

		var boxes = bodyMe.getElementsByTagName("input");
		for( i = 0; i < boxes.length; i++ ){
			myType = boxes[i].getAttribute("type");
			if( myType == "text" ){
				boxes[i].removeAttribute("disabled");
			}
		}

		var boxes = bodyMe.getElementsByTagName("select");
		for( i = 0; i < boxes.length; i++ ){
			boxes[i].removeAttribute("disabled");		
		}
	});

    $(document).on("click", ".returnMe", function () {
    	var id = $(this).data('id');
    	var belong = $(this).data('belong');
    	var manager = $(this).data('manager');

    	var url = $(this).data('base');
    	var form = $('<form></form>');
    	form.attr("method", "post");
    	form.attr("action", url);

    	var field = $('<input></input>');
	    field.attr("type", "hidden");
	    field.attr("name", 'id_view');
        field.attr("value", id);
		form.append(field);

        var field1 = $('<input></input>');
        field1.attr("type", "hidden");
	    field1.attr("name", 'manager');
        field1.attr("value", manager);
        form.append(field1);

        var field2 = $('<input></input>');
        field2.attr("type", "hidden");
	    field2.attr("name", 'belong');
        field2.attr("value", belong);
        form.append(field2);

        $(document.body).append(form);
	    form.submit();
	});
</script>

<div class="span9" id="bodyMe" style="margin-left: -30px">
	<div class="content">
		<div class="control-group">
			<div class="controls">
				<button onclick="addrow('admin2')" <?php if($count>0){ ?> style="display:none" <?php }else{?>style="display:visible"<?php }?> type="button" id="AddNew" style="display:none" class="btn btn-info btn-large" >Add New Row <i class="glyphicon glyphicon-list"></i></button>
				<button type="button" data-belong="<?php echo $belong; ?>" data-manager="<?php echo $man; ?>" data-id="<?php echo $category_id; ?>" data-base="<?php echo base_url().'index.php/course/viewCat'; ?>" class="btn btn-large returnMe btn-success">Back <i class="glyphicon glyphicon-backward"></i></button>
			</div>
		</div>
		<hr>

		<?php if( !empty( $message ) ){ ?>
			<div class="panel panel-info">
			  <div class="panel-heading">Successful!</div>
			  <div class="panel-body">
			    <p><?php echo $message; ?></p>
			  </div>
			</div>
		<?php }?>

		<?php
			$this->load->helper('form');
			$class = "form-horizontal";
			echo form_open('course/saveQuestions', $class);
		?>

		<input type="hidden" id="Count" name="count" value="<?php echo $count; ?>" >
		<input type="hidden" id="mannager" name="manager" value="<?php echo $man; ?>" >
		<input type="hidden" id="categoryId" name="categoryId" value="<?php echo $category_id; ?>" >
		<input type="hidden" id="title_name" name="title_name" value="<?php echo $title_name; ?>" >

		<?php if($count >0){ ?>
			<div class="panel panel-success">
			  <div class="panel-heading"><?php echo $title_name; ?></div>
			  <table class="table table-striped" id="admin">
			  		<thead>	
						<tr>
							<th id="del" style="width: 3%; display:none"></th>
							<th style="width: 82%"><center>Questions</center></th>
							<th style="width: 15%"><center>Type</center></th>
						</tr>
					</thead>
					<tbody>	
						<?php for( $i = 0; $i < $count; $i++ ): ?>
						<div>
							<tr class="linka">	
								<td style="display:none" id="<?php echo 't_'.$i; ?>" class="button_table"><button onclick="deleteRow(this)" style='padding: 5px'; type="button" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Remove" data-toggle="modal" class='btn btn-danger' name="edit" ><i class="glyphicon glyphicon-minus"></i></button></td>																						
								<td class="dataf"><center><input disabled="disabled" style="width:99%" type="text" name="QE[]" value="<?php echo $questions[$i];?>" /></center></td>	
								<td class="dataf">
									<center>
										<select id="cert" name="cert[]" class="select" disabled="disabled" value="<?php echo set_value('cert[]');?>" >
											<option value="Radio Button" <?php if(!$type[$i]){ ?> selected <?php } ?> > Radio Button</option>
											<option value="Essay" <?php if($type[$i]){ ?> selected <?php } ?> > Essay</option>
										</select>
									</center>
								</td>
							</tr>
						</div>
						<?php endfor ?>	
					</tbody>
			  </table>
			</div>
		<?php }?>

		<div style="<?php if($count > 0 ){ echo 'display:none'; } ?>" class="panel panel-success">
		  <div class="panel-heading"><?php echo $title_name; ?></div>
		  <table class="table table-striped" id="admin2">
		    	<thead>	
					<tr>
						<th style="width: 3%"></th>
						<th style="width: 82%"><center>Questions</center></th>
						<th style="width: 15%"><center>Type</center></th>
					</tr>
				</thead>
				<tbody>	
					<div>
						<tr class="linka">	
							<td class="button_table"><button onclick="deleteRow(this)" style='padding: 5px'; data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Remove" type="button" data-toggle="modal" class='btn btn-danger' name="edit" ><i class="glyphicon glyphicon-minus"></i></button></td>
							<td><input <?php if($count>0){ ?> disabled="disabled" <?php }?> style="width:99%" placeholder="Type your questions here" type="text" name="QE[]" /></td>
							<td class="dataf">
								<center>
									<select id="cert" name="cert[]" class="select" value="<?php echo set_value('cert[]');?>" >
										<option value="Radio Button"> Radio Button</option>
										<option value="Essay"> Essay</option>
									</select>
								</center>
							</td>
						</tr>
					</div>
				</tbody>
		  </table>
		</div>

		<hr>

		<div>
			<center>
				<input type="hidden" name="belong" value="<?php echo $belong; ?>">
				<button type="button" <?php if($count>0){ ?> style="display:" <?php }else{?>style="display:none"<?php }?> class="btn btn-warning btn-large EditData" id="editME" name="editMe" >Edit <i class="glyphicon glyphicon-edit"></i></button>
				<button type="submit" <?php if($count>0){ ?> style="display:none" <?php }else{?>style="display:"<?php }?> class="btn btn-success btn-large" id="SetOkay" name="uploadSig" >Save <i class="glyphicon glyphicon-ok"></i></button>
			</center>
		</div>

		<?php form_close(); ?>
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