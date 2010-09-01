<?php
$this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Yii::t('RightsModule.core', 'Tasks'),
);
?>

<div id="tasks">

	<h2><?php echo Yii::t('RightsModule.core', 'Tasks'); ?></h2>

	<p>
		<?php echo CHtml::link(Yii::t('RightsModule.core', 'Create a new task'), array('authItem/create', 'type'=>CAuthItem::TYPE_TASK), array(
			'class'=>'add-task-link',
		)); ?>
	</p>

	<?php $this->widget('zii.widgets.grid.CGridView', array(
	    'dataProvider'=>$dataProvider,
	    'template'=>'{items}',
	    'emptyText'=>Yii::t('RightsModule.core', 'No tasks found.'),
	    'htmlOptions'=>array('class'=>'grid-view task-table'),
	    'columns'=>array(
    		array(
    			'name'=>'name',
    			'header'=>Yii::t('RightsModule.core', 'Name'),
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'name-column'),
    			'value'=>'$data->nameColumn(true, true)',
    		),
    		array(
    			'name'=>'description',
    			'header'=>Yii::t('RightsModule.core', 'Description'),
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'description-column'),
    		),
    		array(
    			'name'=>'bizRule',
    			'header'=>Yii::t('RightsModule.core', 'Business rule'),
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'bizrule-column'),
    		),
    		array(
    			'name'=>'data',
    			'header'=>Yii::t('RightsModule.core', 'Data'),
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'data-column'),
    		),
    		array(
    			'name'=>'delete',
    			'header'=>'&nbsp;',
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'delete-column'),
    			'value'=>'$data->deleteTaskColumn()',
    		),
	    )
	)); ?>

	<p class="info"><?php echo Yii::t('RightsModule.core', 'Values within square brackets tell how many children each item has.'); ?></p>

</div>
