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
        $("#participantsorter").tablesorter(); 
    } ); 
</script>
</head>

<div id="body_box">
<table id="body_table" border="0">

	<tr>	
		<td id="navigation">
			<a href="http://localhost/meteorindex.php/managerparticipant" style="color: #7b1113;">VIEW</a> <br/>
		</td>	
		
		<td id="ruler"></td>

		<td id="pagefield">
<!---------------PAGE CONTENT-------------------------->	

		
			<!----SEARCH BUTTON | SUBJECT TO CHANGE TO FIT CI FRAMEWORK------->
			<form action="<?php echo base_url().'index.php/managerparticipant/search_users';?>" method="post">
				<input class ="textf" type="text" name="search" required/>
				<input class="button_login" type="submit" name="submit" value="search" />
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
				
			<tr>
				<td>
				<div id="profileInfo">
			<table class="viewtable" border="0" id="participantsorter">
				<thead>
					<tr>
						<th style="width: 5%" class=""></th>
						<th style="width: 20%" class=""><div> Last Name</div></th>
						<th style="width: 25%" class=""><div> First Name</div></th>
						<th style="width: 30%" class=""><div> Email</div></th>
						<th style="width: 20%" ><div> Status</div></th>
						<th> </th>
					</tr>
				</thead>
				<tbody>
					<?php for($i=0; $i<$counter; $i++) {?>
						<tr class="linka">
						<td class="buttontable">
							<?php
								$this->load->helper('form');									
								echo validation_errors(); 
								echo form_open('managerparticipant/viewprofile' );
									
								echo "<input type='hidden' name='user_id' value='".$id[$i] ."' />";			
											
								echo "<input class='button_smalla' onMouseOver=\"ddrivetip('View Profile', '', 100)\"; onMouseOut=\"hideddrivetip()\" type='submit' name='submit' value='>' /> ";
																	
								echo"</form>";	
							?>
						</td>
						<td class="dataf"><a href="#"><center><div><?php echo $lastname[$i]?></div></center></a></td>
						<td class="dataf"><a href="#"><center><div><?php echo $firstname[$i]?></div></center></a></td>
						<td class="dataf"><a href="#"><center><div><?php echo $username[$i]?></div></center></a></td>
						<td class="dataf"><a href="#"><div><center>
							<?php
								$setCancelled = 1; $setCash = 1; $setBank = 1; $setRes = 1;
								$queryCash = $this->db->get_where( 'payment', array('user_id' => $id[$i]) );
								$arrayCash = $queryCash->row_array();
											
								$queryCancelled = $this->db->get_where( 'cancelled', array('user_id' => $id[$i]) );
								$arrayCancelled= $queryCancelled->row_array();
											
								$queryRes = $this->db->get_where( 'reserved', array('user_id' => $id[$i]) );
								$arrayRes = $queryRes->row_array();
										
								if( !empty($arrayCancelled['id']) ) $setCancelled = 0;
								if( !empty($arrayRes['id']) ) $setRes = 0;
								else if( !empty($arrayCash['id']) ) $setCash = 0;
											
								if( $setRes == 0 && $setCancelled == 0 ) echo "<center>For Validation<br>Has Refunded Course(s)</center>";
								else if( $setRes == 0 ) echo "<center>For Validation</center>";
								else if( $setCash == 0 && $setCancelled == 0 ) echo "<center>Validated<br>Has Refunded Course(s)</center>";					
								else if( $setCancelled == 0 ) echo "<center>Has Refunded Course(s)</center>";
								else if( ($setRes && $setCancelled) && $setCash ) echo "<center>Has No Course(s) Yet</center>";
								else echo "<center>Validated</center>";
								?>
							</center></div></a></td>
						</td>
						</tr> </div> </a>
					<?php }?>
				</tbody>
			</table>
				</div>
				</td>
				
				
			</tr>
			<?php }?>
			
			</table>		
			<!----PAGE CONTENT END------->
			
<!---------------PAGE CONTENT-------------------------->						
		</td>
		
	</tr>

</table>

</div>
<div id="dhtmltooltip"></div>
<script language="javascript" src="<?php echo base_url(); ?>js/tooltip.js" type="text/javascript"></script>
