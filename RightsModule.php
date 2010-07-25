<?php
/**
* Rights module class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @version 0.9.3
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
	* @var string Default roles
	*/
	public $defaultRoles = array('Guest');
	/**
	* @var array Users with access to Rights
	*/
	public $superUsers = array(1=>'admin');
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
	* @var bool Whether to install the module when ran or not?
	*/
	public $install = false;
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

		// Install the module if needed
		if( $this->install===true )
			$this->install();

		// Add the installer and authorizer component needed by this module
		$this->setComponent('auth', new RightsAuthorizer);

		// Set the default roles for the auth manager
		$this->auth->authManager->defaultRoles = $this->defaultRoles;

		// Set the super user, user model and create the permission tree
		$this->auth->superUserRole = $this->superUserRole;
		$this->auth->superUsers = $this->superUsers;
		$this->auth->user = $this->userModel;
		$this->auth->usernameColumn = $this->usernameColumn;

		// Publish the module's assets folder
		$assetPath = Yii::app()->assetManager->publish(dirname(__FILE__).DIRECTORY_SEPARATOR.'assets', false, -1, true);

		// Register jQuery and necessary scripts and styles
		$app = Yii::app();
		$app->clientScript->registerCoreScript('jquery');
		$app->clientScript->registerScriptFile($assetPath.'/js/rights.js');
		$app->clientScript->registerCssFile($assetPath.'/css/rights.css');

		// Set the default controller
		$this->defaultController = 'main';
	}

	/**
	* Installs Rights.
	*/
	public function install()
	{
		$this->setComponent('installer', new RightsInstaller);
		$installer = $this->getComponent('installer');
		$installer->install($this->defaultRoles, $this->superUserRole, $this->superUsers);
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
		return '0.9.3';
	}
}
