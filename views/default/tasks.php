<?php
$this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Yii::t('RightsModule.core', 'Tasks'),
);
?>

<div id="rightsTasks">

	<h2><?php echo Yii::t('RightsModule.core', 'Tasks'); ?></h2>

	<p>
		<?php echo CHtml::link(Yii::t('RightsModule.core', 'Create a new task'), array('authItem/create', 'type'=>CAuthItem::TYPE_TASK), array(
			'class'=>'addTaskLink',
		)); ?>
	</p>

	<?php $this->widget('zii.widgets.grid.CGridView', array(
	    'dataProvider'=>$dataProvider,
	    'template'=>'{items}',
	    'emptyText'=>Yii::t('RightsModule.core', 'No tasks found.'),
	    'htmlOptions'=>array('class'=>'grid-view taskTable'),
	    'columns'=>array(
    		array(
    			'name'=>'name',
    			'header'=>Yii::t('RightsModule.core', 'Name'),
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'nameColumn'),
    			'value'=>'$data->nameColumn(true, true)',
    		),
    		array(
    			'name'=>'description',
    			'header'=>Yii::t('RightsModule.core', 'Description'),
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'descriptionColumn'),
    		),
    		array(
    			'name'=>'bizRule',
    			'header'=>Yii::t('RightsModule.core', 'Business rule'),
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'bizRuleColumn'),
    		),
    		array(
    			'name'=>'data',
    			'header'=>Yii::t('RightsModule.core', 'Data'),
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'dataColumn'),
    		),
    		array(
    			'name'=>'delete',
    			'header'=>'&nbsp;',
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'deleteColumn'),
    			'value'=>'$data->deleteTaskColumn()',
    		),
	    )
	)); ?>

	<p class="info"><?php echo Yii::t('RightsModule.core', 'Values within square brackets tell how many children each item has.'); ?></p>

</div>
