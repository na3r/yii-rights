<?php $this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Rights::getAuthItemTypeNamePlural($model->type)=>array(Rights::getAuthItemRoute($model->type)),
	$model->name,
); ?>

<div id="updatedAuthItem">

	<div class="form span-12 first">

		<h2><?php echo Rights::t('core', 'Update :name', array(':name'=>$model->name)); ?></h2>

		<p class="info"><?php echo Rights::getAuthItemTypeName($model->type); ?></p>

		<?php echo $form->render(); ?>

	</div>

	<div class="relations span-11 last">

		<h2><?php echo Rights::t('core', 'Relations'); ?></h2>

		<?php if( $model->name!==Rights::module()->superuserName ): ?>

			<div class="parents">

				<h3><?php echo Rights::t('core', 'Parents'); ?></h3>

				<?php $this->widget('zii.widgets.grid.CGridView', array(
					'dataProvider'=>$parentDataProvider,
					'template'=>'{items}',
					'hideHeader'=>true,
					'emptyText'=>Rights::t('core', 'This item has no parents.'),
					'htmlOptions'=>array('class'=>'grid-view parent-table mini'),
					'columns'=>array(
    					array(
    						'name'=>'name',
    						'header'=>Rights::t('core', 'Name'),
    						'type'=>'raw',
    						'htmlOptions'=>array('class'=>'name-column'),
    						'value'=>'$data->getNameLink()',
    					),
    					array(
    						'name'=>'type',
    						'header'=>Rights::t('core', 'Type'),
    						'type'=>'raw',
    						'htmlOptions'=>array('class'=>'type-column'),
    						'value'=>'$data->getTypeText()',
    					),
    					array(
    						'header'=>'&nbsp;',
    						'type'=>'raw',
    						'htmlOptions'=>array('class'=>'empty-column'),
    						'value'=>'',
    					),
					)
				)); ?>

			</div>

			<div class="children">

				<h3><?php echo Rights::t('core', 'Children'); ?></h3>

				<?php $this->widget('zii.widgets.grid.CGridView', array(
					'dataProvider'=>$childDataProvider,
					'template'=>'{items}',
					'hideHeader'=>true,
					'emptyText'=>Rights::t('core', 'This item has no children.'),
					'htmlOptions'=>array('class'=>'grid-view parent-table mini'),
					'columns'=>array(
    					array(
    						'name'=>'name',
    						'header'=>Rights::t('core', 'Name'),
    						'type'=>'raw',
    						'htmlOptions'=>array('class'=>'name-column'),
    						'value'=>'$data->getNameLink()',
    					),
    					array(
    						'name'=>'type',
    						'header'=>Rights::t('core', 'Type'),
    						'type'=>'raw',
    						'htmlOptions'=>array('class'=>'type-column'),
    						'value'=>'$data->getTypeText()',
    					),
    					array(
    						'name'=>'remove',
    						'header'=>'&nbsp;',
    						'type'=>'raw',
    						'htmlOptions'=>array('class'=>'remove-column'),
    						'value'=>'$data->getRemoveChildLink()',
    					),
					)
				)); ?>

			</div>

			<div class="addChild">

				<h4><?php echo Rights::t('core', 'Add Child'); ?></h4>

				<?php if( $childForm!==null ): ?>

					<div class="form">

						<?php echo $childForm->render(); ?>

					</div>

				<?php else: ?>

					<p class="info"><?php echo Rights::t('core', 'No children available to be added to this item.'); ?>

				<?php endif; ?>

			</div>

		<?php else: ?>

			<p class="info">

				<?php echo Rights::t('core', 'No relations need to be set for the superuser role.'); ?><br />
				<?php echo Rights::t('core', 'Super users are always granted access implicitly.'); ?>

			</p>

		<?php endif; ?>

	</div>

</div>
