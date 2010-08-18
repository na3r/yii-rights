<?php
/**
* Rights default controller class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.5
*/
class DefaultController extends Controller
{
	/**
	* @var RightsModule
	*/
	private $_module;
	/**
	* @var RightsAuthorizer
	*/
	private $_authorizer;

	/**
	* Initializes the controller.
	*/
	public function init()
	{
		$this->_module = $this->getModule();
		$this->_authorizer = $this->_module->getAuthorizer();
		$this->layout = $this->_module->layout;
		$this->defaultAction = 'permissions';
	}

	/**
	* @return array action filters
	*/
	public function filters()
	{
		return array('accessControl');
	}

	/**
	* Specifies the access control rules.
	* This method is used by the 'accessControl' filter.
	* @return array access control rules
	*/
	public function accessRules()
	{
		return array(
			array('allow', // Allow superusers to access Rights
				'actions'=>array(
					'permissions',
					'operations',
					'tasks',
					'roles',
				),
				'users'=>$this->_authorizer->getSuperusers(),
			),
			array('deny', // Deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	* Displays the permission overview.
	*/
	public function actionPermissions()
	{
		// Create the permissions tree
		$roles = $this->_authorizer->getRoles(false);
		$items = $this->_authorizer->getAuthItems(array(CAuthItem::TYPE_OPERATION, CAuthItem::TYPE_TASK), null, null, true);
		$permissions = $this->_authorizer->getPermissions();

		// Get the rights to items for each role
		$rights = array();
		foreach( $roles as $roleName=>$role )
			foreach( $items as $name=>$item )
				$rights[ $roleName ][ $name ] = $this->_authorizer->hasPermission($name, $permissions[ $roleName ]);

		// Get the item parents
		$parents = array();
		foreach( $rights as $roleName=>$perm )
			foreach( $perm as $name=>$right )
				if( $right===Rights::PERM_INHERITED )
					if( ($p = $this->_authorizer->getAuthItemParents($name, $roleName, true))!==array() && $p===(array)$p )
						$parents[ $roleName ][ $name ] = implode(', ', array_map(array('Rights', 'beautifyName'), $p));

		// View parameters
		$params = array(
			'roles'=>$roles,
			'roleColumnWidth'=>$roles!==array() ? 75/count($roles) : 0,
			'items'=>$items,
			'rights'=>$rights,
			'parents'=>$parents,
		);

		// Render the view
		if( isset($_POST['ajax'])===true )
			$this->renderPartial('_permissions', $params);
		else
			$this->render('permissions', $params);
	}

	/**
	* Displays the operation management page.
	*/
	public function actionOperations()
	{
		$operations = $this->_authorizer->getAuthItems(CAuthItem::TYPE_OPERATION, null, null, true);
		$childCounts = $this->_authorizer->getAuthItemChildCounts($operations);

		$data = array();
		foreach( $operations as $item )
		{
			$row = array();

			$name = CHtml::link(Rights::beautifyName($item->name), array('authItem/update', 'name'=>$item->name, 'redirect'=>urlencode('default/operations')));
			$name.= $childCounts[ $item->name ]>0 ? ' <span class="childCount">[ <span class="childCountNumber">'.$childCounts[ $item->name ].'</span> ]</span>' : '';

			$row['name'] = $name;
			$row['description'] = CHtml::encode($item->description);

			if( isset($item->bizRule)===true )
				$row['bizRule'] = CHtml::encode($item->bizRule);

			if( isset($item->bizRuleData)===true )
				$row['bizRuleData'] = CHtml::encode($item->bizRuleData);

			$row['delete'] = CHtml::linkButton(Yii::t('RightsModule.core', 'Delete'), array(
				'submit'=>array('authItem/delete', 'name'=>$name, 'redirect'=>urlencode('default/operations')),
				'confirm'=>Yii::t('RightsModule.core', 'Are you sure you want to delete this operation?'),
				'class'=>'deleteLink',
			));

			$data[] = $row;
		}

		$dataProvider = new RightsDataProvider('tasks', $data);

		// Register the script to bind the sortable plugin to the operation table
		Yii::app()->getClientScript()->registerScript('rightsOperationTableSort',
			"jQuery('.operationTable').rightsSortableTable({
				url:'".$this->createUrl('authItem/processSortable')."'
			});"
		);

		// Render the view
		$this->render('operations', array(
			'dataProvider'=>$dataProvider,
			'isBizRuleEnabled'=>$this->_module->enableBizRule,
			'isBizRuleDataEnabled'=>$this->_module->enableBizRuleData,
		));
	}

	/**
	* Displays the operation management page.
	*/
	public function actionTasks()
	{
		$tasks = $this->_authorizer->getAuthItems(CAuthItem::TYPE_TASK, null, null, true);
		$childCounts = $this->_authorizer->getAuthItemChildCounts($tasks);

		$data = array();
		foreach( $tasks as $item )
		{
			$row = array();

			$name = CHtml::link(Rights::beautifyName($item->name), array('authItem/update', 'name'=>$item->name, 'redirect'=>urlencode('default/tasks')));
			$name.= $childCounts[ $item->name ]>0 ? ' <span class="childCount">[ <span class="childCountNumber">'.$childCounts[ $item->name ].'</span> ]</span>' : '';

			$row['name'] = $name;
			$row['description'] = CHtml::encode($item->description);

			if( isset($item->bizRule)===true )
				$row['bizRule'] = CHtml::encode($item->bizRule);

			if( isset($item->bizRuleData)===true )
				$row['bizRuleData'] = CHtml::encode($item->bizRuleData);

			$row['delete'] = CHtml::linkButton(Yii::t('RightsModule.core', 'Delete'), array(
				'submit'=>array('authItem/delete', 'name'=>$name, 'redirect'=>urlencode('default/tasks')),
				'confirm'=>Yii::t('RightsModule.core', 'Are you sure you want to delete this task?'),
				'class'=>'deleteLink',
			));

			$data[] = $row;
		}

		$dataProvider = new RightsDataProvider('tasks', $data);

		// Register the script to bind the sortable plugin to the task table
		Yii::app()->getClientScript()->registerScript('rightsTaskTableSort',
			"jQuery('.taskTable').rightsSortableTable({
				url:'".$this->createUrl('authItem/processSortable')."'
			});"
		);

		// Render the view
		$this->render('tasks', array(
			'dataProvider'=>$dataProvider,
			'isBizRuleEnabled'=>$this->_module->enableBizRule,
			'isBizRuleDataEnabled'=>$this->_module->enableBizRuleData,
		));
	}

	/**
	* Displays the role management page.
	*/
	public function actionRoles()
	{
		$roles = $this->_authorizer->getRoles();
		$superuserRole = $this->_module->superuserRole;
		$childCounts = $this->_authorizer->getAuthItemChildCounts($roles);

		$data = array();
		foreach( $roles as $item )
		{
			$row = array();

			$name = CHtml::link(Rights::beautifyName($item->name), array('authItem/update', 'name'=>$item->name, 'redirect'=>urlencode('default/roles')));
			$name.= $item->name===$superuserRole ? ' <span class="superuser">( <span class="superuserText">'.Yii::t('RightsModule.core', 'superuser').'</span> )</span>' : '';
			$name.= $childCounts[ $item->name ]>0 ? ' <span class="childCount">[ <span class="childCountNumber">'.$childCounts[ $item->name ].'</span> ]</span>' : '';

			$row['name'] = $name;
			$row['description'] = CHtml::encode($item->description);

			if( isset($item->bizRule)===true )
				$row['bizRule'] = CHtml::encode($item->bizRule);

			if( isset($item->bizRuleData)===true )
				$row['bizRuleData'] = CHtml::encode($item->bizRuleData);

			if( $item->name!==$superuserRole )
			{
				$row['delete'] = CHtml::linkButton(Yii::t('RightsModule.core', 'Delete'), array(
					'submit'=>array('authItem/delete', 'name'=>$name, 'redirect'=>urlencode('default/roles')),
					'confirm'=>Yii::t('RightsModule.core', 'Are you sure you want to delete this role?'),
					'class'=>'deleteLink',
				));
			}

			$data[] = $row;
		}

		$dataProvider = new RightsDataProvider('roles', $data);

		// Register the script to bind the sortable plugin to the role table
		Yii::app()->getClientScript()->registerScript('rightsRoleTableSort',
			"jQuery('.roleTable').rightsSortableTable({
				url:'".$this->createUrl('authItem/processSortable')."'
			});"
		);

		// Render the view
		$this->render('roles', array(
			'dataProvider'=>$dataProvider,
			'isBizRuleEnabled'=>$this->_module->enableBizRule,
			'isBizRuleDataEnabled'=>$this->_module->enableBizRuleData,
		));
	}
}
