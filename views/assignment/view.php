<?php $this->breadcrumbs = array(
	'Rights'=>array('/rights'),
	Yii::t('RightsModule.tr', 'Assignments'),
); ?>

<div id="rightsAssignments">

	<h2><?php echo Yii::t('RightsModule.tr', 'Assignments'); ?></h2>

	<?php if( count($users)>0 ): ?>

		<table class="rightsTable assignmentsTable" border="0" cellpadding="0" cellspacing="0">

			<thead>

				<tr>

					<th class="usernameColumnHeading"><?php echo Yii::t('RightsModule.tr', 'Username'); ?></th>

					<th class="assignmentColumnHeading"><?php echo Yii::t('RightsModule.tr', 'Assignments'); ?></th>

				</tr>

			</thead>

			<tbody>

				<?php $i=0; foreach( $users as $i=>$user ): ?>

					<tr class="<?php echo ($i % 2)===0 ? 'odd' : 'even'; ?>">

						<td><?php echo CHtml::link($user->$nameColumn, array('assignment/user', 'id'=>$user->id)); ?></td>

						<td class="assignmentColumn"><?php echo isset($assignments[ $user->id ])===true ? implode(', ', $assignments[ $user->id ]) : ''; ?></td>

					</tr>

				<?php endforeach; ?>

			</tbody>

		</table>

		<?php $this->widget('CLinkPager', array('pages'=>$pages)); ?>

	<?php else: ?>

		<p><?php echo Yii::t('RightsModule.tr', 'No users found.'); ?></p>

	<?php endif; ?>

</div>