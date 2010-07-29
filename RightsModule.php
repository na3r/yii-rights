<?php
/**
* Rights module class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @version 0.9.7
*/
class RightsModule extends CWebModule
{
	/**
	* @var string the name of the role with super user priviledges.
	*/
	public $superUserRole = 'Admin';
	/**
	* @var array list of default roles.
	*/
	public $defaultRoles = array('Guest');
	/**
	* @var string the name of the user model class.
	*/
	public $userClass = 'User';
	/**
	* @var string the name of the username column in the user table.
	*/
	public $usernameColumn = 'username';
	/**
	* @var boolean whether to enable business rules or not.
	*/
	public $enableBizRule = true;
	/**
	* @var boolean whether to enable data for business rules or not.
	*/
	public $enableBizRuleData = false;
	/**
	* @var boolean whether to enable organization of authorization items.
	*/
	public $enableWeights = true;
	/**
	* @var boolean whether to install the module when ran or not?
	*/
	public $install = false;
	/**
	* @var string the style sheet file to use for Rights.
	*/
	public $cssFile;
	/**
	* @var string path to the layout file to use for displaying Rights.
	*/
	public $layout;

	/**
	* Initializes the module.
	*/
	public function init()
	{
		// Set required classes for import
		$this->setImport(array(
			'rights.models.*',
			'rights.components.*',
			'rights.controllers.*',
		));

		// Run the installer if necessary
		if( $this->install!==false  )
			$this->runInstaller();

		// Set the authorizer component
		$this->setComponent('authorizer', new RightsAuthorizer);
		$authorizer = $this->getAuthorizer();
		$authorizer->getAuthManager()->defaultRoles = $this->defaultRoles;
		$authorizer->superUserRole = $this->superUserRole;
		$authorizer->user = $this->userClass;
		$authorizer->usernameColumn = $this->usernameColumn;

		// Publish the necessary paths
		$app = Yii::app();
		$am = $app->getAssetManager();
		$assetPath = $am->publish(Yii::getPathOfAlias('rights.assets'), false, -1, true);
		$juiPath = $am->publish(Yii::getPathOfAlias('zii.vendors.jui'));

		// Register the necessary scripts
		$cs = $app->getClientScript();
		$cs->registerCoreScript('jquery');
		$cs->registerScriptFile($juiPath.'/js/jquery-ui.min.js');
		$cs->registerScriptFile($assetPath.'/rights.js');

		// Default style sheet is used unless one is provided
		if( $this->cssFile===null )
			$this->cssFile = $assetPath.'/rights.css';

		// Register the style sheet
		$cs->registerCssFile($this->cssFile);

		// Default layout is used unless one is provided
		if( $this->layout===null )
			$this->layout = 'application.views.layouts.column1';

		// Set the default controller
		$this->defaultController = 'main';
	}

	/**
	* Runs the installer component.
	*/
	public function runInstaller()
	{
		$config = $this->install;
		if( $config===(array)$config )
		{
			$superUsers = isset($config['superUsers'])===true ? $config['superUsers'] : array();
			$overwrite = isset($config['overwrite'])===true ? $config['overwrite'] : false;
			$this->setComponent('installer', new RightsInstaller);
			$installer = $this->getComponent('installer');
			$installer->run($this->superUserRole, $this->defaultRoles, $superUsers, $this->enableWeights, $overwrite);
		}
		else
		{
		 	throw new CException('Install property has to be an array of configurations.');
		}
	}

	/**
	* @return RightsAuthorizer the authorizer component
	*/
	public function getAuthorizer()
	{
		return $this->getComponent('authorizer');
	}

	/**
	* @return the current version
	*/
	public function getVersion()
	{
		return '0.9.7';
	}
}
