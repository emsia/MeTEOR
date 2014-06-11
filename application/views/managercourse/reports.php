<head>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/styleGeneral.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/view.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/boots.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/view2.css" type="text/css">
<link href="<?php echo base_url(); ?>css/css_recipes.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/datepicker.css" type="text/css"  />

<script src="<?php echo base_url(); ?>js/jquery.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrapdatepicker.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap-timepicker.js"></script>
<script src="<?php echo base_url(); ?>js/jquery_tablesorter.js"></script> 
<script src="<?php echo base_url(); ?>js/bootstrap.js"></script> 
<script src="<?php echo base_url(); ?>js/bootstrap-modal.js"></script> 

<link href="<?php echo base_url('css/bootstrap-timepicker.css') ?>" rel="stylesheet">

</head>

<div id="body_box">
<table id="body_table" border="0">			
	
	<tr>
	
		<td id="navigation">
			<a href="<?php echo base_url().'index.php/managercourse';?>" >VIEW</a> <br/>
			<a href="<?php echo base_url().'index.php/managercourse/cancelled';?>">CANCEL</a> <br/>
			<a href="<?php echo base_url().'index.php/managercourse/reports';?>"style="color: #7b1113;">EVENT FORMS</a> <br/>
			<a href="<?php echo base_url().'index.php/course/reports_chart';?>">REPORTS</a> <br/>
			<a href="<?php echo base_url().'index.php/managercourse/upload';?>">UPLOAD</a> <br/>
			<a href="<?php echo base_url().'index.php/managercourse/SURVEY';?>">EVALUATION RESULTS</a> <br/>	
			<a href="<?php echo base_url().'index.php/managercourse/origsurveyResult';?>">SURVEY RESULTS</a> <br/>
			<a href="<?php echo base_url().'index.php/managercourse/request';?>">REQUEST</a> <br/>
		</td>	
		
		<td id="ruler"></td>

		<td id="pagefield">
<!---------------PAGE CONTENT-------------------------->	

		
			<!----SEARCH BUTTON | SUBJECT TO CHANGE TO FIT CI FRAMEWORK------->
			<?php $this->load->helper('form');
				echo form_open('managercourse/reports_search'); ?>				
				<!--<input class ="textf" type="text" name="search" required/>-->
				&nbsp;&nbsp;<b style="font-size: 19px;" >FROM</b>&nbsp;
				<input id="starting" class="textf input-medium pick" type="text" placeholder="Required" name ="starting"  value="<?php echo set_value('starting');?>" readonly />
				&nbsp;<b style="font-size: 19px;">TO</b>
				<input id="ending" class="textf input-medium pick" type="text" placeholder="Required" name="ending"  value="<?php echo set_value('ending');?>" readonly />
				&nbsp;&nbsp;&nbsp;
				<b style="font-size: 19px;">FILTER BY</b>
				<input name="type" type="hidden" value="COURSE" />
				&nbsp;&nbsp;
				<?php $list = array( '-- Dept --', 'CM', 'EIS', 'FMIS', 'HARDWARE', 'HRIS', 'IS', 'PS', 'SAIS', 'SPCMIS', 'TRAINING', '-- ALL --'); ?>
				<select name="dept" class="textf">
					<?php for( $i = 0; $i <= 11; $i++ ){ ?>
					<option value="<?php echo $list[$i]; ?>"><?php echo $list[$i]; ?></option>				  
					<?php } ?>
				</select>
				&nbsp;&nbsp;&nbsp; 	
				<input class="button_login" type="submit" name="submit" value="Search" />
			<?php echo form_close();?>
			<!----SEARCH BUTTON END------->
			<br/>
			<table class="viewtable" border="0">	
				<tr class="abclink">
					<?php if( !empty( $error ) ) { ?><td style="color: red"><center><?php echo $error;?></center></td><?php }?>
				</tr>
			</table>
		
<!---------------PAGE CONTENT-------------------------->						
		</td>
	</tr>

</table>

<!-------- Date ---------->
<script>
	$(document).ready(function() 
    { 
        $("#addCourse").tablesorter(); 
		$('.pick').datepicker({
		    todayBtn: "linked",
		    multidate: false,
		    format: "M d, yyyy",
		    autoclose: true,
		    todayHighlight: true
		});
		$('#startTime').timepicker();
        $('#endTime').timepicker();
    } );
</script>

</div>
<div id="dhtmltooltip"></div>
<script language="javascript" src="<?php echo base_url(); ?>js/tooltip.js" type="text/javascript"></script>