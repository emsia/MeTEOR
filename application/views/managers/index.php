<style type="text/css">
	.cap{
		text-transform: capitalize;
	}
	.red {
		color: red;
		font-size: 14px;
	}
</style>

<script type="text/javascript">
	window.setTimeout("closeHelpDiv();", 3000);
	function closeHelpDiv(){
		document.getElementById("helpdiv").style.display= "none";
	}
</script>

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
	    <div class="red col-md-offset-5" id="invalid" style="display:none">Please enter a valid e-mail</div>
	    <div class="red col-md-offset-5" id="taken" style="display:none">Your Email is already taken</div>
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
    <button type="submit" onclick="return checkMe2()" class="btn btn-warning" >Save <i class="glyphicon glyphicon-ok"></i></button>
  </div>
  <?php echo form_close(); ?>
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

	function checkMe2(){
		var name1 = 'invalid';
	    var name2 = 'taken';
	    var err = 0; err2 = 0;
	    var name = document.getElementById('email').value;

		if(!checkMail()){
			document.getElementById(name1).style.display='';
			document.getElementById(name2).style.display = 'none';
			err = 1;
		}else{
			document.getElementById(name1).style.display='none';
			err = 0;
		}

		if(!err){
			if(checkExist(name)){
				document.getElementById(name2).style.display = '';
				document.getElementById(name1).style.display='none';
				err2 = 1;
			}else{
				document.getElementById(name2).style.display = 'none';
				err2 = 0;
			}
		}

		if(!err && !err2 )return true;
		return false;
	}

	function checkExist(compare){
		var boxes = bodyMe.getElementsByTagName("input");
		for( i = 0; i < boxes.length; i++ ){
			myType = boxes[i].getAttribute("type");
			myvalue = boxes[i].value;

			if( myType == "hidden" ) {
				if(compare.trim()==myvalue.trim()) return true;
			}	
		}
		return false;
	}

	function checkMail(){
		var x = document.getElementById('email').value;
		var atpos = x.indexOf("@");
		var dotpos = x.lastIndexOf(".");
		if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
		{
		  return false;
		}
		return true;
	}
</script>

<div class="span9" style="margin-left: -30px" id="bodyMe">
	<?php
		foreach($emails as $email){
	?>
		<input type="hidden" name="mails[]" value="<?php echo $email; ?>" />
	<?php }?>

	<div class="content">
		<?php
			$this->load->helper('form');
			echo form_open('managers/search_results');
		?>
		<div class="control-group">
			<div class="controls">
				<input type="text" autocomplete="off" data-provide='typeahead' data-items='<?php echo $count_All; ?>' data-source='<?php echo $array;?>' required placeholder="Type Here" name="search"/>
				<button type="submit" class="btn btn-large btn-success">Search</button>
				<a href="#addManeger" data-toggle="modal"><button type="button" class="btn btn-info btn-large">Add Manager <i class="glyphicon glyphicon-plus"></i></button></a>
			</div>
		</div>
		<?php echo form_close();?>
		<hr>

		<?php if(!empty($message) && !$error){ ?>
		<div class="panel panel-danger">
		  <div class="panel-heading">Warning!</div>
		  <div class="panel-body">
		    <?php echo $message; ?>
		  </div>
		</div>
		<?php } ?>

		<?php if(!empty($message) && $error){ ?>
		<div id="helpdiv" class="panel panel-primary">
		  <div class="panel-heading">Successful!</div>
		  <div class="panel-body">
		    <?php echo $message; ?>
		  </div>
		</div>
		<?php } ?>

		<div class="panel panel-success">
		  <div class="panel-heading"><?php if(!isset($search)){?>Managers List<?php }else{ ?>Search Results<?php }?></div>
		  <table class="table table-striped">
		    <thead>
				<tr>
					<th style="width: 3%"></th>
					<th style="width: 3%"></th>
					<th style="width: 3%"></th>
					<th style="width: 22%" ><center>Last Name</center></th>
					<th style="width: 22%" ><center>First Name</center></th>
					<th style="width: 32%"><center>Email</center></th>
					<th style="width: 15%"><center>Status</center></th>
				</tr>
			</thead>
			<tbody>
				<?php for ( $i = 0; $i < $counter; $i++ ): ?>
				<a href="#"><div class="divf">					
				<tr class="linka">
				<td class="dataf" style="vartical-align: bottom">
				
					<?php	
							
					if($role[$i] == 1){
						$this->load->helper('form');									
						echo validation_errors(); 
						echo form_open('managers/promote' ); ?>
				
							<input type='hidden' name='id' value='<?php echo $id[$i]; ?>' />		
							<input type='hidden' name='role' value='<?php echo $role[$i]; ?>' />
							<button class='btn btn-success' style='padding: 5px' data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Promote Manager" type='submit' name='submit'><i class="glyphicon glyphicon-arrow-up"></i></button>
												
						<?php echo form_close();
					
					}	
					else if($role[$i] == 0){
						$this->load->helper('form');
						echo validation_errors(); 
						echo form_open('managers/promote' ); ?>

							<input type='hidden' name='id' value='<?php echo $id[$i]; ?>' />		
							<input type='hidden' name='role' value='<?php echo $role[$i]; ?>' />
							<button class='btn btn-warning' style='padding: 5px' data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Demote Manager" type='submit' name='submit'><i class="glyphicon glyphicon-arrow-down"></i></button>
										
						<?php echo form_close(); ?>
					
					<?php } ?>
				</td>
				<td class="dataf" style="vartical-align: bottom">
				
					<?php	
					if($status[$i] == 0){
						$this->load->helper('form');									
						echo validation_errors(); 
						echo form_open('managers/status' ); ?>
				
							<input type='hidden' name='user_id' value='<?php echo $id[$i]; ?>' />		
							<input type='hidden' name='status' value='<?php echo $status[$i]; ?>' />
							<button class='btn btn-success' type='submit' style='padding: 5px' data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Enable Manager" name='submit'><i class="glyphicon glyphicon-play"></i></button>
												
						<?php echo form_close(); ?>
					
					<?php } else{
						$this->load->helper('form');
						echo validation_errors(); 
						echo form_open('managers/status' ); ?>

							<input type='hidden' name='user_id' value='<?php echo $id[$i]; ?>' />			
							<input type='hidden' name='status' value='<?php echo $status[$i]; ?>' />
							<button class='btn btn-info' type='submit' style='padding: 5px' data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Disable Manager" name='submit'><i class="glyphicon glyphicon-pause"></i></button>
										
						<?php echo form_close(); ?>
					
					<?php } ?>
				</td>
				<td>
					<?php $this->load->helper('form');
						echo validation_errors(); 
						echo form_open('managers/delete' ); ?>

							<input type='hidden' name='id' value='<?php echo $id[$i]; ?>' />		
							<input type='hidden' name='role' value='<?php echo $role[$i]; ?>' />
							<button class='btn btn-danger' style='padding: 5px' data-toggle="tooltip" data-trigger="hover" data-placement="top" title data-original-title="Delete Manager" type='submit' onclick="return confirm('Are you sure you want to delete this manager?')" name='submit'><i class="glyphicon glyphicon-minus"></i></button>
										
						<?php echo form_close(); ?>
				</td>
				<td class="dataf"><center><?php echo $lastname[$i]; ?></center></td>
				<td class="dataf"><center><?php echo $firstname[$i]; ?></center></td>
				<td class="dataf"><center><?php echo $username[$i]; ?></center></td>	
				<td class="dataf">				
					<?php			
						if($status[$i] == 0){ ?>
							<center><span class="badge badge-error">Disabled</span></center>
						<?php } else { ?>
							<center><span class="badge badge-success">Able</span></center>
						<?php } ?>
				</td>
				
			</tr></div></a>
				<?php endfor ?>
				
		</tbody>
		  </table>
		</div>
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