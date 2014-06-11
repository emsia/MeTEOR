<head>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/styleGeneral.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/view.css" type="text/css">
</head>

<div id="body_box">
<table id="body_table" border="0">

	<tr>
	
		<td id="navigation"> 
			<a href="<?php echo base_url().'index.php/course';?>">BACK</a> <br/>		
		</td>
		
		<td id="ruler"></td>
		
		<td id="pagefield">
<!---------------PAGE CONTENT-------------------------->	
		
			<!----SEARCH BUTTON | SUBJECT TO CHANGE TO FIT CI FRAMEWORK------->
			<?php $this->load->helper('form');
				echo form_open('course/search_find'); ?>
				<select name="type" class="textf">
				  <option value="COURSE">COURSE</option>
				  <option value="USER">USER</option> 
				</select>
				<input class ="textf" type="text" name="search" required/>
				<input class="button_login" type="submit" name="submit" value="Search" />
			</form>
			<!----SEARCH BUTTON END------->
			
			
			<!----PAGE CONTENT------->
			<!--<a href="http://localhost/csu/index.php/validation/letter_search/A">A</a> |-->
			
			
			<!----PAGE CONTENT END------->
			

<!---------------PAGE CONTENT-------------------------->						
		</td>
		
	</tr>

</table>

</div>