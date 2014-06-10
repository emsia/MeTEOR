<head>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/styleGeneral.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/view.css" type="text/css">
<link href="<?php echo base_url(); ?>css/css_recipes.css" rel="stylesheet" type="text/css">

<script src="<?php echo base_url(); ?>js/jquery-latest.js"></script> 
<script src="<?php echo base_url(); ?>js/jquery_tablesorter.js"></script> 
</head>

<script>
	$(document).ready(function() 
    { 
        $("#participantsorter").tablesorter(); 
    } ); 
</script>

<div id="body_box">
<table id="body_table" border="0">

	<tr>
	
		<td id="navigation"> 
			<a href="http://localhost/meteor/index.php/participant">VIEW</a><br/>
			<a href="http://localhost/meteor/index.php/participant/addStudent" style="color:#7b1113;">ADD</a><br/>
		</td>
		
		<td id="ruler"></td>
		

		<td id="pagefield">			
			<table border="0">
				<tr>
					<td>
						<table class="viewtable" border="0" id="participantsorter">
						<thead>	
							<tr>
								<th style="width: 31%"><div> Last Name</div></th>
								<th style="width: 31%"><div> First Name</div></th>
								<th style="width: 31%"><div> Email</div></th>
								<th style="width: 7%"> </th>
							</tr>
						</thead>
						<tbody>
							<tr id="add_more_div">
								<td class="dataf"><input class="textf input-large" name="add_last[]" type="text" /></td>
								<td class="dataf"><input class="textf input-large" name="add_first[]" type="text" /></td>
								<td class="dataf"><input class="textf input-large" name="add_email[]" type="text" /></td>
								<td class="dataf"><input type="button" onclick="add_more_text_box('add_more_div','add_last[]',child());" class="button_login" value="+" /></td>
							</tr>
						</tbody>	
						</table>
					</td>
				</tr>
			</table>					
		</td>
	</tr>


</table>

<script>
	function add_more_text_box(parent_id, child_name, child_id)
	{
	  var myTable = document.getElementById(parent_id);
	  var oDiv, oInput, sss, oo;
	  oDiv = document.createElement('div');
	  oo = document.createTextNode( "\u00A0" );	
	  oDiv.setAttribute('id', 'part'+ child_id);
	  
	  oDiv.setAttribute('class', 'control-group');
	  myTable.appendChild(oDiv);

	  oInput = document.createElement('input');
	  sss = document.createElement('input');
	  sss.setAttribute('type', 'button');
	  sss.setAttribute('class', 'button_login removeVar');
	  sss.setAttribute('placeholder', 'Required');
	  sss.setAttribute('value', '-');

	  oInput.setAttribute('type', 'text');
	  oInput.setAttribute('required', true);
	  oInput.setAttribute('name', child_name);
	  oInput.setAttribute('id', child_id);
	  oInput.setAttribute('placeholder', 'Required');
	  oInput.setAttribute('class', 'textf input-large');

	  oDiv.appendChild(oInput);
	  oDiv.appendChild(oo);
	  oDiv.appendChild(sss);
	} 

	var child_id = 1;
	function child()
	{ 
		return child_id++;
	}	
</script>

</div>
<div id="dhtmltooltip"></div>
<script language="javascript" src="<?php echo base_url(); ?>js/tooltip.js" type="text/javascript"></script>