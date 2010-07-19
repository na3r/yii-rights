<?php
$this->breadcrumbs = array(
	Yii::t('rights', 'Rights')=>array('/rights/main'),
	Yii::t('rights', 'Auth Item'),
	$model->name,
);
?>

<div class="rights">

	<?php $this->renderPartial('/main/_menu'); ?>

	<div class="authItem">

		<div class="rightsForm form span-12 first">

			<h2><?php echo Yii::t('rights', 'Update :name', array(':name'=>$model->name)); ?></h2>

			<p class="rightsInfo"><?php echo ucfirst(Rights::getAuthItemTypeString($model->type)); ?></p>

			<?php echo $form->render(); ?>

		</div>

		<div id="authItemRelations" class="span-11 last">

			<div id="authItemParents">

				<h2><?php echo Yii::t('rights', 'Parents'); ?></h2>

				<?php if( count($parents)>0 ): ?>

					<table class="rightsMiniTable parentTable" border="0" cellpadding="0" cellspacing="0">

						<?php $i=0; ?>

						<?php foreach( $parents as $parentName ): ?>

							<tr class="<?php echo ($i++ % 2)===0 ? 'odd' : 'even'; ?>">

								<td><?php echo CHtml::link($parentName, array('authItem/update', 'name'=>$parentName)); ?></td>
								<td>&nbsp;</td>

							</tr>

						<?php endforeach; ?>

			   		</table>

				<?php else: ?>

					<p class="rightsInfo"><?php echo Yii::t('rights', 'This item has no parents.'); ?></p>

				<?php endif;?>

			</div>

			<div id="authItemChildren">

				<h2><?php echo Yii::t('rights', 'Children'); ?></h2>

				<?php if( count($children)>0 ): ?>

					<table class="rightsMiniTable childTable" border="0" cellpadding="0" cellspacing="0">

						<?php $i=0; ?>

						<?php foreach( $children as $childName ): ?>

							<tr class="<?php echo ($i++ % 2)===0 ? 'odd' : 'even'; ?>">

								<td><?php echo CHtml::link($childName, array('authItem/update', 'name'=>$childName)); ?></td>

								<td class="removeColumn">
									<?php
									echo CHtml::linkButton(Yii::t('rights', 'Remove'), array(
										'submit'=>array('authItem/removeChild', 'name'=>$model->name, 'child'=>$childName),
										'confirm'=>Yii::t('rights', 'Are you sure you want to remove this child?')
									));
									?>
								</td>

							</tr>

						<?php endforeach; ?>

					</table>

				<?php else: ?>

					<p class="rightsInfo"><?php echo Yii::t('rights', 'This item has no children.'); ?></p>

				<?php endif; ?>

			</div>

			<div id="authItemAddChild">

				<h3><?php echo Yii::t('rights', 'Add Child'); ?></h3>

				<div class="rightsForm form">

					<?php echo $childForm->render(); ?>

				</div>

			</div>

		</div>

	</div>

</div>