<?php
/**
* Rights main controller class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.5
*/
class MainController extends Controller
{
	/**
	* @var RightsAuthorizer
	*/
	private $_authorizer;

	/**
	* Initialization.
	*/
	public function init()
	{
		$this->_authorizer = Rights::getAuthorizer();
		$this->layout = Rights::getConfig('layout');
		$this->defaultAction = 'permissions';
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl',
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array(
					'permissions',
					'operations',
					'tasks',
					'roles',
				),
				'users'=>$this->_authorizer->superUsers,
			),
			array('deny',
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
		$this->_authorizer->createPermissions();

		// Get the roles, tasks and operations
		$roles = $this->_authorizer->getRoles();
		$authItems = $this->_authorizer->getAuthItems(array('operation', 'task'));

		// loop through the roles to get the list of right
		// and parents for those that are inherited
		$rights = $parents = array();
		foreach( $roles as $roleName=>$role )
		{
			// Loop through each auth item
			foreach( $authItems as $name=>$item )
			{
				// Get the permission to each item
				$right = $this->_authorizer->hasPermission($roleName, $name);

				// Permissions in inherited, we need to get the parents for this item
				if( $right===Rights::PERM_INHERIT )
					$parents[ $roleName ][ $name ] = implode(', ', array_map(array('Rights', 'beautifyName'), $this->_authorizer->getAuthItemParents($name, $roleName)));

				// Add the item to the list of rights
				$rights[ $roleName ][ $name ] = $right;
			}
		}

		// Calculate the role column width based on the amount of existing roles
		$roleColumnWidth = count($roles)>0 ? 75/count($roles) : 0;

		$params = array(
			'roles'=>$roles,
			'roleColumnWidth'=>$roleColumnWidth,
			'authItems'=>$authItems,
			'rights'=>$rights,
			'parents'=>$parents,
			'i'=>0,
		);

		// Render the view
		isset($_POST['ajax'])===true ? $this->renderPartial('_permissions', $params) : $this->render('permissions', $params);
	}

	/**
	* Displays the operation management page.
	*/
	public function actionOperations()
	{
		$operations = $this->_authorizer->getAuthItems('operation');

		// Calculate how many children each item has
		$childCount = array();
		foreach( $operations as $name=>$item )
			$childCount[ $name ] = count($item->children);

		// Render the view
		$this->render('operations', array(
			'authItems'=>$operations,
			'childCount'=>$childCount,
			'isBizRuleEnabled'=>Rights::getConfig('enableBizRule'),
			'isBizRuleDataEnabled'=>Rights::getConfig('enableBizRuleData'),
			'i'=>0,
		));
	}

	/**
	* Displays the operation management page.
	*/
	public function actionTasks()
	{
		$tasks = $this->_authorizer->getAuthItems('task');

		// Calculate how many children each item has
		$childCount = array();
		foreach( $tasks as $name=>$item )
			$childCount[ $name ] = count($item->children);

		// Render the view
		$this->render('tasks', array(
			'authItems'=>$tasks,
			'childCount'=>$childCount,
			'isBizRuleEnabled'=>Rights::getConfig('enableBizRule'),
			'isBizRuleDataEnabled'=>Rights::getConfig('enableBizRuleData'),
			'i'=>0,
		));
	}

	/**
	* Displays the role management page.
	*/
	public function actionRoles()
	{
		$roles = $this->_authorizer->getRoles();

		// Calculate how many children each item has
		$childCount = array();
		foreach( $roles as $name=>$item )
			$childCount[ $name ] = count($item->children);

		// Render the view
		$this->render('roles', array(
			'authItems'=>$roles,
			'childCount'=>$childCount,
			'isBizRuleEnabled'=>Rights::getConfig('enableBizRule'),
			'isBizRuleDataEnabled'=>Rights::getConfig('enableBizRuleData'),
			'i'=>0,
		));
	}
}
