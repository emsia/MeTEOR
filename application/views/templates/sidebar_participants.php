<div class="row-fluid">
	<div class="span3">
		<div class="sidebar">
			<ul>
				<li <?php if (  !empty($active_nav) && $active_nav == 'UPCOMING' ){?>class="active" <?php } else {?> class="inactive" <?php }?>>
					<a style="text-decoration: none" href="<?php echo base_url('index.php/participantcourse/upcoming');?>">
						<div class="sidebar-content">
							<div class="sidebar-icon glyphicon glyphicon-home"></div>
								UPCOMING <br/> (<?php echo $user['firstname']; ?>)
						</div>
					</a>
				</li>

				<li <?php if (   !empty($active_nav) && $active_nav == 'COMPLETED'){ ?>class="active" <?php } else {?> class="inactive" <?php }?>>
					<a style="text-decoration: none" href="<?php echo base_url('index.php/participantcourse/completed');?>">
						<div class="sidebar-content">
							<div class="sidebar-icon glyphicon glyphicon-flag"></div>
								COMPLETED
						</div>
					</a>
				</li>
			</ul>
		</div>
	</div>