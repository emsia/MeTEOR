<head>

<script src="<?php echo base_url('js/highcharts.js'); ?>"></script>
<script src="<?php echo base_url('js/exporting.js'); ?>"></script>
<script src="<?php echo base_url('js/signica.js');?>"></script>

</head>

<div class="span9" style="margin-left: -30px">
	<div class="content">
		<?php
			if( $set ){
		?>
		<div id="profileInfo">
			<div class="tab-content">
				<div class="tab-pane active" id="tab1">
					<?php for($i=0;$i<$countChart;$i++){ ?>
						<?php $id = 'graph'.$i; ?>
						<center><div style="height: auto" id="<?php echo $id ?>" ><?php if(isset($all_charts[$id])) echo $all_charts[$id];?></div></center>
						<br/>
					<?php }?>
				</div>
			</div>
		<?php $class = array('class' => 'form-horizontal');?>
		</div>
		<div class="row-fluid"><center>
			<?php echo form_open('course/downloadReports',  $class);?>
			<input type="hidden" name="start" value="<?php echo $start;?>" />
			<input type="hidden" name="end" value="<?php echo $end;?>" />
			<input type="hidden" name="belonging" value="0" />
			<input type="hidden" name="course_name" value="<?php echo $name;?>" />

			<div class="control-group"><center>
				<div class="control-group"><center>
					<button type="submit" name="type" class="btn btn-inverse" value="xls" ><span class="glyphicon glyphicon-save"></span> Download Excel File</button></center>
				</div></center>
			</div>
		<?php echo form_close();?>
		</center>
		</div>
		<?php }?>
	</div>
</div>