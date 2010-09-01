<?php $this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Yii::t('RightsModule.core', 'Assignments'),
); ?>

<div id="rightsAssignments">

	<h2><?php echo Yii::t('RightsModule.core', 'Assignments'); ?></h2>

	<?php $this->widget('zii.widgets.grid.CGridView', array(
	    'dataProvider'=>$dataProvider,
	    'template'=>'{items}',
	    'emptyText'=>Yii::t('RightsModule.core', 'No users found.'),
	    'htmlOptions'=>array('class'=>'grid-view assignment-table'),
	    'columns'=>array(
    		array(
    			'name'=>'name',
    			'header'=>Yii::t('RightsModule.core', 'Name'),
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'name-column'),
    			'value'=>'$data->getAssignmentNameLink()',
    		),
    		array(
    			'name'=>'assignments',
    			'header'=>Yii::t('RightsModule.core', 'Assignments'),
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'assignment-column'),
    			'value'=>'$data->getAssignments()',
    		),
	    )
	)); ?>

</div>
