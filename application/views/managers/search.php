<style type="text/css">
	.cap{
		text-transform: capitalize;
	}
</style>

<div id="body_box">
<table id="body_table" border="0">
	
		<td id="navigation"> 
			<a href="http://localhost/meteor/index.php/managers" style="color: #7b1113;">VIEW</a> <br/>		
			<!--a href="http://localhost/meteor/index.php/managers/create">ADD</a> <br/-->		
		</td>
		
		<td id="ruler"></td>
		

		<td id="pagefield">
			<form action="http://localhost/meteor/index.php/managers/search_results" method="post">
				<input class ="textf" type="text" name="search" required/>
				<input class="button_login" type="submit" name="submit" value="Search" />
				<input href="#addManeger" type="button" class="button_login" data-toggle="modal" value="ADD" />
			</form>
				
			<table border="0">
			<tr class="abclink">
				<td style="color: #a42125"><center>SEARCH RESULTS</center></td>
			</tr>
			<tr>
				<td>	
					<table class="viewtable" border="0" id="managersorter">
					<thead>
						<tr>		
							<th style="width: 3%"></th>
							<th style="width: 3%"></th>
							<th style="width: 22%" ><div> Last Name</th>
							<th style="width: 25%" ><div> First Name</div></th>
							<th style="width: 32%"><div> Email</div></th>
							<th style="width: 15%"><div> Status</div></th>
						</tr>
					<thead>
					<tbody>
					<?php for($i=0; $i<$counter; $i++) {?>
					<a href ="#"><div class="divf"><tr class='linka'> 
					<td class="dataf" style="vartical-align: bottom">
						<?php
							if($role[$i] == 1){
								$this->load->helper('form');									
								echo validation_errors(); 
								echo form_open('managers/promote' );
							
									echo "<input type='hidden' name='id' value='".$id[$i]."' />";			
									echo "<input type='hidden' name='role' value='".$status[$i]."' />";
									echo "<input class='button_smalla' onMouseOver=\"ddrivetip('Promote Manager', '', 200)\"; onMouseOut=\"hideddrivetip()\" type='submit' name='submit' value='P' /> ";
															
									echo"</form>";
								
							}	
							else if($role[$i] == 0){
								$this->load->helper('form');
								echo validation_errors(); 
								echo form_open('managers/promote' );

									echo "<input type='hidden' name='id' value='".$id[$i]."' />";			
									echo "<input type='hidden' name='role' value='".$role[$i]."' />";
									echo "<input class='button_smallb' onMouseOver=\"ddrivetip('Demote Manager', '', 200)\"; onMouseOut=\"hideddrivetip()\" type='submit' name='submit' value='P' /> ";
													
								echo"</form>";
							
							}
						?>
					</td>
					<td class="dataf" style="vartical-align: bottom">
					<?php	
						if($status[$i] == 0){
							$this->load->helper('form');									
							echo validation_errors(); 
							echo form_open('managers/status' );
					
								echo "<input type='hidden' name='user_id' value='".$id[$i]."' />";			
								echo "<input type='hidden' name='status' value='".$status[$i]."' />";
								echo "<input class='button_smallb' type='submit' onMouseOver=\"ddrivetip('Enable Manager', '', 200)\"; onMouseOut=\"hideddrivetip()\" name='submit' value='D' /> ";
														
							echo"</form>";
								
						}	
						else{
							$this->load->helper('form');
							echo validation_errors(); 
							echo form_open('managers/status' );

								echo "<input type='hidden' name='user_id' value='".$id[$i]."' />";			
								echo "<input type='hidden' name='status' value='".$status[$i]."' />";
								echo "<input class='button_smalla' type='submit' onMouseOver=\"ddrivetip('Disable Manager', '', 200)\"; onMouseOut=\"hideddrivetip()\" name='submit' value='D' /> ";
											
							echo"</form>";
						
						}
						?>
						</td>
				<td class="dataf"><a href="#"><div><center><?php echo "$lastname[$i]"; ?></center></div></a></td>
				<td class="dataf"><a href="#"><div><center><?php echo "$firstname[$i]"; ?></center></div></a></td>
				<td class="dataf"><a href="#"><div><center><?php echo "$username[$i]"; ?></center></div></a></td>
				<td class="dataf"> 
					<?php 
					if($status[$i] == 1) echo "<center>Able</center>";
					else  echo "<center>Disable</center>";
					?>
				
				</td>
				</tr> </div> </a>
					<?php } ?>					
				</tbody>
			
			</table>
				</td>	
			</table>					
		</td>
	</tr>


</table>


<div id="addManeger" data-backdrop="static" data-keyboard="false" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-header palette-alizarin">
  	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="text-white">Add Managers</h4>
  </div>
   <?php 
		$this->load->helper('form');
		$class = array('class' => 'form-horizontal');
		echo form_open('managers/create', $class);
	?>	

  <div class="modal-body">
	<div class="form-group">
	  <label class="col-sm-5 control-label">Last Name</label>
	  <div class="controls">
	    <input class="textg cap input input-xlarge" type="text" name="lastname" required value="" />
	  </div>
	</div>
	<div class="form-group">
	  <label class="col-sm-5 control-label">First Name</label>
	  <div class="controls">
	    <input class="textg cap input input-xlarge" type="text" name="firstname" required value="" />
	  </div>
	</div>
	<div class="form-group">
	  <label class="col-sm-5 control-label">E-mail</label>
	  <div class="controls">
	    <input class="textg input input-xlarge" type="text" name="email" id="email" required value="" />
	  </div>
	</div>
	<div class="form-group">
	  <label class="col-sm-5 control-label">Password</label>
	  <div class="controls">
	    <input class="textg input input-xlarge" type="password" autocomplete="off" id="password" name="password" required value="" />
	  </div>
	</div>
  </div>
  <div class="modal-footer">
  	<button type="button" id="showPass_forge" style="display:visible" data-balik="<?php echo "0"; ?>" class="btn btn-danger pull-left showMe" >Show Password <i class="glyphicon glyphicon-pencil"></i></button>
  	<button type="button" id="hidePass_forge" style="display:none" data-balik="<?php echo "1"; ?>" class="btn btn-inverse pull-left showMe" >Hide Password <i class="glyphicon glyphicon-pencil"></i></button>
    <button type="submit" onclick="return checkMail()" class="btn btn-warning" >Save <i class="glyphicon glyphicon-ok"></i></button>
  </div>
  </form>
</div>

</div>

<script type="text/javascript">
	$(document).on("click", ".showMe", function () {
	    var back = $(this).data('balik');
	    var name1 = 'showPass_forge';
	    var name2 = 'hidePass_forge';
	    var new1 = document.getElementById('password');

	    if(back==0){
	    	document.getElementById(name1).style.display='none';
	    	document.getElementById(name2).style.display='';
	    	new1.setAttribute('type','text');
	    }else{
	    	document.getElementById(name1).style.display='';
	    	document.getElementById(name2).style.display='none';
	    	new1.setAttribute('type','password');
	    }
	});

	function checkMail(){
		var x = document.getElementById('email').value;
		var atpos = x.indexOf("@");
		var dotpos = x.lastIndexOf(".");
		if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
		{
		  alert("Not a valid e-mail address");
		  return false;
		}
		return true;
	}
</script>

</div>
<div id="dhtmltooltip"></div>
<script language="javascript" src="<?php echo base_url(); ?>js/tooltip.js" type="text/javascript"></script>

<div class="span9" style="margin-left: -30px">
	<div class="content">
		<?php
			$this->load->helper('form');
			echo form_open('managers/search_results');
		?>
		<div class="control-group">
			<div class="controls">
				<input type="text" required placeholder="Type Here" name="search"/>
				<button type="submit" class="btn btn-large btn-success">Search</button>
				<a href="#addManeger" data-toggle="modal"><button type="button" class="btn btn-info btn-large">Add Manager <i class="glyphicon glyphicon-plus"></i></button></a>
			</div>
		</div>
		<?php echo form_close();?>
		<hr>
	</div>
</div>
