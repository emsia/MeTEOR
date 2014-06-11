<head>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/styleGeneral.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/view.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/view2.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/tooltip.css" type="text/css"/>
<link href="<?php echo base_url(); ?>css/css_recipes.css" rel="stylesheet" type="text/css">

<script src="<?php echo base_url(); ?>js/jquery-1.8.3.min.js"></script> 
<script src="<?php echo base_url(); ?>js/jquery-latest.js"></script> 
<script src="<?php echo base_url(); ?>js/jquery_tablesorter.js"></script> 
</head>

<div id="body_box">
<table id="body_table" border="0">			
	
	<tr>
	
		<td id="navigation">
			<?php if(!$man) {?>
			<a href="<?php echo base_url().'index.php/course';?>">VIEW</a> <br/>
			<a href="<?php echo base_url().'index.php/course/add';?>">ADD</a> <br/>
			<a href="<?php echo base_url().'index.php/course/cancelled';?>">CANCEL</a> <br/>
			<a href="<?php echo base_url().'index.php/course/reports';?>">EVENT FORMS</a> <br/>
			<a href="<?php echo base_url().'index.php/course/reports_chart';?>">REPORTS</a> <br/>
			<a href="<?php echo base_url().'index.php/course/upload';?>">UPLOAD</a> <br/>
			<a href="<?php echo base_url().'index.php/course/SURVEY';?>" style="color: #7b1113;">EVALUATION RESULTS</a> <br/>
			<a href="<?php echo base_url().'index.php/course/origsurveyResult';?>">SURVEY RESULTS</a> <br/>
			<a href="<?php echo base_url().'index.php/course/request';?>">REQUEST</a> <br/>
			<?php } else {?>
				<a href="<?php echo base_url().'index.php/managercourse';?>">VIEW</a> <br/>
				<a href="<?php echo base_url().'index.php/managercourse/cancelled';?>">CANCEL</a> <br/>
				<a href="<?php echo base_url().'index.php/managercourse/reports';?>">EVENT FORMS</a> <br/>
			<a href="<?php echo base_url().'index.php/course/reports_chart';?>">REPORTS</a> <br/>
				<a href="<?php echo base_url().'index.php/managercourse/upload';?>">UPLOAD</a> <br/>
				<a href="<?php echo base_url().'index.php/managercourse/surveyResult';?>" style="color: #7b1113;">EVALUATION RESULTS</a> <br/>
				<a href="<?php echo base_url().'index.php/managercourse/origsurveyResult';?>">SURVEY RESULTS</a> <br/>
				<a href="<?php echo base_url().'index.php/managercourse/request';?>">REQUEST</a> <br/>
			<?php }?>
		</td>	
		
		<td id="ruler"></td>

		<td id="pagefield">
<!---------------PAGE CONTENT-------------------------->	

		
			<!----SEARCH BUTTON | SUBJECT TO CHANGE TO FIT CI FRAMEWORK------->
			<?php $this->load->helper('form');
				if(!$man) echo form_open('course/search_survey'); 
				else echo form_open('managercourse/search_survey'); ?>				
				<input class ="textf" type="text" name="search" required/>
				<input class="button_login" type="submit" name="submit" value="Search" />
			</form>
			<!----SEARCH BUTTON END------->
			
		
			
			<!----PAGE CONTENT BODY NYA------->
			<table class="viewtable" border="0">		
				<tr class="abclink">
					<td style="list-style: none;"><center></center></td>
				</tr>
				<?php
					$set = 1;
					if( $set ){
				?>
				<tr>
					<tr class="abclink">
					<td style="color: #a42125"><center>SEARCH RESULTS</center></td>
				</tr>
					<td>
						<div id="profileInfo">
							<table id="course" class="viewtable" border="0" id="addCourse">
								<thead>	
									<tr>
										<th style="width: 15%" ><div>Last Name</div></th>
										<th style="width: 15%" ><div>First Name</div></th>
										<th style="width: 20%" ><div>Course Name</div></th>
										<th style="width: 7%" onMouseOver="ddrivetip('Questions in Objective', '', 200)"; onMouseOut="hideddrivetip()"><div>QI</div></th>
										<th style="width: 7%" onMouseOver="ddrivetip('Questions in Methodology', '', 200)"; onMouseOut="hideddrivetip()"><div>QII</div></th>
										<th style="width: 7%" onMouseOver="ddrivetip('Questions in Materials', '', 200)"; onMouseOut="hideddrivetip()"><div>QIII</div></th>
										<th style="width: 7%" onMouseOver="ddrivetip('Questions in Facilities', '', 200)"; onMouseOut="hideddrivetip()"><div>QIV</div></th>
										<th style="width: 7%" onMouseOver="ddrivetip('Questions in Intructor/Facilitator', '', 300)"; onMouseOut="hideddrivetip()"><div>QV</div></th>
										<th style="width: 7%" onMouseOver="ddrivetip('Questions in Assessment', '', 200)"; onMouseOut="hideddrivetip()"><div>QVI</div></th>
										<th style="width: 8%" class="" ><div>Total</div></th>
									</tr>
								</thead>
								<tbody>	
									<?php for( $i = 0; $i < $count; $i++ ): ?>
									<div><a href="#">
									<tr  class="linka">		
										<?php 
											$avg1 = round( ($total1[$i] / 40 ) * 100); //objective
											$avg2 = round( ($total2[$i] / 15 ) * 100); //methodology
											$avg3 = round( ($total3[$i] / 15 ) * 100); //materials
											$avg4 = round( ($total4[$i] / 25 ) * 100); //facilities
											$avg5 = round( ($total5[$i] / 30 ) * 100); //instructor
											$avg6 = round( ($total6[$i] / 30 ) * 100); //overall
											$totalAll = round( ($overAllTotal[$i] / 155 ) * 100); //total
										?>						
										<td class="dataf"><a href="#"><center><div><?php echo $lastname[$i];?></div></center></a></td>								
										<td class="dataf"><a href="#"><center><div><?php echo $firstname[$i];?></div></center></a></td>								
										<td class="dataf"><a href="#"><center><div><?php echo $courseName[$i]; ?></div></center></a></td>
										<td class="dataf"><a href="#"><center><div><?php echo $avg1."%"; ?></div></center></a></td>
										<td class="dataf"><a href="#"><center><div><?php echo $avg2."%" ; ?></div></center></a></td>
										<td class="dataf"><a href="#"><center><div><?php echo $avg3."%" ; ?></div></center></a></td>
										<td class="dataf"><a href="#"><center><div><?php echo $avg4."%" ; ?></div></center></a></td>
										<td class="dataf"><a href="#"><center><div><?php echo $avg5."%" ; ?></div></center></a></td>
										<td class="dataf"><a href="#"><center><div><?php echo $avg6."%" ; ?></div></center></a></td>
										<td class="dataf"><a href="#"><center><div><?php echo $totalAll."%" ; ?></div></center></a></td>									
									</tr></a></div>
									
									
									<?php endfor ?>	
								</tbody>	
							</table>
						</div>
					</td>
				</tr>
				<?php }?>
			<!----PAGE CONTENT END------->
			</table>
<!---------------PAGE CONTENT-------------------------->						
		</td>
	</tr>

</table>
</div>
<script>
	$(document).ready(function() 
    { 
        $("#course").tablesorter(); 
    } );	
</script>

<div id="dhtmltooltip"></div>
<script language="javascript" src="<?php echo base_url('js/tooltip.js'); ?>" type="text/javascript"></script>