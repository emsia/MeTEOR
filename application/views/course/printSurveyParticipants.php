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
	<?php 
		$temp = date('F j\, Y', strtotime($start));
		$temp1 = date('F j\, Y', strtotime($end));
		if( $start == $end ) $message = $temp;
		else {
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
				if( $startPieces[1] == $endPieces[1] ) { /*month checker*/ 
					//$message .= $startPieces2[0]." to ".$endPieces2[0]." of ".$startPieces2[2]." ".$startPieces[0];
					$totalDays = ($endPieces[2] - $startPieces[2]) + 1;
					if( $totalDays == $totDays ) $message .= "for Month of ".$startPieces2[2]." ".$startPieces[0];
					else $message = $startPieces2[0]." to ".$endPieces2[0]." of ".$startPieces2[2]." ".$startPieces[0];
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
	<div class="title"><?php echo $name; ?></div>
	<div class="title2"><?php echo $venue."<br/>".$message;?></div>

	<div class="title3">SURVEY RESULTS</div>
	<div class="lastWords">				
				<p>
					<b style="color: red">1</b> -- Not Confident &nbsp;&nbsp;
					<b style="color: red">2</b> -- Slightly Confident &nbsp;&nbsp;
					<b style="color: red">3</b> -- Confident &nbsp;&nbsp;
					<b style="color: red">4</b> -- Very Confident &nbsp;&nbsp;
				</p>
				<p>
					Number Participants: <b style="color: red"><?php echo $count; ?></b>
				</p>					
			</div>	
	<div class="content">
			<table class="viewtable" border="0">	
			<thead>
				<tr>
					<th style="width: 70%"><div>Questions</div></th>
					<th style="width: 15%"><div>Rating</div></th>										
					<th style="width: 15%"><div>Average</div></th>
				</tr>
			</thead>
			<tbody>
				<?php 
					$title = array('concepts', 'word', 'spreadsheet', 'images', 'presentation', 'internet', 'email');
					$sir = array('I', 'II', 'III', 'IV', 'V', 'VI', 'VII');				
					$divideBy = array(8, 14, 8, 4, 5, 8, 6);

					for( $i = 0; $i < 7; $i++ ){						
						echo "<tr><td><b>&nbsp;".$sir[$i].". ".strtoupper($title[$i])."</b></td><td class='dataf'></td><td class='dataf'></td></tr>";

						for( $j = 1; $j <= $divideBy[$i]; $j++ ){
							$k = $j - 1;
							// class="lin"
							echo "<tr class='lin'>";
							
							switch ($i) {
								case '0':
									echo "<td>".$conceptsS[$k]."</td>";
									break;
								case '1':
									echo "<td class='dataf'>".$wordS[$k]."</td>";
									break;
								case '2':
									echo "<td class='dataf'>".$spreadshtS[$k]."</td>";
									break;
								case '3':
									echo "<td class='dataf'>".$imagesS[$k]."</td>";
									break;
								case '4':
									echo "<td class='dataf'>".$presentationS[$k]."</td>";
									break;	
								case '5':
									echo "<td class='dataf'>".$internetS[$k]."</td>";
									break;				
								default:
									echo "<td class='dataf'>".$emailS[$k]."</td>";
									break;
							}
							
							echo "<td class='dataf'><center>".round($totalPerQ[$i][$j],2)."</center></td><td></td><tr></tr>";
							// for grand each question round( $total_array[$j-1], 2)
						}
						echo "<tr><td class='dataf' style='text-align: right; color: red;'>AVG:</td><td class='dataf'></td><td class='dataf'><center class='avg'>".round($totalPerQuest[$i],2)."</center></td></tr>"; 

						//echo "</tr>";
					}
				 ?>
			</tbody>	
			</table>
			<div class="average"><?php echo "GENERAL AVERAGE: ".round($grandTotal, 2);?></div>	
			<div>		
					Prepared By:					
					
					<div class="titleSir">CARLOS N. FORTEZA</div>
					<div class="alias">Deputy Team Leader, Training and Events</div>
				<br/><br/><br/>
				
					Noted By:
					
					<div class="titleSir">DR. JAIME D.L. CARO</div>
					<div class="alias">eUP Project Director</div>	
			</div>		
	</div>	