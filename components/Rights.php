<?php
/**
* Rights class file.
*
* Provides static functions for interaction with Rights from outside of the module.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.9.1
*/
class Rights
{
	const PERM_NONE = 0;
	const PERM_DIRECT = 1;
	const PERM_INHERITED = 2;

	/**
	* @var array the authorization item types
	*/
	public static $authItemTypes = array(
		CAuthItem::TYPE_OPERATION,
		CAuthItem::TYPE_TASK,
		CAuthItem::TYPE_ROLE,
	);

	/**
	* Assigns an authorization item to a specific user.
	* @param string the name of the item to assign.
	* @param integer the user id of the user for which to assign the item.
	* @param string business rule associated with the item. This is a piece of
	* PHP code that will be executed when {@link checkAccess} is called for the item.
	* @param mixed additional data associated with the item.
	* @return CAuthItem the authorization item
	*/
	public static function assign($itemName, $userId, $bizRule=null, $data=null)
	{
		$authorizer = self::getAuthorizer();
		return $authorizer->authManager->assign($itemName, $userId, $bizRule, $data);
	}

	/**
	* Revokes an authorization item from a specific user.
	* @param string the name of the item to revoke.
	* @param integer the user id of the user for which to revoke the item.
	* @return boolean whether the item was removed or not.
	*/
	public static function revoke($itemName, $userId)
	{
		$authorizer = self::getAuthorizer();
		return $authorizer->authManager->assign($itemName, $userId);
	}

	/**
	* Returns the roles assigned to a specific user.
	* @param integer the user id of the user for which roles to get.
	* @return array the roles.
	*/
	public static function getAssignedRoles($userId=null)
	{
		$u = Yii::app()->getUser();
		if( $userId===null && $u->isGuest===false )
			$userId = $u->id;

	 	$authorizer = self::getAuthorizer();
	 	return $authorizer->getAuthItems(CAuthItem::TYPE_ROLE, $userId);
	}

	/**
	* Returns a specific Rights configuration variable.
	* @param string the name of the variable to get.
	* @return mixed the value of the variable or null if not set.
	*/
	public static function getConfig($name)
	{
		$module = self::getModule();
		if( isset($module->$name)===true )
			return $module->$name;
		else
			return null;
	}

	/**
	* Beautifies authorization item names.
	* @param string the name to beautify.
	* @return string the beautified name.
	*/
	public static function beautifyName($name)
	{
	 	return str_replace('_', ' ', $name);
	}

	/**
	* Returns the authorization item type select options.
	* @return array the select options.
	*/
	public static function getAuthItemTypeSelectOptions()
	{
	 	return array(
	 		CAuthItem::TYPE_OPERATION=>Yii::t('RightsModule.tr', 'Operation'),
	 		CAuthItem::TYPE_TASK=>Yii::t('RightsModule.tr', 'Task'),
	 		CAuthItem::TYPE_ROLE=>Yii::t('RightsModule.tr', 'Role'),
		);
	}

	/**
	* Returns a specific authorization item type as a string.
	* @param integer the item type (0: operation, 1: task, 2: role).
	* @return string the authorization item type string.
	*/
	public static function getAuthItemTypeString($type)
	{
		switch( (int)$type )
		{
			case CAuthItem::TYPE_OPERATION: return Yii::t('RightsModule.tr', 'Operation');
			case CAuthItem::TYPE_TASK: return Yii::t('RightsModule.tr', 'Task');
			case CAuthItem::TYPE_ROLE: return Yii::t('RightsModule.tr', 'Role');
			default: throw new CException('Invalid auth item type.');
		}
	}

	/**
	* Returns the valid child item types for a specific type.
	* @param string the authorization item type.
	* @return array the valid types.
	*/
	public static function getValidChildTypes($type)
	{
	 	switch( (int)$type )
		{
			case CAuthItem::TYPE_ROLE: return array('role', 'task', 'operation');
			case CAuthItem::TYPE_TASK: return array('task', 'operation');
			case CAuthItem::TYPE_OPERATION: return array('operation');
			default: throw new CException('Invalid auth item type.');
		}
	}

	/**
	* @return RightsModule the Rights module
	*/
	public static function getModule()
	{
		return self::findModule();
	}

	/**
	* Searches for the Rights module among all installed modules.
	* The module will be found even if it's nested within another module.
	* @param object the module to find the module in. Defaults to null,
	* meaning that the application will be used.
	* @return the Rights module.
	*/
	private static function findModule($module=null)
	{
		if( $module===null )
			$module = Yii::app();

		if( ($m = $module->getModule('rights'))!==null )
			return $m;

		foreach( $module->getModules() as $id=>$c )
			if( ($m = $module->getModule($id))!==null )
				if( ($result = self::findModule($m))!==null )
					return $result;

		return null;
	}

	/**
	* @return RightsAuthorizer the authorizer component
	*/
	public static function getAuthorizer()
	{
		$module = self::getModule();
		return $module->getAuthorizer();
	}
}
