<div id="installer" class="ready">

	<h2><?php echo Yii::t('RightsModule.install', 'Congratulations!'); ?></h2>

	<p class="green-text">
		<?php echo Yii::t('RightsModule.install', 'Rights has been installed succesfully.'); ?>
	</p>

	<p>
		<?php echo Yii::t('RightsModule.install', 'You can start by generating your authorization items') ;?>
		<?php echo CHtml::link(Yii::t('RightsModule.install', 'here'), array('authItem/generate')); ?>.
	</p>

</div>