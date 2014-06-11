<?php $list = array( '-- Dept --', 'CM', 'EIS', 'FMIS', 'HARDWARE', 'HRIS', 'IS', 'PS', 'SAIS', 'SPCMIS', 'TRAINING', '-- ALL --'); ?>

<div class="span9" style="margin-left: -30px">
	<div class="content">
		<?php echo form_open('course/reports_search');?>
		<input name="type" type="hidden" value="COURSE" />
		<div class="control-group">
			<div class="controls">
				<input type="text" class="pick" required placeholder="From" name="starting"/>
				<input type="text" class="pick" required placeholder="To" name="ending"/>
				<div class="btn-group btn-input clearfix">
					<select name="dept" class="select">
						<?php for( $i = 0; $i <= 11; $i++ ){ ?>
						<option value="<?php echo $list[$i]; ?>"><?php echo $list[$i]; ?></option>				  
						<?php } ?>
					</select>
				</div>
				<button type="submit" class="btn btn-large btn-success">Search</button>
			</div>
		</div>
		<hr/>
		<?php echo form_close();?>

		<?php if( !empty( $error ) ) { ?>
			<div class="panel panel-danger">
			  <div class="panel-heading">Warning!</div>
			  <div class="panel-body">
			    <p><?php echo $error; ?></p>
			  </div>
			</div>
		<?php }?>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() 
    { 
        $('.pick').datepicker({
			todayBtn: "linked",
		    multidate: false,
		    format: "M d, yyyy",
		    autoclose: true,
		    todayHighlight: true
		});
    });
</script>