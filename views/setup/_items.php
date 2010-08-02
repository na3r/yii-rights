<?php foreach( $items as $key=>$item ): ?>

	<?php if( isset($item['actions'])===true && $item['actions']!==array() ): ?>

		<?php $controllerIndex = isset($moduleName)===true ? $moduleName.'.'.$key : $key; ?>
		<?php $controllerExists = isset($operations[ strtolower($controllerIndex.'.All') ]); ?>

		<tr style="background-color:#d3d7e8;">
			<td><?php echo $controllerExists===false ? $form->checkBox($model, 'items['.$controllerIndex.'.All]') : '&nbsp;X'; ?></td>
			<td colspan="2" style="font-size:12px;"><?php echo ucfirst($key).'Controller'; ?></td>
		</tr>

		<?php $i=0; foreach( $item['actions'] as $action ): ?>

			<?php $actionIndex = $controllerIndex.'.'.$action['name']; ?>
			<?php $actionExists = isset($operations[ strtolower($actionIndex) ]); ?>

			<tr class="<?php echo ($i++ % 2)===0 ? 'odd' : 'even'; ?>">
				<td><?php echo $actionExists===false ? $form->checkBox($model, 'items['.$actionIndex.']') : '&nbsp;X'; ?></td>
				<td><?php echo $action['name']; ?></td>
				<td style="color:#808080;"><?php echo substr($item['path'], $basePathLength+1).'('.$action['line'].')'; ?></td>
			</tr>

		<?php endforeach; ?>

	<?php endif; ?>

	<?php if( $key==='modules' ): ?>

		<?php foreach( $item as $moduleName=>$c ): ?>

			<tr><th colspan="3"><?php echo Yii::t('RightsModule.setup', 'Modules'); ?></th></tr>
			<tr><th colspan="3" style="background-color:#bdc1d1;"><?php echo ucfirst($moduleName).'Module'; ?></th></tr>

			<?php $this->renderPartial('_items', array(
				'model'=>$model,
				'form'=>$form,
				'items'=>$c,
				'operations'=>$operations,
				'moduleName'=>$moduleName,
				'basePathLength'=>$basePathLength,
			)); ?>

		<?php endforeach; ?>

	<?php endif; ?>

<?php endforeach; ?>