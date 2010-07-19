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
		$users = $this->_auth->getUsers();
		$authAssignments = $this->_auth->getUserAuthAssignments(array_keys($users));

		// Render the view
		$this->render('view', array(
			'users'=>$users,
			'username'=>$this->_auth->usernameColumn,
			'authAssignments'=>$authAssignments,
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
		$assignmentSelectOptions = $this->_auth->getAuthItemSelectOptions();

		// Unset the already assigned items
		foreach( $assignedItems as $itemName )
			if( isset($assignmentSelectOptions[ $itemName ])===true )
				unset($assignmentSelectOptions[ $itemName ]);

		// Create a from to add a child for the auth item
	    $form = new CForm(array(
		    'elements'=>array(
		        'authItem'=>array(
		            'type'=>'dropdownlist',
		            'items'=>$assignmentSelectOptions,
		        ),
		    ),
		    'buttons'=>array(
		        'submit'=>array(
		            'type'=>'submit',
		            'label'=>Yii::t('rights', 'Assign'),
		        ),
		    ),
		), new AssignmentForm);

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
			'auth'=>$this->_auth,
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
