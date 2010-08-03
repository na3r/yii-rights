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
	* Installs the module.
	*/
	public function actionInstall()
	{
		// Get the installer and authorizer
		$installer = $this->getModule()->getInstaller();

		// Make sure rights is not already installed
		if( $installer->isInstalled()===false )
		{
			// Redirect to generate if install is succeeds
			if( $installer->run()===true )
				$this->redirect($this->createUrl('setup/installReady'));

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

	/**
	* Displays the install ready page.
	*/
	public function actionInstallReady()
	{
		$this->render('installReady');
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
					Yii::app()->getUser()->setFlash('rightsSuccess',
						Yii::t('RightsModule.setup', 'Created :items.', array(':items'=>implode(', ', $generatedItems)))
					);
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
