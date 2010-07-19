<h2><?php echo Yii::t('rights', 'Permissions'); ?></h2>

<?php if( count($authItems)>0 ): ?>

	<table class="rightsTable permissionTable" border="0" cellpadding="0" cellspacing="0">

		<tr>

			<th class="descriptionColumnHeading" style="width:25%;"><?php echo Yii::t('rights', 'Description'); ?></th>

			<?php foreach( $roles as $roleName=>$role ): ?>

				<th class="roleColumnHeading" style="width:<?php echo $roleColumnWidth; ?>%"><?php echo CHtml::encode($roleName); ?></th>

			<?php endforeach; ?>

		</tr>

		<?php foreach( $authItems as $name => $item ): ?>

			<tr class="<?php echo ($i++ % 2)===0 ? 'odd' : 'even'; ?>">

				<td><?php echo CHtml::encode($item->description); ?></td>

				<?php foreach( $roles as $roleName=>$role ): ?>

					<td>
						<?php if( $rights[ $roleName ][ $name ]===Rights::PERM_DIRECT ): ?>

							<?php
							// "Minor" hack. Couldn't think of any other way to do this.
							echo CHtml::link(Yii::t('rights', 'Revoke'), '#', array(
								'onclick'=>'jQuery.ajax({ type:"POST", url:"'.$this->createUrl('authItem/revoke', array('name'=>$role->name, 'child'=>$name)).'", data:{ ajax:true }, success:function() { $("#rightsPermissions").load("'.$this->createUrl('main/permissions').'", { ajax:true }); } }); return false;'
							));
							/*
							echo CHtml::linkButton(Yii::t('rights', 'Revoke'), array(
								'submit'=>array('authItem/revoke', 'name'=>$role->name, 'child'=>$name),
							));
							*/
							?>

						<?php elseif( $rights[ $roleName ][ $name ]===Rights::PERM_INHERIT ): ?>

							<span class="inheritedItem" title="<?php echo isset($parents[ $roleName ][ $name ])===true ? $parents[ $roleName ][ $name ] : ''; ?>">
								<?php echo Yii::t('rights', 'Inherited'); ?> *
							</span>

						<?php else: ?>

							<?php
							// "Minor" hack. Couldn't think of any other way to do this.
							echo CHtml::link(Yii::t('rights', 'Assign'), '#', array(
								'onclick'=>'jQuery.ajax({ type:"POST", url:"'.$this->createUrl('authItem/assign', array('name'=>$role->name, 'child'=>$name)).'", data:{ ajax:true }, success:function() { $("#rightsPermissions").load("'.$this->createUrl('main/permissions').'", { ajax:true }); } }); return false;'
							));
							/*
							echo CHtml::linkButton(Yii::t('rights', 'Assign'), array(
								'submit'=>array('authItem/assign', 'name'=>$role->name, 'child'=>$name),
							));
							*/
							?>

						<?php endif; ?>
					</td>

				<?php endforeach; ?>

			</tr>

		<?php endforeach; ?>

	</table>

	<p class="rightsInfo">* <?php echo Yii::t('rights', 'Hover to see from where the permission is inherited.'); ?></p>

	<script type="text/javascript">

		jQuery('.inheritedItem').rightsTooltip({
			title:'<?php echo Yii::t('rights', 'Parents: '); ?>'}
		);

	</script>

<?php else: ?>

	<p><?php echo Yii::t('rights', 'No auth items found.'); ?></p>

<?php endif; ?>