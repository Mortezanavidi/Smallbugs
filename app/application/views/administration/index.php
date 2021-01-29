<h3>
	<?php echo __('smallbugs.administration'); ?>
	<span><?php echo __('smallbugs.administration_description'); ?></span>
</h3>

<div class="pad">
	<div class="pad2">
		<table class="table">
			<tr>
				<th style="border-top: 1px solid #ddd;"><a href="administration/users"><?php echo __('smallbugs.total_users'); ?></a></th>
				<td style="border-top: 1px solid #ddd;"><b><?php echo $users; ?></b></td>
			</tr>
			<tr>
				<th><a href="<?php echo URL::to('roles'); ?>"><?php echo __('smallbugs.role'); ?>s</a></th>
				<td><b><?php echo @$roles; ?></b></td>
			</tr>
			<tr>
				<th><a href="projects"><?php echo __('smallbugs.projects'); ?></a>
				<div class="adminListe">
					<?php echo ($active_projects < 2) ? __('smallbugs.active_project') : __('smallbugs.active_projects'); ?><br />
					<?php echo ($archived_projects < 2) ? __('smallbugs.archived_project') : __('smallbugs.archived_projects'); ?><br />
				</div>			
				</th>
				<td>
					<b><?php echo ($active_projects + $archived_projects); ?></b><br />
					<?php echo ($active_projects == 0) ? __('smallbugs.no_one') : $active_projects; ?><br />
					<?php echo ($archived_projects == 0) ? __('smallbugs.no_one') : $archived_projects; ?><br />
				</td>
			</tr>
			<tr>
			</tr>
			
			<tr>
				<th><a href="<?php echo URL::to('tags'); ?>"><?php echo __('smallbugs.tags'); ?></a></th>
				<td><b><?php echo $tags; ?></b></td>
			</tr>
			<tr>
				<th><a href="user/issues"><?php echo __('smallbugs.issues'); ?></a>
					<div class="adminListe">
						<?php echo __('smallbugs.open_issues'); ?><br />
						<?php echo __('smallbugs.closed_issues'); ?><br />
					</div>
				</th>
				<td><b><?php echo ($issues['open']+$issues['closed']); ?></b><br />
				<?php echo $issues['open']; ?><br />
				<?php echo $issues['closed']; ?><br />
				</td>
			</tr>
			<tr>
				<th><a href="https://github.com/mortezanavidi/smallbugs" target="_blank"><?php echo __('smallbugs.version'); ?></a>
					<div class="adminListe">
					<?php echo __('smallbugs.version'); ?><br />
					<?php echo __('smallbugs.version_release_numb'); ?><br />
					<?php echo __('smallbugs.version_release_date'); ?><br />
					</div>
				</th>
				<td>
					<b><?php echo Config::get('smallbugs.version').Config::get('smallbugs.release'); ?></b><br />
					<?php echo Config::get('smallbugs.version'); ?><br />
					<?php echo Config::get('smallbugs.release'); ?><br />
					<?php echo $release_date = Config::get('smallbugs.release_date'); ?><br />
				</td>
			</tr>
		</table>
	
	</div>
	<div class="pad2">
		<br />
		<?php
			include "../app/application/libraries/checkVersion.php";
			echo '<h4><b>'.__('smallbugs.version_check').'</b> : Active - Stable';
			echo '<br /><br />';
			echo __('smallbugs.version_actuelle');
			echo ' : 1.00';
			echo '<br />'.__('smallbugs.version_release_numb').' : 1';
			echo '<br /><br />';
			if ($verActu == $verNum) {
				echo '<a name="Apprécions">'.__('smallbugs.version_good').'!</a>';
				echo '<br /></h4>';
			} else if ($verNum == 0) {
				echo __('smallbugs.version_offline');
				echo '<br /></h4>';
				echo '<a href="https://github.com/mortezanavidi/smallbugs" target="_blank">https://github.com/mortezanavidi/smallbugs</a>';
			} else if ($verNum < $verActu) {
				echo '<h4><b>'.__('smallbugs.version_ahead').'</b></h4>';
				echo __('smallbugs.version_disp').' : '.$verNum.'<br />';
				echo __('smallbugs.version_commit').' : '.$verCommit.'<br />';
				echo '<br />';
				echo '<a href="https://github.com/mortezanavidi/smallbugsreleases" target="_blank">'.__('smallbugs.version_details').'</a> <br />';
			} else {
				echo '<h4><a href="javascript: agissons.submit();">'.__('smallbugs.version_need').'.</a></h4>';
				echo __('smallbugs.version_disp').' : '.$verNum.'<br />';
				echo __('smallbugs.version_commit').' : '.$verCommit.'<br />';
				echo '<a href="https://github.com/mortezanavidi/smallbugsreleases" target="_blank">'.__('smallbugs.version_details').'</a> <br />';
				echo '<form action="'.URL::to('administration/update').'" method="post" id="agissons">';
				echo '<input type="hidden" name="Etape" value="1" />';
				echo '<input type="hidden" name="versionYour" value="'.$verActu.'" />';
				echo '<input type="hidden" name="versionDisp" value="'.$verNum.'" />';
				echo '<input type="hidden" name="versionComm" value="'.$verCommit.'" />';
				echo '<br /><br />';
				echo '<input type="submit" value="'.__('smallbugs.update').'" class="button	primary"/>';
				echo Form::token();
				echo '</form>';
			}
			echo '<br /><br />';
		?>
	</div>
</div>
