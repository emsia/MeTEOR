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

			<?php $this->load->helper('form');
				echo form_open('managercourse/reports_search'); ?>				
				&nbsp;&nbsp;<b style="font-size: 19px;" >FROM</b>&nbsp;
				<input id="start" class="textf input-medium pick" type="text" placeholder="Required" name ="starting"  value="<?php echo set_value('start');?>" readonly />
				&nbsp;<b style="font-size: 19px;">TO</b>
				<input id="end" class="textf input-medium pick" type="text" placeholder="Required" size="15" name ="ending"  value="<?php echo set_value('end');?>" readonly />
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
			
			<table class="viewtable" border="0">
				<?php if( $counter > 0 ) {?>
				<tr class="abclink"></tr>
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
							if( $startPieces[1] == $endPieces[1] ) {
								//$message .= $startPieces2[0]." to ".$endPieces2[0]." of ".$startPieces2[2]." ".$startPieces[0];
								$totalDays = ($endPieces[2] - $startPieces[2]) + 1;
								if( $totalDays == $totDays ) $message .= "Month of ".$startPieces2[1]." ".$startPieces[0];
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
				<tr class="abclink">
					<?php if( !empty( $error ) ) { ?><td style="color: red"><center><?php echo $error;?></center></td><?php }else{?>
					<td style="color: #a42125"><center>SEARCH RESULTS: <?php echo $message; ?></center></td><?php }?>
				</tr>
				<tr>
					<td>
						<div id="profileInfo">
							<table class="viewtable" border="0" id="Course">
								<thead>
									<?php if(!$deptTrue){ ?>
									<tr>
										<th style="width: 18%" class="" ><div>Name</div></th>
										<th style="width: 18%" class="" ><div>Description</div></th>										
										<th style="width: 14%" class="tootip" onMouseOver="ddrivetip('Month - Day - Year', '', 130)"; onMouseOut="hideddrivetip()"><div>Start</div></th>
										<th style="width: 14%" class="tootip" onMouseOver="ddrivetip('Month - Day - Year', '', 130)"; onMouseOut="hideddrivetip()"><div>End</div></th>
										<th style="width: 13%" class=""><div>Venue</div></th>
										<th style="width: 10%" class=""><div>Cost</div></th>
										<th style="width: 13%" class="tootip" onMouseOver="ddrivetip('Reserved | Available | Paid', '', 200)"; onMouseOut="hideddrivetip()"><div>R | A | P</div></th>
									</tr>
									<?php }else{?>
										<tr>
											<th style="width: 12%" class="" ><div>In-Charge</div></th>
											<th style="width: 20%" class="" ><div>Training/Workshop</div></th>										
											<th style="width: 12%" class="tootip" onMouseOver="ddrivetip('Month - Day - Year', '', 130)"; onMouseOut="hideddrivetip()"><div>Start</div></th>
											<th style="width: 12%" class="tootip" onMouseOver="ddrivetip('Month - Day - Year', '', 130)"; onMouseOut="hideddrivetip()"><div>End</div></th>
											<th style="width: 13%" class=""><div>Participants</div></th>
											<th style="width: 16%" class=""><div>Venue</div></th>
											<th style="width: 15%" class="tootip" ><div>Facilitator</div></th>
										</tr>
									<?php }?>
								</thead>
								<tbody>
									<?php for($i=0; $i<$counter; $i++) {?>
										<?php
											$temp1 = strtotime($start[$i]);
															
											$temp = strtotime($end[$i]);
											$var2 = date('m-d-Y', $temp).PHP_EOL;
											$var1 = date('m-d-Y', $temp1).PHP_EOL;
											
											$true = 0;
											for($j = 0; $j < $decount; $j++ ){
												if( $tag[$j] == $id[$i] ){
													$true;
													break;
												}
											}

											if( $reserved[$i] > 0 || $paid[$i] > 0)
												$direction = base_url().'index.php/managercourse/participantReport/'.$id[$i];
											else $direction = '#';

											?>
											
											<div><a href = "#">
											<tr class='linka'>

											<?php if( !$true && !$deptTrue ){ $direction .= '/0'; ?>
												<td class="dataf"><a href="<?php echo $direction;?>"><center><div><?php echo $name[$i]; ?></div></center></a></td>
												<td class="dataf"><a href="<?php echo $direction;?>"><center><div><?php echo $description[$i]; ?></div></center></a></td>
												<td class="dataf"><a href="<?php echo $direction;?>"><center><div><?php echo $var1; ?></div></center></a></td>
												<td class="dataf"><a href="<?php echo $direction;?>"><center><div><?php echo $var2; ?></div></center></a></td>
												<td class="dataf"><a href="<?php echo $direction;?>"><center><div><?php echo $venue[$i] ?></div></center></a></td>
												<td class="dataf"><a href="<?php echo $direction;?>"><center><div><?php echo $cost[$i]; ?></div></center></a></td>
												<td class="dataf"><a href="<?php echo $direction;?>"><center><div><?php echo $reserved[$i]?> | <?php echo ($available[$i] - ($reserved[$i]+$paid[$i]) ); ?> | <?php echo $paid[$i]; ?></div></center></a></td>	
											
										<?php } else{ $direction .= '/1'; ?>
											<td class="dataf"><a href="<?php echo $direction;?>"><center><div><?php echo $department[$i];?></div></center></a></td>
											<td class="dataf"><a href="<?php echo $direction;?>"><center><div><?php echo $name[$i];?></div></center></a></td>
											<td class="dataf"><a href="<?php echo $direction;?>"><center><div><?php echo $var1; ?></div></center></a></td>
											<td class="dataf"><a href="<?php echo $direction;?>"><center><div><?php echo $var2; ?></div></center></a></td>
											<td class="dataf"><a href="<?php echo $direction;?>"><center><div><?php echo $count[$i];?></div></center></a></td>
											<td class="dataf"><a href="<?php echo $direction;?>"><center><div><?php echo $venue[$i];?></div></center></a></td>
											<td class="dataf"><a href="<?php echo $direction;?>"><center><div><?php echo $facilitator[$i];?></div></center></a></td>
										<?php }?>
										</tr></a></div>				
									<?php }?>
								</tbody>
							</table>
						</div>
						<?php echo form_open('managercourse/printS');?>
						<input type="hidden" name="starting" value="<?php echo $starting;?>" />
						<input type="hidden" name="ending" value="<?php echo $ending;?>" />
						<input type="hidden" name="deptTrue" value="<?php echo $deptTrue;?>" />
						<input type="hidden" name="dept" value="<?php echo $dept;?>" />
						<center><button class="button_login" name="print" type="submit">Print</button></center>
						<?php echo form_close();?>
					</td>
				</tr>
				<?php }?>
			</table>							
		</td>
		
	</tr>

</table>
<script>
	$(document).ready(function() 
    { 
        $("#Course").tablesorter(); 
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
<script type="text/javascript">
	function prnt() {
		var answer = confirm("Do you really want to print this list of projects?");
		var a = $('#project').val();
		if(answer === true){
		  window.open('','','width=1000,height=600');
		} 
	}
</script> 
</div>
<div id="dhtmltooltip"></div>
<script language="javascript" src="<?php echo base_url(); ?>js/tooltip.js" type="text/javascript"></script>
