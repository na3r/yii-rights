<h2><?php echo Yii::t('RightsModule.setup', 'Install Rights'); ?></h2>

<?php if( $isInstalled===true ): ?>

	<p class="rightsInfo">
		<?php echo Yii::t('RightsModule.setup', 'Rights is already properly installed.'); ?><br />
		<?php echo Yii::t('RightsModule.setup', 'You should disable this installer from the module configuration.'); ?>
	</p>

<?php endif; ?>

<p style="color:#ff0000;"><?php echo Yii::t('RightsModule.setup', 'Warning: Choosing "Overwrite" will delete all your previous data.'); ?></p>

<p><?php echo Yii::t('RightsModule.setup', 'Rights require you to select users to promote to super users.'); ?></p>

<div class="rightsForm form">

	<?php echo $form->render(); ?>

</div>