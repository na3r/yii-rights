<?php $this->widget('zii.widgets.CMenu', array(
	'htmlOptions'=>array('class'=>'rightsMenu'),
	'items'=>array(
		array(
			'label'=>Yii::t('RightsModule.tr', 'Permissions'),
			'url'=>array('/rights/main/permissions'),
			'itemOptions'=>array('class'=>'permissions')
		),
		array(
			'label'=>Yii::t('RightsModule.tr', 'Assignments'),
			'url'=>array('/rights/assignment/view'),
			'itemOptions'=>array('class'=>'assignments')
		),
		array(
			'label'=>Yii::t('RightsModule.tr', 'Operations'),
			'url'=>array('/rights/main/operations'),
			'itemOptions'=>array('class'=>'operations')
		),
		array(
			'label'=>Yii::t('RightsModule.tr', 'Tasks'),
			'url'=>array('/rights/main/tasks'),
			'itemOptions'=>array('class'=>'tasks')
		),
		array(
			'label'=>Yii::t('RightsModule.tr', 'Roles'),
			'url'=>array('/rights/main/roles'),
			'itemOptions'=>array('class'=>'roles')
		),
		array(
			'label'=>Yii::t('RightsModule.tr', 'Create Auth Item'),
			'url'=>array('/rights/authItem/create'),
			'itemOptions'=>array('class'=>'authItem')
		),
	)
));	?>