<div class="row-fluid">
	<div class="span3">
		<div class="sidebar">
			<ul>
				<li <?php if (  !empty($active_nav) && $active_nav == 'VIEW' ){?>class="active" <?php } else {?> class="inactive" <?php }?>>
					<a style="text-decoration: none" href="<?php echo base_url('index.php/managercourse');?>">
						<div class="sidebar-content">
							<div class="sidebar-icon glyphicon glyphicon-eye-open"></div>
								VIEW
						</div>
					</a>
				</li>

				<li <?php if (   !empty($active_nav) && $active_nav == 'CANCEL'){ ?>class="active" <?php } else {?> class="inactive" <?php }?>>
					<a style="text-decoration: none" href="<?php echo base_url('index.php/managercourse/cancelled');?>">
						<div class="sidebar-content">
							<div class="sidebar-icon glyphicon glyphicon-remove"></div>
								CANCEL
						</div>
					</a>
				</li>

				<li <?php if(   !empty($active_nav) && $active_nav ==  'EVENT'){ ?>class="active" <?php } else {?> class="inactive" <?php }?>>
					<a style="text-decoration: none" href="<?php echo base_url('index.php/managercourse/reports');?>">
						<div class="sidebar-content">
							<div class="sidebar-icon glyphicon glyphicon-bookmark"></div>
								EVENT FORMS
						</div>
					</a>
				</li>

				<li <?php if (   !empty($active_nav) && $active_nav == 'REPORTS'){ ?>class="active" <?php } else {?> class="inactive" <?php }?>>
					<a style="text-decoration: none" href="<?php echo base_url('index.php/course/reports_chart');?>">
						<div class="sidebar-content">
							<div class="sidebar-icon glyphicon glyphicon-stats"></div>
								REPORTS
						</div>
					</a>
				</li>

				<li <?php if(   !empty($active_nav) && $active_nav ==  'UPLOAD'){ ?>class="active" <?php } else {?> class="inactive" <?php }?>>
					<a style="text-decoration: none" href="<?php echo base_url('index.php/managercourse/upload');?>">
						<div class="sidebar-content">
							<div class="sidebar-icon glyphicon glyphicon-cloud-upload"></div>
								UPLOAD
						</div>
					</a>
				</li>

				<li <?php if(   !empty($active_nav) && $active_nav ==  'EVALUATION'){ ?>class="active" <?php } else {?> class="inactive" <?php }?>>
					<a style="text-decoration: none" href="<?php echo base_url('index.php/managercourse/SURVEY');?>">
						<div class="sidebar-content">
							<div class="sidebar-icon glyphicon glyphicon-tasks"></div>
								EVALUATION RESULTS
						</div>
					</a>
				</li>

				<li <?php if(   !empty($active_nav) && $active_nav ==  'SURVEY'){ ?>class="active" <?php } else {?> class="inactive" <?php }?>>
					<a style="text-decoration: none" href="<?php echo base_url('index.php/managercourse/origsurveyResult');?>">
						<div class="sidebar-content">
							<div class="sidebar-icon glyphicon glyphicon-book"></div>
								SURVEY RESULTS
						</div>
					</a>
				</li>

				<li <?php if(   !empty($active_nav) && $active_nav ==  'REQUEST'){ ?>class="active" <?php } else {?> class="inactive" <?php }?>>
					<a style="text-decoration: none" href="<?php echo base_url('index.php/managercourse/request');?>">
						<div class="sidebar-content">
							<div class="sidebar-icon glyphicon glyphicon-paperclip"></div>
								REQUEST
						</div>
					</a>
				</li>
			</ul>
		</div>
	</div>