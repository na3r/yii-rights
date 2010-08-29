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
	* @var RightsModule
	*/
	private $_module;
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
		$this->_module = $this->getModule();
		$this->_authorizer = $this->_module->getAuthorizer();
		$this->layout = $this->_module->layout;
		$this->defaultAction = 'create';

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
					'create',
					'update',
					'delete',
					'generate',
					'removeChild',
					'assign',
					'revoke',
					'processSortable',
				),
				'users'=>$this->_authorizer->getSuperusers(),
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
		// Make sure that we have a type
		if( isset($_GET['type'])===true )
		{
			// Create the authorization item form
		    $form = new CForm('rights.views.authItem.authItemForm', new AuthItemForm('create'));

		    // Form is submitted and data is valid, redirect the user
		    if( $form->submitted()===true && $form->validate()===true )
			{
				// Create item, set success message and redirect
				$this->_authorizer->createAuthItem($form->model->name, $_GET['type'], $form->model->description, $form->model->bizRule, $form->model->data);
				Yii::app()->user->setFlash($this->_module->flashSuccessKey,
					Yii::t('RightsModule.core', ':name created.', array(':name'=>Rights::beautifyName($form->model->name)))
				);
				$this->redirect(array('authItem/update', 'name'=>$form->model->name));
			}
		}
		else
		{
			throw new CHttpException(404, Yii::t('RightsModule.core', 'Invalid authorization item type.'));
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

		// Create the authorization item form
	    $form = new CForm('rights.views.authItem.authItemForm', new AuthItemForm('update'));

		// Form is submitted and data is valid
		if( $form->submitted()===true && $form->validate()===true )
		{
			// Update item, set success message and redirect
			$this->_authorizer->updateAuthItem($_GET['name'], $form->model->name, $form->model->description, $form->model->bizRule, $form->model->data);
			Yii::app()->user->setFlash($this->_module->flashSuccessKey,
				Yii::t('RightsModule.core', ':name updated.', array(':name'=>Rights::beautifyName($form->model->name)))
			);
			$this->redirect(array(isset($_GET['redirect'])===true ? urldecode($_GET['redirect']) : 'default/permissions'));
		}

		// Create a form to add children to the authorization item
		$validTypes = Rights::getValidChildTypes($model->type);
		$exclude = array($this->_authorizer->superuserName);
		$selectOptions = $this->_authorizer->getAuthItemSelectOptions($validTypes, null, $model, true, $exclude);
		if( $selectOptions!==array() )
		{
			// Create the child form
		    $childForm = new CForm('rights.views.authItem.authChildForm', new AuthChildForm);
		    $childForm->elements['name']->items = $selectOptions; // Populate name items

			// Child form is submitted and data is valid
			if( $childForm->submitted()===true && $childForm->validate()===true )
			{
				// Add child, set success message and redirect to the same page
				$this->_authorizer->authManager->addItemChild($_GET['name'], $childForm->model->name);
				Yii::app()->user->setFlash($this->_module->flashSuccessKey,
					Yii::t('RightsModule.core', 'Child :name added.', array(':name'=>Rights::beautifyName($childForm->model->name)))
				);
				$this->redirect(array('authItem/update', 'name'=>$_GET['name']));
			}
		}
		else
		{
			$childForm = null;
		}

		// Set the values for the form fields
		$form->model->name = $model->name;
		$form->model->description = $model->description;
		$form->model->type = $model->type;
		$form->model->bizRule = $model->bizRule!=='NULL' ? $model->bizRule : '';
		$form->model->data = $model->data!==null ? serialize($model->data) : '';

		$parentDataProvider = new RightsAuthItemParentDataProvider($model);
		$childDataProvider = new RightsAuthItemChildDataProvider($model);

		// Render the view
		$this->render('update', array(
			'model'=>$model,
			'parentDataProvider'=>$parentDataProvider,
			'childDataProvider'=>$childDataProvider,
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

			Yii::app()->user->setFlash($this->_module->flashSuccessKey,
				Yii::t('RightsModule.core', ':name deleted.', array(':name'=>Rights::beautifyName($_GET['name'])))
			);

			// if AJAX request, we should not redirect the browser
			if( isset($_POST['ajax'])===false )
				$this->redirect(array(isset($_GET['redirect'])===true ? urldecode($_GET['redirect']) : 'default/permissions'));
		}
		else
		{
			throw new CHttpException(400, Yii::t('RightsModule.core', 'Invalid request. Please do not repeat this request again.'));
		}
	}

	/**
	* Displays the generator page.
	*/
	public function actionGenerate()
	{
		// Get the generator and authorizer
		$generator = $this->_module->getGenerator();

		// Createh the form model
		$model = Yii::createComponent('rights.models.GenerateForm');

		// Form has been submitted
		if( isset($_POST['GenerateForm'])===true )
		{
			// Form is valid
			$model->attributes = $_POST['GenerateForm'];
			if( $model->validate()===true )
			{
				// Get the chosen items
				$items = array();
				foreach( $model->items as $itemname=>$value )
					if( (bool)$value===true )
						$items[] = $itemname;

				// Add the items to the generator as operations and run the generator
				$generator->addItems($items, CAuthItem::TYPE_OPERATION);
				if( ($generatedItems = $generator->run())!==false && $generatedItems!==array() )
				{
					Yii::app()->getUser()->setFlash($this->_module->flashSuccessKey,
						Yii::t('RightsModule.core', 'Authorization items created.')
					);
					$this->redirect(array('default/permissions'));
				}
			}
		}

		// We need operation names lowercase for comparason
		$existingItems = $this->_authorizer->getAuthItems(CAuthItem::TYPE_OPERATION);

		Yii::app()->clientScript->registerScript('rightsGenerateItemTableSelectRows',
			"jQuery('.generateItemTable').rightsSelectRows();"
		);

		// Render the view
		$this->render('generate', array(
			'model'=>$model,
			'items'=>$generator->getControllerActions(),
			'existingItems'=>$existingItems,
		));
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

			Yii::app()->user->setFlash($this->_module->flashSuccessKey,
				Yii::t('RightsModule.core', 'Child :name removed.', array(':name'=>Rights::beautifyName($_GET['child'])))
			);

			// if AJAX request, we should not redirect the browser
			if( isset($_POST['ajax'])===false )
				$this->redirect(array('authItem/update', 'name'=>$_GET['name']));
		}
		else
		{
			throw new CHttpException(400, Yii::t('RightsModule.core', 'Invalid request. Please do not repeat this request again.'));
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
				$this->redirect(array('default/permissions'));
		}
		else
		{
			throw new CHttpException(400, Yii::t('RightsModule.core', 'Invalid request. Please do not repeat this request again.'));
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
				$this->redirect(array('default/permissions'));
		}
		else
		{
			throw new CHttpException(400, Yii::t('RightsModule.core', 'Invalid request. Please do not repeat this request again.'));
		}
	}

	public function actionProcessSortable()
	{
		// We only allow sorting via POST request
		if( Yii::app()->request->isPostRequest===true )
		{
			$this->_authorizer->authManager->updateItemWeight($_POST['result']);
		}
		else
		{
			throw new CHttpException(400, Yii::t('RightsModule.core', 'Invalid request. Please do not repeat this request again.'));
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
				throw new CHttpException(404, Yii::t('RightsModule.core', 'The requested page does not exist.'));
		}

		return $this->_model;
	}
}
