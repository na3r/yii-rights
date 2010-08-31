<?php $this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Yii::t('RightsModule.core', 'Assignments')=>array('assignment/view'),
	$model->getName(),
); ?>

<div id="userAssignments" class="span-12 first">

	<h2><?php echo Yii::t('RightsModule.core', 'Assignments for :username', array(':username'=>$model->getName())); ?></h2>

	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$dataProvider,
		'template'=>'{items}',
		'hideHeader'=>true,
		'emptyText'=>Yii::t('RightsModule.core', 'This user has not been assigned any authorization items.'),
		'htmlOptions'=>array('class'=>'miniTable userAssignmentTable'),
		'columns'=>array(
    		array(
    			'name'=>'name',
    			'header'=>Yii::t('RightsModule.core', 'Name'),
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'nameColumn'),
    			'value'=>'$data->nameColumn()',
    		),
    		array(
    			'name'=>'type',
    			'header'=>Yii::t('RightsModule.core', 'Type'),
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'typeColumn'),
    			'value'=>'$data->typeColumn()',
    		),
    		array(
    			'name'=>'revoke',
    			'header'=>'&nbsp;',
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'revokeColumn'),
    			'value'=>'$data->revokeAssignmentColumn()',
    		),
		)
	)); ?>

</div>

<div id="addUserAssignment" class="span-11 last">

	<h3><?php echo Yii::t('RightsModule.core', 'Add Assignment'); ?></h3>

	<?php if( $form!==null ): ?>

		<div class="form">

			<?php echo $form->render(); ?>

		</div>

	<?php else: ?>

		<p class="info"><?php echo Yii::t('RightsModule.core', 'No assignments available to be assigned to this user.'); ?>

	<?php endif; ?>

</div>
