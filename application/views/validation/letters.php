<head>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/styleGeneral.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/view.css" type="text/css">
</head>

<div id="body_box">
<table id="body_table" border="0">

	<tr>
	
		<td id="navigation"> 
			<a href="#">VIEW</a> <br/>		
		</td>
		
		<td id="ruler"></td>
		
		<td id="pagefield">
		
<!---------------PAGE CONTENT-------------------------->	

			<!----SEARCH BUTTON | SUBJECT TO CHANGE TO FIT CI FRAMEWORK------->
			<form action="http://localhost/csu/index.php/validation/search_results" method="post">
				<input class ="textf" type="text" name="search" required/>
				<input class="button_login" type="submit" name="submit" value="Search" />
			</form>
			<!----SEARCH BUTTON END------->
			
			<!----PAGE CONTENT------->
			<table class="viewtable" border="0">
							<tr>
								<th  style="width: 10%"><div> ID</div></th>
								<th  style="width: 50%"><div> Name</div></th>
								<th  style="width: 40%"><div> Email</div></th>
							</tr>
			
			<?php for($i=0; $i<$counter; $i++) {?>
				<a href = ''><div class="divf"><tr class='linka'> 
				<td class="dataf"><?php echo "<div>$id[$i]"; ?></div></a></td>
				<td class="dataf"><?php echo "<div>$lastname[$i], $firstname[$i]"; ?></div></a></td>
				<td class="dataf"><?php echo "<div>$username[$i]"; ?></div></a></td>
				</center></td>
				</tr> </div> </a>
			<?php } ?>
			
			</table>			
			<!----PAGE CONTENT END------->
			
<!---------------PAGE CONTENT-------------------------->						
		</td>
		
	</tr>

</table>

</div>