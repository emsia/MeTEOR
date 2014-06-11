<?php $list = array( '-- Dept --', 'CM', 'EIS', 'FMIS', 'HARDWARE', 'HRIS', 'IS', 'PS', 'SAIS', 'SPCMIS', 'TRAINING', '-- ALL --'); ?>

<div class="span9" style="margin-left: -30px">
	<div class="content">
		<?php echo form_open('course/reports_search');?>
		<input name="type" type="hidden" value="COURSE" />
		<div class="control-group">
			<div class="controls">
				<input type="text" class="pick" required placeholder="From" name="starting"/>
				<input type="text" class="pick" required placeholder="To" name="ending"/>
				<div class="btn-group btn-input clearfix">
					<select name="dept" class="select">
						<?php for( $i = 0; $i <= 11; $i++ ){ ?>
						<option value="<?php echo $list[$i]; ?>"><?php echo $list[$i]; ?></option>				  
						<?php } ?>
					</select>
				</div>
				<button type="submit" class="btn btn-large btn-success">Search</button>
			</div>
		</div>
		<hr/>
		<?php echo form_close();?>

		<?php if( !empty( $error ) ) { ?>
			<div class="panel panel-danger">
			  <div class="panel-heading">Warning!</div>
			  <div class="panel-body">
			    <p><?php echo $error; ?></p>
			  </div>
			</div>
		<?php }?>

		<?php
			if( $starting == $ending ) $message = date('M d, Y', strtotime($starting));
			else{
				$message = "";
				$dateStart = date('d M Y', strtotime($starting));
				$dateEnd = date('d M Y', strtotime($ending));

				$startPieces2 = explode(" ", $dateStart);
				$endPieces2 = explode(" ", $dateEnd);

				$startPieces = explode("-", $starting);
				$endPieces = explode("-", $ending);
				
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

		<?php if($counter){?>
			<div class="panel panel-success">
			  <div class="panel-heading"><?php echo "Search Results: ".$message; ?></div>

			  <table class="table">
			  	<thead>
					<?php if(!$deptTrue){ ?>
						<tr>
							<th style="width: 18%"><center>Name</center></th>
							<th style="width: 18%"><center>Description</center></th>										
							<th style="width: 14%"><center>Start</center></th>
							<th style="width: 14%"><center>End</center></th>
							<th style="width: 13%"><center>Venue</center></th>
							<th style="width: 10%"><center>Cost</center></th>
							<th style="width: 13%" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Reserved | Available | Paid"><center>R | A | P</center></th>
						</tr>
					<?php } else{ ?>
						<tr>
							<th style="width: 12%"><center>In-Charge</center></th>
							<th style="width: 20%"><center>Training/Workshop</center></th>										
							<th style="width: 12%"><center>Start</center></th>
							<th style="width: 12%"><center>End</center></th>
							<th style="width: 13%"><center>Participants</center></th>
							<th style="width: 16%"><center>Venue</center></th>
							<th style="width: 15%"><center>Facilitator</center></th>
						</tr>
					<?php }?>
				</thead>
				<tbody>
					<?php for($i=0; $i<$counter; $i++) {?>
						<?php
							$temp1 = strtotime($start[$i]);
							$temp = strtotime($end[$i]);
							$var2 = date('M d, Y', $temp).PHP_EOL;
							$var1 = date('M d, Y', $temp1).PHP_EOL;
							
							$true = 0;
							for($j = 0; $j < $decount; $j++ ){
								if( $tag[$j] == $id[$i] ){
									$true = 1;
									break;
								}
							}

							if( $reserved[$i] > 0 || $paid[$i] > 0)
								$direction = base_url().'index.php/course/participantReport/'.$id[$i];
							else $direction = '#';

							?> 

							<div>
							<tr class='linka'>

							<?php if( !$deptTrue ){ $direction .= '/0'; ?>
								<td class="dataf"><a href="<?php echo $direction; ?>"><center><div><?php echo $name[$i]; ?></div></center></a></td>
								<td class="dataf"><center><div><?php echo $description[$i]; ?></div></center></td>
								<td class="dataf"><center><div><?php echo $var1; ?></div></center></td>
								<td class="dataf"><center><div><?php echo $var2; ?></div></center></td>
								<td class="dataf"><center><div><?php echo $venue[$i] ?></div></center></td>
								<td class="dataf"><center><div><?php echo $cost[$i]; ?></div></center></td>
								<td class="dataf"><center><div><?php echo $reserved[$i]?> | <?php echo ($available[$i] - ($reserved[$i]+$paid[$i]) ); ?> | <?php echo $paid[$i]; ?></div></center></td>	
							
						<?php }else{ $direction .= '/1'; ?>
							<td class="dataf"><a href="<?php echo $direction; ?>"><center><div><?php echo $department[$i];?></div></center></a></td>
							<td class="dataf"><center><div><?php echo $name[$i];?></div></center></td>
							<td class="dataf"><center><div><?php echo $var1; ?></div></center></td>
							<td class="dataf"><center><div><?php echo $var2; ?></div></center></td>
							<td class="dataf"><center><div><?php echo $count[$i];?></div></center></td>
							<td class="dataf"><center><div><?php echo $venue[$i];?></div></center></td>
							<td class="dataf"><center><div><?php echo $facilitator[$i];?></div></center></td>
						<?php }?>
						</tr></a></div>				
					<?php }?>
				</tbody>
			  </table>
			</div>
			<hr>

			<?php echo form_open('course/printEventForms');?>
				<input type="hidden" name="starting" value="<?php echo $starting;?>" />
				<input type="hidden" name="ending" value="<?php echo $ending;?>" />
				<input type="hidden" name="deptTrue" value="<?php echo $deptTrue;?>" />
				<input type="hidden" name="dept" value="<?php echo $dept;?>" />
				<center><button class="btn btn-success btn-large" name="print" type="submit">Print <i class="glyphicon glyphicon-print"></i></button></center>
			<?php echo form_close();?>
		<?php }?>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() 
    { 
        $('.pick').datepicker({
			todayBtn: "linked",
		    multidate: false,
		    format: "M d, yyyy",
		    autoclose: true,
		    todayHighlight: true
		});
    });
</script>

<script>
    $(function() {
	    var tooltips = $( "[title]" ).tooltip();
	    $(document)(function() {
	    	tooltips.tooltip( "open" );
	    })
    });
</script>