<h3>
	<?php echo __('smallbugs.create_a_new_project');?>
	<span><?php echo __('smallbugs.create_a_new_project_description');?></span>
</h3>

<div class="pad">

	<form method="post" action="" id="submit-project">
		<table class="form" style="width: 80%;">
			<tr>
				<th style="width: 10%;"><?php echo __('smallbugs.name');?></th>
				<td><input type="text" name="name" style="width: 90%;  background-color: #FFF; color: #000; border-width: 2px; border-color: #999;" /></td>
			</tr>
		</table>

		<ul class="assign-users" style="display: none">
			<li class="project-user<?php echo Auth::user()->id; ?>">
				<a href="javascript:void(0);" onclick="$('.project-user<?php echo Auth::user()->id; ?>').remove();" class="delete"><?php echo __('smallbugs.remove');?></a>
				<?php echo Auth::user()->firstname . ' ' . Auth::user()->lastname; ?>
				<input type="hidden" name="user[]" value="<?php echo Auth::user()->id; ?>" />
			</li>
		</ul>
		<input type="hidden" name="default_assignee" value="1" id="default_assignee-id" />
	</form>

	<table class="form" style="width: 80%;">
		<tr>
			<th style="width: 10%;"><?php echo __('smallbugs.assign_users');?></th>
			<td>
				<input type="text" id="add-user-project" style="margin: 0;  background-color: #FFF; color: #000; border-width: 2px; border-color: #999;" placeholder="<?php echo __('smallbugs.assign_users_holder');?>" />

				<ul class="assign-users" style="width: 218px;">
					<li class="project-user<?php echo Auth::user()->id; ?>">
						<a href="javascript:void(0);" onclick="$('.project-user<?php echo Auth::user()->id; ?>').remove();" class="delete">Remove</a>
						<?php echo Auth::user()->firstname . ' ' . Auth::user()->lastname; ?>
						<input type="hidden" name="user[]" value="<?php echo Auth::user()->id; ?>" />
					</li>
				</ul>
			</td>
		</tr>
		<tr>
			<th></th>
			<td><input type="submit" onclick="$('#submit-project').submit();" value="<?php echo __('smallbugs.create_project');?>"  /></td>
		</tr>
	</table>

</div>