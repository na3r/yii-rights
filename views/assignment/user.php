<?php $this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Yii::t('RightsModule.core', 'Assignments')=>array('assignment/view'),
	$model->$nameColumn,
); ?>

<div id="userAssignments" class="span-12 first">

	<h2><?php echo Yii::t('RightsModule.core', 'Assignments for :username', array(':username'=>$model->$nameColumn)); ?></h2>

	<?php if( count($assignedItems)>0 ): ?>

		<table class="miniTable userAssignmentTable" border="0" cellpadding="0" cellspacing="0">

			<tbody>

				<?php $i=0; foreach( $assignedItems as $itemName ): ?>

					<tr class="<?php echo ($i++ % 2)===0 ? 'odd' : 'even'; ?>">

						<td><?php echo CHtml::link(Rights::beautifyName($itemName), array('authItem/update', 'name'=>$itemName)); ?></td>

						<td class="revokeColumn">
							<?php echo CHtml::linkButton(Yii::t('RightsModule.core', 'Revoke'), array(
								'submit'=>array('assignment/revoke', 'id'=>$model->$idColumn, 'name'=>$itemName),
								'class'=>'revokeLink',
							)); ?>
						</td>

					</tr>

				<?php endforeach; ?>

			</tbody>

		</table>

	<?php else: ?>

		<p class="info"><?php echo Yii::t('RightsModule.core', 'This user has not been assigned any authorization items.'); ?></p>

	<?php endif; ?>

</div>

<div id="addUserAssignment" class="span-11 last">

	<h3><?php echo Yii::t('RightsModule.core', 'Add Assignment'); ?></h3>

	<div class="form">

		<?php echo $form->render(); ?>

	</div>

</div>
