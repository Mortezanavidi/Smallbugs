<h3>
	<?php echo __('smallbugs.projects');?>
	<span><?php echo __('smallbugs.projects_description');?></span>
</h3>

<div class="pad">

	<ul class="tabs">
		<li <?php echo $active == 'active' ? 'class="active"' : ''; ?>>
			<a href="<?php echo URL::to('projects'); ?>">
				<?php echo $active_count < 2 ? (($active_count == 0) ? __('smallbugs.no_one') : '1') . ' '.__('smallbugs.active_project') : $active_count . ' '.__('smallbugs.active_projects'); ?>
			</a>
		</li>
		<li <?php echo $active == 'archived' ? 'class="active"' : ''; ?>>
			<a href="<?php echo URL::to('projects'); ?>?status=0">
				<?php echo $archived_count < 2 ? (($archived_count == 0) ? __('smallbugs.no_one') : '1') . ' '.__('smallbugs.archived_project') : $archived_count . ' '.__('smallbugs.archived_projects'); ?>
				</a>
		</li>
	</ul>

	<div class="inside-tabs">

		<div class="blue-box">

			<div class="inside-pad">
				<ul class="projects">
					<?php
					foreach($projects as $row):
						$issues = $row->count_open_issues();
						$closedissues = $row->issues()->where('status', '=', 0)->count();
						$dayspassed = (date("U") - date("U",strtotime($row->created_at)))/86400;
						$velocity = number_format($closedissues/$dayspassed,2);
						$etcday = 0;
						if($velocity > 0){ $etcday = ceil($issues / $velocity); }else{ $etcday = $issues / 1; }
						$etc = date("d-m-Y",strtotime("+".$etcday." days"));
					?>
					<li>
						<a href="<?php echo $row->to(); ?>"><?php echo $row->name; ?></a><br />
						<?php echo $issues == 1 ? '1 '. __('smallbugs.open_issue') : $issues . ' '. __('smallbugs.open_issues'); ?><br />
						<?php if ($row->count_open_issues() > 0) {  ?>
							<strong><?php echo __('smallbugs.velocity_velocity'); ?>:</strong>&nbsp;<?php echo $velocity.'&nbsp;'.__('smallbugs.velocity_rate'); ?>&nbsp;&nbsp;&nbsp;
							<strong><?php echo __('smallbugs.velocity_etc'); ?>:</strong>&nbsp;<?php echo $etc; ?>
						<?php } ?>
						<br />
					</li>
					<?php endforeach; ?>

					<?php if(count($projects) == 0): ?>
					<li>
						<?php echo __('smallbugs.you_do_not_have_any_projects'); ?> <a href="<?php echo URL::to('projects/new'); ?>"><?php if(Auth::user()->permission('project-create')): echo __('smallbugs.create_project'); endif; ?></a>
					</li>
					<?php endif; ?>
				</ul>
				


			</div>

		</div>

	</div>

</div>
