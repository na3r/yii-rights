<?php
/**
* Rights module class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @version 0.9.1
*/
class RightsModule extends CWebModule
{
	/**
	* Do not change these default values!
	* These can be set in the module config.
	*/
	/**
	* @var string Name of the role with super user priviledges
	*/
	public $superUserRole = 'Admin';
	/**
	* @var array Users with access to Rights
	*/
	public $superUsers = array('admin');
	/**
	* @var string User model class name
	*/
	public $userModel = 'User';
	/**
	* @var string Name of the username column in the db
	*/
	public $usernameColumn = 'username';
	/**
	* @var bool Enable business rules?
	*/
	public $enableBizRule = true;
	/**
	* @var bool Enable data for business rules?
	*/
	public $enableBizRuleData = false;
	/**
	* @var string Path to layout to use for Rights.
	*/
	public $layout = 'application.views.layouts.column1';

	/**
	* Initialization.
	*/
	public function init()
	{
		// Set required classes for import
		$this->setImport(array(
			'rights.models.*',
			'rights.components.*',
			'rights.controllers.*',
		));

		// Add the authorizer component needed by this module
		$this->setComponent('auth', new RightsAuthorizer);

		// Add the translation component
		/*
	    $this->setComponents(array(
			'i18N'=>array(
				'class'=>'CPhpMessageSource',
				'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'messages',
			),
	    ));
	    */

	    //var_dump($this->i18N->translate('rights', 'Auth Item', 'fi'));

		// Set the super user, user model and create the permission tree
		$this->auth->superUserRole = $this->superUserRole;
		$this->auth->superUsers = $this->superUsers;
		$this->auth->user = $this->userModel;
		$this->auth->usernameColumn = $this->usernameColumn;
		$this->auth->createPermissions();

		// Publish the module's assets folder
		$assetPath = Yii::app()->assetManager->publish(dirname(__FILE__).DIRECTORY_SEPARATOR.'assets');

		// Register jQuery and necessary scripts and styles
		$app = Yii::app();
		$app->clientScript->registerCoreScript('jquery');
		$app->clientScript->registerScriptFile($assetPath.'/rights.js');
		$app->clientScript->registerCssFile($assetPath.'/rights.css');

		// Set the default controller
		$this->defaultController = 'main';
	}

	/**
	* @return RightsAuthorizer component
	*/
	public function getAuth()
	{
		return $this->getComponent('auth');
	}

	/**
	* @return Current version
	*/
	public function getVersion()
	{
		return '0.9.1';
	}
}
