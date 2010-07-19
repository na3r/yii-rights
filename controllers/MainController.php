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
	* @var RightsModule
	*/
	private $_module;

	/**
	* @var RightsAuthorizer
	*/
	private $_auth;

	/**
	* Initialization.
	*/
	public function init()
	{
		$this->_module = Yii::app()->getModule('rights');
		$this->_auth = $this->_module->getComponent('auth');

		$this->layout = $this->_module->layout;
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
				'users'=>$this->_auth->superUsers,
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
		// Get the roles, tasks and operations
		$roles = $this->_auth->getRoles();
		$authItems = $this->_auth->getAuthItems(array('operation', 'task'));

		// loop through the roles to get the list of right
		// and parents for those that are inherited
		$rights = $parents = array();
		foreach( $roles as $roleName=>$role )
		{
			// Loop through each auth item
			foreach( $authItems as $name=>$item )
			{
				// Get the permission to each item
				$right = $this->_auth->hasPermission($roleName, $name);

				// Permissions in inherited, we need to get the parents for this item
				if( $right===Rights::PERM_INHERIT )
					$parents[ $roleName ][ $name ] = implode(', ', $this->_auth->getAuthItemParents($name, $roleName));

				// Add the item to the list of rights
				$rights[ $roleName ][ $name ] = $right;
			}
		}

		$params = array(
			'roles'=>$roles,
			'roleColumnWidth'=>(75/count($roles)),
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
		$operations = $this->_auth->getAuthItems('operation');

		// Calculate how many children each item has
		$childCount = array();
		foreach( $operations as $name=>$item )
			$childCount[ $name ] = count($item->children);

		// Render the view
		$this->render('operations', array(
			'authItems'=>$operations,
			'childCount'=>$childCount,
			'isBizRuleEnabled'=>$this->_module->enableBizRule,
			'isBizRuleDataEnabled'=>$this->_module->enableBizRuleData,
			'i'=>0,
		));
	}

	/**
	* Displays the operation management page.
	*/
	public function actionTasks()
	{
		$tasks = $this->_auth->getAuthItems('task');

		// Calculate how many children each item has
		$childCount = array();
		foreach( $tasks as $name=>$item )
			$childCount[ $name ] = count($item->children);

		// Render the view
		$this->render('tasks', array(
			'authItems'=>$tasks,
			'childCount'=>$childCount,
			'isBizRuleEnabled'=>$this->_module->enableBizRule,
			'isBizRuleDataEnabled'=>$this->_module->enableBizRuleData,
			'i'=>0,
		));
	}

	/**
	* Displays the role management page.
	*/
	public function actionRoles()
	{
		$roles = $this->_auth->getRoles();

		// Calculate how many children each item has
		$childCount = array();
		foreach( $roles as $name=>$item )
			$childCount[ $name ] = count($item->children);

		// Render the view
		$this->render('roles', array(
			'authItems'=>$roles,
			'childCount'=>$childCount,
			'isBizRuleEnabled'=>$this->_module->enableBizRule,
			'isBizRuleDataEnabled'=>$this->_module->enableBizRuleData,
			'i'=>0,
		));
	}
}
