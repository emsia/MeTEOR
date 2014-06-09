<script src="<?php echo base_url(); ?>js/sha.js"></script>

<div class="row-fluid">
	<div class="span3">
		<div class="sidebar">
			<ul>
				<li <?php if ( !empty($active_nav) && $active_nav == 'PROFILE' ){?>class="active" <?php } else {?> class="inactive" <?php }?>>
					<a style="text-decoration: none" href="<?php echo base_url('index.php/participantprofile');?>">
						<div class="sidebar-content">
							<div class="sidebar-icon glyphicon glyphicon-user"></div>
								PROFILE
						</div>
					</a>
				</li>
				<li <?php if ( !empty($active_nav) && $active_nav == 'PASSWORD' ){?>class="active" <?php } else {?> class="inactive" <?php }?>>
					<a style="text-decoration: none" href="<?php if($this->session->userdata('change')){ echo "#forgetPass"; }else{ echo "#myModal";} ?>" data-toggle="modal" >
						<div class="sidebar-content">
							<div class="sidebar-icon glyphicon glyphicon-lock"></div>
								CODE
						</div>
					</a>
				</li>
			</ul>
		</div>
	</div>

	<div id="myModal" data-backdrop="static" data-keyboard="false" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
	  <div class="modal-header palette-nephritis">
	  	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h4 class="text-white">Change Password</h4>
	  </div>
	  <form class="form-horizontal">
	  <div class="modal-body">
	  	<div class="form-group">
		  <label class="col-sm-5 control-label">Old Password</label>
		  <div class="controls">
		    <input class="textg input input-xlarge" type="password" autocomplete="off" id="old_p" name="old_p" value="" />
		    <div id="old_error" class="col-sm-6 col-md-offset-5 red" style="display:none">Old password is incorrect</div>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-sm-5 control-label">New Password</label>
		  <div class="controls">
		    <input class="textg input input-xlarge" type="password" autocomplete="off" id="new_pass" name="new_pass" value="" />
		    <div id="length_error" class="col-sm-6 col-md-offset-5 red" style="display:none">Should be greater than 6</div>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-sm-5 control-label">Retype Password</label>
		  <div class="controls">
		    <input class="textg input input-xlarge" type="password" autocomplete="off" id="retype" name="retype" value="" />
		    <div id="retype_error" class="col-sm-6 col-md-offset-5 red" style="display:none">Password did not matched</div>
		    <div id="none_error" class="col-sm-6 col-md-offset-5 red" style="display:none">One password is empty</div>
		  </div>
		</div>
	  </div>
	  <div class="modal-footer">
	  	<button type="button" id="showPass" style="display:visible" data-balik="<?php echo "0"; ?>" data-edit="<?php echo "0"; ?>" class="btn btn-danger showMe pull-left" >Show Password <i class="glyphicon glyphicon-pencil"></i></button>
	  	<button type="button" id="hidePass" style="display:none" data-balik="<?php echo "1"; ?>" data-edit="<?php echo "0"; ?>" class="btn btn-inverse pull-left showMe" >Hide Password <i class="glyphicon glyphicon-pencil"></i></button>
	    <button type="button" data-forgeme="<?php echo "0"; ?>" data-pass="<?php echo $pass_code; ?>" data-base="<?php echo base_url('index.php/participantprofile/password'); ?>" class="btn btn-success checkSame" >Save <i class="glyphicon glyphicon-ok"></i></button>
	  </div>
	  </form>
	</div>

	<div id="forgetPass" data-backdrop="static" data-keyboard="false" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
	  <div class="modal-header palette-carrot">
	  	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h4 class="text-white">Forgot Password</h4>
	  </div>
	  <form class="form-horizontal">
	  <div class="modal-body">
		<div class="form-group">
		  <label class="col-sm-5 control-label">New Password</label>
		  <div class="controls">
		    <input class="textg input input-xlarge" type="password" autocomplete="off" id="new_pass_forge" name="new_pass" value="" />
		    <div id="length_error_forge" class="col-sm-6 col-md-offset-5 red" style="display:none">Should be greater than 6</div>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-sm-5 control-label">Retype Password</label>
		  <div class="controls">
		    <input class="textg input input-xlarge" type="password" autocomplete="off" id="retype_forge" name="retype" value="" />
		    <div id="retype_error_forge" class="col-sm-6 col-md-offset-5 red" style="display:none">Password did not matched</div>
		    <div id="none_error_forge" class="col-sm-6 col-md-offset-5 red" style="display:none">One password is empty</div>
		  </div>
		</div>
	  </div>
	  <div class="modal-footer">
	  	<button type="button" id="showPass_forge" style="display:visible" data-balik="<?php echo "0"; ?>" data-edit="<?php echo "1"; ?>" class="btn btn-danger pull-left showMe" >Show Password <i class="glyphicon glyphicon-pencil"></i></button>
	  	<button type="button" id="hidePass_forge" style="display:none" data-balik="<?php echo "1"; ?>" data-edit="<?php echo "1"; ?>" class="btn btn-inverse pull-left showMe" >Hide Password <i class="glyphicon glyphicon-pencil"></i></button>
	    <button type="button" data-forgeme="<?php echo "1"; ?>" data-base="<?php echo base_url('index.php/participantprofile/password'); ?>" class="btn btn-warning checkSame" >Save <i class="glyphicon glyphicon-ok"></i></button>
	  </div>
	  </form>
	</div>

<script type="text/javascript">
	$(document).on("click", ".checkSame", function () {
	    var current = $(this).data('pass');
	    var forget = $(this).data('forgeme');

	    if(forget==0){
		    var old = document.getElementById('old_p');
		    var new1 = document.getElementById('new_pass');
		    var new2 = document.getElementById('retype');
			var old1 = sha1(old.value);
			var name1 = 'none_error';
			var name2 = 'retype_error';
			var name3 = 'length_error';
			var err = 0;
	    }else{
		    var new1 = document.getElementById('new_pass_forge');
		    var new2 = document.getElementById('retype_forge');
		    var name1 = 'none_error_forge';
			var name2 = 'retype_error_forge';
			var name3 = 'length_error_forge';
			var err = 1;
	    }

		if(forget==0){
			if(old1!=current){
				document.getElementById('old_error').style.display = '';
				old.setAttribute('class', 'textg input input-xlarge alert-error');
				err = 0;
			}else{
				document.getElementById('old_error').style.display = 'none';
				old.setAttribute('class', 'textg input input-xlarge');
				err = 1;
			}
		}

		if(new1.value=='' || new2.value==''){
			new1.setAttribute('class', 'textg input input-xlarge alert-error');
			new2.setAttribute('class', 'textg input input-xlarge alert-error');
			document.getElementById(name1).style.display = '';
			document.getElementById(name2).style.display = 'none';
			document.getElementById(name3).style.display = 'none';
		}
		else if(new1.value.length<7){
			new1.setAttribute('class', 'textg input input-xlarge alert-error');
			document.getElementById(name1).style.display = 'none';
			document.getElementById(name2).style.display = 'none';
			document.getElementById(name3).style.display = '';
		}else if(new1.value!=new2.value){
			new1.setAttribute('class', 'textg input input-xlarge alert-error');
			new2.setAttribute('class', 'textg input input-xlarge alert-error');
			document.getElementById(name1).style.display = 'none';
			document.getElementById(name2).style.display = '';
			document.getElementById(name3).style.display = 'none';
		}else if(err){
			var url = $(this).data('base');
	    	var form = $('<form></form>');
	    	form.attr("method", "post");
	    	form.attr("action", url);

	    	var field = $('<input></input>');
		    field.attr("type", "hidden");
		    field.attr("name", 'new_password');
	        field.attr("value", new2.value);
			form.append(field);

	        $(document.body).append(form);
		    form.submit();
		}
	});
	
	$(document).on("click", ".showMe", function () {
	    var edit = $(this).data('edit');
	    var back = $(this).data('balik');

	    if(edit==0){
		    var old = document.getElementById('old_p');
		    var new1 = document.getElementById('new_pass');
		    var new2 = document.getElementById('retype');
		    var name1 = 'showPass';
		    var name2 = 'hidePass';
	    }else{
		    var new1 = document.getElementById('new_pass_forge');
		    var new2 = document.getElementById('retype_forge');
		    var name1 = 'showPass_forge';
		    var name2 = 'hidePass_forge';
	    }

	    if(back==0){
	    	if(edit==0) old.setAttribute('type','text');
	    	document.getElementById(name1).style.display='none';
	    	document.getElementById(name2).style.display='';
	    	new1.setAttribute('type','text');
	    	new2.setAttribute('type','text');
	    }else{
	    	if(edit==0) old.setAttribute('type','password');
	    	document.getElementById(name1).style.display='';
	    	document.getElementById(name2).style.display='none';
	    	new1.setAttribute('type','password');
	    	new2.setAttribute('type','password');
	    }
	});

</script>