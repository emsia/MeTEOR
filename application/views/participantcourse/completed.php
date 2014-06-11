<script type="text/javascript">
	window.setTimeout("closeHelpDiv();", 3000);
	function closeHelpDiv(){
		document.getElementById("helpdiv").style.display= "none";
	}
</script>
<div class="span9" style="margin-left: -30px">
	<div class="content">
		<?php 
			$this->load->helper('form');
			echo form_open('participantcourse/search_completed');
		?>
		<div class="control-group">
			<div class="controls">
				<input type="text" autocomplete="off" data-provide='typeahead' data-items='<?php echo $count_All; ?>' data-source='<?php echo $array;?>' required placeholder="Type Here" name="search"/>
				<button type="submit" class="btn btn-large btn-success">Search</button>
			</div>
		</div>
		<?php echo form_close();?>
		<hr>

		<?php if(!empty($message) && !$error){ ?>
			<div class="panel panel-danger">
			  <div class="panel-heading">Warning!</div>
			  <div class="panel-body">
			    <p><?php echo $message; ?></p>
			  </div>
			</div>
		<?php }?>
		<?php if(!empty($message) && $error){ ?>
			<div id="helpdiv" class="panel panel-info">
			  <div class="panel-heading">Successful!</div>
			  <div class="panel-body">
			    <p><?php echo $message; ?></p>
			  </div>
			</div>
		<?php }?>

		<?php
			date_default_timezone_set("Asia/Manila");											
			$date = date('Y-m-d');
			$true = 0;

			for( $i = 0; $i < $count; $i++ ){
				if( $end[$i] == $date  ){
					if( time() > strtotime($endTime[$i])){
						$true = 1;
						break;
					}	
				}elseif( $end[$i] < $date ){
					$true = 1;
					break;
				}
			}
			if( $true ){
		?>

		<div class="panel panel-info">
		  <div class="panel-heading">Instruction</div>
		  <div class="panel-body">
		    <p>Certificate Generator Button will only show up until you finished answering Evaluation Form and Survey Form.</p>
		  </div>
		</div>
		
		<div class="panel panel-success">
		  <div class="panel-heading"><?php if( $search ){ ?>Search Results<?php }else{ ?>Completed Courses<?php } ?></div>
		  <table class="table table-striped">
		    <thead>
				<tr>
					<th style="width: 3%"></th>
					<th style="width: 3%"></th>
					<th style="width: 24%"><center>Name</center></th>
					<th style="width: 20%"><center>Description</center></th>
					<th style="width: 13%"><center>Start</center></th>
					<th style="width: 13%"><center>End</center></th>
					<th style="width: 14%"><center>Venue</center></th>
					<th style="width: 10%"><center>Cost</center></th>
				</tr>
			</thead>

			<tbody>
				<?php for( $i = 0; $i < $count; $i++ ): ?>
					<?php
						$true = 0;
						$temp = strtotime($start[$i]);
						$var1 = date('M d, Y', $temp).PHP_EOL;
											
						$temp = strtotime($end[$i]);
						$var2 = date('M d, Y', $temp).PHP_EOL;		
						
					$this->load->helper('date');
					$this->load->helper('form');
					date_default_timezone_set("Asia/Manila");											
					$date = date('Y-m-d');										
						
						if( $end[$i] < $date  ){
							$true = 1;
						} elseif( $end[$i] == $date ){
							if( time() > strtotime($endTime[$i])){
								$true = 1;
							}
						}

						if( $true  ){
					?>						
					 			
					<tr>
					<?php
						$tagSurvey = 1; $tagCert = 1; $tagDone = 0; $tagSuperSurvey = 0; $tagPerm = 0;
						for( $j = 0; $j < $countDef; $j++ ){
							if( $tag[$j] == $id[$i] ){
								$tagSurvey = 0;
								break;
							}	
						}
						for( $g = 0; $g < $countDef; $g++ ){

							if( $alreadyGet[$g] == $id[$i] ){
								$tagDone = 1;
								break;
							}	
						}

						for( $b = 0; $b < $countPermission; $b++ ){

							if( $tagPermission[$b] == $id[$i] ){
								$tagPerm = 1;
								break;
							}	
						}

						for( $h = 0; $h < $countSurvey; $h++ ){

							if( $tagSuperSurveyS[$h] == $id[$i] ){
								$tagSuperSurvey = 1;
								break;
							}	
						}
						
						for( $j = 0; $j < $countPhoto; $j++ ){
							if( $photoId[$j] == $id[$i] ){
								$tagCert = 0;
								break;
							}	
						}
						if( $tagSurvey || !$tagSuperSurvey ) {
					?>
					<td class="buttontable">
						<?php 
							if( $tagSurvey ){
							$this->load->helper('form');
							echo form_open('participantcourse/survey' );?>
							<input type='hidden' name='course_id' value='<?php echo $id[$i]?>' />
							<button class='btn btn-info' type='submit' name='survey' style="padding: 5px" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Answer Evaluation Form" ><i class="glyphicon glyphicon-list"></i></button>						
							
							<?php echo form_close(); } else { ?>
								<button class='btn btn-warning' type='button' style="padding: 5px" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Already Answered Evaluation"><i class="glyphicon glyphicon-list"></i></button>
							<?php } ?>
					</td>
					<td class="buttontable">
					<?php 
							if( !$tagSuperSurvey ){
							$this->load->helper('form');
							echo form_open('participantcourse/origsurvey' );?>
							<input type='hidden' name='course_id' value='<?php echo $id[$i]?>' />
							<button class='btn btn-info' type='submit' name='origsurvey' style="padding: 5px" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Answer Survey Form"><i class="glyphicon glyphicon-stats"></i></button>						
							
					<?php echo form_close(); } else{?>
						<button class='btn btn-warning' type='button' style="padding: 5px" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Already Answer Survey"><i class="glyphicon glyphicon-stats"></i></button>
					<?php }?>
					</td>
						<?php	} else if( !$tagCert && !$tagPerm) {
							/*date_default_timezone_set("Asia/Manila");
							$date1 = date('Y-m-d');

							$startCERT = strtotime($start[$i]);
							$endCERT = strtotime($date1);
							$end3 = strtotime($end[$i]);
							$diff = round(($endCERT - $startCERT)/86400);
							$diff2 = round(($end3 - $startCERT)/86400);

							$startCERT = $diff * -1;
							$endCERT = $startCERT + $diff2;
							
							echo $startCERT."  ".$endCERT."<br/>";
							*/
						?>
							<td class="buttontable">
								<?php 
									echo form_open('participantcourse/certGen' );
								?>
								<input type="hidden" name="CourseName" value="<?php echo $name[$i]; ?>" />
								<input type="hidden" name="course_id" value="<?php echo $id[$i]; ?>" />
								<input type="hidden" name="startDate" value="<?php echo $start[$i]; ?>" />
								<input type="hidden" name="endDate" value="<?php echo $end[$i]; ?>" />
								<input type="hidden" name="venue" value="<?php echo $venue[$i]; ?>" />
								<input type="hidden" name="user_id" value="<?php echo $user['id']; ?>" />
								<button class='btn btn-danger' name='cert' type='submit' style="padding: 5px" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Certificate Generator"><i class="glyphicon glyphicon-certificate"></i></button>
								<?php	echo form_close();	?>
							</td>
							<td class="buttontable"></td>
					<?php echo form_close(); }
							/* else if( !$tagPerm ){
					?>
							<td class='buttontable'>
								<input class='button_smalla' href="#myModal" 
								data-id    = "<?php echo $id[$i];?>"
								data-name  = "<?php echo $name[$i];?>"
								data-fullname = "<?php echo $user['firstname']." ".$user['lastname'];?>"
								data-slugs   = "<?php echo $user['slug']; ?>"
								data-types = "<?php echo $typeS[$i]; ?>"
								data-userid = "<?php echo $user['id']; ?>"
								type='button' data-toggle="modal" name='cert' value='R' onMouseOver="ddrivetip('Send Request', '', 100)"; onMouseOut="hideddrivetip()" />
							</td>
							<td class="buttontable">									
							</td>
					<?php	} */		
							else{
					?>
							<td class="buttontable">
								<button class='btn btn-danger' type='button' style="padding: 5px" data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="No signature uploaded"><i class="glyphicon glyphicon-asterisk"></i></button>
							</td>
							<td class="buttontable"></td>
					<?php }?>
					<td class="dataf"><center><?php echo $name[$i];?></center></td>
					<td class="dataf"><center><?php echo $description[$i];?></center></td>
					<td class="dataf"><center><?php echo $var1;?></center></td>
					<td class="dataf"><center><?php echo $var2;?></center></td>
					<td class="dataf"><center><?php echo $venue[$i];?></center></td>
					<td class="dataf"><center><?php echo $cost[$i];?></center></td>
					
					</tr> 
					
					<?php }  endfor ?>
			</tbody>
		  </table>
		</div>
		<?php }?>
	</div>
</div>

<script>
    $(function() {
	    var tooltips = $( "[title]" ).tooltip();
	    $(document)(function() {
	    	tooltips.tooltip( "open" );
	    })
    });
</script>