<table class="permissionTable" border="0" cellpadding="0" cellspacing="0">

	<thead>

		<tr>

			<th class="descriptionColumnHeading" style="width:25%;"><?php echo Yii::t('RightsModule.core', 'Permission'); ?></th>

			<?php foreach( $roles as $roleName=>$role ): ?>

				<th class="roleColumnHeading" style="width:<?php echo $roleColumnWidth; ?>%"><?php echo CHtml::encode($roleName); ?></th>

			<?php endforeach; ?>

		</tr>

	</thead>

	<tbody>

		<?php $i=0; foreach( $items as $name => $item ): ?>

			<tr class="<?php echo ($i++ % 2)===0 ? 'odd' : 'even'; ?>">

				<td><?php echo $item->description!='' ? CHtml::encode($item->description) : CHtml::encode($name); ?></td>

				<?php foreach( $roles as $roleName=>$role ): ?>

					<td><?php echo $item->permissionColumn($role); ?></td>

				<?php endforeach; ?>

			</tr>

		<?php endforeach; ?>

	</tbody>

</table>

<p class="info">*) <?php echo Yii::t('RightsModule.core', 'Hover to see from where the permission is inherited.'); ?></p>

<script type="text/javascript">

	jQuery('.inheritedItem').rightsTooltip({
		title:'<?php echo Yii::t('RightsModule.core', 'Parents'); ?>: '
	});

</script>