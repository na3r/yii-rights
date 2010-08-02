<?php $this->widget('zii.widgets.CMenu', array(
	'items'=>array(
		array(
			'label'=>Yii::t('RightsModule.core', 'Permissions'),
			'url'=>array('/rights/default/permissions'),
			'itemOptions'=>array('class'=>'permissions'),
		),
		array(
			'label'=>Yii::t('RightsModule.core', 'Assignments'),
			'url'=>array('/rights/assignment/view'),
			'itemOptions'=>array('class'=>'assignments'),
		),
		array(
			'label'=>Yii::t('RightsModule.core', 'Operations'),
			'url'=>array('/rights/default/operations'),
			'itemOptions'=>array('class'=>'operations'),
		),
		array(
			'label'=>Yii::t('RightsModule.core', 'Tasks'),
			'url'=>array('/rights/default/tasks'),
			'itemOptions'=>array('class'=>'tasks'),
		),
		array(
			'label'=>Yii::t('RightsModule.core', 'Roles'),
			'url'=>array('/rights/default/roles'),
			'itemOptions'=>array('class'=>'roles'),
		),
		array(
			'label'=>Yii::t('RightsModule.core', 'Create Auth Item'),
			'url'=>array('/rights/authItem/create'),
			'itemOptions'=>array('class'=>'authItem'),
		),
	)
));	?>
