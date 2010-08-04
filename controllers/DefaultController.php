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
	* @var RightsAuthorizer
	*/
	private $_authorizer;

	/**
	* Initializes the controller.
	*/
	public function init()
	{
		if( $this->getModule()->getInstaller()->isInstalled===false )
			$this->redirect(array('setup/install'));

		$this->_authorizer = $this->getModule()->getAuthorizer();
		$this->layout = Rights::getConfig('layout');
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
		$items = $this->_authorizer->getAuthItems(array(CAuthItem::TYPE_OPERATION, CAuthItem::TYPE_TASK), null, true);
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
		$operations = $this->_authorizer->getAuthItems(CAuthItem::TYPE_OPERATION, null, true);

		// Register the script to bind the sortable plugin to the operation table
		Yii::app()->getClientScript()->registerScript('rightsOperationTableSort',
			"jQuery('.operationTable').rightsSortableTable({
				url:'".$this->createUrl('/rights/authItem/processSortable')."'
			});"
		);

		// Render the view
		$this->render('operations', array(
			'operations'=>$operations,
			'childCounts'=>$this->_authorizer->getAuthItemChildCounts($operations),
			'isBizRuleEnabled'=>Rights::getConfig('enableBizRule'),
			'isBizRuleDataEnabled'=>Rights::getConfig('enableBizRuleData'),
		));
	}

	/**
	* Displays the operation management page.
	*/
	public function actionTasks()
	{
		$tasks = $this->_authorizer->getAuthItems(CAuthItem::TYPE_TASK, null, true);

		// Register the script to bind the sortable plugin to the task table
		Yii::app()->getClientScript()->registerScript('rightsTaskTableSort',
			"jQuery('.taskTable').rightsSortableTable({
				url:'".$this->createUrl('/rights/authItem/processSortable')."'
			});"
		);

		// Render the view
		$this->render('tasks', array(
			'tasks'=>$tasks,
			'childCounts'=>$this->_authorizer->getAuthItemChildCounts($tasks),
			'isBizRuleEnabled'=>Rights::getConfig('enableBizRule'),
			'isBizRuleDataEnabled'=>Rights::getConfig('enableBizRuleData'),
		));
	}

	/**
	* Displays the role management page.
	*/
	public function actionRoles()
	{
		$roles = $this->_authorizer->getRoles();

		// Register the script to bind the sortable plugin to the role table
		Yii::app()->getClientScript()->registerScript('rightsRoleTableSort',
			"jQuery('.roleTable').rightsSortableTable({
				url:'".$this->createUrl('/rights/authItem/processSortable')."'
			});"
		);

		// Render the view
		$this->render('roles', array(
			'roles'=>$roles,
			'childCounts'=>$this->_authorizer->getAuthItemChildCounts($roles),
			'isBizRuleEnabled'=>Rights::getConfig('enableBizRule'),
			'isBizRuleDataEnabled'=>Rights::getConfig('enableBizRuleData'),
		));
	}
}
