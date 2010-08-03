<h2><?php echo Yii::t('RightsModule.setup', 'Generate Auth Items'); ?></h2>

<div class="rightsForm form">

	<?php $form=$this->beginWidget('CActiveForm'); ?>

		<div class="row">
			<p>
				<?php echo Yii::t('RightsModule.setup', 'Rights can generate your authorization items for you.'); ?><br />
				<?php echo Yii::t('RightsModule.setup', 'Please select which items you wish to generate.'); ?>
			</p>
			<table class="rightsTable generateItemTable" border="0" cellpadding="0" cellspacing="0">
				<tbody>

					<tr><th colspan="3"><?php echo Yii::t('RightsModule.setup', 'Application'); ?></th></tr>

					<?php $this->renderPartial('_items', array(
						'model'=>$model,
						'form'=>$form,
						'items'=>$items,
						'existingItems'=>$existingItems,
						'basePathLength'=>strlen(Yii::app()->basePath),
					)); ?>

				</tbody>
			</table>
		</div>

   		<div class="row">
			<?php echo CHtml::submitButton(Yii::t('RightsModule.setup', 'Generate')); ?>
		</div>

	<?php $this->endWidget(); ?>

</div>