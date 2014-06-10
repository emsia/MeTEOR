<body>
<style>

	h1,
	h2,
	h3 {
	  line-height: 40px;
	}
</style>

<div>
	<div style="height: 108px; margin-top: -8px; margin-left: -10px; width: 105%; background-color: #5e0000; background-image: url('<?php echo base_url('css/images/strip.png'); ?>');">
		<table style="border-collapse: collapse;" >
			<tr>				
				<td style="width: 200px">
					<img src="<?php echo base_url('css/images/pic.png'); ?>" style="margin-top: -1px;"/> 
				</td>
			</tr>
		</table>
	</div>

	<div style="margin-top: 10px; padding: 8px 35px 8px 14px; margin-bottom: 10px; text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5); background-color: #f2dede;  -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px;">		
		<th style="width: 800px">
			<center>
			<div style=" font-size: 25px; color: #b94a48; font-weight: bold;" ><?php echo $name." Details Change";?></div>
			</center>
		</th>
	</div>

	<div style=" padding: 8px 35px 8px 14px;  margin-bottom: 20px; text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5); color: #468847; background-color: #dff0d8; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px;">	
	  <strong><?php echo "The course ".$name." you've enrolled, received changes as follows:"; ?></strong><br/><br/>
	  <?php echo "----------------------------------------------------------------------------------------------------------------------------------------------------------------------";?><br/>
	  <?php 
	  		if(!empty($description) ) echo "<br/>Description is now ".$description;
			if(!empty($venue) ) echo "<br/>The Venue is now on ".$venue;
			if(!empty($start) ) echo "<br/>The starting date is now on ".date( 'F j\, Y', strtotime($start))." ";
			if(!empty($end) ) echo "<br/>and the ending date is now on ".date( 'F j\, Y', strtotime($end)).".";
			if(!empty($startTime) ) echo "<br/>and the starting time is now on ".date( 'h:i A', strtotime($startTime)).".";
			if(!empty($endTime) ) echo "<br/>up to ".date( 'h:i A', strtotime($endTime)).".";
			echo "<br/><br/>----------------------------------------------------------------------------------------------------------------------------------------------------------------------<br/><br/>";
			
			echo "If You have any comments, suggestions, and reactions, feel free to contact us at <a style='color: #0088cc; text-decoration: none; font-size: 15px' href='localhost/meteor'>localhost/meteor</a>.<br/>Thank you for registering!";
			
	  ?>
	</div>
</div>
</body>