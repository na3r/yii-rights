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
	* @property CDbConnection
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
						$sql = "INSERT INTO {$itemTable} (name, type, data)
							VALUES (:name, :type, :data)";
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
	* FIXME: Rewrite with directory iteratiors.
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
					preg_match('/public[ \t]+function[ \t]+action([A-Z]{1}[a-zA-Z0-9]+)[ \t]*\(/', $line, $matches);
					if( $matches!==array() )
					{
						$actions[ strtolower($matches[1]) ] = array(
							'name'=>$matches[1],
							'line'=>$lineNumber
						);
					}
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
		$controllers = $this->getControllersInPath($basePath.DIRECTORY_SEPARATOR.'controllers');
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

		if( file_exists($path)===true )
		{
			$dir = opendir($path);
			while( ($entry = readdir($dir))!==false )
			{
				if( $entry[0]!=='.' )
				{
					$entryPath = $path.DIRECTORY_SEPARATOR.$entry;
					if( strpos(strtolower($entry), 'controller')!==false )
					{
						$controllers['controllers'][ substr(strtolower($entry), 0, -14) ] = array(
							'file'=>$entry,
							'path'=>$entryPath,
						);
					}

					if( is_dir($entryPath)===true )
						foreach( $this->getControllersInPath($entryPath) as $k=>$v )
							$controllers[ $k ] = $v;
				}
			}
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
				if( $entry[0]!=='.' && $entry!=='rights' )
				{
					$subModulePath = $modulePath.DIRECTORY_SEPARATOR.$entry;
					if( file_exists($subModulePath)===true )
					{
						if( ($moduleControllers = $this->getControllersInPath($subModulePath.DIRECTORY_SEPARATOR.'controllers'))!==array() )
							$controllers[ $entry ] = $moduleControllers;

						$controllers[ $entry ]['modules'] = $this->getControllersInModules($subModulePath);
					}
				}
			}
		}

		return $controllers;
	}
}
