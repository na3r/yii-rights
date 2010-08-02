<h2><?php echo Yii::t('RightsModule.setup', 'Congratulations!'); ?></h2>

<p><?php echo Yii::t('RightsModule.setup', ' Rights has been installed succesfully.'); ?></p>

<p>
	<?php echo Yii::t('RightsModule.setup', 'You can start by creating some authorization items') ;?>
	<?php echo CHtml::link(Yii::t('RightsModule.setup', 'here'), array('/rights/authItem')); ?>.
</p>