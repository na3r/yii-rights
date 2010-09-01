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
		$dataProvider = new PermissionDataProvider('permissions');

		$roles = $dataProvider->getRoles();
		$roleColumnWidth = $roles!==array() ? 75/count($roles) : 0;

		$columns = array();
		$columns[] = array(
    		'name'=>'description',
    		'header'=>Yii::t('RightsModule.core', 'Item'),
    		'htmlOptions'=>array(
    			'class'=>'permission-column',
    			'style'=>'width:25%',
    		),
    	);

    	foreach( $roles as $roleName=>$role )
    	{
    		$columns[] = array(
				'name'=>strtolower($roleName),
    			'header'=>$roleName,
    			'type'=>'raw',
    			'htmlOptions'=>array(
    				'class'=>'role-column',
    				'style'=>'width:'.$roleColumnWidth.'%',
    			),
    		);
		}

		$view = 'permissions';

		$params = array(
			'dataProvider'=>$dataProvider,
			'columns'=>$columns,
		);

		// Render the view
		isset($_POST['ajax'])===true ? $this->renderPartial($view, $params) : $this->render($view, $params);
	}

	/**
	* Displays the operation management page.
	*/
	public function actionOperations()
	{
		$dataProvider = new AuthItemDataProvider('operationTable', array(
			'type'=>CAuthItem::TYPE_OPERATION,
			'sortable'=>array(
				'id'=>'RightsOperationTableSort',
				'element'=>'.operation-table',
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
		$dataProvider = new AuthItemDataProvider('taskTable', array(
			'type'=>CAuthItem::TYPE_TASK,
			'sortable'=>array(
				'id'=>'RightsTaskTableSort',
				'element'=>'.task-table',
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
		$dataProvider = new AuthItemDataProvider('roleTable', array(
			'type'=>CAuthItem::TYPE_ROLE,
			'sortable'=>array(
				'id'=>'RightsRoleTableSort',
				'element'=>'.role-table',
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
