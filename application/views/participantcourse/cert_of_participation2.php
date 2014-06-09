<html>
<body>
<div class="bigText1">University of the Philippines</div>
<div class="smallText">presents this</div>
<div class="bigText2">Certificate of <?php echo $type ?></div>
<div class="smallText">to</div>
<div id="participant"><?php echo $nameS; ?></div>
<div id="workshop"><?php echo utf8_encode($workshop); ?></div>
<?php if( $eventStart == $eventEnd ) {
	$dateStart = date('jS \of F Y', strtotime($eventStart)); //date("jS \of F Y");
?>
<div id="venue"> on <?php echo $dateStart; ?> held at <br> <?php echo utf8_encode($venue) ?></div>
<?php } elseif( empty($message2) ) {	
	$message = "";
	$dateStart = date('jS \of F Y', strtotime($eventStart));
	$dateEnd = date('jS \of F Y', strtotime($eventEnd));

	$startPieces2 = explode(" ", $dateStart);
	$endPieces2 = explode(" ", $dateEnd);

	$startPieces = explode("-", $eventStart);
	$endPieces = explode("-", $eventEnd);
	if( $startPieces[0] == $endPieces[0] ){ //year
		/*month checker*/ if( $startPieces[1] == $endPieces[1] ) $message = $startPieces2[0]."-".$endPieces2[0]." of ".$startPieces2[2]." ".$startPieces[0];
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
			else $message = $dateStart." - ".$endDate;
		}	
	}
	$i = 0;
?>
<div id="venue"> on <?php echo $message; ?> <br/>held at <?php echo utf8_encode($venue) ?></div>
<?php } else{ ?>
<div id="venue"> on <?php echo $message2; ?> <br/>held at <?php echo utf8_encode($venue) ?></div>
<?php }?>
<div id="date">Given this day, <?php echo $endDateCert; ?></div>

<div>
	<?php if(!$numFormat){ ?>
		<div class="centerStage">
	<?php } else { ?>
		<div class="signature1">
	<?php } ?>
		<img src="<?php echo $signature1 ?>" class="imgsignature1"><br>
		<span class="name"><?php echo $signatory_name1; ?></span><br>
		<?php if(str_word_count($signatory_position1) > 6 ){
			$sig1 = explode(" ", $signatory_position1);
			$i = strpos($signatory_position1, $sig1[5]);
			$i = $i + strlen($sig1[5]);
		?>

			<span><?php echo $sig1[0]." ".$sig1[1]." ".$sig1[2]." ".$sig1[3]." ".$sig1[4]." ".$sig1[5]; ?></span><br>
			<span><?php echo substr($signatory_position1, $i + 1); ?></span><br>
		<?php } else {?>	
		<span><?php echo $signatory_position1; ?></span><br>
		<?php }?>
	</div>	
	<?php if($numFormat){ ?>
	<div class="signature2">
		<img src="<?php echo $signature2 ?>" class="imgsignature2"><br>
		<span class="name"><?php echo $signatory_name2; ?></span><br>
		<?php if(str_word_count($signatory_position2) > 6 ){
			$sig1 = explode(" ", $signatory_position2);
			$i = strpos($signatory_position2, $sig1[5]);
			$i = $i + strlen($sig1[5]);
		?>

			<span><?php echo $sig1[0]." ".$sig1[1]." ".$sig1[2]." ".$sig1[3]." ".$sig1[4]." ".$sig1[5]; ?></span><br>
			<span><?php echo substr($signatory_position2, $i + 1); ?></span><br>
		<?php } else {?>	
		<span><?php echo $signatory_position2; ?></span><br>
		<?php }?>
	</div>
	<?php }?>	
</div>
</body>
</html>
