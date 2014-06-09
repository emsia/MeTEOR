<head>
<style>
	th{
		color:white; background-color: #003000;
	}
	
	table{
		border: 1px solid #666633;
	}
	
	#bg{
		opacity: 0.5;
	}
</style>
</head>
<body>	
	<?php 
		$temp = date('F j\, Y', strtotime($start));
		$temp1 = date('F j\, Y', strtotime($end));
		if( $start == $end ) $message = $temp;
		else{
			$message = "";
			$dateStart = date('jS \of F Y', strtotime($start));
			$dateEnd = date('jS \of F Y', strtotime($end));

			$startPieces2 = explode(" ", $dateStart);
			$endPieces2 = explode(" ", $dateEnd);

			$startPieces = explode("-", $start);
			$endPieces = explode("-", $end);

			$totDays = date("t",strtotime($startPieces[0].'-'.$startPieces[1].'-01'));

			if( $startPieces[0] == $endPieces[0] && (($startPieces[1] == 1 && $endPieces[1] == 12) ) && ($startPieces[2] == 1 && $endPieces[2] == 31) ){
				$message = "YEAR ".$startPieces[0];	
			} 
			else if( $startPieces[0] == $endPieces[0] ){ //year
				/*month checker*/ 
				if( $startPieces[1] == $endPieces[1] ){
					//$message .= $startPieces2[0]." to ".$endPieces2[0]." of ".$startPieces2[2]." ".$startPieces[0];
					$totalDays = ($endPieces[2] - $startPieces[2]) + 1;
					if( $totalDays == $totDays ) $message .= "for Month of ".$startPieces2[2]." ".$startPieces[0];
					else $message .= $startPieces2[0]." to ".$endPieces2[0]." of ".$startPieces2[2]." ".$startPieces[0];
				} 
				else {
					if( $startPieces[2] == $endPieces[2] ) $message = $startPieces2[0]." of ".$startPieces2[2]."-".$endPieces2[2]." ".$startPieces[0];
					else $message = $startPieces2[0]." of ".$startPieces2[2]." - ".$endPieces2[0]." of ".$endPieces2[2]." ".$startPieces[0];	
				}	
			}else{
				if( $startPieces[1] == $endPieces[1] ){
					if( $startPieces[2] == $endPieces[2] ) $message = $startPieces2[0]." of ".$startPieces2[2]." ".$startPieces[0]."-".$endPieces[0];
					else $message = $startPieces2[0]."-".$endPieces2[0]." of ".$startPieces2[2]." ".$startPieces[0]."-".$endPieces[0];
				}else {
					if( $startPieces[2] == $endPieces[2]) $message = $startPieces2[0]." of ".$startPieces2[2]."-".$endPieces2[2]." ".$startPieces[0]."-".$endPieces[0];
					else $message = $dateStart." - ".$dateEnd;
				}	
			}
		}
	?>

	<div class="title4">TRAINING / EVENT SCHEDULE FORM</div>
	<div class="content"><br/>
		<table class="viewtable" border="0">		
			<?php
				if( $start == $end ) $message = date('M d, Y', strtotime($start));
				else{
					$message = "";
					$dateStart = date('d M Y', strtotime($start));
					$dateEnd = date('d M Y', strtotime($end));

					$startPieces2 = explode(" ", $dateStart);
					$endPieces2 = explode(" ", $dateEnd);

					$startPieces = explode("-", $start);
					$endPieces = explode("-", $end);
					
					$totDays = date("t",strtotime($startPieces[0].'-'.$startPieces[1].'-01'));

					if( $startPieces[0] == $endPieces[0] && (($startPieces[1] == 1 && $endPieces[1] == 12) ) && ($startPieces[2] == 1 && $endPieces[2] == 31) ){
						$message = "for YEAR ".$startPieces[0];	
					} 
					else if( $startPieces[0] == $endPieces[0] ){ //year
						/*month checker*/ 
						if( $startPieces[1] == $endPieces[1] ){
							//$message .= $startPieces2[0]." to ".$endPieces2[0]." of ".$startPieces2[2]." ".$startPieces[0];
							$totalDays = ($endPieces[2] - $startPieces[2]) + 1;
							if( $totalDays == $totDays ) $message .= "Month of ".$startPieces2[1]." ".$startPieces[0];
							else $message .= $startPieces2[0]." to ".$endPieces2[0]." of ".$startPieces2[1]." ".$startPieces[0];
						} 
						else {
							if( $startPieces[2] == $endPieces[2] ) $message = $startPieces2[0]." of ".$startPieces2[1]."-".$endPieces2[1]." ".$startPieces[0];
							else $message = $startPieces2[0]." of ".$startPieces2[1]." - ".$endPieces2[0]." of ".$endPieces2[1]." ".$startPieces[0];	
						}	
					}else{
						if( $startPieces[1] == $endPieces[1] ){
							if( $startPieces[2] == $endPieces[2] ) $message = $startPieces2[0]." of ".$startPieces2[2]." ".$startPieces[0]."-".$endPieces[0];
							else $message = $startPieces2[0]."-".$endPieces2[0]." of ".$startPieces2[1]." ".$startPieces[0]."-".$endPieces[0];
						}else {
							if( $startPieces[2] == $endPieces[2]) $message = $startPieces2[0]." of ".$startPieces2[1]."-".$endPieces2[1]." ".$startPieces[0]."-".$endPieces[0];
							else $message = $dateStart." - ".$dateEnd;
						}	
					}
				}
			?>
			<tbody>
				<tr class='lin'>
					<td class='dataf'><b>Training / Event</b></td>
					<td class='dataf'><?php echo $name; ?></td>
				</tr>
				<tr class='lin'>
					<td class='dataf'><b>Objectives</b></td>
					<td class='dataf'><?php echo nl2br($objectives); ?></td>
				</tr>
				<tr class='lin'>
					<td class='dataf'><b>Date</b></td>
					<td class='dataf'><?php echo $message; ?></td>
				</tr>
				<tr class='lin'>
					<td class='dataf'><b>Time</b></td>
					<?php
						$hours = $endTime - $startTime;
						$startTime = date('g:i A', strtotime($startTime));
						$endTime = date('g:i A', strtotime($endTime));
					?>
					<td class='dataf'><?php echo $startTime." to ".$endTime." (".($hours-1)." hrs) per day" ?></td>
				</tr>
				<tr class='lin'>
					<td class='dataf'><b>Venue</b></td>
					<td class='dataf'><?php echo $venue; ?></td>
				</tr>
				<tr class='lin'>
					<td class='dataf'><b>Attendees</b></td>
					<td class='dataf'><?php echo nl2br($attendees); ?></td>
				</tr>
				<tr class='lin'>
					<td class='dataf'><b>No. of Attendees</b></td>
					<td class='dataf'><?php echo $available; ?></td>
				</tr>
				<tr class='lin'>
					<td class='dataf'><b>Food Expenses</b></td>
					<td class='dataf'><?php echo nl2br($foodRemarks)."<br/><br/>"."<b>TOTAL:</b> Php ".number_format($food, 2); ?></td>
				</tr>
				<tr class='lin'>
					<td class='dataf'><b>Land Transportation</b></td>
					<td class='dataf'><?php echo nl2br($landRemarks)."<br/><br/>"."<b>TOTAL:</b> Php ".number_format($landTranspo, 2); ?></td>
				</tr>
				<tr class='lin'>
					<td class='dataf'><b>Accomodation</b></td>
					<td class='dataf'><?php echo nl2br($accomodationRemarks)."<br/><br/>"."<b>TOTAL:</b> Php ".number_format($accomodation, 2); ?></td>
				</tr>
				<tr class='lin'>
					<td class='dataf'><b>Airfare</b></td>
					<td class='dataf'><?php echo nl2br($airfareRemarks)."<br/><br/>"."<b>TOTAL:</b> Php ".number_format($airfare, 2); ?></td>
				</tr>
				<tr class='lin'>
					<td class='dataf'><b>Total Expenses</b></td>
					<td class='dataf'><?php echo "Accomodation: Php ".number_format($accomodation, 2)."<br/>"."Airfare: Php ".number_format($airfare, 2)."<br/>"."Land Transportation: Php ".number_format($landTranspo, 2)."<br/>"."Food Expenses: Php ".number_format($food, 2)."<br/><br/>"."<b>TOTAL:</b> Php ".number_format($totalexp, 2); ?></td>
				</tr>
			</tbody>	
		</table>	
	</div>	
</body>