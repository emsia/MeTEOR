<head>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/boots.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/flat-ui.css" type="text/css">

<style>
	.panel-heading-succcess {
	  color: white;
	  background-color: #2ecc71;
	  border-color: #2ecc71;
	}
	.panel-heading-info {
	  color: white;
	  background-color: #3498db;
	  border-color: #3498db;
	}
	.list-group {
	  margin-bottom: 0;
	}
	.list-group-item {
	  border: 1px solid #ddd !important;
	}
	div.content1{
		padding-top: .2in; 
		font-family: arial;
		font-size: 12pt;
		margin-left: 1in;
		margin-right: 1in;
	}
	div.title1{
		font-family: arial;
		text-align: center;
		font-size: 18pt;
		font-weight: bold;
	}
	</style>
</head>

<body>
	<div class='title1'><?php if(!$evalOrNot){ ?> Evaluation <?php }else{ ?>Survey <?php }?> Form</div>
	<div class="content1">
		<div class="panel panel-info">
		  <div class="panel-heading panel-heading-info"><?php if(!$evalOrNot){ ?> Evaluation <?php }else{ ?>Survey <?php }?> Form</div>
		  <div class="panel-body">
		    <p><b style="color:red">Instruction:</b> Click on the radio button that corresponds to your opinion regarding each statement. Scores are listed below.</p>
		  </div>
		  <ul class="list-group" style='list-style-type: none;'>
		  	<?php if(!$evalOrNot){ ?>
			  	<li class="list-group-item"><b style="color:red">0</b> - Not Applicable</li>
			    <li class="list-group-item"><b style="color:red">1</b> - Strongly Agree</li>
			    <li class="list-group-item"><b style="color:red">2</b> - Agree</li>
			    <li class="list-group-item"><b style="color:red">3</b> - Disagree</li>
			    <li class="list-group-item"><b style="color:red">4</b> - Strongly Disagree</li>
		   	<?php }else{ ?>
		   		 <li class="list-group-item"><b style="color:red">1</b> - Not Confident</li>
			    <li class="list-group-item"><b style="color:red">2</b> - Slightly Confident</li>
			    <li class="list-group-item"><b style="color:red">3</b> - Confident</li>
			    <li class="list-group-item"><b style="color:red">4</b> - Very Confident</li>
		   	<?php }?>
		  </ul>
		</div>

		<?php for($i=0;$i<$count;$i++){ ?>
			<?php $t = $full_array[$i][0]['type_all'][0]; ?>
			<div class="panel panel-success">
			  <div class="panel-heading panel-heading-succcess"><?php echo strtoupper($titles[$i]); ?></div>
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
						<tr>
							<td><?php echo ($j+1)?>. <?php echo $full_array[$i][0]['questions_all'][$j] ?></td>
							
							<?php
								for ($k = 1 ; $k <= 5; $k++){ ?>
									<td><center>
									<label class="radio" id="r">
										<input <?php echo set_radio($pangalan, $k); ?> type='radio' />
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
			<div class="panel panel-success">
			  <div class="panel-heading panel-heading-succcess"><?php echo $full_array[$i][0]['questions_all'][$l]; ?></div>
			  <div class="panel-body" style='height: 100px'>
			  </div>
			</div>
			<?php } }?>
		<?php }?>
	</div>
</body>