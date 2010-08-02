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
	* Initializes the controller.
	*/
	public function init()
	{
		$this->layout = Rights::getConfig('layout');
		$this->defaultAction = 'install';
	}

	/**
	* Displays the install page.
	*/
	public function actionInstall()
	{
		// Get the installer and authorizer
		$installer = $this->getModule()->getInstaller();
		$authorizer = $this->getModule()->getAuthorizer();

		// Get all the users and the name of the username column
		$users = $authorizer->user->findAll();
		$usernameColumn = $authorizer->usernameColumn;

		// Create the select options for the super users
		$selectOptions = array();
		foreach( $users as $user )
			$selectOptions[ $user->id ] = $user->$usernameColumn;

		// Create the install form
		$form = new CForm('rights.views.setup.installForm', new InstallForm);
		$form->elements['superUsers']->items = $selectOptions;

		// Form is submitted and valid
		if( $form->submitted()===true && $form->validate()===true )
		{
			// Check if the module is already installed,
			// if so require that the user chooses to overwrite.
			if( $installer->isInstalled===false || $installer->isInstalled===true && (bool)$form->model->overwrite!==false )
			{
				// Configure and run the installer and redirect to the ready page
				$installer->superUsers = $form->model->superUsers;
				$installer->overwrite = (bool)$form->model->overwrite;

				// Installer ran correctly
				if( $installer->run()===true )
				{
					$this->redirect(array('setup/ready'));
				}
				// Installer failed (probably sql error)
				else
				{
					Yii::app()->user->setFlash('rightsError', Yii::t('RightsModule.setup', 'Install failed.'));
				}
			}
			// Module is already installed and the user did not choose to overwrite
			else
			{
				Yii::app()->user->setFlash('rightsError', Yii::t('RightsModule.setup', 'Rights is already installed! To reinstall select "Overwrite".'));
			}
		}

		// Render the view
		$this->render('install', array(
			'form'=>$form,
			'isInstalled'=>$installer->isInstalled,
		));
	}

	/**
	* Displays the install ready page.
	*/
	public function actionReady()
	{
		$this->render('ready');
	}
}
