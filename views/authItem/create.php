<?php $this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Yii::t('RightsModule.core', 'Create :type', array(':type'=>Rights::getAuthItemTypeString($_GET['type']))),
); ?>

<div class="authItem">

	<h2><?php echo Yii::t('RightsModule.core', 'Create :type', array(':type'=>Rights::getAuthItemTypeString($_GET['type']))); ?></h2>

	<div class="form">

		<?php echo $form->render(); ?>

	</div>

</div>