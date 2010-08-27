<?php
/**
* Rights authorizer component class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.5
*/
class RightsAuthorizer extends CApplicationComponent
{
	private $_authManager;
	private $_superuserName;
	private $_defaultRoles;

	/**
	* Initializes the authorizer.
	*/
	public function init()
	{
		parent::init();

		$this->_authManager = Yii::app()->getAuthManager();
		$this->_authManager->defaultRoles = $this->_defaultRoles;
	}

	/**
	* Returns the a list of all roles.
	* @param boolean whether to include the superuser.
	* @param boolean whether to sort the items by their weights.
	* @return the roles.
	*/
	public function getRoles($includeSuperuser=true, $sort=true)
	{
		$exclude = $includeSuperuser===false ? array($this->_superuserName) : array();
	 	return $this->getAuthItems(CAuthItem::TYPE_ROLE, null, null, $sort, $exclude);
	}

	/**
	* Creates an authorization item.
	* @param string the item name. This must be a unique identifier.
	* @param integer the item type (0: operation, 1: task, 2: role).
	* @param string description of the item
	* @param string business rule associated with the item. This is a piece of
	* PHP code that will be executed when {@link checkAccess} is called for the item.
	* @param mixed additional data associated with the item.
	* @return CAuthItem the authorization item
	*/
	public function createAuthItem($name, $type, $description='', $bizRule=null, $data=null)
	{
		$bizRule = $bizRule!=='' ? $bizRule : null;

		if( $data!==null )
			$data = empty($data)===false ? $this->sanitizeExpression('return '.$data.';') : null;

		return $this->_authManager->createAuthItem($name, $type, $description, $bizRule, $data);
	}

	/**
	* Updates an authorization item.
	* @param string the item name. This must be a unique identifier.
	* @param integer the item type (0: operation, 1: task, 2: role).
	* @param string description of the item
	* @param string business rule associated with the item. This is a piece of
	* PHP code that will be executed when {@link checkAccess} is called for the item.
	* @param mixed additional data associated with the item.
	*/
	public function updateAuthItem($oldName, $name, $description='', $bizRule=null, $data=null)
	{
		$authItem = $this->_authManager->getAuthItem($oldName);
		$authItem->name = $name;
		$authItem->description = $description!=='' ? $description : null;
		$authItem->bizRule = $bizRule!=='' ? $bizRule : null;

		// Make sure that data is not already serialized
		if( @unserialize($data)===false )
			$authItem->data = $data!=='' ? $this->sanitizeExpression('return '.$data.';') : null;

		$this->_authManager->saveAuthItem($authItem, $oldName);
	}

	/**
	 * Returns the authorization items of the specific type and user.
	 * @param integer the item type (0: operation, 1: task, 2: role). Defaults to null,
	 * meaning returning all items regardless of their type.
	 * @param mixed the user ID. Defaults to null, meaning returning all items even if
	 * they are not assigned to a user.
	 * @param CAuthItem the item for which to get the select options.
	 * @param boolean sort items by to weights.
	 * @param array the items to be excluded.
	 * @return array the authorization items of the specific type.
	 */
	public function getAuthItems($type=null, $userId=null, $owner=null, $sort=false, $exclude=array())
	{
		$items = $this->_authManager->getAuthItems($type, $userId, $sort);
		$items = $this->excludeInvalidAuthItems($items, $owner, $exclude);

		return $items;
	}

	/**
	* Excludes invalid authorization items.
	* When an item is provided its parents and children are excluded aswell.
	* @param array the authorization items to process.
	* @param CAuthItem the item to check valid authorization items for.
	* @param array additional items to be excluded.
	* @return array valid authorization items.
	*/
	protected function excludeInvalidAuthItems($items, $owner=null, $exclude=array())
	{
		// We are getting authorization items valid for a certain item
		// exclude its parents and children aswell
		if( $owner!==null )
		{
		 	$exclude[] = $owner->name;
		 	foreach( $owner->getChildren() as $child )
		 		$exclude[] = $child->name;

		 	// Exclude the parents recursively to avoid inheritance loops
		 	$parents = $this->getAuthItemParents($owner->name);
		 	$exclude = array_merge($parents, $exclude);
		}

		// Get the valid authorization items
		$validAuthItems = array();
		foreach( $items as $name=>$item )
			if( in_array($name, $exclude)===false )
				$validAuthItems[ $name ] = $item;

		return $validAuthItems;
	}

	/**
	* Returns the valid authorization item select options for a type and/or model.
	* @param integer the item type (0: operation, 1: task, 2: role). Defaults to null,
	* meaning returning all items regardless of their type.
	* @param mixed the user ID. Defaults to null, meaning returning all items even if
	* they are not assigned to a user.
	* @param CAuthItem the item for which to get the select options.
	* @param boolean whether to sort the authorization items.
	* @param array the items to be excluded.
	* @return array the select options.
	*/
	public function getAuthItemSelectOptions($type=null, $userId=null, $owner=null, $sort=true, $exclude=array())
	{
		$items = $this->getAuthItems($type, $userId, $owner, $sort, $exclude);

		$selectOptions = array();
		foreach( $items as $item )
			$selectOptions[ $item->name ] = Rights::beautifyName($item->name);

		return $selectOptions;
	}

	/**
	* Returns the parents of the specified authorization item.
	* @param string the item name for which to get its parents.
	* @param string the name of the role in which permissions to search.
	* @param boolean whether we want the specified items parent or all parents.
	* @return array the names of the parent items.
	*/
	public function getAuthItemParents($itemName, $roleName=null, $direct=false, $sort=true)
	{
		$permissions = $this->getPermissions($roleName);
		$parents = $this->getAuthItemParentsRecursive($itemName, $permissions, $direct);

		if( $sort===true )
			$this->sortAuthItems($parents);

		return $parents;
	}

	/**
	* Returns the parents of the specified authorization item recursively.
	* @param string the item name for which to get its parents.
	* @param array the items to process.
	* @param boolean whether we want the specified items parent or all parents.
	* @return the names of the parents items recursively.
	*/
	private function getAuthItemParentsRecursive($itemName, $items, $direct)
	{
		$parents = array();
		foreach( $items as $name=>$children )
		{
		 	if( $children!==array() )
		 	{
		 		// Item found
		 		if( isset($children[ $itemName ])===true )
		 		{
		 			if( isset($parents[ $name ])===false )
		 				$parents[ $name ] = $this->_authManager->getAuthItem($name);
				}
				// Check if item is in the children recursively
				else
				{
		 			if( ($p = $this->getAuthItemParentsRecursive($itemName, $children, $direct))!==array() )
		 			{
		 				if( $direct===false && isset($parents[ $name ])===false )
		 					$parents[ $name ] = $this->_authManager->getAuthItem($name);

		 				$parents = array_merge($parents, $p);
					}
				}
			}
		}

		return $parents;
	}

	/**
	* Returns the children for the specified authorization item recursively.
	* @param CAuthItem the item for which to get its children.
	* @param boolean whether to sort the children by type.
	* @return array the names of the item's children.
	*/
	public function getAuthItemChildren(CAuthItem $item, $sort=true)
	{
		$children = $item->getChildren();

		if( $sort===true )
			$this->sortAuthItems($children);

		return $children;
	}

	/**
	* Sorts the authorization items by type and name.
	* @param array the items to sort.
	* @return the sorted items.
	*/
	protected function sortAuthItems($items)
	{
		usort($items, array('self', 'sortAuthItemsByType'));
		return $items;
	}

	/**
	* Sorts authorization items by their type.
	* @param CAuthItem the first item to compare.
	* @param CAuthItem the second item to compare.
	* @return integer the result of the comparison.
	*/
	protected function sortAuthItemsByType(CAuthItem $item1, CAuthItem $item2)
	{
		if( $item1->type!==$item2->type )
        	return $item1->type>$item2->type ? -1 : 1;
		else
        	return 0;
	}

	/**
	* Returns the users with superuser priviledges.
	* @return the superusers.
	*/
	public function getSuperusers()
	{
		$userClass = Rights::module()->userClass;
		$users = CActiveRecord::model($userClass)->findAll();
		$superusers = array();
		foreach( $users as $u )
		{
			$u->attachBehavior('rights', new RightsUserBehavior);
			$items = $this->getAuthItems(CAuthItem::TYPE_ROLE, $u->getId());
			if( isset($items[ $this->_superuserName ])===true )
				$superusers[] = $u->getName();
		}

		return $superusers;
	}

	/**
	* Checks whether the user is a superuser.
	* @param integer the user id. Defaults to null, meaning the logged in user.
	* @return boolean whether the user is a superuser.
	*/
	public function isSuperuser($userId=null)
	{
		$user = Yii::app()->getUser();
		if( $user->isGuest===false )
		{
			if( $userId===null)
				$userId = $user->id;

			$assignments = $this->_authManager->getAuthAssignments($userId);
			return isset($assignments[ $this->_superuserName ]);
		}

		return false;
	}

	/**
	* Returns the permissions for a specific authorization item.
	* @param string the name of the item for which to get permissions. Defaults to null,
	* meaning that the full permission tree is returned.
	* @return the permission tree.
	*/
	public function getPermissions($itemName=null)
	{
		if( $itemName!==null )
		{
			$item = $this->_authManager->getAuthItem($itemName);
			$permissions[ $itemName ] = $this->getPermissionsRecursive($item);
		}
		else
		{
			foreach( $this->getRoles() as $name=>$item )
				$permissions[ $name ] = $this->getPermissionsRecursive($item);
		}

		return $permissions;
	}

	/**
	* Returns the permissions for a specific authorization item recursively.
	* @param CAuthItem the item for which to get permissions.
	* @return array the section of the permissions tree.
	*/
	private function getPermissionsRecursive(CAuthItem $item)
	{
		$permissions = array();
	 	foreach( $item->getChildren() as $childName=>$child )
	 	{
	 		$permissions[ $childName ] = array();
	 		if( ($grandChildren = $this->getPermissionsRecursive($child))!==array() )
				$permissions[ $childName ] = $grandChildren;
		}

		return $permissions;
	}

	/**
	* Check if a specific role has permissions to a specific authorization item.
	* @param string the name of the role for which to check permissions.
	* @param string the name of the item to check for.
	* @return integer the permission type (0: None, 1: Direct, 2: Inherited).
	*/
	public function hasPermission($itemName, $permissions)
	{
		if( isset($permissions[ $itemName ])===true )
			return 1;

		foreach( $permissions as $children )
			if( $children!==array() )
				if( $this->hasPermission($itemName, $children)>0 )
					return 2;

		return 0;
	}

	/**
	* Returns the assignments for a specific user.
	* @param mixed one or many user ids.
	* @return array the assignments.
	*/
	public function getUserAssignments($userId=null)
	{
		if( $userId!==(array)$userId )
		{
			$assignments = $this->_authManager->getAuthAssignments($userId);
		}
		else
		{
			$assignments = array();
			foreach( $userId as $id )
				$assignments[ $id ] = $this->_authManager->getAuthAssignments($id);
		}

		return $assignments;
	}

	/**
	* Tries to sanitize code to make it safe for execution.
	* @param string the code to be execute.
	* @return mixed the return value of eval() or null if the code was unsafe to execute.
	*/
	protected function sanitizeExpression($code)
	{
		// Language consturcts
		$languageConstructs = array(
			'echo',
			'empty',
			'isset',
			'unset',
			'exit',
			'die',
			'include',
			'include_once',
			'require',
			'require_once',
		);

		// Loop through the language constructs
		foreach( $languageConstructs as $lc )
			if( preg_match('/'.$lc.'\ *\(?\ *[\"\']+/', $code)>0 )
				return null; // Language construct found, not safe for eval

		// Get a list of all defined functions
		$definedFunctions = get_defined_functions();
		$functions = array_merge($definedFunctions['internal'], $definedFunctions['user']);

		// Loop through the functions and check the code for function calls
		// Append a '(' to the functions to avoid confusion between e.g. array() and array_merge()
		foreach( $functions as $f )
			if( preg_match('/'.$f.'\ *\({1}/', $code)>0 )
				return null; // Function call found, not safe for eval

		// Evaluate the safer code
		$result = @eval($code);

		// Return the evaluated code or null if the result was false
		return $result!==false ? $result : null;
	}

	/**
	* @return CDbAuthManager the authorization manager
	*/
	public function getAuthManager()
	{
		return $this->_authManager;
	}

	/**
	* @param CDbAuthManager the authorization manager
	*/
	public function setAuthManager($value)
	{
		$this->_authManager = $value;
	}

	/**
	* @return string the name of the superuser role.
	*/
	public function getSuperuserName()
	{
		return $this->_superuserName;
	}

	/**
	* @param string the name of the superuser role.
	*/
	public function setSuperuserName($value)
	{
		$this->_superuserName = $value;
	}

	/**
	* @param string the default roles.
	*/
	public function setDefaultRoles($value)
	{
		$this->_defaultRoles = $value;
	}
}
