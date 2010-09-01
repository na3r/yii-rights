<?php $this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Rights::getAuthItemTypeNamePlural($model->type)=>array(Rights::getAuthItemRoute($model->type)),
	Rights::beautifyName($model->name),
); ?>

<div id="updatedAuthItem">

	<div class="form span-12 first">

		<h2><?php echo Yii::t('RightsModule.core', 'Update :name', array(':name'=>Rights::beautifyName($model->name))); ?></h2>

		<p class="info"><?php echo Rights::getAuthItemTypeName($model->type); ?></p>

		<?php echo $form->render(); ?>

	</div>

	<div class="relations" class="span-11 last">

		<h2><?php echo Yii::t('RightsModule.core', 'Relations'); ?></h2>

		<?php if( $model->name!==Rights::module()->superuserName ): ?>

			<div class="parents">

				<h3><?php echo Yii::t('RightsModule.core', 'Parents'); ?></h3>

				<?php $this->widget('zii.widgets.grid.CGridView', array(
					'dataProvider'=>$parentDataProvider,
					'template'=>'{items}',
					'hideHeader'=>true,
					'emptyText'=>Yii::t('RightsModule.core', 'This item has no parents.'),
					'htmlOptions'=>array('class'=>'grid-view parent-table mini'),
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
    					/*
    					array(
    						'header'=>'&nbsp;',
    						'type'=>'raw',
    						'htmlOptions'=>array('class'=>'empty-column'),
    						'value'=>'',
    					),
    					*/
					)
				)); ?>

			</div>

			<div class="children">

				<h3><?php echo Yii::t('RightsModule.core', 'Children'); ?></h3>

				<?php $this->widget('zii.widgets.grid.CGridView', array(
					'dataProvider'=>$childDataProvider,
					'template'=>'{items}',
					'hideHeader'=>true,
					'emptyText'=>Yii::t('RightsModule.core', 'This item has no children.'),
					'htmlOptions'=>array('class'=>'grid-view parent-table mini'),
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
    						'name'=>'remove',
    						'header'=>'&nbsp;',
    						'type'=>'raw',
    						'htmlOptions'=>array('class'=>'remove-column'),
    						'value'=>'$data->removeChildColumn()',
    					),
					)
				)); ?>

			</div>

			<div class="addChild">

				<h4><?php echo Yii::t('RightsModule.core', 'Add Child'); ?></h4>

				<?php if( $childForm!==null ): ?>

					<div class="form">

						<?php echo $childForm->render(); ?>

					</div>

				<?php else: ?>

					<p class="info"><?php echo Yii::t('RightsModule.core', 'No children available to be added to this item.'); ?>

				<?php endif; ?>

			</div>

		<?php else: ?>

			<p class="info">

				<?php echo Yii::t('RightsModule.core', 'No relations need to be set for the superuser role.'); ?><br />
				<?php echo Yii::t('RightsModule.core', 'Super users are always granted access implicitly.'); ?>

			</p>

		<?php endif; ?>

	</div>

</div>
