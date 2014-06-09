<style>
	#left{
	  padding-left: 50px;
	}
	#r{
		margin-top: 10%;
		margin-left: 28%;
	}
	#ileft{
		padding-left: 100px;
	}
</style>
<div class="span9" style="margin-left: -30px">
	<div class="content">

		<?php if(!empty($err) && $err == 1 ){ ?>
			<div class="panel panel-danger">
			  <div class="panel-heading">Warning</div>
			  <div class="panel-body">
			    <p>You missed some items to fill out. Please review your answers.</p>
			  </div>
			</div>
		<?php }?>

		<div class="panel panel-info">
		  <div class="panel-heading">Evaluation Form</div>
		  <div class="panel-body">
		    <p><b style="color:red">Instruction:</b> Click on the radio button that corresponds to your opinion regarding each statement. Scores are listed below.</p>
		  </div>
		  <ul class="list-group">
		  	<li class="list-group-item"><b style="color:red">0</b> - Not Applicable</li>
		    <li class="list-group-item"><b style="color:red">1</b> - Strongly Agree</li>
		    <li class="list-group-item"><b style="color:red">2</b> - Agree</li>
		    <li class="list-group-item"><b style="color:red">3</b> - Disagree</li>
		    <li class="list-group-item"><b style="color:red">4</b> - Strongly Disagree</li>
		  </ul>
		</div>

		<?php
			$attribute = array('class' => 'form-horizontal');
			$this->load->helper('form'); 
			echo form_open('participantcourse/formSurvey', $attribute);
		?>
		<input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
		<input type="hidden" name="survey" value="<?php echo $survey; ?>">

		<?php for($i=0;$i<$count;$i++){ ?>
			<?php $t = $full_array[$i][0]['type_all'][0]; ?>
			<div class="panel panel-success">
			  <div class="panel-heading"><?php echo strtoupper($titles[$i]); ?></div>
			  <?php if($t==0){ ?>
			  <table class="table table-bordered">
			  	<thead>
			  		<tr>
			  			<th></th>
			  			<th style='width: 5%'><center>1</center></th>
			  			<th style='width: 5%'><center>2</center></th>
			  			<th style='width: 5%'><center>3</center></th>
			  			<th style='width: 5%'><center>4</center></th>
			  			<th style='width: 5%'><center>0</center></th>
			  		</tr>
			  	</thead>
			  	<tbody>
			  		<?php for($j=0; $j<$full_array[$i][0]['count_all']; $j++){
						$pangalan = $full_array[$i][0]['ids'][$j]."_id";
						if( !$full_array[$i][0]['type_all'][$j] ){
					?>
						<tr class='<?php $class = (form_error($pangalan) !== '') ? 'alert-error' : ''; echo $class;?>'>
							<td><?php echo ($j+1)?>. <?php echo $full_array[$i][0]['questions_all'][$j] ?></td>
							
							<?php
								for ($k = 1 ; $k <= 5; $k++){ ?>
									<td><center>
									<label class="radio" id="r">
										<input <?php echo set_radio($pangalan, $k); ?> type='radio' name='<?php echo $pangalan; ?>' value='<?php echo "$k";?>' data-toggle="radio" />
									</label>
									</center></td>
								<?php }
							?>
						</tr>
					<?php } } ?>
			  	</tbody>
			  </table>
			  <?php }?>
			</div>

			<?php for($l=0;$l<$full_array[$i][0]['count_all'];$l++){
				$pangalan = $full_array[$i][0]['ids'][$l]."_id";
				if( $full_array[$i][0]['type_all'][$l] ){
			?>
			<?php $class = (form_error($pangalan) !== '') ? 'panel panel-danger' : 'panel panel-success'; ?>
			<div class="<?php echo $class; ?>">
			  <div class="panel-heading"><?php echo $full_array[$i][0]['questions_all'][$l]; ?></div>
			  <div class="panel-body">
			    <textarea class="span11" name="<?php echo $pangalan; ?>" cols="25" rows="5" placeholder="Type Here..."><?=set_value($pangalan)?></textarea>
			  </div>
			</div>
			<?php } }?>
		<?php }?>

		<center><button type='submit' class="btn btn-success btn-large" name='submit'>SUBMIT <i class="glyphicon glyphicon-play"></i></button></center>

		<?php echo form_close(); ?>
	</div>
</div>