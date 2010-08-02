<?php
/**
* Rights authorization item controller class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.5
*/
class AuthItemController extends Controller
{
	/**
	* @var RightsAuthorizer
	*/
	private $_authorizer;

	/**
	* @var CAuthItem the currently loaded data model instance.
	*/
	private $_model;

	/**
	* Initializes the controller.
	*/
	public function init()
	{
		$this->_authorizer = $this->getModule()->getAuthorizer();
		$this->layout = Rights::getConfig('layout');
		$this->defaultAction = 'create';
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
			array('allow', // Allow super users to access Rights
				'actions'=>array(
					'create',
					'update',
					'delete',
					'removeChild',
					'assign',
					'revoke',
					'processSortable',
				),
				'users'=>$this->_authorizer->getSuperUsers(),
			),
			array('deny', // Deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	* Creates an authorization item.
	*/
	public function actionCreate()
	{
		// Create the auth item form
	    $form = new CForm('rights.views.authItem.authItemForm', new AuthItemForm('create'));

	    // Form is submitted and data is valid, redirect the user
	    if( $form->submitted()===true && $form->validate()===true )
		{
			// Make sure that an item with the name does not already exist
			if( $this->_authorizer->authManager->getAuthItem($form->model->name)===null )
			{
				// Create item, set success message and redirect
				$this->_authorizer->createAuthItem($form->model->name, $form->model->type, $form->model->description, $form->model->bizRule, $form->model->data);
				Yii::app()->user->setFlash('rightsSuccess', Yii::t('RightsModule.tr', ':name created.', array(':name'=>Rights::beautifyName($form->model->name))));
				$this->redirect(array('authItem/update', 'name'=>$form->model->name));
			}

			// Auth item already exists, add a message
			Yii::app()->user->setFlash('rightsError',
				Yii::t('RightsModule.tr', 'Could not create :name, item already exists.', array(
					':name'=>Rights::beautifyName($form->model->name))
				)
			);
		}

		// Render the view
		$this->render('create', array(
			'form'=>$form,
		));
	}

	/**
	* Updates an authorization item.
	*/
	public function actionUpdate()
	{
		// Get the authorization item
		$model = $this->loadModel();

		// Create the auth item form
	    $form = new CForm('rights.views.authItem.authItemForm', new AuthItemForm('update'));

		// Form is submitted and data is valid
		if( $form->submitted()===true && $form->validate()===true )
		{
			// Check if name has been changed, if so make sure that an item with that name does not already exist
			if( $_GET['name']===$form->model->name || ($_GET['name']!==$form->model->name && $this->_authorizer->authManager->getAuthItem($form->model->name)===null) )
			{
				// Update item, set success message and redirect
				$this->_authorizer->updateAuthItem($_GET['name'], $form->model->name, $form->model->description, $form->model->bizRule, $form->model->data);
				Yii::app()->user->setFlash('rightsSuccess', Yii::t('RightsModule.tr', ':name updated.', array(':name'=>Rights::beautifyName($form->model->name))));
				$this->redirect(array(isset($_GET['redirect'])===true ? urldecode($_GET['redirect']) : 'rights/default/permissions'));
			}

			// An item with the new name already exists, set an error message
			Yii::app()->user->setFlash('rightsError',
				Yii::t('RightsModule.tr', 'Could not rename :oldName to :name, an item with that name already exists.', array(
					':oldName'=>Rights::beautifyName($_GET['name']),
					':name'=>Rights::beautifyName($form->model->name)
				))
			);
		}

		// Create a form to add children to the auth item
		$childForm = null;
		$selectOptions = $this->_authorizer->getAuthItemSelectOptions($model->type, $model);
		if( count($selectOptions)>0 )
		{
			// Create the child form
		    $childForm = new CForm('rights.views.authItem.authChildForm', new AuthChildForm);
		    $childForm->elements['name']->items = $selectOptions; // Populate name items

			// Child form is submitted and data is valid
			if( $childForm->submitted()===true && $childForm->validate()===true )
			{
				// Add child, set success message and redirect to the same page
				$this->_authorizer->authManager->addItemChild($_GET['name'], $childForm->model->name);
				Yii::app()->user->setFlash('rightsSuccess', Yii::t('RightsModule.tr', 'Child :name added.', array(':name'=>Rights::beautifyName($childForm->model->name))));
				$this->redirect(array('authItem/update', 'name'=>$_GET['name']));
			}
		}

		// Set the values for the form fields
		$form->model->name = $model->name;
		$form->model->description = $model->description;
		$form->model->type = $model->type;
		$form->model->bizRule = $model->bizRule!=='NULL' ? $model->bizRule : '';
		$form->model->data = $model->data!==null ? serialize($model->data) : '';

		// Render the view
		$this->render('update', array(
			'model'=>$model,
			'children'=>$this->_authorizer->getAuthItemChildren($model, true),
			'parents'=>$this->_authorizer->getAuthItemParents($model->name),
			'form'=>$form,
			'childForm'=>$childForm,
		));
	}

	/**
	 * Deletes an operation.
	 */
	public function actionDelete()
	{
		// We only allow deletion via POST request
		if( Yii::app()->request->isPostRequest===true )
		{
			$this->_authorizer->authManager->removeAuthItem($_GET['name']);

			Yii::app()->user->setFlash('rightsSuccess',
				Yii::t('RightsModule.tr', ':name deleted.', array(':name'=>Rights::beautifyName($_GET['name'])))
			);

			// if AJAX request, we should not redirect the browser
			if( isset($_POST['ajax'])===false )
				$this->redirect(array(isset($_GET['redirect'])===true ? urldecode($_GET['redirect']) : 'rights/default/permissions'));
		}
		else
		{
			throw new CHttpException(400, Yii::t('RightsModule.tr', 'Invalid request. Please do not repeat this request again.'));
		}
	}

	/**
	* Removes a child from an authorization item.
	*/
	public function actionRemoveChild()
	{
		// We only allow deletion via POST request
		if( Yii::app()->request->isPostRequest===true )
		{
			$this->_authorizer->authManager->removeItemChild($_GET['name'], $_GET['child']);

			Yii::app()->user->setFlash('rightsSuccess',
				Yii::t('RightsModule.tr', 'Child :name removed.', array(':name'=>Rights::beautifyName($_GET['child'])))
			);

			// if AJAX request, we should not redirect the browser
			if( isset($_POST['ajax'])===false )
				$this->redirect(array('authItem/update', 'name'=>$_GET['name']));
		}
		else
		{
			throw new CHttpException(400, Yii::t('RightsModule.tr', 'Invalid request. Please do not repeat this request again.'));
		}
	}

	/**
	* Adds a child to an authorization item.
	*/
	public function actionAssign()
	{
		// We only allow deletion via POST request
		if( Yii::app()->request->isPostRequest===true )
		{
			$model = $this->loadModel();

			if( isset($_GET['child'])===true && $model->hasChild($_GET['child'])===false )
				$model->addChild($_GET['child']);

			// if AJAX request, we should not redirect the browser
			if( isset($_POST['ajax'])===false )
				$this->redirect(array('rights/default/permissions'));
		}
		else
		{
			throw new CHttpException(400, Yii::t('RightsModule.tr', 'Invalid request. Please do not repeat this request again.'));
		}
	}

	/**
	* Removes a child from an authorization item.
	*/
	public function actionRevoke()
	{
		// We only allow deletion via POST request
		if( Yii::app()->request->isPostRequest===true )
		{
			$model = $this->loadModel();

			if( isset($_GET['child'])===true && $model->hasChild($_GET['child'])===true )
				$model->removeChild($_GET['child']);

			// if AJAX request, we should not redirect the browser
			if( isset($_POST['ajax'])===false )
				$this->redirect(array('rights/default/permissions'));
		}
		else
		{
			throw new CHttpException(400, Yii::t('RightsModule.tr', 'Invalid request. Please do not repeat this request again.'));
		}
	}

	public function actionProcessSortable()
	{
		// We only allow sorting via POST request
		if( Yii::app()->request->isPostRequest===true )
		{
			$this->_authorizer->authManager->updateItemWeights($_POST['result']);
		}
		else
		{
			throw new CHttpException(400, Yii::t('RightsModule.tr', 'Invalid request. Please do not repeat this request again.'));
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if( $this->_model===null )
		{
			if( isset($_GET['name'])===true )
				$this->_model = $this->_authorizer->authManager->getAuthItem($_GET['name']);

			if( $this->_model===null )
				throw new CHttpException(404, Yii::t('RightsModule.tr', 'The requested page does not exist.'));
		}

		return $this->_model;
	}
}
