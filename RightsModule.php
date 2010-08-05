<?php
/**
* Rights module class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @version 0.9.8
*/
class RightsModule extends CWebModule
{
	/**
	* @var string the name of the role with superuser priviledges.
	*/
	public $superuserRole = 'Admin';
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
	public $userNameColumn = 'username';
	/**
	* @var boolean whether to enable business rules.
	*/
	public $enableBizRule = true;
	/**
	* @var boolean whether to enable data for business rules.
	*/
	public $enableBizRuleData = false;
	/**
	* @var string the style sheet file to use for Rights.
	*/
	public $cssFile;
	/**
	* @var string path to the layout file to use for displaying Rights.
	*/
	public $layout;

	private $_assetsUrl;

	/**
	* Initializes the "rights" module.
	*/
	public function init()
	{
		// Set required classes for import
		$this->setImport(array(
			'rights.models.*',
			'rights.components.*',
			'rights.controllers.*',
		));

		// Set the components component
		$this->setComponents(array(
			'authorizer'=>array(
				'class'=>'RightsAuthorizer',
				'superuserRole'=>$this->superuserRole,
				'defaultRoles'=>$this->defaultRoles,
				'user'=>$this->userClass,
				'userNameColumn'=>$this->userNameColumn,
			),
			'installer'=>array(
				'class'=>'RightsInstaller',
				'superuserRole'=>$this->superuserRole,
				'defaultRoles'=>$this->defaultRoles,
			),
			'generator'=>array(
				'class'=>'RightsGenerator',
			),
		));

		// Register the scripts
		$this->registerScripts();

		// Default layout is used unless one is provided
		if( $this->layout===null )
			$this->layout = 'rights.views.layouts.rights';
	}

	/**
	* Registers the necessary scripts.
	*/
	public function registerScripts()
	{
		// Publish the necessary paths
		$app = Yii::app();
		$assetsUrl = $this->getAssetsUrl();
		$juiUrl = $app->getAssetManager()->publish(Yii::getPathOfAlias('zii.vendors.jui'));

		// Register the necessary scripts
		$cs = $app->getClientScript();
		$cs->registerCoreScript('jquery');
		$cs->registerScriptFile($juiUrl.'/js/jquery-ui.min.js');
		$cs->registerScriptFile($assetsUrl.'/js/rights.js');

		// Make sure we want to register a style sheet
		if( $this->cssFile!==false )
		{
			// Default style sheet is used unless one is provided
			if( $this->cssFile===null )
				$this->cssFile = $assetsUrl.'/css/rights.css';
			else
				$this->cssFile = Yii::app()->request->baseUrl.$this->cssFile;

			// Register the style sheet
			$cs->registerCssFile($this->cssFile);
		}
	}

	/**
	* @return string the base URL that contains all published asset files of Rights.
	*/
	public function getAssetsUrl()
	{
		if( $this->_assetsUrl===null )
			$this->_assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('rights.assets'), false, -1, true);

		return $this->_assetsUrl;
	}

	/**
	* @return RightsAuthorizer the authorizer component
	*/
	public function getAuthorizer()
	{
		return $this->getComponent('authorizer');
	}

	/**
	* @return RightsInstaller the installer component
	*/
	public function getInstaller()
	{
		return $this->getComponent('installer');
	}

	/**
	* @return RightsGenerator the generator component
	*/
	public function getGenerator()
	{
		return $this->getComponent('generator');
	}

	/**
	* @return the current version
	*/
	public function getVersion()
	{
		return '0.9.8';
	}
}
