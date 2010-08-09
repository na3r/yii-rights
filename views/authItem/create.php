<?php $this->breadcrumbs = array(
	'Rights'=>array('./'),
	Yii::t('RightsModule.core', 'Create :type', array(':type'=>Rights::getAuthItemTypeString($_GET['type']))),
); ?>

<div class="authItem">

	<h2><?php echo Yii::t('RightsModule.core', 'Create :type', array(':type'=>Rights::getAuthItemTypeString($_GET['type']))); ?></h2>

	<div class="rightsForm form">

		<?php echo $form->render(); ?>

	</div>

</div>