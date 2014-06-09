<head>
<style>
	th{
		color:white; background-color: #003000;
	}
	
	table{
		border: 2px solid #666633;
	}
	
	#bg{
		opacity: 0.5;
	}
</style>
</head>
<body>
<img src="css/images/docLogo2.png" class="headNew" />
<div>
	<div class="title">
	<?php 
		$temp = date('F j\, Y', strtotime($starting));
		$temp1 = date('F j\, Y', strtotime($ending));
		if( $starting == $ending ) $message = " on ".$temp;
		else {
			$message = "from ";
			$dateStart = date('jS \of F Y', strtotime($starting));
			$dateEnd = date('jS \of F Y', strtotime($ending));

			$startPieces2 = explode(" ", $dateStart);
			$endPieces2 = explode(" ", $dateEnd);

			$startPieces = explode("-", $starting);
			$endPieces = explode("-", $ending);

			$totDays = date("t",strtotime($startPieces[0].'-'.$startPieces[1].'-01'));

			if( $startPieces[0] == $endPieces[0] && (($startPieces[1] == 1 && $endPieces[1] == 12) ) && ($startPieces[2] == 1 && $endPieces[2] == 31) ){
				$message = "for YEAR ".$startPieces[0];	
			} 			
			elseif( $startPieces[0] == $endPieces[0] ){ //year
				
				if( $startPieces[1] == $endPieces[1] ) { /*month checker*/ 
					//$message .= $startPieces2[0]." to ".$endPieces2[0]." of ".$startPieces2[2]." ".$startPieces[0];
					$totalDays = ($endPieces[2] - $startPieces[2]) + 1;
					if( $totalDays == $totDays ) $message .= "for Month of ".$startPieces2[2]." ".$startPieces[0];
					else $message .= $startPieces2[0]." to ".$endPieces2[0]." of ".$startPieces2[2]." ".$startPieces[0];
				}
				else {
					if( $startPieces[2] == $endPieces[2] ) $message .= $startPieces2[0]." of ".$startPieces2[2]." to ".$endPieces2[2]." ".$startPieces[0];
					else $message .= $startPieces2[0]." of ".$startPieces2[2]." to ".$endPieces2[0]." of ".$endPieces2[2]." ".$startPieces[0];	
				}	
			}else{
				if( $startPieces[1] == $endPieces[1] ){
					if( $startPieces[2] == $endPieces[2] ) $message .= $startPieces2[0]." of ".$startPieces2[2]." ".$startPieces[0]."-".$endPieces[0];
					else $message .= $startPieces2[0]." to ".$endPieces2[0]." of ".$startPieces2[2]." ".$startPieces[0]." to ".$endPieces[0];
				}else {
					if( $startPieces[2] == $endPieces[2]) $message .= $startPieces2[0]." of ".$startPieces2[2]."-".$endPieces2[2]." ".$startPieces[0]." to ".$endPieces[0];
					else $message .= $dateStart." to ".$dateEnd;
				}	
			}
		}//$message = " from ".$temp." to ".$temp1;
	echo "List of Courses ".$message; ?></div>
	<?php echo "<div class='date'>(".$currDate.")</div>";?>
	<br/>
	<div class="content">
			<table class="viewtable" border="0">	
			<thead>
				<?php if( !$deptTrue ){ ?>
					<tr>
						<th style="width: 17%"><div>Name</div></th>
						<th style="width: 17%"><div>Description</div></th>										
						<th style="width: 17%"><div>Start</div></th>
						<th style="width: 17%"><div>End</div></th>
						<th style="width: 14%"><div>Venue</div></th>
						<th style="width: 7%"><div>Cost</div></th>
						<th style="width: 10%"><div>R | A | P</div></th>
					</tr>
				<?php }else{ ?>
					<tr>
						<th style="width: 11%" class=""><div>In-Charge</div></th>
						<th style="width: 20%" class=""><div>Training/Workshop</div></th>										
						<th style="width: 12%" class=""><div>Start</div></th>
						<th style="width: 12%" class=""><div>End</div></th>
						<th style="width: 14%" class=""><div>Participants</div></th>
						<th style="width: 16%" class=""><div>Venue</div></th>
						<th style="width: 15%" class="tootip" ><div>Facilitator</div></th>
					</tr>
				<?php } ?>
			</thead>
			<tbody>
				<?php for($i=0; $i<$counter; $i++) {?>
					<?php
						$temp1 = strtotime($start[$i]);
										
						$temp = strtotime($end[$i]);
						$var2 = date('F j\, Y', $temp).PHP_EOL;
						$var1 = date('F j\, Y', $temp1).PHP_EOL;
						
						$true = 0;
						for($j = 0; $j < $decount; $j++ ){
							if( $tag[$j] == $id[$i] ){
								$true;
								break;
							}
						} ?>

					<div>
						<tr class="lin">	
						<?php if( !$true && !$deptTrue ){?>								
						<td class="dataf"><center><div><?php echo $name[$i]; ?></div></center></td>
						<td class="dataf"><center><div><?php echo $description[$i]; ?></div></center></td>
						<td class="dataf"><center><div><?php echo $var1;?></div></center></td>
						<td class="dataf"><center><div><?php echo $var2;?></div></center></td>
						<td class="dataf"><center><div><?php echo $venue[$i] ?></div></center></td>
						<td class="dataf"><center><div><?php echo $cost[$i]; ?></div></center></td>
						<td class="dataf"><center><div><?php echo $reserved[$i]?> | <?php echo ($available[$i] - ($reserved[$i]+$paid[$i]) ); ?> | <?php echo $paid[$i]; ?></div></center></td>	
					<?php } else{ ?>
						<td class="dataf"><a href="#"><center><div><?php echo $department[$i];?></div></center></a></td>
						<td class="dataf"><a href="#"><center><div><?php echo $name[$i];?></div></center></a></td>
						<td class="dataf"><a href="#"><center><div><?php echo $var1; ?></div></center></a></td>
						<td class="dataf"><a href="#"><center><div><?php echo $var2; ?></div></center></a></td>
						<td class="dataf"><a href="#"><center><div><?php echo $count[$i];?></div></center></a></td>
						<td class="dataf"><a href="#"><center><div><?php echo $venue[$i];?></div></center></a></td>
						<td class="dataf"><a href="#"><center><div><?php echo $facilitator[$i];?></div></center></a></td>										
					<?php }?>
					</tr></div>				
				<?php }?>
			</tbody>
			</table>
	</div>
</div>		