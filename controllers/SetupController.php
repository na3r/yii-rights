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
		$isInstalled = $installer->isInstalled;

		// Create the install form
		$form = new CForm(array(
			'elements'=>array(
				'overwrite'=>array(
					'type'=>'checkbox',
					'visible'=>$isInstalled===true,
				),
			),
			'buttons'=>array(
				'submit'=>array(
					'type'=>'submit',
					'label'=>Yii::t('RightsModule.setup', 'Install'),
				),
			),
		), new InstallForm);

		// Form is submitted and valid
		if( $form->submitted()===true && $form->validate()===true && $form->model->canInstall()===true )
		{
			// Run the installer and redirect
			$installer->run($form->model->overwrite);
			$this->redirect(array('setup/installReady'));
		}

		// Render the view
		$this->render('install', array(
			'form'=>$form,
			'isInstalled'=>$isInstalled,
		));
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
				}
			}
		}

		// We need operation names lowercase for comparason
		$ops = $authorizer->getAuthItems(CAuthItem::TYPE_OPERATION);
		$operations = array();
		foreach( $ops as $name=>$item )
			$operations[ strtolower($name) ] = $item;

		// Render the view
		$this->render('generate', array(
			'model'=>$model,
			'items'=>$generator->getControllerActions(),
			'operations'=>$operations,
		));
	}
}
