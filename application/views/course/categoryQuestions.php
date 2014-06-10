<head>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/styleGeneral.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/view.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/boot.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/view2.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/tooltip.css" type="text/css"/>
<link href="<?php echo base_url(); ?>css/css_recipes.css" rel="stylesheet" type="text/css">

<script src="<?php echo base_url(); ?>js/jquery.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap.js"></script> 
<script src="<?php echo base_url(); ?>js/bootstrap-modal.js"></script> 

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
			if(inputs[i].value != "X")
				inputs[i].value = ''
		}

		  // Add the new row to the tBody (required for IE)

		var tBody = table.tBodies[0];
		tBody.insertBefore(newRow, tBody.lastChild);
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

</head>

<body>
<div id="body_box">
<table id="body_table" border="0">			
	
	<tr>
	
		<td id="navigation">
			<?php if(!$man) {?>
			<a href="<?php echo base_url().'index.php/course';?>">VIEW</a> <br/>
			<a href="<?php echo base_url().'index.php/course/add';?>">ADD</a> <br/>
			<a href="<?php echo base_url().'index.php/course/cancelled';?>">CANCEL</a> <br/>
			<a href="<?php echo base_url().'index.php/course/reports';?>">REPORTS</a> <br/>
			<a href="<?php echo base_url().'index.php/course/upload';?>">UPLOAD</a> <br/>
			<a href="<?php echo base_url().'index.php/course/SURVEY';?>" style="color: #7b1113;">EVALUATION RESULTS</a> <br/>
			<a href="<?php echo base_url().'index.php/course/origsurveyResult';?>">SURVEY RESULTS</a> <br/>
			<a href="<?php echo base_url().'index.php/course/request';?>">REQUEST</a> <br/>
			<?php } else {?>
				<a href="<?php echo base_url().'index.php/managercourse';?>">VIEW</a> <br/>
				<a href="<?php echo base_url().'index.php/managercourse/cancelled';?>">CANCEL</a> <br/>
				<a href="<?php echo base_url().'index.php/managercourse/reports';?>">REPORTS</a> <br/>
				<a href="<?php echo base_url().'index.php/managercourse/upload';?>">UPLOAD</a> <br/>
				<a href="<?php echo base_url().'index.php/managercourse/SURVEY';?>" style="color: #7b1113;">EVALUATION RESULTS</a> <br/>
				<a href="<?php echo base_url().'index.php/managercourse/origsurveyResult';?>">SURVEY RESULTS</a> <br/>
				<a href="<?php echo base_url().'index.php/managercourse/request';?>">REQUEST</a> <br/>
			<?php }?>
		</td>	
		
		<td id="ruler"></td>

		<td id="pagefield">

			<form style="padding-left:5px;" >
				<input href="#addModal" type="button" class="button_login" data-toggle="modal" data-name="<?php echo $manager;?>" value="Add Question Categories" />
			</form>


			<table class="viewtable" border="0">
				<?php if( !empty( $message ) ){ ?>
				<tr class="abclink">
				<td style="list-style: none;"><center><div class="alert alert-danger" style="width:50%"><div class='error'><?php echo $message; ?></div></div></center></td>	
				</tr>
				<?php }?>
				<?php
					if( $count!=0 ){
				?>

				<tr>
					<div id="profileInfo">
						<table class="viewtable" border="0" id="addCourse">
							<thead>	
								<tr>
									<th style="width: 3%" class="" ></th>
									<th style="width: 3%" class="" ></th>
									<th style="width: 94%" class=""><div>Titles</div></th>
								</tr>
							</thead>
							<tbody>	
								<?php for( $i = 0; $i < $count; $i++ ): ?>
								<div><a href="#">
								<tr  class="linka">
									<td class="button_table"><input href="#editModal" data-id="<?php echo $ids[$i]; ?>" data-edittitle="<?php echo $titles[$i]; ?>" style='padding: 0px'; onMouseOver="ddrivetip('Edit Title', '', 100)"; onMouseOut="hideddrivetip()" type="button" data-toggle="modal" class='button_smalla editMode' name="edit" value="E" /></td>
									<td class="button_table"><input href="#removeModal" data-id="<?php echo $ids[$i]; ?>" style='padding: 0px'; onMouseOver="ddrivetip('Remove', '', 50)"; onMouseOut="hideddrivetip()" type="button" data-toggle="modal" class='button_smalla deleteMode' name="edit" value="R" /></td>														
									<td class="dataf"><a href="#" class="manOrNot" data-manager="<?php echo $manager; ?>" data-id="<?php echo $ids[$i]; ?>" data-base="<?php echo base_url().'index.php/course/viewQuestions'?>"><center><div><?php echo strtoupper($titles[$i]); ?></div></center></a></td>								
									</tr></a></div>
								<?php endfor ?>	
							</tbody>
						</table>
					</div>
				</tr>
				<?php }?>
			</table>						
		</td>
	</tr>

</table>
</div>
<script>
	$(document).ready(function() 
    { 
        $("#course").tablesorter(); 
    } );

    $(document).on("click", ".manOrNot", function () {
    	var id = $(this).data('id');
    	var manager = $(this).data('manager');

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
        /*
	    var form = createElement("form", {action: url,
                                      method: "POST",
                                      style: "display: none"});
	    form.append(createElement("input", {type: "hidden",
                                                 name: 'manager',
                                                 value: manager}));
	    form.append(createElement("input", {type: "hidden",
                                                 name: 'belong',
                                                 value: '0'}));
*/
	    //window.location.href = "http://stackoverflow.com";
	    //document.body.appendChild(form);
	    //alert(form);
	    $(document.body).append(form);
	    form.submit();
	    //document.body.removeChild(form);
	});

	$(document).on("click", ".editMode", function () {
    	var tit = $(this).data('edittitle');
    	var id = $(this).data('id');
    	$(".modal-body #editTitle").val( tit );
    	$(".modal-footer #id_tit").val( id );
	});
	$(document).on("click", ".deleteMode", function () {
    	var id = $(this).data('id');
    	$(".modal-footer #id_del").val( id );
	});
</script>

	<?php 
		$this->load->helper('form');
		$class = array('class' => 'form-horizontal');
		echo form_open('course/addCategories', $class); 
	?>
<div id="addModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="confirmedLabel" data-backdrop="static" aria-hidden="true">
	
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3 id="myModalLabel">Adding Categories
		<form style="padding-left:50%"><input onclick="addrow('admin2')" type="button" class="button_login" value="Add New Row"></form></h3>
	</div>
	<div class="modal-body">
		<table class="viewtable" border="0" id="admin2">
			<thead>	
				<tr>
					<th style="width: 3%" class="" ></th>
					<th style="width: 97%" class="" ><div>Title</div></th>
				</tr>
			</thead>
			<tbody>	
				<div><a href="#">
				<tr class="linka">	
					<td class="button_table"><input onclick="deleteRow(this)" style='padding: 0px'; onMouseOver="ddrivetip('Delete', '', 70)"; onMouseOut="hideddrivetip()" type="button" data-toggle="modal" class='button_smalla zUp' name="edit" value="X" /></td>
					<td><input class="textf" style="width:99%" type="input" name="Cat[]" /></td>
				</tr></a></div>
			</tbody>	
		</table>
	</div>
	<div class="modal-footer">
	    <input type="hidden" name="belong" value="0" />
	    <input type="hidden" id="manager" name="manager" value="" />
	    <input class="button_login" type="submit" value="Save" />
	</div>
</div>
</form>

<?php 
		$this->load->helper('form');
		$class = array('class' => 'form-horizontal');
		echo form_open('course/delCategories', $class); 
	?>
<div id="removeModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="confirmedLabel" data-backdrop="static" aria-hidden="true">
	
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3 id="myModalLabel">Confirm Delete</h3>
	</div>
	<div class="modal-body">
		<p>Are you sure you want to delete this Category from Category Questions?</p>
		<p>Continuing this will delete some answers of the participants.</p>
	</div>
	<div class="modal-footer">
	    <input type="hidden" id="id_del" name="id_del" value="" />
	    <input class="button_login" type="submit" value="Continue" />
	</div>
</div>
</form>

<?php 
		$this->load->helper('form');
		$class = array('class' => 'form-horizontal');
		echo form_open('course/editCategory', $class); 
	?>
<div id="editModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="confirmedLabel" data-backdrop="static" aria-hidden="true">
	
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3 id="myModalLabel">Edit Category</h3>
	</div>
	<div class="modal-body">
		<table class="viewtable" border="0" id="admin2">
			<thead>	
				<tr>
					<th><div>Title</div></th>
				</tr>
			</thead>
			<tbody>	
				<div><a href="#">
				<tr class="linka"><td><input class="textf" style="width:99%; text-transform:uppercase;" type="input" id="editTitle" name="editTitle" /></td>
				</tr></a></div>
			</tbody>	
		</table>
	</div>
	<div class="modal-footer">
	    <input type="hidden" id="id_tit" name="id_tit" value="" />
	    <input class="button_login" type="submit" value="Save" />
	</div>
</div>
</form>

<div id="dhtmltooltip"></div>
<script language="javascript" src="<?php echo base_url('js/tooltip.js'); ?>" type="text/javascript"></script>
</body>