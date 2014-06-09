<div class="row-fluid">
	<div class="span3">
		<div class="sidebar">
			<ul>
				<li <?php if (  !empty($active_nav) && $active_nav == 'VIEW' ){?>class="active" <?php } else {?> class="inactive" <?php }?>>
					<a style="text-decoration: none" href="<?php echo base_url('index.php/managerparticipant');?>">
						<div class="sidebar-content">
							<div class="sidebar-icon glyphicon glyphicon-eye-open"></div>
								VIEW
						</div>
					</a>
				</li>
			</ul>
		</div>
	</div>