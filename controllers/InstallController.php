<?php
/**
* Rights installation controller class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.9.8
*/
class InstallController extends Controller
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
	* @var RightsInstaller
	*/
	private $_installer;

	/**
	* Initializes the controller.
	*/
	public function init()
	{
		$this->_module = $this->getModule();

		if( $this->_module->install!==true )
			$this->redirect(Yii::app()->homeUrl);

		$this->_authorizer = $this->_module->getAuthorizer();
		$this->_installer = $this->_module->getInstaller();
		$this->layout = $this->_module->layout;
		$this->defaultAction = $this->_installer->isInstalled===true ? 'confirm' : 'run';
	}

	/**
	* @return array action filters
	*/
	public function filters()
	{
		// Use access control when installed
		return $this->_installer->isInstalled===true ? array('accessControl') : array();
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
					'confirm',
					'run',
					'ready',
				),
				'users'=>$this->_authorizer->getSuperusers(),
			),
			array('deny', // Deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	* Dislays the confirm install page.
	*
	*/
	public function actionConfirm()
	{
		$this->render('confirm');
	}

	/**
	* Installs the module.
	*/
	public function actionRun()
	{
		// Make sure the user is not a guest
		if( Yii::app()->user->isGuest===false )
		{
			// Redirect to generate if install is succeeds
			if( $this->_installer->run(true)===true )
				$this->redirect(array('install/ready'));

			// Set an error message
			Yii::app()->getUser()->setFlash($this->_module->flashErrorKey,
				Yii::t('RightsModule.install', 'Installation failed.')
			);

			// Redirect to Rights default action
			$this->redirect(Yii::app()->homeUrl);
		}
		// User is guest, deny access
		else
		{
			throw new CHttpException(403, Yii::t('RightModule.install', 'You must be logged in to install Rights.'));
		}
	}

	/**
	* Displays the install ready page.
	*/
	public function actionReady()
	{
		$this->render('ready');
	}
}
