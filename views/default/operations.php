<?php
$this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Yii::t('RightsModule.core', 'Operations'),
); ?>

<div id="rightsOperations">

	<h2><?php echo Yii::t('RightsModule.core', 'Operations'); ?></h2>

	<p>
		<?php echo CHtml::link(Yii::t('RightsModule.core', 'Create a new operation'), array('authItem/create', 'type'=>CAuthItem::TYPE_OPERATION), array(
			'class'=>'addOperationLink',
		)); ?>
	</p>

	<?php $this->widget('zii.widgets.grid.CGridView', array(
	    'dataProvider'=>$dataProvider,
	    'template'=>'{items}',
	    'emptyText'=>Yii::t('RightsModule.core', 'No operations found.'),
	    'htmlOptions'=>array('class'=>'grid-view operationTable'),
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
    			'value'=>'$data->deleteOperationColumn()',
    		),
	    )
	)); ?>

	<p class="info"><?php echo Yii::t('RightsModule.core', 'Values within square brackets tell how many children each item has.'); ?></p>

</div>