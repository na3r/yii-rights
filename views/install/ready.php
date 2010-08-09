<div id="installReady">

	<h2><?php echo Yii::t('RightsModule.install', 'Congratulations!'); ?></h2>

	<p style="color:#00aa00;">
		<?php echo Yii::t('RightsModule.install', ' Rights has been installed succesfully.'); ?>
	</p>

	<p>
		<?php echo Yii::t('RightsModule.install', 'You can start by generating your authorization items') ;?>
		<?php echo CHtml::link(Yii::t('RightsModule.install', 'here'), array('authItem/generate')); ?>.
	</p>

</div>