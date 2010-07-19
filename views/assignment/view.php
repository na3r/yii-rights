<?php
$this->breadcrumbs=array(
	Yii::t('rights', 'Rights')=>array('/rights/main'),
	Yii::t('rights', 'Assignments'),
);
?>

<div class="rights">

	<?php $this->renderPartial('/main/_menu'); ?>

	<div id="rightsAssignments">

		<h2><?php echo Yii::t('rights', 'Assignments'); ?></h2>

		<?php if( count($users)>0 ): ?>

			<table class="rightsTable assignmentsTable" border="0" cellpadding="0" cellspacing="0">

				<tr>

					<th class="usernameColumnHeading"><?php echo Yii::t('rights', 'Username'); ?></th>
					<th class="assignmentColumnHeading"><?php echo Yii::t('rights', 'Assignments'); ?></th>

				</tr>

				<?php foreach( $users as $id=>$user ): ?>

					<tr class="<?php echo ($i++ % 2)===0 ? 'odd' : 'even'; ?>">

						<td><?php echo CHtml::link($user->$username, array('assignment/user', 'id'=>$id)); ?></td>
						<td class="assignmentColumn"><?php echo implode(', ', array_keys($authAssignments[ $id ])); ?></td>

					</tr>

				<?php endforeach; ?>

			</table>

		<?php else: ?>

			<p><?php echo Yii::t('rights', 'No users found.'); ?></p>

		<?php endif; ?>

	</div>

</div>