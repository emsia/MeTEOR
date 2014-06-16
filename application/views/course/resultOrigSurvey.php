<body onload="javascript:setTimeout('location.reload(true);',20000);">
<script>
    $(document).on("click", ".manOrNot", function () {
    	var manager = $(this).data('name');
    	var url = $(this).data('base');
    	var form = $('<form></form>');
    	var belong = $(this).data('belong');

    	form.attr("method", "post");
    	form.attr("action", url);
	    var field = $('<input></input>');
	    field.attr("type", "hidden");
	    field.attr("name", 'manager');
        field.attr("value", manager);

        form.append(field);

        var field1 = $('<input></input>');
        field1.attr("type", "hidden");
	    field1.attr("name", 'belong');
        field1.attr("value", belong);
        form.append(field1);
	    $(document.body).append(form);
	    form.submit();
	});

	$(document).on("click", ".dl_manOrNot", function () {
    	var url = $(this).data('base');
    	var form = $('<form></form>');

    	form.attr("method", "post");
    	form.attr("action", url);
	    $(document.body).append(form);
	    form.submit();
	});
</script>

<div class="span9" style="margin-left: -30px">
	<div class="content">
		<?php 
			if( !$man )	echo form_open('course/search_survey'); 
			else echo form_open('managercourse/search_survey'); 
		?>
		<div class="control-group">
			<div class="controls">
				<input type="text" autocomplete="off" data-provide='typeahead' data-items='<?php echo $count_All; ?>' data-source='<?php echo $array;?>' required placeholder="Type Here" name="search"/>
				<input type="hidden" name="evalOrSurvey" value="<?php echo $pili;?>" />
				<button type="submit" name="submit" class="btn btn-large btn-success">Search</button>
				<button type="button" class="btn btn-large btn-info manOrNot" data-belong="<?php echo $pili;?>" data-name="<?php echo $man;?>" data-base="<?php echo base_url().'index.php/course/viewCat';?>" >Question Categories</button>
				<button type="button" class="btn btn-large btn-warning dl_manOrNot" data-toggle="tooltip" data-trigger="hover" data-placement="right" title data-original-title="Download Survey Form"  data-base="<?php echo base_url().'index.php/course/dl_survey';?>" ><i class='glyphicon glyphicon-save'></i></button>
			</div>
		</div>

		<?php echo form_close();?>
		<hr>

		<?php if(!empty($message)){ ?>
			<div class="panel panel-danger">
			  <div class="panel-heading">Warning!</div>
			  <div class="panel-body">
			    <p><?php echo $message;?></p>
			  </div>
			</div>
		<?php }?>

		<?php if( $set ){ ?>
			<div class="panel panel-success">
			  <div class="panel-heading">Search Results</div>
			  <table class="table table-striped">
			  	<thead>	
					<tr>
						<th style="width: 20%"><center>Name</center></th>
						<th style="width: 24%"><center>Description</center></th>
						<th style="width: 13%"><center>Venue</center></th>
						<th style="width: 13%"><center>Cost</center></th>										
						<th style="width: 20%"><center>Expected Participants</center></th>
						<th style="width: 10%"><center>Count</center></th>
					</tr>
				</thead>
				<tbody>	
					<?php for( $i = 0; $i < $count; $i++ ): ?>
					<div>
						<tr class="linka">	
							<?php 
								$tag = 0;
								//echo $count;
								for( $j = 0; $j < $all; $j++ ){
									//echo $courseS[$j]."<br/>";
									if( $courseS[$j] == $idS[$i] ){
										$tag = 1;
										break;
									}
								}

								if( $tag ){?>															
								<td class="dataf"><a href="<?php echo base_url().'index.php/course/resultOrigSurvey/'.$idS[$i]."/".$man;?>"><center><?php echo $name[$i];?></center></a></td>								
								<td class="dataf"><center><?php echo $description[$i];?></center></td>	
								<td class="dataf"><center><?php echo $venue[$i]; ?></center></td>
								<td class="dataf"><center><?php echo $cost[$i]; ?></center></td>
								<td class="dataf"><center><?php echo $totalCount[$i];?></center></td>
								<td class="dataf"><center><?php echo $studentCount[$i];?></center></td>
							<?php } else {?>
								<td class="dataf"><a href="#"><center><?php echo $name[$i];?></center></a></td>								
								<td class="dataf"><center><?php echo $description[$i];?></center></td>	
								<td class="dataf"><center><?php echo $venue[$i]; ?></center></td>
								<td class="dataf"><center><?php echo $cost[$i]; ?></center></td>
								<td class="dataf"><center><?php echo $totalCount[$i]; ?></center></td>
								<td class="dataf"><center><?php echo $studentCount[$i];?></center></td>							
							<?php }?>
						</tr>
					</div>
					<?php endfor ?>	
				</tbody>
			  </table>
			</div>
		<?php }?>
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