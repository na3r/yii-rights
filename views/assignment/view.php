<?php $this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Yii::t('RightsModule.core', 'Assignments'),
); ?>

<div id="rightsAssignments">

	<h2><?php echo Yii::t('RightsModule.core', 'Assignments'); ?></h2>

	<?php if( count($users)>0 ): ?>

		<table class="assignmentsTable" border="0" cellpadding="0" cellspacing="0">

			<thead>

				<tr>

					<th class="usernameColumnHeading"><?php echo Yii::t('RightsModule.core', 'Username'); ?></th>

					<th class="assignmentColumnHeading"><?php echo Yii::t('RightsModule.core', 'Assignments'); ?></th>

				</tr>

			</thead>

			<tbody>

				<?php $i=0; foreach( $users as $i=>$user ): ?>

					<tr class="<?php echo ($i % 2)===0 ? 'odd' : 'even'; ?>">

						<td><?php echo CHtml::link($user->$nameColumn, array('assignment/user', 'id'=>$user->$idColumn)); ?></td>

						<td class="assignmentColumn"><?php echo isset($assignments[ $user->$idColumn ])===true ? implode(', ', $assignments[ $user->$idColumn ]) : ''; ?></td>

					</tr>

				<?php endforeach; ?>

			</tbody>

		</table>

		<?php $this->widget('CLinkPager', array('pages'=>$pages)); ?>

	<?php else: ?>

		<p class="info"><?php echo Yii::t('RightsModule.core', 'No users found.'); ?></p>

	<?php endif; ?>

</div>
