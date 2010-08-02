<h2><?php echo Yii::t('RightsModule.setup', 'Install Rights'); ?></h2>

<?php if( $isInstalled===false ): ?>

	<p><?php echo Yii::t('RightsModule.setup', 'Please press "Install" to install the Rights module.'); ?></p>

<?php else: ?>

	<p><?php echo Yii::t('RightsModule.setup', 'Rights is already installed!'); ?></p>

	<p class="rightsInfo"><?php echo Yii::t('RightsModule.setup', 'Notice: You should disable the installer from the module configuration unless you wish to reinstall.'); ?></p>

<?php endif; ?>

<div class="rightsForm form">

	<?php echo $form->render(); ?>

</div>