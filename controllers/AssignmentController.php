<?php
/**
* Rights assignment controller class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.9.1
*/
class AssignmentController extends Controller
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
		$this->defaultAction = 'view';
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
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(
					'view',
					'user',
					'revoke',
				),
				'users'=>$this->_auth->superUsers,
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	* Displays the auth assignments overview.
	*/
	public function actionView()
	{
		$criteria = new CDbCriteria();
		$count = $this->_auth->user->count($criteria);

		// Create the pager
		$pages = new CPagination($count);
		$pages->pageSize = 20;
		$pages->applyLimit($criteria);

		// Get all users
		$allUsers = $this->_auth->user->findAll($criteria);

		// Remove super users
		$users = array();
		foreach( $allUsers as $user )
			if( $this->_auth->isSuperUser($user->id)===false )
				$users[ (int)$user->id ] = $user;

		// Get the assigned auth items for all user
		$authAssignments = $this->_auth->getUserAuthAssignments(array_keys($users));

		// Create a list of assignments with beautified names for each user
		// and place them in a list of assignment with the user id as key
		$assignments = array();
		foreach( $authAssignments as $userId=>$items )
			foreach( $items as $name=>$item )
				$assignments[ $userId ][] = Rights::beautifyName($name);

		// Render the view
		$this->render('view', array(
			'users'=>$users,
			'username'=>$this->_auth->usernameColumn,
			'assignments'=>$assignments,
			'pages'=>$pages,
			'i'=>0,
		));
	}

	/**
	* Displays the auth assignments for an user.
	*/
	public function actionUser()
	{
		$model = $this->_auth->user->findByPk($_GET['id']);
		$assignedAuthItems = $this->_auth->getAuthItems(NULL, $model->id);

		// Get the assigned items
		$assignedItems = array();
		foreach( $assignedAuthItems as $item )
			$assignedItems[] = $item->name;

		// Get the assignment select options
		$selectOptions = $this->_auth->getAuthItemSelectOptions(NULL, NULL, $assignedItems);

		// Create a from to add a child for the auth item
	    $form = new CForm('application.modules.rights.views.assignment.assignmentForm', new AssignmentForm);
	    $form->elements['authItem']->items = $selectOptions; // Populate auth items

		// Form is submitted and data is valid, redirect the user
	    if( $form->submitted()===true && $form->validate()===true )
		{
			// Update and redirect
			$this->_auth->authManager->assign($form->model->authItem, $model->id);
			$this->redirect(array('assignment/user', 'id'=>$model->id));
		}

		// Render the view
		$this->render('user', array(
			'model'=>$model,
			'form'=>$form,
			'assignedItems'=>$assignedItems,
			'username'=>$this->_auth->usernameColumn,
			'i'=>0,
		));
	}

	public function actionRevoke()
	{
		// We only allow deletion via POST request
		if( Yii::app()->request->isPostRequest===true )
		{
			$this->_auth->authManager->revoke($_GET['name'], $_GET['id']);

			// if AJAX request, we should not redirect the browser
			if( isset($_POST['ajax'])===false )
				$this->redirect(array('assignment/user', 'id'=>$_GET['id']));
		}
		else
		{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}
}
