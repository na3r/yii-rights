<?php $this->breadcrumbs = array(
	'Rights'=>array('./'),
	Yii::t('RightsModule.core', 'Tasks'),
); ?>

<div id="rightsTasks">

	<h2><?php echo Yii::t('RightsModule.core', 'Tasks'); ?></h2>

	<p><?php echo CHtml::link(Yii::t('RightsModule.core', 'Create a new task'), array('authItem/create', 'type'=>CAuthItem::TYPE_TASK)); ?></p>

	<?php if( count($tasks)>0 ): ?>

		<table class="rightsTable taskTable" border="0" cellpadding="0" cellspacing="0">

			<thead>

				<tr>

					<th class="nameColumnHeading"><?php echo Yii::t('RightsModule.core', 'Name'); ?></th>

					<th class="descriptionColumnHeading"><?php echo Yii::t('RightsModule.core', 'Description'); ?></th>

					<?php if( $isBizRuleEnabled===true ): ?>

						<th class="bizRuleColumnHeading"><?php echo Yii::t('RightsModule.core', 'Business rule'); ?></th>

						<?php if( $isBizRuleDataEnabled===true ): ?>

							<th class="dataColumnHeading"><?php echo Yii::t('RightsModule.core', 'Data'); ?></th>

						<?php endif; ?>

					<?php endif; ?>

					<th class="deleteColumnHeading">&nbsp;</th>

				</tr>

			</thead>

			<tbody>

				<?php $i=0; foreach( $tasks as $name=>$item ): ?>

					<tr id="<?php echo $name; ?>" class="<?php echo ($i++ % 2)===0 ? 'odd' : 'even'; ?>">

						<td>
							<?php echo CHtml::link(Rights::beautifyName($name), array('authItem/update', 'name'=>$name, 'redirect'=>urlencode('default/tasks'))); ?>

							<?php if( $childCounts[ $name ]>0 ): ?>

								<span class="childCount">[ <span class="childCountNumber"><?php echo $childCounts[ $name ]; ?></span> ]</span>

							<?php endif; ?>
						</td>

						<td><?php echo CHtml::encode($item->description); ?></td>

						<?php if( $isBizRuleEnabled===true ): ?>

							<td class="bizRuleColumn"><?php echo CHtml::encode($item->bizRule); ?></td>

							<?php if( $isBizRuleDataEnabled===true ): ?>

								<td class="bizRuleDataColumn"><?php echo $item->data!==null ? CHtml::encode( @serialize($item->data) ) : ''; ?></td>

							<?php endif; ?>

						<?php endif; ?>

						<td class="deleteColumn">

							<?php echo CHtml::linkButton(Yii::t('RightsModule.core', 'Delete'), array(
								'submit'=>array('authItem/delete', 'name'=>$name, 'redirect'=>urlencode('default/tasks')),
								'confirm'=>Yii::t('RightsModule.core', 'Are you sure you want to delete this task?'),
								'class'=>'deleteLink',
							)); ?>

						</td>

					</tr>

				<?php endforeach; ?>

			</tbody>

		</table>

		<p class="rightsInfo"><?php echo Yii::t('RightsModule.core', 'Values within square brackets tell how many children each item has.'); ?></p>

	<?php else: ?>

		<p class="rightsInfo"><?php echo Yii::t('RightsModule.core', 'No tasks found.'); ?></p>

	<?php endif; ?>

</div>