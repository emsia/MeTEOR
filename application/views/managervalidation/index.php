<head>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/styleGeneral.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/view.css" type="text/css">
</head>

<div id="body_box">
<table id="body_table" border="0">

	<tr>
	
		<td id="navigation"> 
			<a href="#" style="color:#7b1113;">VIEW</a> <br/>		
		</td>
		
		<td id="ruler"></td>
		
		<td id="pagefield">
<!---------------PAGE CONTENT-------------------------->	
		
			<!----SEARCH BUTTON | SUBJECT TO CHANGE TO FIT CI FRAMEWORK------->
			<form action="http://localhost/meteor/index.php/validation/search_results" method="post">
				<input class ="textf" type="text" name="search" required/>
				<input class="button_login" type="submit" name="submit" value="Search" />
			</form>
			<!----SEARCH BUTTON END------->
			
			
			<!----PAGE CONTENT------->
			
			
			<!----PAGE CONTENT END------->
			

<!---------------PAGE CONTENT-------------------------->						
		</td>
		
	</tr>

</table>

</div>