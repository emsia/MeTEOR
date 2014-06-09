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
			<div style=" font-size: 25px; color: #b94a48; font-weight: bold;" >Certificate Request</div>
			</center>
		</th>
	</div>

	<div style=" padding: 8px 35px 8px 14px;  margin-bottom: 20px; text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5); color: #468847; background-color: #dff0d8; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px;">	
		<strong><?php echo $fullName?></strong><?php echo " is requesting a <b>Certificate of ".$type."</b> for the course <b>".$title."</b>"; ?><br/><br/>
		<?php $link = "http://localhost/meteor/index.php/viewPermission/".$unique."/".$user_slug; ?>
		Click <a style="color: #0088cc; text-decoration: none; font-size: 15px" href="<?php echo $link;?>">here</a> to view the certificate.<br/><br/>
		<?php $link = "http://localhost/meteor/index.php/givePermission/".$username."/".$unique."/".$user_slug; ?>
		Click <a style="color: #0088cc; text-decoration: none; font-size: 15px" href="<?php echo $link;?>">here</a> to approve the request.<br/><br/>
		<?php echo "If you have any comments, suggestions, and reactions, feel free to contact us at <a style='color: #0088cc; text-decoration: none; font-size: 15px' href='localhost/meteor'>
	  	localhost/meteor</a>.<br/>Thank you for registering!"; ?>
	</div>
</div>
</body>