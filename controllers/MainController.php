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
	* Initializes the controller.
	*/
	public function init()
	{
		$this->_authorizer = $this->getModule()->getAuthorizer();
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
			array('allow', // Allow super users to access Rights
				'actions'=>array(
					'permissions',
					'operations',
					'tasks',
					'roles',
				),
				'users'=>$this->_authorizer->getSuperUsers(),
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
		$this->_authorizer->createPermissions();

		// Get the roles, tasks and operations
		$roles = $this->_authorizer->getRoles(false);
		$authItems = $this->_authorizer->getAuthItems(array(CAuthItem::TYPE_OPERATION, CAuthItem::TYPE_TASK));

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
				if( $right===Rights::PERM_INHERITED )
				{
					// Get auth item parents
					$authItemParents = $this->_authorizer->getAuthItemParents($name, $roleName);
					if( $authItemParents!==array() )
					{
						// If the item has parents beautify their names,
						// implode them to a string and add them to the list of parents
						$authItemParents = array_map(array('Rights', 'beautifyName'), $authItemParents);
						$parents[ $roleName ][ $name ] = implode(', ', $authItemParents);
					}
				}

				// Add the item to the list of rights
				$rights[ $roleName ][ $name ] = $right;
			}
		}

		// Calculate the role column width based on the amount of existing roles
		$roleColumnWidth = $roles!==array() ? 75/count($roles) : 0;

		$params = array(
			'roles'=>$roles,
			'roleColumnWidth'=>$roleColumnWidth,
			'authItems'=>$authItems,
			'rights'=>$rights,
			'parents'=>$parents,
		);

		// Render the view
		isset($_POST['ajax'])===true ? $this->renderPartial('_permissions', $params) : $this->render('permissions', $params);
	}

	/**
	* Displays the operation management page.
	*/
	public function actionOperations()
	{
		$operations = $this->_authorizer->getAuthItems(CAuthItem::TYPE_OPERATION);

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
		$tasks = $this->_authorizer->getAuthItems(CAuthItem::TYPE_TASK);

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

		// Register the script to bind the sortable plugin to the role table if necessary
		if( Rights::getConfig('enableWeights')===true )
		{
			Yii::app()->getClientScript()->registerScript('rightsRoleTable',
				"$('.roleTable').rightsSortableTable({ url:'".$this->createUrl('authItem/processSortable')."' });"
			);
		}

		// Render the view
		$this->render('roles', array(
			'roles'=>$roles,
			'childCounts'=>$this->_authorizer->getAuthItemChildCounts($roles),
			'isBizRuleEnabled'=>Rights::getConfig('enableBizRule'),
			'isBizRuleDataEnabled'=>Rights::getConfig('enableBizRuleData'),
		));
	}
}
