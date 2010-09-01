<?php $this->breadcrumbs=array(
	'Rights'=>Rights::getBaseUrl(),
	Yii::t('RightsModule.core', 'Permissions'),
); ?>

<div id="permissions">

	<h2><?php echo Yii::t('RightsModule.core', 'Permissions'); ?></h2>

	<?php if( $items!==array() ): ?>

		<?php $this->renderPartial('_permissions', array(
			'roles'=>$roles,
			'roleColumnWidth'=>$roleColumnWidth,
			'items'=>$items,
		)); ?>

	<?php else: ?>

		<p><?php echo Yii::t('RightsModule.core', 'No authorization items found.'); ?></p>

	<?php endif; ?>

</div>