<?php
$this->breadcrumbs = array(
	Yii::t('breadcrumb', 'Rights')=>array('/rights/main'),
	Yii::t('breadcrumb', 'Create Auth Item'),
);
?>

<div class="rights">

	<?php $this->renderPartial('/main/_menu'); ?>

	<div class="authItem">

		<h2><?php echo Yii::t('rights', 'Create Auth Item'); ?></h2>

		<p class="rightsInfo"><?php echo Yii::t('rights', 'Notice: Auth Item type cannot be changed afterwards.'); ?></p>

		<div class="rightsForm form">

			<?php echo $form->render(); ?>

		</div>

	</div>

</div>