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
			<a href="<?php echo base_url().'index.php/course'?>" style="color: #7b1113;">VIEW</a> <br/>
			<a href="<?php echo base_url().'index.php/course/add'?> ">ADD</a> <br/>
			<a href="<?php echo base_url().'index.php/course/cancelled'?>">CANCEL</a> <br/>
			<a href="<?php echo base_url().'index.php/course/reports';?>">EVENT FORMS</a> <br/>
			<a href="<?php echo base_url().'index.php/course/reports_chart';?>">REPORTS</a> <br/>
			<a href="<?php echo base_url().'index.php/course/upload';?>">UPLOAD</a> <br/>
			<a href="<?php echo base_url().'index.php/course/SURVEY';?>">EVALUATION RESULTS</a> <br/>
			<a href="<?php echo base_url().'index.php/course/origsurveyResult';?>">SURVEY RESULTS</a> <br/>
			<a href="<?php echo base_url().'index.php/course/request';?>">REQUEST</a> <br/>
		</td>	
		
		<td id="ruler"></td>

		<td id="pagefield">
			<?php $this->load->helper('form');
				echo form_open('course/search_find'); ?>
				<select name="type" class="textf">
				  <option value="COURSE">COURSE</option>
				  <option value="USER">USER</option> 
				</select>
				<input class ="textf" type="text" name="search" required/>
				<input class="button_login" type="submit" name="submit" value="Search" />
			</form>

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
					<th style="width: 100%" colspan="5" class=""><center><div style="border:none;background-color: #cccc99; font-size:24px; color: #a42125">UPCOMING COURSES</div></center></th>
				</tr>
				<tr>
					<td>
						<div id="profileInfo">
							<table class="viewtable" border="0" id="Course">
								<thead>
									<tr>
										<th style="width: 3%" class="" ></th>
										<th style="width: 3%" class="" ></th>
										<th style="width: 17%" class="" ><div>Name</div></th>
										<th style="width: 17%" class="" ><div>Description</div></th>										
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
															
											$temp = strtotime($end[$i]);
											$var2 = date('m-d-Y', $temp).PHP_EOL;
															
											if( $start[$i] > $date && $end[$i] > $date ){
												$yes = 0;
												
												for( $j = 0; $j < $decount; $j++ ){
													if( $tag[$j] == $id[$i] ){
														$yes = 1;
														break;
													}
												}
										?>
										<div><a href = "#">
										<tr class='linka'>
										<?php if( !$yes ){ ?>	
										<td class="buttontable">
											<?php
												$this->load->helper('form');
												echo validation_errors();
												echo form_open('course/edit');
												echo "<input type='hidden' name='course_id' value='".$id[$i]."' />";
												echo "<input type='hidden' name='name' value='".$name[$i]."' />";
												//echo "<input type='hidden' name='name' value='".$username[$i]."' />";
												echo "<input type='hidden' name='description' value='".$description[$i]."' />";
												echo "<input type='hidden' name='objectives' value='".$objectives[$i]."' />";
												echo "<input type='hidden' name='time' value='".$time[$i]."' />";
												echo "<input type='hidden' name='venue' value='".$venue[$i]."' />";
												echo "<input type='hidden' name='start' value='".$start[$i]."' />";
												echo "<input type='hidden' name='end' value='".$end[$i]."' />";
												echo "<input type='hidden' name='cost' value='".$cost[$i]."' />";
												echo "<input type='hidden' name='available' value='".$available[$i]."' />";
												echo "<input type='hidden' name='attendees' value='".$attendees[$i]."' />";
												echo "<input type='hidden' name='attendeesno' value='".$attendeesno[$i]."' />";
												echo "<input type='hidden' name='foodexp' value='".$foodexp[$i]."' />";
												echo "<input type='hidden' name='transpo' value='".$transpo[$i]."' />";
												echo "<input type='hidden' name='accommodation' value='".$accommodation[$i]."' />";
												echo "<input type='hidden' name='totalexp' value='".$totalexp[$i]."' />";
											?>
											<input style='padding: 0px'; onMouseOver="ddrivetip('Edit Course', '', 100)"; onMouseOut="hideddrivetip()" onclick="return confirm('Are you sure you want to edit this course?')" class='button_smalla' type='submit' name='submit' value='E'/>									 					
										</td>
										<?php } else {?>
										<td class="buttontable">
											<input style='padding: 0px'; onMouseOver="ddrivetip('Unable to Edit Course', '', 150)"; onMouseOut="hideddrivetip()" class='button_smallb' type='button' name='submit' value='E'/>									 					
										</td>
										<?php }?>
										<td class="buttontable">
											<?php 								
												$this->load->helper('date');
												$this->load->helper('form');
																	
												date_default_timezone_set("Asia/Manila");
																	
												$var1 = date('Y-m-d G:i:s');													
												
												if( !$yes ){	
													$this->load->helper('form');									
													echo validation_errors(); 
													echo form_open('course/cancelledStatus');
													
													echo "<input type='hidden' name='user_id' value='".$userid."' />";			
													echo "<input type='hidden' name='course_id' value='".$id[$i]."' />";
													echo "<input type='hidden' name='date' value='".$var1."' />";
													echo "<input type='hidden' name='refunded' value='".$paid[$i]."'/>";
											?>
											<input style='padding: 0px'; onMouseOver="ddrivetip('Cancel Course', '', 83)"; onMouseOut="hideddrivetip()" onclick="return confirm('Are you sure you want to proceed?')" class='button_smalla' type='submit' name='submit' value='C'/>									 					
											<?php															
													echo"</form>";	
												}	
												else{
											?>
											<input style='padding: 0px'; onMouseOver="ddrivetip('Cancelled Already', '', 100)"; onMouseOut="hideddrivetip()" class='button_smallb' type='submit' name='submit' value='C' disable/>									 					
											<?php	
											}	
											?>
										</td>	
										<?php
											$var1 = date('m-d-Y', $temp).PHP_EOL;
											if( $reserved[$i] > 0 || $paid[$i] > 0){
												if( $reserved[$i] > 0 || $paid[$i] > 0 ) $location = base_url().'index.php/course/process/';
												else $location = base_url().'index.php/course/cancelled/';
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
										<?php }?>										
										</tr> </div> </a>				
									<?php }}?>
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
										<th style="width: 3%" class="" ></th>
										<th style="width: 3%" class="" ></th>
										<th style="width: 17%" class="" ><div>Name</div></th>
										<th style="width: 17%" class="" ><div>Description</div></th>										
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
															
											$temp = strtotime($end[$i]);
											$var2 = date('m-d-Y', $temp).PHP_EOL;
															
											if( $start[$i] <= $date && $end[$i] > $date ){
										?>
										<div><a href = "#">
										<tr class='linka'> 	
										<td class="buttontable">
											<input style='padding: 0px'; onMouseOver="ddrivetip('Edit Course', '', 100)"; onMouseOut="hideddrivetip()" onclick="return confirm('Are you sure you want to proceed?')" class='button_smalla' type='submit' name='submit' value='E'/>									 					
										</td>
										<td class="buttontable">
											<?php 								
												$this->load->helper('date');
												$this->load->helper('form');
																	
												date_default_timezone_set("Asia/Manila");
																	
												$var1 = date('Y-m-d G:i:s');	
												$yes = 0;
												
												for( $j = 0; $j < $decount; $j++ ){
													if( $tag[$j] == $id[$i] ){
														$yes = 1;
														break;
													}
												}
												
												if( !$yes ){	
													$this->load->helper('form');									
													echo validation_errors(); 
													echo form_open('course/cancelledStatus');
													
													echo "<input type='hidden' name='user_id' value='".$userid."' />";			
													echo "<input type='hidden' name='course_id' value='".$id[$i]."' />";
													echo "<input type='hidden' name='date' value='".$var1."' />";
													echo "<input type='hidden' name='refunded' value='".$paid[$i]."'/>";
											?>
											<input style='padding: 0px'; onMouseOver="ddrivetip('Cancel Course', '', 83)"; onMouseOut="hideddrivetip()" onclick="return confirm('Are you sure you want to proceed?')" class='button_smalla' type='submit' name='submit' value='C'/>									 					
											<?php															
													echo"</form>";	
												}	
												else{
											?>
											<input style='padding: 0px'; onMouseOver="ddrivetip('Cancelled Already', '', 100)"; onMouseOut="hideddrivetip()" class='button_smallb' type='submit' name='submit' value='C' disable/>									 					
											<?php	
											}	
											?>
										</td>
										<?php
											$var1 = date('m-d-Y', $temp).PHP_EOL;											
											if( $reserved[$i] > 0 || $paid[$i] > 0){
												if( $reserved[$i] > 0 || $paid[$i] > 0 ) $location = base_url().'index.php/course/';
												else $location = base_url().'index.php/course/cancelled/';
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
										<?php }?>
										</tr> </div> </a>				
									<?php }}?>
								</tbody>
							</table>
						</div>
					</td>
				</tr>
			<?php }}?>
			</table>						
		</td>
		
	</tr>

</table>

</div>
<div id="dhtmltooltip"></div>
<script language="javascript" src="<?php echo base_url(); ?>js/tooltip.js" type="text/javascript"></script>
