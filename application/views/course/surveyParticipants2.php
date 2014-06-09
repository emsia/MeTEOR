<script src="<?php echo base_url('js/highcharts.js'); ?>"></script>
<script src="<?php echo base_url('js/exporting.js'); ?>"></script>
<script src="<?php echo base_url('js/signica.js');?>"></script>

<div class="span9" style="margin-left: -30px">
	<div class="content">
		<?php
			if(!$man) $link=base_url().'index.php/course/origsurveyResult';
			else $link=base_url().'index.php/managercourse/origsurveyResult';
		?>
		<div class="control-group">
			<div class="controls">
				<a href="<?php echo $link; ?>"><button type="button" class="btn btn-large btn-success">Back <i class="glyphicon glyphicon-backward"></i></button></a>
			</div>
		</div>
		<hr>

		<?php if($set){ ?>
		<div class="panel panel-danger">
		  <div class="panel-heading"><?php echo $title_course; ?></div>
		  <ul class="list-group">
	        <li class="list-group-item"><b style="color:red">1</b> - Not Confident</li>
	        <li class="list-group-item"><b style="color:red">2</b> - Confident</li>
	        <li class="list-group-item"><b style="color:red">3</b> - Slightly Confident</li>
	        <li class="list-group-item"><b style="color:red">4</b> - Very Confident</li>
	      </ul>
		</div>

		<div id="profileInfo">
			<ul class="nav nav-tabs">
			    <li class="active"></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab1">
					<?php for($i=0;$i<$count;$i++){
						$graph = "graph".$i;
					?>
						<div style="height: auto" id="<?php echo $graph;?>" ><?php if(isset($all_charts[$graph])) echo $all_charts[$graph];?></div>
						<br/>
					<?php }?>
				</div>
			</div>
		</div>

		<div class="row-fluid">
			<center>
				<?php $class = array('class' => 'form-horizontal');?>
				<?php echo form_open('course/printResult',  $class);?>
				<input type="hidden" name="course_id" value="<?php echo $course_id;?>" />
				<input type="hidden" name="start" value="<?php echo $start;?>" />
				<input type="hidden" name="end" value="<?php echo $end;?>" />
				<input type="hidden" name="venue" value="<?php echo $venue;?>" />
				<input type="hidden" name="server" value="origsurvey" />
				<input type="hidden" name="belonging" value="1" />
				<input type="hidden" name="course_name" value="<?php echo $name;?>" />

				<div class="control-group">
					<center>
						<div class="control-group">
							<center><button type="submit" name="type" class="btn btn-inverse" value="xls" ><span class="glyphicon glyphicon-save"></span> Download Excel File</button></center>
						</div>
					</center>
				</div>
				<?php echo form_close();?>
			</center>
		</div>

		<?php }?>
	</div>
</div>