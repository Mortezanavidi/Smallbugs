<h3>
   <a href="<?php echo Project::current()->to('issue/new'); ?>" class="newissue"><?php echo __('smallbugs.new_issue');?></a>
   <a href="<?php echo Project::current()->to(); ?>"><?php echo Project::current()->name; ?></a>
	<span><?php echo __('smallbugs.project_overview');?></span>
</h3>

<div class="pad">
	<ul class="tabs">
		<li <?php echo $active == 'activity' ? 'class="active"' : ''; ?>>
			<a href="<?php echo Project::current()->to(); ?>"><?php echo __('smallbugs.activity'); ?></a>
		</li>
		<li <?php echo $active == 'open' ? 'class="active"' : ''; ?>>
			<a href="<?php echo Project::current()->to('issues'); ?>?tag_id=1">
			<?php echo $open_count == 1 ? '1 '.__('smallbugs.open_issue') : $open_count . ' '.__('smallbugs.open_issues'); ?>
			</a>
		</li>
		<li <?php echo $active == 'closed' ? 'class="active"' : ''; ?>>
			<a href="<?php echo Project::current()->to('issues'); ?>?tag_id=2">
			<?php echo $closed_count == 1 ? '1 '.__('smallbugs.closed_issue') : $closed_count . ' '.__('smallbugs.closed_issues'); ?>
			</a>
		</li>
		<li <?php echo $active == 'assigned' ? 'class="active"' : ''; ?>>
			<a href="<?php echo Project::current()->to('issues'); ?>?tag_id=1&amp;assigned_to=<?php echo Auth::user()->id; ?>">
			<?php echo $assigned_count == 1 ? '1 '.__('smallbugs.issue_assigned_to_you') : $assigned_count . ' '.__('smallbugs.issues_assigned_to_you'); ?>
			</a>
		</li>
	</ul>

	<div class="inside-tabs">
		<?php echo $page; ?>
	</div>
</div>