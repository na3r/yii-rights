<?php $this->breadcrumbs = array(
	'Rights'=>array('/rights'),
	Yii::t('RightsModule.tr', 'Create Auth Item'),
); ?>

<div class="authItem">

	<h2><?php echo Yii::t('RightsModule.tr', 'Create Auth Item'); ?></h2>

	<p class="rightsInfo"><?php echo Yii::t('RightsModule.tr', 'Notice: Auth Item type cannot be changed afterwards.'); ?></p>

	<div class="rightsForm form">

		<?php echo $form->render(); ?>

	</div>

</div>