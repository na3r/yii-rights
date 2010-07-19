<?php
/**
* Rights helper class file.
*
* Provides static functions for interaction with Rights outside of the module.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.9.1
*/
class Rights
{
	const PERM_NONE = 0;		// Access denied
	const PERM_DIRECT = 1;		// Non-inherited permission
	const PERM_INHERIT = 2;		// Inherited permission

	/**
	* @var array Valid auth item types
	*/
	public static $authItemTypes = array(
		CAuthItem::TYPE_OPERATION=>'operation',
		CAuthItem::TYPE_TASK=>'task',
		CAuthItem::TYPE_ROLE=>'role',
	);

	/**
	* Assigns an auth item to the given user.
	* @param mixed $itemName Name of the auth item to assign
	* @param mixed $userId User id for user to assign the item to
	* @param mixed $bizRule Business rule
	* @param mixed $data Business rule data
	* @return CAuthItem
	*/
	public static function assign($itemName, $userId, $bizRule=NULL, $data=NULL)
	{
		$auth = self::getAuth();
		return $auth->authManager->assign($itemName, $userId, $bizRule, $data);
	}

	/**
	* Revokes an auth item from the given user.
	* @param string $itemName Name of the auth item to revoke
	* @param mixed $userId User id for user to revoke the item from
	* @return bool Was revoke successful?
	*/
	public static function revoke($itemName, $userId)
	{
		$auth = self::getAuth();
		return $auth->authManager->assign($itemName, $userId);
	}

	/**
	* Gets the given module configuration variable.
	* @param string $name Name of the variable to get
	* @return mixed Variable value
	*/
	public static function getConfig($name)
	{
		$module = Yii::app()->getModule('rights');
		if( isset($module->$name)===true )
			return $module->$name;

		return NULL;
	}

	/**
	* Gets the auth item type select options.
	* @return array Select options
	*/
	public static function getAuthItemTypeSelectOptions()
	{
	 	$selectOptions = array();
	 	foreach( Rights::$authItemTypes as $key=>$type )
	 		$selectOptions[ $key ] = ucfirst($type);

	 	return $selectOptions;
	}

	/**
	* Gets the valid auth item types for the given type.
	* Used to avoid impossible assignments.
	* @param string $type Authorization item type
	* @return array Valid types
	*/
	public static function getValidChildTypes($type)
	{
	 	switch( (int)$type )
		{
			case CAuthItem::TYPE_ROLE: return array('role', 'task', 'operation');
			case CAuthItem::TYPE_TASK: return array('task', 'operation');
			case CAuthItem::TYPE_OPERATION: return array('operation');
			default: throw new CException('Invalid authorization item type.');
		}
	}

	/**
	* Gets the auth item type as a string.
	* @param integer Auth item type as integer
	* @return string Auth item type
	*/
	public static function getAuthItemTypeString($type)
	{
		switch( (int)$type )
		{
			case CAuthItem::TYPE_OPERATION: return Yii::t('rights', 'operation');
			case CAuthItem::TYPE_TASK: return Yii::t('rights', 'task');
			case CAuthItem::TYPE_ROLE: return Yii::t('rights', 'role');
			default: throw new CException('Invalid authorization item type.');
		}
	}

	/**
	* Gets the auth item type by string.
	* @param string $string Auth item name
	* @return integer Auth item type
	*/
	public static function getAuthItemTypeByString($string)
	{
		switch( $string )
		{
			case 'operation': return CAuthItem::TYPE_OPERATION;
			case 'task': return CAuthItem::TYPE_TASK;
			case 'role': return CAuthItem::TYPE_ROLE;
			default: throw new CException('Invalid authorization item type.');
		}
	}

	/**
	* @return RightsModule
	*/
	public static function getModule()
	{
		return Yii::app()->getModule('rights');
	}

	/**
	* @return RightsAuthorizer component
	*/
	public static function getAuth()
	{
		$module = self::getModule();
		return $module->getComponent('auth');
	}
}
