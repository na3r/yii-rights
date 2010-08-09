<div id="installConfirm">

	<h2><?php echo Yii::t('RightsModule.install', 'Install Rights'); ?></h2>

	<p style="color:#ff0000;">Rights is already installed!</p>

	<p>Please confirm if you wish to reinstall.</p>

	<p>
		<?php echo CHtml::link(Yii::t('RightsModule.install', 'Yes'), array('install/run')); ?> /
		<?php echo CHtml::link(Yii::t('RightsModule.install', 'No'), Yii::app()->homeUrl); ?>
	</p>

	<p class="rightsInfo">Notice: All your existing data will be lost.</p>

</div>