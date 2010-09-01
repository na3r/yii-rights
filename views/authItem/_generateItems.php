<?php foreach( $items as $key=>$item ): ?>

	<?php if( isset($item['actions'])===true && $item['actions']!==array() ): ?>

		<?php $controllerKey = isset($moduleName)===true ? ucfirst($moduleName).'.'.$key : $key; ?>
		<?php $controllerExists = isset($existingItems[ $controllerKey.'.*' ]); ?>

		<tr class="controller-row <?php echo $controllerExists===true ? 'exists' : ''; ?>">
			<td class="checkbox-column"><?php echo $controllerExists===false ? $form->checkBox($model, 'items['.$controllerKey.'.*]') : ''; ?></td>
			<td class="name-column"><?php echo ucfirst($key).'Controller'; ?></td>
			<td class="path-column"><?php echo substr($item['path'], $basePathLength+1); ?></td>
		</tr>

		<?php $i=0; foreach( $item['actions'] as $action ): ?>

			<?php $actionKey = $controllerKey.'.'.$action['name']; ?>
			<?php $actionExists = isset($existingItems[ $actionKey ]); ?>

			<tr class="actionRow <?php echo $actionExists===true ? 'exists' : ''; ?> <?php echo ($i++ % 2)===0 ? 'odd' : 'even'; ?>">
				<td class="checkbox-column"><?php echo $actionExists===false ? $form->checkBox($model, 'items['.$actionKey.']') : ''; ?></td>
				<td class="name-column"><?php echo $action['name']; ?></td>
				<td class="path-column"><?php echo substr($item['path'], $basePathLength+1).'('.$action['line'].')'; ?></td>
			</tr>

		<?php endforeach; ?>

	<?php endif; ?>

	<?php if( $key==='modules' && $items['modules']!==array() ): ?>

		<?php if( $showModuleHeadingRow===true ): ?>

			<tr><th class="module-heading-row" colspan="3"><?php echo Yii::t('RightsModule.core', 'Modules'); ?></th></tr>

		<?php endif; ?>

		<?php foreach( $item as $moduleName=>$c ): ?>

			<tr><th class="module-row" colspan="3"><?php echo ucfirst($moduleName).' module'; ?></th></tr>

			<?php $this->renderPartial('_generateItems', array(
				'model'=>$model,
				'form'=>$form,
				'items'=>$c,
				'existingItems'=>$existingItems,
				'moduleName'=>$moduleName,
				'moduleHeadingRowVisible'=>false,
				'basePathLength'=>$basePathLength,
			)); ?>

		<?php endforeach; ?>

	<?php endif; ?>

<?php endforeach; ?>