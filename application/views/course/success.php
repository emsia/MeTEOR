<head>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/styleGeneral.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/view.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/view2.css" type="text/css">

</head>

<div id="body_box">
<table id="body_table" border="0">

	<tr>	
		<?php
			if( $temp == 1 || $temp == 3) {
				 echo "<br><br>
                  <center>
                  <h2>Thank you!</h2>
                  The form has been successfully saved.
                  <BR><BR>";
            } elseif( $temp == 2 ) {
            	echo "<br><br>
                  <center>
                  <h2>Thank you!</h2>
                  Your attendance for ".$CourseName." has been successfully saved.
                  <BR><BR>";
            } else{
            	echo "<br><br>
                  <center>
                  <h2>Thank you!</h2>
                  The form has been successfully saved.
                  <BR><BR>";
                $temp = 0;  
            }     
		?>
		<?php if( $temp == 2 ){ ?>
			<a href='<?php echo base_url().'index.php/logout';?>' style='font-size: 20px; color: #e2618c;'>Log Out</a> <br/>	
		<?php }elseif( $temp == 3 ){ 
                  $place = "participantcourse/completed"
            ?>                  
                  <a href='<?php echo base_url().'index.php/'.$place;?>' style='font-size: 20px; color: #e2618c;'>Back to Completed View</a> <br/>
            <?php } elseif( $temp == 0 ){?>
		<a href='<?php echo base_url().'index.php/course';?>' style='font-size: 20px; color: #e2618c;'>Back to Course View</a> <br/><?php } else{ ?>
			<?php if(!$numD) $place = 'index.php/course/request';
			else $place = 'index.php/managercourse/request';
			?>		
			<a href='<?php echo base_url().$place;?>' style='font-size: 20px; color: #e2618c;'>Back to Request View</a> <br/>
			<?php }?>
	</tr>

</table>

</div>
