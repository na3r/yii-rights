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
	private $_superuserRole;
	private $_guestRole;
	private $_defaultRoles;
	private $_user;
	private $_userNameColumn;

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
	* Returns the roles.
	* @param boolean whether to include the superuser.
	* @param boolean whether to sort the items by their weights.
	* @return the roles.
	*/
	public function getRoles($includeSuperuser=true, $sort=true)
	{
		$exclude = $includeSuperuser===false ? array($this->_superuserRole) : array();
	 	return $this->getAuthItems(CAuthItem::TYPE_ROLE, null, $sort, $exclude);
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
			$data = empty($data)===false ? $this->saferEval('return '.$data.';') : null;

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
			$authItem->data = $data!=='' ? $this->saferEval('return '.$data.';') : null;

		$this->_authManager->saveAuthItem($authItem, $oldName);
	}

	/**
	 * Returns the authorization items of the specific type and user.
	 * @param integer the item type (0: operation, 1: task, 2: role). Defaults to null,
	 * meaning returning all items regardless of their type.
	 * @param mixed the user ID. Defaults to null, meaning returning all items even if
	 * they are not assigned to a user.
	 * @param boolean sort items by to weights.
	 * @param array the items to be excluded.
	 * @return array the authorization items of the specific type.
	 */
	public function getAuthItems($type=null, $userId=null, $sort=false, $exclude=array())
	{
		if( $type===null )
		{
			$items = $this->_authManager->getAuthItems($type, $userId, $sort);
		}
		else
		{
			// Make sure type is an array
			if( $type!==(array)$type )
				$type = array($type);

			// Get the authorization items for the given types
			$authItems = array();
			foreach( $type as $t )
				$authItems[] = $this->_authManager->getAuthItems($t, $userId, $sort);

			// Merge the authorization items preserving the keys
			$items = array();
			foreach( $authItems as $ai )
				$items = $this->mergeAuthItems($items, $ai);
		}

		// Unset items that should be excluded
		foreach( $exclude as $name )
		 	if( isset($items[ $name ])===true )
		 		unset($items[ $name ]);

		return $items;
	}

	/**
	* Returns a list of the child counts for each item.
	* @param array list of items to get the child count for.
	* @return array the child counts.
	*/
	public function getAuthItemChildCounts($items)
	{
		$childCounts = array();
		if( $items!==array() )
			foreach( $items as $name=>$item )
				$childCounts[ $name ] = count($item->children);

		return $childCounts;
	}

	/**
	* Merges two arrays with authorization items preserving the keys.
	* @param array the items to merge to.
	* @param array the items to merge from.
	* @return array the merged items.
	*/
	protected function mergeAuthItems($array1, $array2)
	{
		foreach( $array2 as $name=>$authItem )
			if( isset($array1[ $name ])===false )
				$array1[ $name ] = $authItem;

		return $array1;
	}

	/**
	* Excludes invalid authorization items.
	* When an item is provided its parents and children are excluded aswell.
	* @param array the authorization items to process.
	* @param CAuthItem the item to check valid authorization items for.
	* @param array additional items to be excluded.
	* @return array valid authorization items.
	*/
	protected function excludeInvalidAuthItems($authItems, $model=null, $exclude=array())
	{
		// We are getting authorization items valid for a certain item
		// exclude its parents and children aswell
		if( $model!==null )
		{
		 	$exclude[] = $model->name;
		 	foreach( $model->getChildren() as $child )
		 		$exclude[] = $child->name;

		 	// Exclude the parents recursively to avoid inheritance loops
		 	$parents = $this->getAuthItemParents($model->name);
		 	$exclude = array_merge($parents, $exclude);
		}

		// Get the valid authorization items
		$validAuthItems = array();
		foreach( $authItems as $name=>$item )
			if( in_array($name, $exclude)===false )
				$validAuthItems[ $name ] = $item;

		return $validAuthItems;
	}

	/**
	* Returns the authorization item select options.
	* @param integer the item type (0: operation, 1: task, 2: role). Defaults to null,
	* meaning returning all items regardless of their type.
	* @param CAuthItem the item for which to get the select options.
	* @return array the select options.
	*/
	public function getAuthItemSelectOptions($type=null, $model=null, $exclude=array())
	{
		// Exclude the superuser role as it cannot be a child of any item
		$exclude[] = $this->_superuserRole;

		// Get the valid authorization items
		$validTypes = $type!==null ? Rights::getValidChildTypes($type) : null;
		$items = $this->getAuthItems($validTypes);
		$items = $this->excludeInvalidAuthItems($items, $model, $exclude);

		$selectOptions = array();
		foreach( $items as $item )
			$selectOptions[ $item->name ] = Rights::beautifyName($item->name);

		return $selectOptions;
	}

	/**
	* Returns the parents of the specified authorization item.
	* @param string the item name for which to get its parents.
	* @param string the name of the role in which permissions to search.
	* @return array the names of the parent items recursively.
	*/
	public function getAuthItemParents($itemName, $roleName=null)
	{
		// Loop through the permissions to find all parents to the given item
		$parentNames = array();
		$permissions = $this->getPermissions($roleName);
		foreach( $permissions as $roleName=>$children )
		{
			// Make sure we have children
			if( $children!==array() )
			{
				// Item is a child of this role, add the role to parents
				if( isset($children[ $itemName ])===true )
					$parentNames[] = $roleName;

				// Get the parents recursive
				$potentialParents = array();
				if( $this->getAuthItemParentsRecursive($itemName, $children, $potentialParents)===true )
					$parentNames = array_merge($parentNames, $potentialParents);
			}
		}

		// We only want each parent once
		return array_unique($parentNames);
	}

	/**
	* Returns the parents of the specified authorization item recursively.
	* @param string the item name for which to get its parents.
	* @param array the children items to process.
	* @param array a list of all parents found so far.
	* @return boolean whether the specified authorization item
	* was found in the branch.
	*/
	private function getAuthItemParentsRecursive($itemName, $children, &$parents)
	{
		// We assume that we do not find the item
		$found = false;

		foreach( $children as $childName=>$grandChildren )
		{
		 	if( $grandChildren!==array() )
		 	{
		 		// Item is a grand child of this child, add all necessary items as parents
		 		// and mark the item found so that we can return that later
		 		if( isset($grandChildren[ $itemName ])===true ||
		 			$this->getAuthItemParentsRecursive($itemName, $grandChildren, $parents)===true )
		 		{
 		 			$parents[] = $childName;
 		 			$found = true;
				}
			}
		}

		return $found;
	}

	/**
	* Returns the children for the specified authorization item recursively.
	* @param CAuthItem the item for which to get its children.
	* @param boolean whether to sort the children by type.
	* @return array the names of the item's children.
	*/
	public function getAuthItemChildren(CAuthItem $item, $sort=false)
	{
		$authItemChildren = $item->getChildren();

		if( $sort===true )
			usort($authItemChildren, array('self', 'sortAuthItems'));

		$childNames = array();
		foreach( $authItemChildren as $child )
			$childNames[] = $child->name;

		return $childNames;
	}

	/**
	* User defined sort function to sort authorization items by their type.
	* @param CAuthItem the first item to compare.
	* @param CAuthItem the second item to compare.
	* @return integer the result of the comparison.
	*/
	protected function sortAuthItems(CAuthItem $item1, CAuthItem $item2)
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
		$nameColumn = $this->_userNameColumn;
		$superusers = array();
		foreach( $this->_user->findAll() as $user )
		{
			$items = $this->getAuthItems(CAuthItem::TYPE_ROLE, $user->id);
			if( isset($items[ $this->_superuserRole ])===true )
				$superusers[] = $user->$nameColumn;
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
			return isset($assignments[ $this->_superuserRole ]);
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
	* Makes code safer for use with eval().
	* @param string the code to be execute.
	* @return mixed the return value of eval() or null if the code was unsafe to run.
	*/
	protected function saferEval($code)
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

		// Eval the safer code
		$evaledCode = @eval($code);

		// Return the eval'ed code or null if the result was false
		return $evaledCode!==false ? $evaledCode : null;
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
	public function setAuthManager($authManager)
	{
		$this->_authManager = $authManager;
	}

	/**
	* @return string the name of the superuser role.
	*/
	public function getSuperuserRole()
	{
		return $this->_superuserRole;
	}

	/**
	* @param string the name of the superuser role.
	*/
	public function setSuperuserRole($superuserRole)
	{
		$this->_superuserRole = $superuserRole;
	}

	/**
	* @param string the default roles.
	*/
	public function setDefaultRoles($roles)
	{
		$this->_defaultRoles = $roles;
	}

	/**
	* @param string the name of the user class.
	*/
	public function setUser($class)
	{
		// Make sure the given class exists
		if( class_exists($class)===false )
			throw new CException('Cannot find the user model.');

		// Create an instance of the model
		$this->_user = new $class;
	}

	/**
	* @return CActiveRecord the user model.
	*/
	public function getUser()
	{
	 	return $this->_user;
	}

	/**
	* @param string the name of the username column.
	*/
	public function setUserNameColumn($name)
	{
		// Make sure the given column name exists in the user table
		if( $this->_user->hasAttribute($name)===false )
			throw new CException('Cannot find the username column.');

		$this->_userNameColumn = $name;
	}

	/**
	* @return string the name of the username column.
	*/
	public function getUserNameColumn()
	{
		return $this->_userNameColumn;
	}
}
