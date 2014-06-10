<head>
<style>
	.zUp:{z-index: 1050};
</style>
<script type="text/javascript">

    function addrow(text) {
        var table = document.getElementById(text);
        
		if (!table) return

		var newRow = table.rows[1].cloneNode(true);

		  // Now get the inputs and modify their names 
		var inputs = newRow.getElementsByTagName('input');

		for (var i=0, iLen=inputs.length; i<iLen; i++) {
			inputs[i].value = ''
		}

		  // Add the new row to the tBody (required for IE)

		var tBody = table.tBodies[0];
		tBody.insertBefore(newRow, tBody.lastChild);
		var tooltips = $( "[title]" ).tooltip();
	    $(document)(function() {
	    	tooltips.tooltip( "open" );
	    })
    }

    function deleteRow(row)
	{
		var table2="admin2"

		var rows = document.getElementById(table2).getElementsByTagName("tbody")[0].getElementsByTagName("tr").length;		

	    var i=row.parentNode.parentNode.rowIndex;
	    if(rows > 1)
	    	document.getElementById(table2).deleteRow(i);
	}
</script>

<script type="text/javascript">
	// close the div in 5 secs
	window.setTimeout("closeHelpDiv();", 3000);
	function closeHelpDiv(){
		document.getElementById("helpdiv").style.display=" none";
	}
	window.setTimeout("closeHelpDiv2();", 3000);
	function closeHelpDiv2(){
		document.getElementById("helpdiv2").style.display=" none";
	}
</script>

</head>

<script>
	$(document).ready(function() 
    { 
        $("#course").tablesorter(); 
    } );

    $(document).on("click", ".manOrNot", function () {
    	var id = $(this).data('id');
    	var belong = $(this).data('belong');
    	var manager = $(this).data('manager');
    	var title_name = $(this).data('title');

    	var url = $(this).data('base');
    	var form = $('<form></form>');
    	form.attr("method", "post");
    	form.attr("action", url);
    	//alert(url);
	    //$(".modal-footer #manager").val( manager );
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

        var field3 = $('<input></input>');
        field3.attr("type", "hidden");
	    field3.attr("name", 'title_name');
        field3.attr("value", title_name);
        form.append(field3);

	    $(document.body).append(form);
	    form.submit();
	});

	$(document).on("click", ".editMode", function () {
		$('#editModal').modal('show');

    	var tit = $(this).data('edittitle');
    	var id = $(this).data('id');
    	var belong = $(this).data('belong');
    	var manager = $(this).data('manager');

    	$(".modal-body #editTitle").val( tit );
    	$(".modal-footer #id_tit").val( id );
    	$(".modal-footer #belong_3").val( belong );
    	$(".modal-footer #manager_3").val( manager );
	});
	$(document).on("click", ".deleteMode", function () {
		$('#removeModal').modal('show');

    	var id = $(this).data('id');
    	var belong = $(this).data('belong');
    	var manager = $(this).data('man');

    	$(".modal-footer #belong_2").val( belong );
    	$(".modal-footer #id_del").val( id );
    	$(".modal-footer #manager_2").val( manager );
	});
	$(document).on("click", ".addMode", function () {
    	var belong = $(this).data('belong');
    	var manager = $(this).data('name');

    	$(".modal-footer #belong").val( belong );
    	$(".modal-footer #manager").val( manager );
	});
</script>

<?php 
	$this->load->helper('form');
	$class = array('class' => 'form-horizontal');
	echo form_open('course/addCategories', $class); 
?>
<div id="addModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="confirmedLabel" data-backdrop="static" aria-hidden="true">
	<div class="modal-header palette-peter-river">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="text-white">Adding Categories
		<button data-toggle="tooltip" data-trigger="hover" data-placement="right" title data-original-title="Add New Row" onclick="addrow('admin2')" type="button" class="btn btn-small btn-inverse" ><i class="glyphicon glyphicon-list"></i></button></h4>
	</div>
	<div class="modal-body">
		<div class="panel panel-info">
		  <div class="panel-heading">New Title for Category</div>
		  <table class="table table-striped" id="admin2">
		   	<thead>	
				<tr>
					<th style="width: 3%"></th>
					<th style="width: 97%"><center>Title</center></th>
				</tr>
			</thead>
			<tbody>	
				<div>
					<tr class="linka">	
						<td class="button_table"><button data-toggle="tooltip" data-trigger="hover" data-placement="right" title data-original-title="Delete" onclick="deleteRow(this)" style='padding: 5px' type="button" data-toggle="modal" class='btn btn-danger zUp' name="edit" ><i class="glyphicon glyphicon-remove"></i></button></td>
						<td><input style="width:100%" type="text" required name="Cat[]" /></td>
					</tr>
				</div>
			</tbody>	
		  </table>
		</div>
	</div>
	<div class="modal-footer">
	    <input type="hidden" name="belong" id="belong" value="" />
	    <input type="hidden" id="manager" name="manager" value="" />
	    <button class="btn btn-info btn-large" type="submit" >Save <i class="glyphicon glyphicon-ok"></i></button>
	</div>
</div>
</form>

<?php 
	$this->load->helper('form');
	$class = array('class' => 'form-horizontal');
	echo form_open('course/delCategories', $class); 
?>
<div id="removeModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="confirmedLabel" data-backdrop="static" aria-hidden="true">
	
	<div class="modal-header palette-alizarin">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="text-white">Confirm Delete</h4>
	</div>
	<div class="modal-body">
		<p>Are you sure you want to delete this Category from Category Questions?</p>
		<p>Continuing this will delete some answers of the participants.</p>
	</div>
	<div class="modal-footer">
	    <input type="hidden" id="id_del" name="id_del" value="" />
	    <input type="hidden" id="belong_2" name="belong" value="" />
	    <input type="hidden" id="manager_2" name="manager" value="" />
	    <button class="btn btn-danger" type="submit" >Continue <i class="glyphicon glyphicon-play"></i></button>
	</div>
</div>
</form>

<?php 
	$this->load->helper('form');
	$class = array('class' => 'form-horizontal');
	echo form_open('course/editCategory', $class); 
?>
<div id="editModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="confirmedLabel" data-backdrop="static" aria-hidden="true">
	
	<div class="modal-header palette-orange">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="text-white">Edit Category</h4>
	</div>
	<div class="modal-body">
		<div class="form-group">
		   <label class="col-sm-5 control-label" for="CourseName">Title</label>
		  <div class="controls">
		    <input style="text-transform:uppercase;" class="input-xlarge" type="text" id="editTitle" name="editTitle" />
		  </div>
		</div>
	</div>
	<div class="modal-footer">
	    <input type="hidden" id="id_tit" name="id_tit" value="" />
	    <input type="hidden" id="belong_3" name="belong" value="" />
	    <input type="hidden" id="manager_3" name="manager" value="" />
	    <button class="btn btn-warning btn-large" type="submit" >Save <i class="glyphicon glyphicon-saved"></i></button>
	</div>
</div>
</form>

<div id="dhtmltooltip"></div>
<script language="javascript" src="<?php echo base_url('js/tooltip.js'); ?>" type="text/javascript"></script>

<div id="mine" class="span9" style="margin-left: -30px">
	<div class="content">
		<div class="control-group">
			<div class="controls">
				<button type="button" data-toggle="modal" data-belong="<?php echo $belong; ?>" data-name="<?php echo $manager;?>" href="#addModal" class="btn btn-large btn-success addMode">Add Question Categories <i class="glyphicon glyphicon-plus"></i></button>
			</div>
		</div>
		<hr>

		<?php if(!empty($message) && !$error){ ?>
			<div id="helpdiv" class="panel panel-danger">
			  <div class="panel-heading">Warning!</div>
			  <div class="panel-body">
			    <p><?php echo $message; ?></p>
			  </div>
			</div>
		<?php }?>

		<?php if(!empty($message) && $error){ ?>
			<div id="helpdiv2" class="panel panel-info">
			  <div class="panel-heading">Successful!</div>
			  <div class="panel-body">
			    <p><?php echo $message; ?></p>
			  </div>
			</div>
		<?php }?>

		<div class="panel panel-success">
		  <div class="panel-heading">All Categories</div>
		  <table class="table table-striped">
		  	<thead>	
				<tr>
					<th style="width: 3%"></th>
					<th style="width: 3%"></th>
					<th style="width: 94%"><center>Titles</center></th>
				</tr>
			</thead>
			<tbody>	
				<?php for( $i = 0; $i < $count; $i++ ): ?>
				<div>
					<tr class="linka">
						<td class="button_table"><button type="button" href="#editModal" data-manager="<?php echo $manager; ?>" data-belong="<?php echo $belong; ?>" data-id="<?php echo $ids[$i]; ?>" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Edit Title" data-edittitle="<?php echo $titles[$i]; ?>" style='padding: 5px'; class='btn btn-warning editMode' name="edit" ><i class="glyphicon glyphicon-pencil"></i></button></td>
						<td class="button_table"><button data-man="<?php echo $manager; ?>" data-id="<?php echo $ids[$i]; ?>" data-belong="<?php echo $belong; ?>" style='padding: 5px'; type="button" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Remove Category" class='btn btn-danger deleteMode' name="edit" ><i class="glyphicon glyphicon-minus"></i></button></td>														
						<td class="dataf"><a href="#" class="manOrNot" data-man="<?php echo $manager; ?>" data-belong="<?php echo $belong; ?>" data-title="<?php echo strtoupper($titles[$i]); ?>" data-manager="<?php echo $manager; ?>" data-id="<?php echo $ids[$i]; ?>" data-base="<?php echo base_url().'index.php/course/viewQuestions'?>"><center><div><?php echo strtoupper($titles[$i]); ?></div></center></a></td>								
					</tr>
				</div>
				<?php endfor ?>	
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