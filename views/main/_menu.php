<div id="rightsMenu">

	<?php
	$this->widget('zii.widgets.CMenu', array(
		'items'=>array(
			array('label'=>Yii::t('rights', 'Permissions'), 'url'=>array('main/permissions')),
			array('label'=>Yii::t('rights', 'Assignments'), 'url'=>array('/rights/assignment')),
			array('label'=>Yii::t('rights', 'Operations'), 'url'=>array('main/operations')),
			array('label'=>Yii::t('rights', 'Tasks'), 'url'=>array('main/tasks')),
			array('label'=>Yii::t('rights', 'Roles'), 'url'=>array('main/roles')),
			array('label'=>Yii::t('rights', 'Create Auth Item'), 'url'=>array('/rights/authItem')),
		),
	));
	?>

</div>