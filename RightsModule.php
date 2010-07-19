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
	public $superUser			= 'Admin';		// Super user name
	public $userModel			= 'User';		// User model class name
	public $usernameColumn		= 'username';	// Name of the username column
	public $enableBizRule		= true;			// Enable business rules?
	public $enableBizRuleData	= false;		// Enable data for business rules?

	private $_assetPath;

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

		// Set the super user, user model and create the permission tree
		$this->auth->superUser = $this->superUser;
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
