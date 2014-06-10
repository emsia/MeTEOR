<head>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/styleGeneral.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/view.css" type="text/css">
<link href="<?php echo base_url(); ?>css/css_recipes.css" rel="stylesheet" type="text/css">

<script src="<?php echo base_url(); ?>js/jquery-latest.js"></script> 
<script src="<?php echo base_url(); ?>js/jquery_tablesorter.js"></script> 
</head>

<script>
	$(document).ready(function() 
    { 
        $("#Course").tablesorter(); 
    } ); 
	$(document).ready(function() 
    { 
        $("#Course1").tablesorter(); 
    } ); 
</script>
</head>

<div id="body_box">
<table id="body_table" border="0">

	<tr>	
		<td id="navigation">
			<a href="<?php echo base_url().'index.php/managercourse';?>" style="color: #7b1113;">VIEW</a> <br/>
			<a href="<?php echo base_url().'index.php/managercourse/cancelled';?>">CANCEL</a> <br/>
			<a href="<?php echo base_url().'index.php/managercourse/reports';?>">EVENT FORMS</a> <br/>
			<a href="<?php echo base_url().'index.php/course/reports_chart';?>">REPORTS</a> <br/>
			<a href="<?php echo base_url().'index.php/managercourse/upload';?>">UPLOAD</a> <br/>
			<a href="<?php echo base_url().'index.php/managercourse/SURVEY';?>">EVALUATION RESULTS</a> <br/>	
			<a href="<?php echo base_url().'index.php/managercourse/origsurveyResult';?>">SURVEY RESULTS</a> <br/>
			<a href="<?php echo base_url().'index.php/managercourse/request';?>">REQUEST</a> <br/>
		</td>	
		
		<td id="ruler"></td>

		<td id="pagefield">
<!---------------PAGE CONTENT-------------------------->	

		
			<!----SEARCH BUTTON | SUBJECT TO CHANGE TO FIT CI FRAMEWORK------->
			<?php $this->load->helper('form');
				echo form_open('managercourse/search_find'); ?>
				<select name="type" class="textf">
				  <option value="COURSE">COURSE</option>
				  <option value="USER">USER</option> 
				</select>
				<input class ="textf" type="text" name="search" required/>
				<input class="button_login" type="submit" name="submit" value="Search" />
			</form>
			<!----SEARCH BUTTON END------->
			
			<!----PAGE CONTENT------->
			<table class="viewtable" border="0">
				<?php 
					if( $counter > 0 ) {
				?>	
				<tr class="abclink">
					<td style="color: #a42125"><center>SEARCH RESULTS</center></td>
				</tr>
				<?php
					$set = 0;
					for($i=0; $i<$counter; $i++) {
						date_default_timezone_set("Asia/Manila");
						$date = date('Y-m-d');
						$temp = strtotime($start[$i]);
						$var1 = date('m-d-Y', $temp).PHP_EOL;
														
						$temp = strtotime($end[$i]);
						$var2 = date('m-d-Y', $temp).PHP_EOL;	
															
						if( $start[$i] > $date && $end[$i] > $date ){
							$set = 1;
							break;
						}						
					}
					if( $set ) {
				?>
				<tr>
				<tr>
					<th style="width: 100%" colspan="5" class=""><center><div style="border:none;background-color: #cccc99; font-size:24px; color: #a42125">UPCOMING COURSES</div></center></th>
				</tr>
					<td>
						<div id="profileInfo">
							<table class="viewtable" border="0" id="Course">
								<thead>
									<tr>
										<th style="width: 20%" class="" ><div>Name</div></th>
										<th style="width: 20%" class="" ><div>Description</div></th>										
										<th style="width: 13%" class="tootip" onMouseOver="ddrivetip('Month - Day - Year', '', 130)"; onMouseOut="hideddrivetip()"><div>Start</div></th>
										<th style="width: 13%" class="tootip" onMouseOver="ddrivetip('Month - Day - Year', '', 130)"; onMouseOut="hideddrivetip()"><div>End</div></th>
										<th style="width: 12%" class=""><div>Venue</div></th>
										<th style="width: 10%" class=""><div>Cost</div></th>
										<th style="width: 12%" class="tootip" onMouseOver="ddrivetip('Reserved | Available | Paid', '', 200)"; onMouseOut="hideddrivetip()"><div>R | A | P</div></th>
									</tr>
								</thead>
								<tbody>
									<?php for($i=0; $i<$counter; $i++) {?>
										<?php
											$date = date('Y-m-d');
											$temp = strtotime($start[$i]);
											$var1 = date('m-d-Y', $temp).PHP_EOL;
															
											$temp = strtotime($end[$i]);
											$var2 = date('m-d-Y', $temp).PHP_EOL;
											
											$yes = 0;
												
											for( $j = 0; $j < $decount; $j++ ){
												if( $tag[$j] == $id[$i] ){
													$yes = 1;
													break;
												}
											}

											if( ($start[$i] > $date && $end[$i] > $date ) && !$yes ){
										?>
										<div><a href = "#">
										<tr class='linka'> 	
										<?php
											if( $reserved[$i] > 0 || $paid[$i] > 0){
												if( $reserved[$i] > 0 || $paid[$i] > 0 )$location = base_url().'index.php/managercourse/process/';
												else $location = base_url().'index.php/managercourse/cancelled/';
										?>									
										<td class="dataf"><a href="<?php echo $location."".$id[$i];?>"><center><div><?php echo $name[$i]; ?></div></center></a></td>
										<td class="dataf"><a href="<?php echo $location."".$id[$i];?>"><center><div><?php echo $description[$i]; ?></div></center></a></td>				
										<td class="dataf"><a href="<?php echo $location."".$id[$i];?>"><center><div><?php echo $var1; ?></div></center></a></td>
										<td class="dataf"><a href="<?php echo $location."".$id[$i];?>"><center><div><?php echo $var2; ?></div></center></a></td>
										<td class="dataf"><a href="<?php echo $location."".$id[$i];?>"><center><div><?php echo $venue[$i] ?></div></center></a></td>
										<td class="dataf"><a href="<?php echo $location."".$id[$i];?>"><center><div><?php echo $cost[$i]; ?></div></center></a></td>
										<td class="dataf"><a href="<?php echo $location."".$id[$i];?>"><center><div><?php echo $reserved[$i]?> | <?php echo ($available[$i] - ($reserved[$i]+$paid[$i]) ); ?> | <?php echo $paid[$i]; ?></div></center></a></td>
										<?php
											}
											else{
										?>	
										<td class="dataf"><a href="#"><center><div><?php echo $name[$i]; ?></div></center></a></td>
										<td class="dataf"><a href="#"><center><div><?php echo $description[$i]; ?></div></center></a></td>
										<td class="dataf"><a href="#"><center><div><?php echo $var1; ?></div></center></a></td>
										<td class="dataf"><a href="#"><center><div><?php echo $var2; ?></div></center></a></td>
										<td class="dataf"><a href="#"><center><div><?php echo $venue[$i] ?></div></center></a></td>
										<td class="dataf"><a href="#"><center><div><?php echo $cost[$i]; ?></div></center></a></td>
										<td class="dataf"><a href="#"><center><div><?php echo $reserved[$i]?> | <?php echo ($available[$i] - ($reserved[$i]+$paid[$i]) ); ?> | <?php echo $paid[$i]; ?></div></center></a></td>	
										<?php }}?>
										</tr> </div> </a>				
									<?php }?>
								</tbody>
							</table>
						</div>
					</td>
				</tr>
				<?php }?>
				<?php if($set){?>
					<tr class="abclink">
						<td style="list-style: none;"><center></center></td>
					</tr>
				<?php }?>
				<?php
					$set = 0;
					for($i=0; $i<$counter; $i++) {
						date_default_timezone_set("Asia/Manila");
						$date = date('Y-m-d');
						$temp = strtotime($start[$i]);
						$var1 = date('m-d-Y', $temp).PHP_EOL;
													
						$temp = strtotime($end[$i]);
						$var2 = date('m-d-Y', $temp).PHP_EOL;
															
						if( $start[$i] <= $date && $end[$i] > $date ){
							$set = 1;
							break;
						}
					}
					if( $set ){
				?>
				<tr>
					<tr>
						<th style="width: 100%" colspan="5" class=""><center><div style="border:none;background-color: #cccc99; font-size:24px; color: #a42125">ONGOING COURSES</div></center></th>
					</tr>
					<td>
						<div id="profileInfo">
							<table class="viewtable" border="0" id="Course1">
								<thead>
									<tr>
										<th style="width: 20%" class="" ><div>Name</div></th>
										<th style="width: 20%" class="" ><div>Description</div></th>										
										<th style="width: 13%" class="tootip" onMouseOver="ddrivetip('Month - Day - Year', '', 130)"; onMouseOut="hideddrivetip()"><div>Start</div></th>
										<th style="width: 13%" class="tootip" onMouseOver="ddrivetip('Month - Day - Year', '', 130)"; onMouseOut="hideddrivetip()"><div>End</div></th>
										<th style="width: 12%" class=""><div>Venue</div></th>
										<th style="width: 10%" class=""><div>Cost</div></th>
										<th style="width: 12%" class="tootip" onMouseOver="ddrivetip('Reserved | Available | Paid', '', 200)"; onMouseOut="hideddrivetip()"><div>R | A | P</div></th>
									</tr>
								</thead>
								<tbody>
									<?php for($i=0; $i<$counter; $i++) {?>
										<?php
											date_default_timezone_set("Asia/Manila");
											$date = date('Y-m-d');
											$temp = strtotime($start[$i]);
											$var1 = date('m-d-Y', $temp).PHP_EOL;
															
											$temp = strtotime($end[$i]);
											$var2 = date('m-d-Y', $temp).PHP_EOL;
											$yes = 0;
												
											for( $j = 0; $j < $decount; $j++ ){
												if( $tag[$j] == $id[$i] ){
													$yes = 1;
													break;
												}
											}

											if( ( $start[$i] <= $date && $end[$i] > $date ) && !$yes ){
										?>
										<div><a href = "#">
										<tr class='linka'> 	
										<?php
											if( $reserved[$i] > 0 || $paid[$i] > 0){
												if( $reserved[$i] > 0 || $paid[$i] > 0  )$location = base_url().'index.php/managercourse/';
												else $location = base_url().'index.php/managercourse/cancelled/';
										?>									
										<td class="dataf"><a href="<?php echo $location."".$id[$i];?>"><center><div><?php echo $name[$i]; ?></div></center></a></td>
										<td class="dataf"><a href="<?php echo $location."".$id[$i];?>"><center><div><?php echo $description[$i]; ?></div></center></a></td>
										<td class="dataf"><a href="<?php echo $location."".$id[$i];?>"><center><div><?php echo $var1; ?></div></center></a></td>
										<td class="dataf"><a href="<?php echo $location."".$id[$i];?>"><center><div><?php echo $var2; ?></div></center></a></td>
										<td class="dataf"><a href="<?php echo $location."".$id[$i];?>"><center><div><?php echo $venue[$i] ?></div></center></a></td>
										<td class="dataf"><a href="<?php echo $location."".$id[$i];?>"><center><div><?php echo $cost[$i]; ?></div></center></a></td>
										<td class="dataf"><a href="<?php echo $location."".$id[$i];?>"><center><div><?php echo $reserved[$i]?> | <?php echo ($available[$i] - ($reserved[$i]+$paid[$i]) ); ?> | <?php echo $paid[$i]; ?></div></center></a></td>
										<?php
											}
											else{
										?>	
										<td class="dataf"><a href="#"><center><div><?php echo $name[$i]; ?></div></center></a></td>
										<td class="dataf"><a href="#"><center><div><?php echo $description[$i]; ?></div></center></a></td>
										<td class="dataf"><a href="#"><center><div><?php echo $var1; ?></div></center></a></td>
										<td class="dataf"><a href="#"><center><div><?php echo $var2; ?></div></center></a></td>
										<td class="dataf"><a href="#"><center><div><?php echo $venue[$i] ?></div></center></a></td>
										<td class="dataf"><a href="#"><center><div><?php echo $cost[$i]; ?></div></center></a></td>
										<td class="dataf"><a href="#"><center><div><?php echo $reserved[$i]?> | <?php echo ($available[$i] - ($reserved[$i]+$paid[$i]) ); ?> | <?php echo $paid[$i]; ?></div></center></a></td>	
										<?php }}?>
										</tr> </div> </a>				
									<?php }?>
								</tbody>
							</table>
						</div>
					</td>
				</tr>
			<?php }}?>
			</table>		
			<!----PAGE CONTENT END------->
			
<!---------------PAGE CONTENT-------------------------->						
		</td>
		
	</tr>

</table>

</div>
<div id="dhtmltooltip"></div>
<script language="javascript" src="<?php echo base_url(); ?>js/tooltip.js" type="text/javascript"></script>
