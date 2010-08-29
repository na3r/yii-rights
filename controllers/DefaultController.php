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

		// Register the scripts
		$this->_module->registerScripts();
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

		// View parameters
		$params = array(
			'roles'=>$roles,
			'items'=>$items,
			'roleColumnWidth'=>$roles!==array() ? 75/count($roles) : 0,
		);

		// Render the view
		if( Yii::app()->request->isPostRequest===true && isset($_POST['ajax'])===true )
			$this->renderPartial('_permissions', $params);
		else
			$this->render('permissions', $params);
	}

	/**
	* Displays the operation management page.
	*/
	public function actionOperations()
	{
		$dataProvider = new RightsAuthItemDataProvider('operationTable', CAuthItem::TYPE_OPERATION, array(
			'sortable'=>array(
				'id'=>'RightsOperationTableSort',
				'element'=>'.operationTable',
				'url'=>$this->createUrl('authItem/processSortable'),
			),
		));

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
		$dataProvider = new RightsAuthItemDataProvider('taskTable', CAuthItem::TYPE_TASK, array(
			'sortable'=>array(
				'id'=>'RightsTaskTableSort',
				'element'=>'.taskTable',
				'url'=>$this->createUrl('authItem/processSortable'),
			),
		));

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
		$dataProvider = new RightsAuthItemDataProvider('roleTable', CAuthItem::TYPE_ROLE, array(
			'sortable'=>array(
				'id'=>'RightsRoleTableSort',
				'element'=>'.roleTable',
				'url'=>$this->createUrl('authItem/processSortable'),
			),
		));

		// Render the view
		$this->render('roles', array(
			'dataProvider'=>$dataProvider,
			'isBizRuleEnabled'=>$this->_module->enableBizRule,
			'isBizRuleDataEnabled'=>$this->_module->enableBizRuleData,
		));
	}
}
