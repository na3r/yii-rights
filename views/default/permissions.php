<?php $this->breadcrumbs=array(
	'Rights'=>array('/rights'),
	Yii::t('RightsModule.tr', 'Permissions'),
); ?>

<div id="rightsPermissions">

	<?php $this->renderPartial('_permissions', array(
		'roles'=>$roles,
		'roleColumnWidth'=>$roleColumnWidth,
		'items'=>$items,
		'rights'=>$rights,
		'parents'=>$parents,
	)); ?>

</div>