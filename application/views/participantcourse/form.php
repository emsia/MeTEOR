<div class="container">	
	<div class="row">
		<br/>
		<?php if(!empty($err) && $err == 1 ){ ?>
			<div class="alert alert-danger">
				<strong>Ooops!</strong> You missed some items to fill out. Please review your answers.
			</div>
		<?php }
			$attribute = array('class' => 'form-horizontal well');
			$this->load->helper('form'); 
			echo form_open('participantcourse/formSurvey', $attribute);
		?>			
			
			<table class="table table-bordered table-striped table-hover">
				<tr>
					<td colspan="6"  style="background-color: #5e0000; solid #cc4e5b; color: #ffe35f; font-family:'futura'; font-size:24px;"><b><center><?php if($survey==0){?>EVALUATION FORM<?php }else{?>SURVEY FORM<?php }?></center></b></td>
				</tr>
				<tr style="border-bottom: 2px solid #666633;">
					<td colspan="6" class="Up" ><b style="color:red">Instruction: </b> <?php if($survey==0){?>Click on the radio button that corresponds to your opinion regarding each statement.<?php }else{?>Choose the appropriate rating on your level of confidence in performing the following ICT(Information and Communication Technology) tasks.<?php }?></td>				
				</tr>
			</table>

			<input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
			<input type="hidden" name="survey" value="<?php echo $survey; ?>">

			<table class="table table-bordered table-striped table-hover">	
				<tr>
					<td style="background-color: #cccc99; solid #cc4e5b;  font-size:24px; font-family:'nevis';" colspan="6">
						<center>
							<?php if($survey==0){?><b style="color:red">1</b>-Strongly Agree   <b style="color:red">2</b>-Agree <b style="color:red">3</b>-Disagree <b style="color:red">4</b>-Stongly Disagree  <b style="color:red">0</b>-N/A
							<?php }else{?><b style="color:red">1</b>- Not Confident    <b style="color:red">2</b>-Slightly Confident   <b style="color:red">3</b>-Confident     <b style="color:red">4</b>-Very Confident<?php }?>
						</center>
					</td>
				</tr>
			</table>

			<?php for($i=0;$i<$count;$i++){ ?>

			<table class="table table-bordered table-striped table-hover">	
				<tbody>
			<?php $t = $full_array[$i][0]['type_all'][0]; ?>
				<tr style="color:red">
					<td><b><?php echo strtoupper($titles[$i]); ?></b></td>
					
					<?php if($t==0){ ?><td>1</td><td>2</td><td>3</td><td>4</td><td>0</td><?php }?>				
				</tr>

				<?php for($j=0; $j<$full_array[$i][0]['count_all']; $j++){
					$pangalan = $full_array[$i][0]['ids'][$j]."_id";
					if( !$full_array[$i][0]['type_all'][$j] ){
				?>
					<tr class='<?php $class = (form_error($pangalan) !== '') ? 'alert-error' : ''; echo $class;?>'>
						<td><?php echo ($j+1)?>. <?php echo $full_array[$i][0]['questions_all'][$j] ?></td>
						
						<?php
							for ($k = 1 ; $k <= 5; $k++){ 
								echo "<td>";?>
								<input <?php echo set_radio($pangalan, $k); ?> class='r' type='radio' name='<?php echo $pangalan; ?>' value='<?php echo "$k";?>'  />
								<?php echo "</td>";
							}
						?>
					</tr>
				<?php } } ?>
				
				</tbody>				
			</table>

			<?php for($l=0;$l<$full_array[$i][0]['count_all'];$l++){
				$pangalan = $full_array[$i][0]['ids'][$l]."_id";
				if( $full_array[$i][0]['type_all'][$l] ){
			?>
			<table class="table table-bordered table-striped table-hover">
				<tr class='<?php $class = (form_error($pangalan) !== '') ? 'alert-error' : ''; echo $class;?>'>
					<td colspan="2"><?php echo ($l+1); ?>. <b><?php echo $full_array[$i][0]['questions_all'][$l]; ?></b></td>
				</tr>
				
				<tr>
					<td colspan="2"><center><textarea class="span11" name="<?php echo $pangalan; ?>" cols="25" rows="5" placeholder="Type Here..."><?=set_value($pangalan)?></textarea></center></td>
				</tr>
			</table>
			<?php } ?>
			<?php } }?>
			<tr>
				<center><button type='submit' class="btn btn-success btn-large" name='submit'/><b>SUBMIT</b></button></center>
			</tr>
		<?php echo form_close();?>
	</div>
	<div class="span11">
		<div class="well"><center>
			We appreciate your help by providing us answers to this evaluation form. Thank you very much and we look 
			forward to having you in one of our future training sessions.
		</div>
		<div class="img-rounded" >
		<center><img style="padding-bottom: 10px" src="<?php echo base_url('css/images/eup-logo.png');?>"/></center>
		</div>
	</div>	
	
	</div>
	<script src="<?php echo base_url('js/bootstrap-button.js') ?>"></script>
</html> 

<script>
	function setTrue(name, num, index){
		for( i = 0; i <= num; i++ ){
			if( i != index ) document.getElementById(name+i).checked = false;
		}
	}
	function setAll(name, num){
		for( i = 0; i <= num; i++ ){
			document.getElementById(name+i).checked = false;
		}
	}
</script>