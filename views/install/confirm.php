<div id="installConfirm">

	<h2><?php echo Yii::t('RightsModule.install', 'Install Rights'); ?></h2>

	<p class="redText">
		<?php echo Yii::t('RightsModule.install', 'Rights is already installed!'); ?>
	</p>

	<p><?php echo Yii::t('RightsModule.install', 'Please confirm if you wish to reinstall.'); ?></p>

	<p>
		<?php echo CHtml::link(Yii::t('RightsModule.install', 'Yes'), array('install/run', 'confirm'=>1)); ?> /
		<?php echo CHtml::link(Yii::t('RightsModule.install', 'No'), Yii::app()->homeUrl); ?>
	</p>

	<p class="info"><?php echo Yii::t('RightsModule.install', 'Notice: All your existing data will be lost.'); ?></p>

</div>