<?php
$this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Yii::t('RightsModule.core', 'Roles'),
);
?>

<div id="rightsRoles">

	<h2><?php echo Yii::t('RightsModule.core', 'Roles'); ?></h2>

	<p>
		<?php echo CHtml::link(Yii::t('RightsModule.core', 'Create a new role'), array('authItem/create', 'type'=>CAuthItem::TYPE_ROLE), array(
			'class'=>'addRoleLink',
		)); ?>
	</p>

	<?php $this->widget('zii.widgets.grid.CGridView', array(
	    'dataProvider'=>$dataProvider,
	    'template'=>'{items}',
	    'emptyText'=>Yii::t('RightsModule.core', 'No roles found.'),
	    'htmlOptions'=>array('class'=>'roleTable'),
	    'columns'=>array(
    		array(
    			'name'=>'name',
    			'header'=>Yii::t('RightsModule.core', 'Name'),
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'nameColumn'),
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
    			'visible'=>$isBizRuleEnabled===true,
    		),
    		array(
    			'name'=>'bizRuleData',
    			'header'=>Yii::t('RightsModule.core', 'Data'),
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'bizRuleDataColumn'),
    			'visible'=>$isBizRuleEnabled===true && $isBizRuleDataEnabled===true,
    		),
    		array(
    			'name'=>'delete',
    			'header'=>'&nbsp;',
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'deleteColumn'),
    		),
	    )
	)); ?>

	<p class="info"><?php echo Yii::t('RightsModule.core', 'Values within square brackets tell how many children each item has.'); ?></p>

</div>
