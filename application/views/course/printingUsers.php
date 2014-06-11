<head>
<style>
	th{
		color:white; background-color: #003000;
	}
	
	table{
		border: 2px solid #666633;
	}
</style>
</head>
<body>
<img src="<?php echo base_url(); ?>css/images/LOGOHeader.png" class="header" />
	<div class="title"><?php echo $cert; ?></div>	
	<?php echo "<div class='date'>(".$currDate.")</div>";?>
	<div class="content">
		<p class="certcontent">
			<table class="viewtable" border="0">	
			<thead>
				<tr>
					<th style="width: 21%"><div>Last Name</div></th>
					<th style="width: 21%"><div>First Name</div></th>
					<th style="width: 21%"><div>Email</div></th>
					<th style="width: 21%"><div>Status</div></th>
					<th style="width: 16%"><div>Payment</div></th>
				</tr>
			</thead>
			<tbody>
				<?php for($i=0; $i<$counter; $i++) {?>
					<div><a href = "#"><tr class="lin">
					<?php
						$set = 1; $setPaid = 1; $tag2 = 0; $var = 1; $did = 0;
												
						$queryPaid = $this->db->get_where( 'payment', array('user_id' => $id[$i]) );
						$arrayPaid = $queryPaid->result_array();
						
						foreach( $arrayPaid as $row1 ){
							$did = 1;
							if( !empty($row1['remarks']) && strtolower($row1['remarks']) == "free" )
								continue;
							else if( !empty($row1['remarks']) ){
								$tag2 = 1;
								break;
							}	
						}
						
						if( $did ) $setPaid = 0;
					?>									
					<td class="dataf"><a href="#"><div><center><?php echo $lastname[$i];?></center></div></a></td>
					<td class="dataf"><a href="#"><div><center><?php echo $firstname[$i];?></center></div></a></td>
					<td class="dataf"><a href="#" style="color: black"><div><center><?php echo $username[$i];?> <center></div></a></td>
					<td class="dataf"> 
						<?php 														
							if($validated[$i] == 0 && $refunded[$i] == 0){ echo "<center>For Validation<br>Has Refunded Course(s)</center>"; $var = 0;}
							else if( $validated[$i] == 0 ){ echo "<center>For Validation</center>"; $var = 0;}
							else if($validated[$i] && $refunded[$i] == 0) echo "<center>Validated<br>Has Refunded Course(s)</center>";					
							else if($refunded[$i] == 0) echo "<center>Has Refunded Course(s)</center>";
							else if( ($validated[$i] && $refunded[$i]) && ( $setPaid ) )
								echo "<center>Has No Course(s) Yet</center>";
							else if($validated[$i] == 1) echo "<center>Validated</center>";
						?>
					</td>
					<td class="dataf">
						<?php 	
							if( $var == 0 ) echo "<center>Not Yet Paid</center>";	
							else if( !$tag2 ) echo "<center class='refund'>Free</center>";	
							else echo "<center>Regular</center>";
						?>
					</td>
					</tr></a></div> 
				<?php } ?>
			</tbody>
			</table>					
		</p>
	</div>	
</body>