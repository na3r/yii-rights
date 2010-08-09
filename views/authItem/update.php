<?php $this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Rights::getAuthItemTypeString($model->type),
	Rights::beautifyName($model->name),
); ?>

<div class="authItem">

	<div class="form span-12 first">

		<h2><?php echo Yii::t('RightsModule.core', 'Update :name', array(':name'=>Rights::beautifyName($model->name))); ?></h2>

		<p class="info"><?php echo Rights::getAuthItemTypeString($model->type); ?></p>

		<?php echo $form->render(); ?>

	</div>

	<div id="authItemRelations" class="span-11 last">

		<h2><?php echo Yii::t('RightsModule.core', 'Relations'); ?></h2>

		<?php if( $model->name!==Rights::getConfig('superuserRole') ): ?>

			<div id="authItemParents">

				<h3><?php echo Yii::t('RightsModule.core', 'Parents'); ?></h3>

				<?php if( count($parents)>0 ): ?>

					<table class="miniTable parentTable" border="0" cellpadding="0" cellspacing="0">

						<tbody>

							<?php $i=0; foreach( $parents as $parentName ): ?>

								<tr class="<?php echo ($i++ % 2)===0 ? 'odd' : 'even'; ?>">

									<td><?php echo CHtml::link(Rights::beautifyName($parentName), array('authItem/update', 'name'=>$parentName)); ?></td>

									<td>&nbsp;</td>

								</tr>

							<?php endforeach; ?>

						</tbody>

			   		</table>

				<?php else: ?>

					<p class="info"><?php echo Yii::t('RightsModule.core', 'This item has no parents.'); ?></p>

				<?php endif;?>

			</div>

			<div id="authItemChildren">

				<h3><?php echo Yii::t('RightsModule.core', 'Children'); ?></h3>

				<?php if( count($children)>0 ): ?>

					<table class="miniTable childTable" border="0" cellpadding="0" cellspacing="0">

						<tbody>

							<?php $i=0; foreach( $children as $childName ): ?>

								<tr class="<?php echo ($i++ % 2)===0 ? 'odd' : 'even'; ?>">

									<td><?php echo CHtml::link(Rights::beautifyName($childName), array('authItem/update', 'name'=>$childName)); ?></td>

									<td class="removeColumn">

										<?php echo CHtml::linkButton(Yii::t('RightsModule.core', 'Remove'), array(
											'submit'=>array('authItem/removeChild', 'name'=>$model->name, 'child'=>$childName),
											'class'=>'removeLink',
										)); ?>

									</td>

								</tr>

							<?php endforeach; ?>

						</tbody>

					</table>

				<?php else: ?>

					<p class="info"><?php echo Yii::t('RightsModule.core', 'This item has no children.'); ?></p>

				<?php endif; ?>

			</div>

			<?php if( $childForm!==null ): ?>

				<div id="authItemAddChild">

					<h4><?php echo Yii::t('RightsModule.core', 'Add Child'); ?></h4>

					<div class="form">

						<?php echo $childForm->render(); ?>

					</div>

				</div>

			<?php endif; ?>

		<?php else: ?>

			<p class="info">

				<?php echo Yii::t('RightsModule.core', 'No relations need to be set for the superuser role.'); ?><br />
				<?php echo Yii::t('RightsModule.core', 'Super users are always granted access implicitly.'); ?>

			</p>

		<?php endif; ?>

	</div>

</div>