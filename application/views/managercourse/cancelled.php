<head>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/styleGeneral.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/view.css" type="text/css">
<script src="<?php echo base_url(); ?>js/jquery-latest.js"></script> 
<script src="<?php echo base_url(); ?>js/jquery_tablesorter.js"></script>
<link href="<?php echo base_url(); ?>css/css_recipes.css" rel="stylesheet" type="text/css">

<script>
	$(document).ready(function() 
    { 
        $("#Course").tablesorter(); 
    } ); 
</script>
</head>

<div id="body_box">
<table id="body_table" border="0">

	<tr>	
		<td id="navigation">
			<a href="<?php echo base_url().'index.php/managercourse';?>">VIEW</a> <br/>
			<a href="<?php echo base_url().'index.php/managercourse/cancelled';?>" style="color: #7b1113;">CANCEL</a> <br/>
			<a href="<?php echo base_url().'index.php/managercourse/reports';?>">EVENT FORMS</a> <br/>
			<a href="<?php echo base_url().'index.php/course/reports_chart';?>">REPORTS</a> <br/>
			<a href="<?php echo base_url().'index.php/managercourse/upload';?>">UPLOAD</a> <br/>
			<a href="<?php echo base_url().'index.php/managercourse/SURVEY';?>">EVALUATION RESULTS</a> <br/>	
			<a href="<?php echo base_url().'index.php/managercourse/origsurveyResult';?>">SURVEY RESULTS</a> <br/>
			<a href="<?php echo base_url().'index.php/managercourse/request';?>">REQUEST</a> <br/>
		</td>	
		
		<td id="ruler"></td>
		
		
		<td id="pagefield">
		<!--------------------- CONTENTS --------------------->
		
			<!--- SEARCH BUTTON --->
			
			<form action="<?php echo base_url().'index.php/managercourse/search_cancelled';?>" method="post">
				<input class ="textf" type="text" name="search" required/>
				<input class="button_login" type="submit" name="submit" value="Search" />
			</form>
			<!--- End of Search Button --->		
			
			<!--------------------- Contents --------------------->			
			<table border="0">
				<tr class="abclink">
					<td style="list-style: none;"><center></center></td>
				</tr>
				
				<tr>
					<td>
						<table class="viewtable" border="0" id="Course">
							<thead>
							<tr>
								<th style="width: 28%" class=""><div>Name</div></th>
								<th style="width: 25%" class="" onMouseOver="ddrivetip('Month - Day - Year', '', 117)"; onMouseOut="hideddrivetip()"><div>Cancelled On</div></th>
								<th style="width: 20%" class=""><div>Venue</div></th>
								<th style="width: 12%" class=""><div>Cost</div></th>
								<th style="width: 15%" class=""><div>For Refund</div></th>
							</tr>
							</thead>
							<tbody>
							<!---php foreach( $cancelled as $cancelled_item ):?--->
							<?php foreach( $courses as $cancelled_item ): ?>
									<?php 
										$query = $this->db->get_where('cancelled', array('course_id' => $cancelled_item['id']) );
										$array1 = $query->row_array();
										
										$queryDis = $this->db->get_where('dissolved', array('course_id' => $cancelled_item['id']) );
										$arrayDis = $queryDis->row_array();
										
										if( empty( $array1['id'] ) && empty($arrayDis['id']) ) continue;
										
										if( !empty( $array1['id'] ) ) $query1 = $this->db->get_where('courses', array('id' => $array1['course_id']));
										else $query1 = $this->db->get_where('courses', array('id' => $arrayDis['course_id']));
										$array = $query1->row_array();
										
										if( !empty( $array1['id'] ) ) $var = strtotime($array1['date']);
										else $var = strtotime($arrayDis['date']);
									?>		
									<a href="#"><div class="divf">
									<tr class="linka">	
										<?php if( $array['paid'] > 0 ){ ?>										
										<td class="dataf"><a href="<?php echo base_url().'index.php/managercourse/cancelled/'.$cancelled_item['id'];?>"><center><div><?php echo $array['name'];?></div></center></a></td>										
										<td class="dataf"><a href="<?php echo base_url().'index.php/managercourse/cancelled/'.$cancelled_item['id'];?>"><center><div><?php echo date('m-d-Y', $var).PHP_EOL; ?></div></center></a></td>
										<td class="dataf"><a href="<?php echo base_url().'index.php/managercourse/cancelled/'.$cancelled_item['id'];?>"><center><div><?php echo $array['venue'];?></div></center></a></td>
										<td class="dataf"><a href="<?php echo base_url().'index.php/managercourse/cancelled/'.$cancelled_item['id'];?>"><center><div><?php echo $array['cost'];?></div></center></a></td>
										<td class="dataf"><a href="<?php echo base_url().'index.php/managercourse/cancelled/'.$cancelled_item['id'];?>"><center><div><?php echo $array['paid'];?></div></center></a></td>							
										<?php } else{ ?>													
										<td class="dataf"><a href="#"><center><div><?php echo $array['name'];?></div></center></a></td>
										<td class="dataf"><a href="#"><center><div><?php echo date('m-d-Y', $var).PHP_EOL; ?></div></center></a></td>
										<td class="dataf"><a href="#"><center><div><?php echo $array['venue'];?></div></center></a></td>
										<td class="dataf"><a href="#"><center><div><?php echo $array['cost'];?></div></center></a></td>
										<td class="dataf"><a href="#"><center><div><?php echo $array['paid'];?></div></center></a></td>							
										<?php }?>
									</tr></div></a>	
							<?php endforeach ?>
							</tbody>
						</table>
					</td>
					
				</tr>
			</table>
		</td>	
	</tr>
</table>	
</div>

<div id="dhtmltooltip"></div>
<script language="javascript" src="<?php echo base_url(); ?>js/tooltip.js" type="text/javascript"></script>
