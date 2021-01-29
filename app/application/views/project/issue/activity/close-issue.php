<li id="comment<?php echo $activity->id; ?>" class="comment">
	<div class="insides">
		<div class="topbar">

			<div class="data">
				<label class="label success"><?php echo __('smallbugs.label_closed'); ?></label> <?php echo __('smallbugs.by'); ?> <strong><?php echo $user->firstname . ' ' . $user->lastname; ?></strong> 
				<span class="time">
					<?php echo date(Config::get('application.my_bugs_app.date_format'), strtotime($activity->created_at)); ?>
				</span>
				<?php if(Project\Issue::current()->status == 0 && Auth::user()->permission('issue-modify')): ?>
				<a href="<?php echo Project\Issue::current()->to('status?status=1'); ?>" class="button success"><?php echo __('smallbugs.reopen'); ?></a>				
				<?php endif;?>
		</div>
	</div>
</li>
