<?php $this->breadcrumbs=array(
	'Rights'=>array('/rights/main'),
	Yii::t('RightsModule.tr', 'Permissions'),
); ?>

<div class="rights">

	<?php $this->renderPartial('/_menu'); ?>

	<?php $this->renderPartial('/_flash'); ?>

	<div id="rightsPermissions">

		<?php $this->renderPartial('_permissions', array(
			'roles'=>$roles,
			'roleColumnWidth'=>$roleColumnWidth,
			'items'=>$items,
			'rights'=>$rights,
			'parents'=>$parents,
		)); ?>

	</div>

</div>
