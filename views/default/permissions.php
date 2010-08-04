<?php $this->breadcrumbs=array(
	'Rights'=>array('./'),
	Yii::t('RightsModule.core', 'Permissions'),
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