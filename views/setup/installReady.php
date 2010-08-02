<h2><?php echo Yii::t('RightsModule.setup', 'Congratulations!'); ?></h2>

<p><?php echo Yii::t('RightsModule.setup', ' Rights has been installed succesfully.'); ?></p>

<p class="rightsInfo">
	<?php echo Yii::t('RightsModule.setup', 'Notice: You should now disable the installer from the module configuration.'); ?>
</p>

<p>
	<?php echo Yii::t('RightsModule.setup', 'You can start by generating some authorization items') ;?>
	<?php echo CHtml::link(Yii::t('RightsModule.setup', 'here'), array('/rights/setup/generate')); ?>.
</p>