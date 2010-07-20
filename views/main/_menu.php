<div id="rightsMenu">

	<?php
	$this->widget('zii.widgets.CMenu', array(
		'items'=>array(
			array('label'=>Yii::t('RightsModule.tr', 'Permissions'), 'url'=>array('main/permissions')),
			array('label'=>Yii::t('RightsModule.tr', 'Assignments'), 'url'=>array('/rights/assignment')),
			array('label'=>Yii::t('RightsModule.tr', 'Operations'), 'url'=>array('main/operations')),
			array('label'=>Yii::t('RightsModule.tr', 'Tasks'), 'url'=>array('main/tasks')),
			array('label'=>Yii::t('RightsModule.tr', 'Roles'), 'url'=>array('main/roles')),
			array('label'=>Yii::t('RightsModule.tr', 'Create Auth Item'), 'url'=>array('/rights/authItem')),
		)
	));
	?>

</div>