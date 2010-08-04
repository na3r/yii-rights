<?php
/**
* Rights setup controller class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.9.8
*/
class SetupController extends Controller
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
		$this->defaultAction = 'install';
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
					'ready',
					'generate',
				),
				'users'=>$this->_authorizer->getSuperusers(),
			),
			array('allow', // Allow the install action
				'actions'=>array('install'),
				'users'=>array('*'),
			),
			array('deny', // Deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	* Installs the module.
	*/
	public function actionInstall()
	{
		// Make sure the user is not a guest
		if( Yii::app()->user->isGuest===false )
		{
			// Get the installer and authorizer
			$installer = $this->getModule()->getInstaller();

			// Make sure rights is not already installed
			if( $installer->isInstalled===false )
			{
				// Redirect to generate if install is succeeds
				if( $installer->run()===true )
					$this->redirect($this->createUrl('setup/ready'));

				// Set an error message
				Yii::app()->getUser()->setFlash('rightsError', Yii::t('RightsModule.setup', 'Installation failed.'));
			}
			// Rights is already installed
			else
			{
				// Set an error
				Yii::app()->getUser()->setFlash('rightsError', Yii::t('RightsModule.setup', 'Rights is already installed.'));
			}

			// Redirect to Rights default action
			$this->redirect(Yii::app()->createUrl('rights'));
		}
		// User is guest, deny access
		else
		{
			throw new CHttpException(403, Yii::t('RightModule.setup', 'You must be logged in to install Rights.'));
		}
	}

	/**
	* Displays the install ready page.
	*/
	public function actionReady()
	{
		$this->render('ready');
	}

	/**
	* Displays the generator page.
	*
	*/
	public function actionGenerate()
	{
		// Get the generator and authorizer
		$generator = $this->getModule()->getGenerator();
		$authorizer = $this->getModule()->getAuthorizer();

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
					Yii::app()->getUser()->setFlash('rightsSuccess', Yii::t('RightsModule.setup', 'Authorization items created.'));
					$this->redirect(Yii::app()->createUrl('rights'));
				}
			}
		}

		// We need operation names lowercase for comparason
		$operations = $authorizer->getAuthItems(CAuthItem::TYPE_OPERATION);
		$existingItems = array();
		foreach( $operations as $name=>$item )
			$existingItems[ strtolower($name) ] = $item;

		// Render the view
		$this->render('generate', array(
			'model'=>$model,
			'items'=>$generator->getControllerActions(),
			'existingItems'=>$existingItems,
		));
	}
}
