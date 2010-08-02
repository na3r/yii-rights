<?php
/**
* Rights generator component class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.9.8
*/
class RightsGenerator extends CApplicationComponent
{
	private $_authManager;
	private $_items;

	/**
	* @var CDbConnection
	*/
	public $db;

	/**
	* Initializes the generator.
	*/
	public function init()
	{
		parent::init();

		$this->_authManager = Yii::app()->getAuthManager();
		$this->db = $this->_authManager->db;
	}

	/**
	* Runs the generator.
	* @return the items generated or false if failed.
	*/
	public function run()
	{
		$authManager = $this->_authManager;
		$itemTable = $authManager->itemTable;

		// Start transaction
		$txn = $this->db->beginTransaction();

		try
		{
			$generatedItems = array();

			// Loop through each type of items
			foreach( $this->_items as $type=>$items )
			{
				// Loop through items
				foreach( $items as $name )
				{
					// Make sure the item does not already exist
					if( $authManager->getAuthItem($name)===null )
					{
						// Insert item
						$sql = "insert into {$itemTable} (name, type, data) ";
						$sql.= "values (:name, :type, :data)";
						$command = $this->db->createCommand($sql);
						$command->bindValue(':name', $name);
						$command->bindValue(':type', $type);
						$command->bindValue(':data', 'N;');
						$command->execute();

						$generatedItems[] = $name;
					}
				}
			}

			// All commands executed successfully, commit
			$txn->commit();
			return $generatedItems;
		}
		catch( CDbException $e )
		{
			// Something went wrong, rollback
			$txn->rollback();
			return false;
		}
	}

	/**
	* Appends items to be generated of a specific type.
	* @param array the items to be generated.
	* @param integer the item type.
	*/
	public function addItems($items, $type)
	{
		if( isset($this->_items[ $type ])===false )
			$this->_items[ $type ] = array();

		foreach( $items as $itemname )
			$this->_items[ $type ][] = $itemname;
	}

	/**
	* Returns all the controllers and their actions.
	* @param array the controllers and actions.
	*/
	public function getControllerActions($controllers=null)
	{
		if( $controllers===null )
			$controllers = $this->getAllControllers();

		foreach( $controllers as $key=>$c )
		{
			if( $key!=='modules' && isset($c['path'])===true )
			{
				$actions = array();
				$file = fopen($c['path'], 'r');
				$lineNumber = 0;
				while( feof($file)===false )
				{
					++$lineNumber;
					$line = fgets($file);
					preg_match('/public function action([A-Z]{1}[a-zA-Z]+)\(\)/', $line, $matches);
					if( $matches!==array() )
						$actions[] = array('name'=>$matches[1], 'line'=>$lineNumber);
				}

				$controllers[ $key ]['actions'] = $actions;
			}
			else
			{
				$controllers[ $key ] = $this->getControllerActions($c);
			}
		}

		return $controllers;
	}

	/**
	* Returns a list of all application controllers.
	* @return array the controllers.
	*/
	protected function getAllControllers()
	{
		$basePath = Yii::app()->basePath;
		$controllers = $this->getControllersInPath($basePath);
		$controllers['modules'] = $this->getControllersInModules($basePath);
		return $controllers;
	}

	/**
	* Returns all controllers under the specified path.
	* @param array the controllers.
	*/
	protected function getControllersInPath($path)
	{
		$controllers = array();

		$controllerPath = $path.DIRECTORY_SEPARATOR.'controllers';
		if( file_exists($controllerPath)===true )
		{
			$dir = opendir($controllerPath);
			while( ($filename = readdir($dir))!==false )
				if( strpos(strtolower($filename), 'controller')!==false )
					$controllers[ substr($filename, 0, -14) ] = array(
						'file'=>$filename,
						'path'=>$controllerPath.DIRECTORY_SEPARATOR.$filename
					);
		}

		return $controllers;
	}

	/**
	* Returns all the controllers under the specified path.
	* @param array the controllers.
	*/
	protected function getControllersInModules($path)
	{
		$controllers = array();

		$modulePath = $path.DIRECTORY_SEPARATOR.'modules';
		if( file_exists($modulePath)===true )
		{
			$dir = opendir($modulePath);
			while( ($entry = readdir($dir))!==false )
			{
				if( $entry!='.' && $entry!='..' && $entry!='rights' )
				{
					$subModulePath = $modulePath.DIRECTORY_SEPARATOR.$entry;
					if( file_exists($subModulePath)===true )
					{
						if( ($moduleControllers = $this->getControllersInPath($subModulePath))!==array() )
							$controllers[ $entry ] = $moduleControllers;

						if( ($subModuleControllers = $this->getControllersInModules($subModulePath))!==array() )
							$controllers[ $entry ]['modules'] = $subModuleControllers;
					}
				}
			}
		}

		return $controllers;
	}
}
