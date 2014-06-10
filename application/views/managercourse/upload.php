<head>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/styleGeneral.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/view.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/css_recipes.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/anytime.css" type="text/css"  />

<script src="<?php echo base_url(); ?>js/jquery-latest.js"></script> 
<script src="<?php echo base_url(); ?>js/jquery_tablesorter.js"></script> 
<script src="<?php echo base_url(); ?>js/anytime.js"></script>

<script>	
	 $(document).ready(function() {
		$('.checkall').change(function() {
			var checkboxes = $(this).closest('form').find(':checkbox');
			if($(this).is(':checked')) {
				checkboxes.attr('checked', 'checked');
				setTrue( 1 );
			} else {
				checkboxes.removeAttr('checked');
				setTrue( 0 );
			}
		});
	 });
	 
	function CheckAll2( chkState ){
		var boxes = body_box.getElementsByTagName("input");
		for( i = 0; i < boxes.length; i++ ){
			myType = boxes[i].getAttribute("type");
			ID = boxes[i].getAttribute("id");
			if( myType == "checkbox" && ID == "ongoing")
				boxes[i].checked = chkState;
		}
		setTrue( chkState );
		return;
	}
	
	function setTrue( opt ){
		if(opt==0)
			document.getElementById('SetOkay').disabled = true;
		if(opt==1)
			document.getElementById('SetOkay').disabled = false;
	}
	function setIt(){
		var boxes = body_box.getElementsByTagName("input");
		for( i = 0; i < boxes.length; i++ ){
			myType = boxes[i].getAttribute("type");
			if( myType == "checkbox" ) {
				if( boxes[i].checked == 1 ){
					setTrue( 1 );
					break;
				}
			}	
		}
		if( i == boxes.length ) setTrue( 0 );
		return;
	}
	
</script>
<noscript>Please Enable javascript to view this Page Correctly.</noscript>
</head>

<div id="body_box">
<table id="body_table" border="0">			
	
	<tr>
	
		<td id="navigation">
			<a href="<?php echo base_url().'index.php/managercourse';?>">VIEW</a> <br/>
			<a href="<?php echo base_url().'index.php/managercourse/cancelled';?>">CANCEL</a> <br/>
			<a href="<?php echo base_url().'index.php/managercourse/reports';?>">EVENT FORMS</a> <br/>
			<a href="<?php echo base_url().'index.php/managercourse/upload';?>"  style="color: #7b1113;">UPLOAD</a> <br/>
		</td>	
		
		<td id="ruler"></td>

		<td id="pagefield">
<!---------------PAGE CONTENT-------------------------->	

		
			<!----SEARCH BUTTON | SUBJECT TO CHANGE TO FIT CI FRAMEWORK-------->
			<?php $this->load->helper('form');
				echo form_open('managercourse/search_upload'); ?>
				<input class ="textf" type="text" name="search" required/>
				<input class="button_login" type="submit" name="submit" value="Search" />
			</form>
			<!----SEARCH BUTTON END------->
			
			<?php 
				if( !empty( $error ) ) echo "<center><div class='error'>".$error."</div></center>";
				echo form_open_multipart('managercourse/upSig'); 
			?>
			
			<!----PAGE CONTENT BODY NYA-------->
			<table class="viewtable" border="0">		
				<tr class="abclink">
					<td style="list-style: none;"><center></center></td>
				</tr>
				<tr>
					<tr>
						<th style="width: 100%" colspan="5" class=""><center><div style="border:none;background-color: #cccc99; font-size:24px; color: #a42125">ALL COURSES</div></center></th>
					</tr>
					<td>
						<div id="profileInfo">
							<table class="viewtable" border="0" id="addCourse">
								<thead>	
									<tr>
										<th  style="width: 5%" onMouseOver="ddrivetip('Check All', '', 55)"; onMouseOut="hideddrivetip()"><center>
											<input type="checkbox" class='checkall' />
										</center></th>
										<th style="width: 20%" class="" ><div>Name</div></th>
										<th style="width: 17%" class="" ><div>Description</div></th>										
										<th style="width: 13%" class="tootip" onMouseOver="ddrivetip('Month - Day - Year', '', 130)"; onMouseOut="hideddrivetip()"><div>Start</div></th>
										<th style="width: 13%" class="tootip" onMouseOver="ddrivetip('Month - Day - Year', '', 130)"; onMouseOut="hideddrivetip()"><div>End</div></th>
										<th style="width: 12%" class=""><div>Venue</div></th>
										<th style="width: 10%" class=""><div>Cost</div></th>
										<th style="width: 12%" class="tootip" onMouseOver="ddrivetip('Reserved | Available | Paid', '', 200)"; onMouseOut="hideddrivetip()"><div>R | A | P</div></th>
									</tr>
								</thead>
								<tbody>	
									<?php for( $i = 0; $i < $count; $i++ ): ?>
									<div><a href="#">
									<tr  class="linka">	
										<td class="dataf"><center>
											<input type="hidden" name="<?php echo "course[]";?>" value ="<?php echo "$id[$i]";?>" >											
											<input type="checkbox" name="check[]" onMouseOver="ddrivetip('Check', '', 35)"; onMouseOut="hideddrivetip()" onClick="setIt()" value="<?php echo "$i";?>" />
										</center></td>
										<?php
											$temp = strtotime($start[$i]);
											$var1 = date('m-d-Y', $temp).PHP_EOL;
											
											$temp = strtotime($end[$i]);
											$var2 = date('m-d-Y', $temp).PHP_EOL;
										?>														
										<td class="dataf"><a href="#"><center><div><?php echo $name[$i];?></div></center></a></td>
										<td class="dataf"><a href="#"><center><div><?php echo $description[$i];?></div></center></a></td>
										<td class="dataf"><a href="#"><center><div><?php echo $var1; ?></div></center></a></td>
										<td class="dataf"><a href="#"><center><div><?php echo $var2; ?></div></center></a></td>
										<td class="dataf"><a href="#"><center><div><?php echo $venue[$i];?></div></center></a></td>
										<td class="dataf"><a href="#"><center><div><?php echo $cost[$i];?></div></center></a></td>
										<td class="dataf"><a href="#"><center><div><?php echo $reserved[$i];?> | <?php echo $available[$i];?> | <?php echo $paid[$i];?></div></center></a></td>	
									</tr></a></div>
									
									<?php endfor ?>	
								</tbody>	
							</table>
							<br/>
							<center>
								<label style="color:red">Ending Date:</label>
								<input type="text" class="textf" id="0" name="ending" onfocus="cal()" value="<?php echo set_value('start[]'); ?>" required /><br/>
								<span class="file-wrapper">
								  <input type="file" name="photo" required />
								  <button class="button_login">Choose a signature</button>
								</span>
										
								<input type="submit" class="button_login" id="SetOkay" name="uploadSig" value="UPLOAD" disabled />		
							</center>
						</div>
					</td>
				</tr>	
				
			<!----PAGE CONTENT END------->
			</table>
			
			<?php echo form_close();?>
<!---------------PAGE CONTENT-------------------------->						
		</td>
	</tr>

</table>
<script>
	
	var c = 1;
	var oneDay = 24*60*60*1000;
	var rangeDemoFormat = "%Y-%m-%e";
	var rangeTimeFormat = "%H:%i:%s";
	var rangeDemoConv = new AnyTime.Converter({format:rangeDemoFormat});
	var rangeTimeConv = new AnyTime.Converter({format:rangeTimeFormat});
	
	function cal()
	{	
		$("#0").AnyTime_picker({format:rangeDemoFormat});
		$("#0").change( function(e) { try {
			var fromDay = rangeDemoConv.parse($("#0").val()).getTime();
			var dayLater = new Date(fromDay);
			dayLater.setHours(0,0,0,0);
		$("#last0").AnyTime_noPicker().removeAttr("disabled").
		  val(rangeDemoConv.format(dayLater)).
		  AnyTime_picker(
			  { earliest: dayLater,
				format: rangeDemoFormat
			  } );
		 } catch(e){ $("#last0").val("").attr("disabled","disabled"); } } );
		 $("#testing").AnyTime_picker({format:rangeTimeFormat});
	}		
</script>

</div>
<div id="dhtmltooltip"></div>
<script language="javascript" src="<?php echo base_url(); ?>js/tooltip.js" type="text/javascript"></script>