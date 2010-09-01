<?php $this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Yii::t('RightsModule.core', 'Assignments')=>array('assignment/view'),
	$model->getName(),
); ?>

<div id="userAssignments">

	<div class="assignments span-12 first">

		<h2><?php echo Yii::t('RightsModule.core', 'Assignments for :username', array(':username'=>$model->getName())); ?></h2>

		<?php $this->widget('zii.widgets.grid.CGridView', array(
			'dataProvider'=>$dataProvider,
			'template'=>'{items}',
			'hideHeader'=>true,
			'emptyText'=>Yii::t('RightsModule.core', 'This user has not been assigned any authorization items.'),
			'htmlOptions'=>array('class'=>'grid-view user-assignment-table mini'),
			'columns'=>array(
    			array(
    				'name'=>'name',
    				'header'=>Yii::t('RightsModule.core', 'Name'),
    				'type'=>'raw',
    				'htmlOptions'=>array('class'=>'name-column'),
    				'value'=>'$data->nameColumn()',
    			),
    			array(
    				'name'=>'type',
    				'header'=>Yii::t('RightsModule.core', 'Type'),
    				'type'=>'raw',
    				'htmlOptions'=>array('class'=>'type-column'),
    				'value'=>'$data->typeColumn()',
    			),
    			array(
    				'name'=>'revoke',
    				'header'=>'&nbsp;',
    				'type'=>'raw',
    				'htmlOptions'=>array('class'=>'revoke-column'),
    				'value'=>'$data->revokeAssignmentColumn()',
    			),
			)
		)); ?>

	</div>

	<div class="add-user-assignment span-11 last">

		<h3><?php echo Yii::t('RightsModule.core', 'Add Assignment'); ?></h3>

		<?php if( $form!==null ): ?>

			<div class="form">

				<?php echo $form->render(); ?>

			</div>

		<?php else: ?>

			<p class="info"><?php echo Yii::t('RightsModule.core', 'No assignments available to be assigned to this user.'); ?>

		<?php endif; ?>

	</div>

</div>
