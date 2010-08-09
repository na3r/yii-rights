<h2><?php echo Yii::t('RightsModule.core', 'Auth Item Generator'); ?></h2>

<div class="rightsForm form">

	<?php $form=$this->beginWidget('CActiveForm'); ?>

		<div class="row">

			<p><?php echo Yii::t('RightsModule.core', 'Please select which authorization items you wish to generate.'); ?></p>

			<table class="rightsTable generateItemTable" border="0" cellpadding="0" cellspacing="0">

				<tbody>

					<tr class="applicationRow">
						<th colspan="3"><?php echo Yii::t('RightsModule.core', 'Application'); ?></th>
					</tr>

					<?php $this->renderPartial('_generateItems', array(
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

   			<?php echo CHtml::link(Yii::t('RightsModule.core', 'Select all'), '#', array(
   				'onclick'=>"jQuery('.generateItemTable').find(':checkbox').attr('checked', 'checked'); return false;",
   				'class'=>'selectAllLink')); ?>
   			/
			<?php echo CHtml::link(Yii::t('RightsModule.core', 'Select none'), '#', array(
				'onclick'=>"jQuery('.generateItemTable').find(':checkbox').removeAttr('checked'); return false;",
				'class'=>'selectNoneLink')); ?>

		</div>

   		<div class="row">

			<?php echo CHtml::submitButton(Yii::t('RightsModule.core', 'Generate')); ?>

		</div>

	<?php $this->endWidget(); ?>

</div>