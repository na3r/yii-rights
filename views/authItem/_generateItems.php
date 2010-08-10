<?php foreach( $items as $key=>$item ): ?>

	<?php if( isset($item['actions'])===true && $item['actions']!==array() ): ?>

		<?php $controllerKey = isset($moduleName)===true ? $moduleName.'.'.$key : $key; ?>
		<?php $controllerExists = isset($existingItems[ strtolower($controllerKey).'.all' ]); ?>

		<tr class="controllerRow <?php echo $controllerExists===true ? 'exists' : ''; ?>">
			<td class="checkboxColumn"><?php echo $controllerExists===false ? $form->checkBox($model, 'items['.strtolower($controllerKey).'.all]') : ''; ?></td>
			<td class="nameColumn"><?php echo ucfirst($key).'Controller'; ?></td>
			<td class="pathColumn"><?php echo substr($item['path'], $basePathLength+1); ?></td>
		</tr>

		<?php $i=0; foreach( $item['actions'] as $action ): ?>

			<?php $actionKey = $controllerKey.'.'.$action['name']; ?>
			<?php $actionExists = isset($existingItems[ strtolower($actionKey) ]); ?>

			<tr class="actionRow <?php echo $actionExists===true ? 'exists' : ''; ?> <?php echo ($i++ % 2)===0 ? 'odd' : 'even'; ?>">
				<td class="checkboxColumn"><?php echo $actionExists===false ? $form->checkBox($model, 'items['.strtolower($actionKey).']') : ''; ?></td>
				<td class="nameColumn"><?php echo $action['name']; ?></td>
				<td class="pathColumn"><?php echo substr($item['path'], $basePathLength+1).'('.$action['line'].')'; ?></td>
			</tr>

		<?php endforeach; ?>

	<?php endif; ?>

	<?php if( $key==='modules' ): ?>

		<?php foreach( $item as $moduleName=>$c ): ?>

			<tr><th class="modulesRow" colspan="3"><?php echo Yii::t('RightsModule.core', 'Modules'); ?></th></tr>
			<tr><th class="moduleRow" colspan="3"><?php echo ucfirst($moduleName).'Module'; ?></th></tr>

			<?php $this->renderPartial('_generateItems', array(
				'model'=>$model,
				'form'=>$form,
				'items'=>$c,
				'existingItems'=>$existingItems,
				'moduleName'=>$moduleName,
				'basePathLength'=>$basePathLength,
			)); ?>

		<?php endforeach; ?>

	<?php endif; ?>

<?php endforeach; ?>