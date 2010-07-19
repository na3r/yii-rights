<?php
$this->breadcrumbs = array(
	Yii::t('rights', 'Rights')=>array('/rights/main'),
	Yii::t('rights', 'Assignments')=>array('main/assignments'),
	$model->$username,
);
?>

<div class="rights">

	<?php $this->renderPartial('/main/_menu'); ?>

	<div id="userAssignments" class="span-12 first">

		<h2><?php echo Yii::t('rights', 'Assignments for :username', array(':username'=>$model->$username)); ?></h2>

		<?php if( count($assignedItems)>0 ): ?>

			<table class="rightsMiniTable userAssignmentTable" border="0" cellpadding="0" cellspacing="0">

				<?php foreach( $assignedItems as $itemName ): ?>

					<tr class="<?php echo ($i++ % 2)===0 ? 'odd' : 'even'; ?>">

						<td><?php echo CHtml::link($itemName, array('authItem/update', 'name'=>$itemName)); ?></td>

						<td class="revokeColumn">
							<?php
							echo CHtml::linkButton(Yii::t('rights', 'Revoke'), array(
								'submit'=>array('assignment/revoke', 'id'=>$model->id, 'name'=>$itemName),
								'confirm'=>Yii::t('rights', 'Are you sure to revoke this assignment?')
							));
							?>
						</td>

					</tr>

				<?php endforeach; ?>

			</table>

		<?php else: ?>

			<p class="rightsInfo"><?php echo Yii::t('rights', 'This user has not been assigned any auth items.'); ?></p>

		<?php endif; ?>

	</div>

	<div id="addUserAssignment" class="span-11 last">

		<h3><?php echo Yii::t('rights', 'Add Assignment'); ?></h3>

		<div class="rightsForm form">

			<?php echo $form->render(); ?>

		</div>

	</div>

</div>