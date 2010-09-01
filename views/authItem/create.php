<?php $this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Yii::t('RightsModule.core', 'Create :type', array(':type'=>Rights::getAuthItemTypeName($_GET['type']))),
); ?>

<div class="createAuthItem">

	<h2><?php echo Yii::t('RightsModule.core', 'Create :type', array(':type'=>Rights::getAuthItemTypeName($_GET['type']))); ?></h2>

	<div class="form">

		<?php echo $form->render(); ?>

	</div>

</div>