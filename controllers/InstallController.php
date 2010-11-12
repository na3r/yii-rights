<?php
/**
* Rights installation controller class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.9.8
*/
class InstallController extends RightsBaseController
{
	/**
	* @property RightsAuthorizer
	*/
	private $_authorizer;
	/**
	* @property RightsInstaller
	*/
	private $_installer;

	/**
	* Initializes the controller.
	*/
	public function init()
	{
		if( $this->module->install!==true )
			$this->redirect(Yii::app()->homeUrl);

		$this->_authorizer = $this->module->getAuthorizer();
		$this->_installer = $this->module->getInstaller();
		$this->layout = $this->module->layout;
		$this->defaultAction = 'run';

		// Register the scripts
		$this->module->registerScripts();
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
	* Dislays the confirm overwrite page.
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
			// Get the application web user
			$user = Yii::app()->getUser();

			// Make sure the web user extends RightsWebUser
			if( $user instanceof RightsWebUser )
			{
				// Make sure that the module is not already installed
				if( isset($_GET['confirm'])===true || $this->_installer->isInstalled===false )
				{
					// Run the installer and check for an error
					if( $this->_installer->run(true)===true )
					{
						// Make the logged in user as a superuser
						$user->setIsSuperuser(true);

						// Redirect to generate if install is succeeds
						$this->redirect(array('install/ready'));
					}

					// Set an error message
					$user->setFlash($this->module->flashErrorKey,
						Rights::t('install', 'Installation failed.')
					);

					// Redirect to Rights default action
					$this->redirect(Yii::app()->homeUrl);
				}
				// Module is already installed
				else
				{
					// Redirect to to the confirm overwrite page
					$this->redirect(array('install/confirm'));
				}
			}
			// Web user does not extend RightsWebUser
			else
			{
				throw new CException(Rights::t('install', 'Application web user must extend RightsWebUser.'));
			}
		}
		// User is guest, deny access
		else
		{
			throw new CHttpException(403, Rights::t('install', 'You must be logged in to install Rights.'));
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
