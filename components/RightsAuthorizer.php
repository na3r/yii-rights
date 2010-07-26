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
	/**
	* @var CDbAuthManager Auth manager
	*/
	private $_authManager;
	/**
	* @var string Name of the super user role
	*/
	private $_superUserRole;
	/**
	* @var string Name of the guest role
	*/
	private $_guestRole;
	/**
	* @var array Users with access to Rights
	*/
	private $_superUsers;
	/**
	* @var CActiveRecord Instance of the user model
	*/
	private $_user;
	/**
	* @var string Name of the username column
	*/
	private $_usernameColumn;
	/**
	* @var array Permission tree from roles down
	*/
	private $_permissions;

	/**
	* Initialization.
	*/
	public function init()
	{
		$this->_authManager = Yii::app()->authManager;

		parent::init();
	}

	/**
	* Gets the roles (sorted by the number of children).
	* @return Sorted roles
	*/
	public function getRoles()
	{
		// Get the roles excluding the super user
	 	$roles = $this->getAuthItems('role', NULL, array($this->_superUserRole));

	 	// Loop through the roles and get their child counts
	 	$childCounts = array();
	 	foreach( $roles as $roleName=>$role )
	 		$childCounts[ $roleName ] = count($role->getChildren());

	 	// Sort the child counts array in reverse
	 	arsort($childCounts);

		// Sort the roles by their child counts
	 	$sortedRoles = array();
	 	foreach( $childCounts as $roleName=>$count )
	 		$sortedRoles[ $roleName ] = $roles[ $roleName ];

	 	return $sortedRoles;
	}

	/**
	* Creates an auth item.
	* @param string $name Name
	* @param integer $type Type
	* @param string $description Description
	* @param string $bizRule Business rule
	* @param string $data Non-serialized data
	* @return CAuthItem
	*/
	public function createAuthItem($name, $type, $description='', $bizRule=NULL, $data=NULL)
	{
		$bizRule = $bizRule!=='' ? $bizRule : NULL;

		if( isset($data)===true )
			$data = empty($data)===false ? $this->saferEval('return '.$data.';') : NULL;

		return $this->_authManager->createAuthItem($name, $type, $description, $bizRule, $data);
	}

	/**
	* Updates an auth item.
	* Reassigns the items parents and children if then name is changed.
	* @param string $oldName Old name
	* @param string $name New name
	* @param string $description Description
	* @param string $bizRule Business rule
	* @param string $data Non-serialized data
	*/
	public function updateAuthItem($oldName, $name, $description='', $bizRule=NULL, $data=NULL)
	{
		$authItem = $this->_authManager->getAuthItem($oldName);
		$authItem->name = $name;
		$authItem->description = $description!=='' ? $description : NULL;
		$authItem->bizRule = $bizRule!=='' ? $bizRule : NULL;

		// Make sure that data is not already serialized
		if( @unserialize($data)===false )
			$authItem->data = $data!=='' ? $this->saferEval('return '.$data.';') : NULL;

		$this->_authManager->saveAuthItem($authItem, $oldName);
	}

	/**
	* Gets auth items of one or several type.
	* @param mixed $types Types of auth items to get - Valid types are 'role', 'task' and 'operation'
	* @param int $userId User to get valid auth items for
	* @param array $exclude Names of items to exclude
	* @return array Auth items
	*/
	public function getAuthItems($types=NULL, $userId=NULL, $exclude=NULL)
	{
		// Type is not given, set type to all valid types
		if( isset($types)===false )
			$types = Rights::$authItemTypes;

		// Make sure types is an array
		if( is_array($types)===false )
			$types = array($types);

		// Get the auth items for the given types
		$items = array();
		foreach( $types as $type )
			$items[] = $this->_authManager->getAuthItems(Rights::getAuthItemTypeByString($type), $userId);

		// Merge the auth items preserving the keys
		$authItems = array();
		foreach( $items as $children )
			$authItems = $this->mergeAuthItems($authItems, $children);

		// We need to exclude items
		if( $exclude!==NULL )
		{
			// Exclude those items
		 	foreach( $exclude as $name )
		 		if( isset($authItems[ $name ])===true )
		 			unset($authItems[ $name ]);
		}

		return $authItems;
	}

	/**
	* Merges two arrays with auth items preserving the keys.
	* @param array $array1 Items to merge to
	* @param array $array2 Items to merge from
	* @return array Merged items
	*/
	protected function mergeAuthItems($array1, $array2)
	{
		foreach( $array2 as $name=>$authItem )
			if( isset($array1[ $name ])===false )
				$array1[ $name ] = $authItem;

		return $array1;
	}

	/**
	* Excludes invalid auth items from those provided.
	* When an item is provided its parents and children are excluded aswell.
	* @param array $authItems Auth items to process
	* @param CAuthItem $model Item to check valid auth items for
	* @param array Additional items to be excluded
	* @return array Valid auth items
	*/
	protected function excludeInvalidAuthItems($authItems, $model=NULL, $exclude=array())
	{
		// Always exclude the super user
		$exclude[] = $this->_superUserRole;

		// We are getting auth items valid for a certain item
		// exclude its parents and children aswell
		if( $model!==NULL )
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
	* Gets the auth item select options.
	* @param string $type Auth item type
	* @param CAuthItem $model Item to get select options for
	* @return array Select options
	*/
	public function getAuthItemSelectOptions($type=NULL, $model=NULL, $exclude=array())
	{
   		// Get the valid children types for this item
		$validTypes = isset($type)===true ? Rights::getValidChildTypes($type) : Rights::$authItemTypes;

		// Get the valid auth items for those types
		$authItems = $this->getAuthItems($validTypes);
		$authItems = $this->excludeInvalidAuthItems($authItems, $model, $exclude);

		$selectOptions = array();
		foreach( $authItems as $item )
			$selectOptions[ $item->name ] = Rights::beautifyName($item->name);

		return $selectOptions;
	}

	/**
	* Gets parents for an auth item.
	* @param string $itemName Authorization item to get parents for
	* @param string $roleName Role in question
	* @return array Names of the parents and grandparents
	*/
	public function getAuthItemParents($itemName, $roleName=NULL)
	{
		$parentNames = array();

		// Loop through the permissions to find all parents to the given item
		$permissions = $this->getPermissions($roleName);
		foreach( $permissions as $roleName=>$children )
		{
			// Make sure we have children
			if( count($children)>0 )
			{
				// Item is a child of this role, add the role to parents
				if( isset($children[ $itemName ])===true )
					$parentNames[] = $roleName;

				// Get the parents recursive
				$potentialParents = array($roleName);
				if( $this->getAuthItemParentsRecursive($itemName, $children, $potentialParents)===true )
					$parentNames = array_merge($parentNames, $potentialParents);
			}
		}

		// We only want each parent once
		return array_unique($parentNames);
	}

	/**
	* Gets parents for an auth item recursively.
	* @param string $itemName Authorization item to get parents for
	* @param array $children Childrens to process
	* @param array $parents Parents
	*/
	private function getAuthItemParentsRecursive($itemName, $children, &$parents)
	{
		// We assume that we do not find the item
		$found = false;

		// Loop through the children
		foreach( $children as $childName=>$grandChildren )
		{
			// Make sure we have items
		 	if( count($grandChildren)>0 )
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
	* Gets the auth item children recursively.
	* @param CAuthItem $item Auth item to get children for
	* @param bool $sort Should the children be sorted by type?
	* @return array Names of the children
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
	* Sorts auth items by their type
	* @param CAuthItem $item1
	* @param CAuthItem $item2
	* @return int Comparison result
	*/
	protected function sortAuthItems(CAuthItem $item1, CAuthItem $item2)
	{
		if($item1->type===$item2->type)
        	return 0;

        return ($item1->type>$item2->type) ? -1 : 1;
	}

	/**
	* Checks if user is a super user.
	* @param integer $userId User id
	* @return bool
	*/
	public function isSuperUser($userId=NULL)
	{
		// Make sure the user is logged in
		if( Yii::app()->user->isGuest===false )
		{
			// User id is not provided, use the logged in user
			if( $userId===NULL)
				$userId = Yii::app()->user->id;

			$authAssignments = $this->_authManager->getAuthAssignments($userId);
			return isset($authAssignments[ $this->_superUserRole ]);
		}

		return false;
	}

	/**
	* Creates and sets the permissions tree.
	*/
	public function createPermissions()
	{
		$permissions = array();
		foreach( $this->getRoles() as $name=>$item )
			$permissions[ $name ] = $this->getPermissionsRecursive($item);

		$this->_permissions = $permissions;
	}

	/**
	* Gets the permissions tree recursively.
	* @param CAuthItem $item Item to get permissions for
	* @return array Part of the permissions tree
	*/
	private function getPermissionsRecursive(CAuthItem $item)
	{
		$permissions = array();

	 	foreach( $item->getChildren() as $childName=>$child )
	 	{
	 		$permissions[ $childName ] = array();
	 		if( count($grandChildren = $this->getPermissionsRecursive($child))>0 )
				$permissions[ $childName ] = $grandChildren;
		}

		return $permissions;
	}

	/**
	* Get the permissions for all or a specific role.
	* @param string $roleName Rolename to get permissions for
	* @return mixed Permissions or false if role not found
	*/
	protected function getPermissions($roleName=NULL)
	{
		if( $roleName!==NULL )
		{
			if( isset($this->_permissions[ $roleName ])===true )
				return $this->_permissions[ $roleName ];

			return false;
		}

		return $this->_permissions;
	}

	/**
	* Checks for permissions to item for given role.
	* @param string $roleName Role name
	* @param string $itemName Item name to check for
	* @return integer 0:none, 1:direct, 2:inherited
	*/
	public function hasPermission($roleName, $itemName)
	{
		if( isset($this->_permissions[ $roleName ])===true )
		{
			if( isset($this->_permissions[ $roleName ][ $itemName ])===true )
				return 1;

			foreach( $this->_permissions[ $roleName ] as $children )
				if( count($children)>0 )
					if( $this->hasPermissionRecursive($itemName, $children)>0 )
						return 2;
		}

		return 0;
	}

	/**
	* Checks for permissions recursively.
	* @param string $itemName Item name to check for
	* @param array $items Items to check
	* @return integer 0:none, 1:direct, 2:inherited
	*/
	private function hasPermissionRecursive($itemName, $items)
	{
		if( isset($items[ $itemName ])===true )
			return 2;

		foreach( $items as $children )
			if( count($children)>0 )
				if( $this->hasPermissionRecursive($itemName, $children)>0 )
					return 2;

		return 0;
	}

	/**
	* Gets auth assignments for the given user(s).
	* @param mixed $userId One or many user ids
	* @return array Auth assignments
	*/
	public function getUserAuthAssignments($userId)
	{
		if( is_array($userId)===false )
			$userId = array($userId);

		$authAssignments = array();
		foreach( $userId as $id )
			$authAssignments[ (string)$id ] = $this->_authManager->getAuthAssignments($id);

		return $authAssignments;
	}

	/**
	* Makes code safer for use with eval().
	* @param string $code Code to be run with eval.
	* @return mixed Eval'ed code or null if the code was not safe
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
				return NULL; // Language construct found, not safe for eval

		// Get a list of all defined functions
		$definedFunctions = get_defined_functions();
		$functions = array_merge($definedFunctions['internal'], $definedFunctions['user']);

		// Loop through the functions and check the code for function calls
		// Append a '(' to the functions to avoid confusion between e.g. array() and array_merge()
		foreach( $functions as $f )
			if( preg_match('/'.$f.'\ *\({1}/', $code)>0 )
				return NULL; // Function call found, not safe for eval

		// Eval the safer code
		$evaledCode = @eval($code);

		// Return the eval'ed code or null if the result was false
		return $evaledCode!==false ? $evaledCode : NULL;
	}

	/**
	* @return CDbAuthManager Auth manager
	*/
	public function getAuthManager()
	{
		return $this->_authManager;
	}

	/**
	* @param CDbAuthManager $authManager Auth manager
	*/
	public function setAuthManager($authManager)
	{
		$this->_authManager = $authManager;
	}

	/**
	* @return string Super user role name
	*/
	public function getSuperUserRole()
	{
		return $this->_superUserRole;
	}

	/**
	* @param string $superUserRole Super user role name
	*/
	public function setSuperUserRole($superUserRole)
	{
		$this->_superUserRole = $superUserRole;
	}

	/**
	* @return string Super users
	*/
	public function getSuperUsers()
	{
		return $this->_superUsers;
	}

	/**
	* @param string $superUsers Super users
	*/
	public function setSuperUsers($superUsers)
	{
		$this->_superUsers = $superUsers;
	}

	/**
	* @param string $mode User model name
	*/
	public function setUser($model)
	{
		// Make sure the given model exists
		if( class_exists($model)===false )
			throw new CException('Cannot find user model.');

		// Create an instance of the model
		$this->_user = new $model;
	}

	/**
	* @return CActiveRecord User model
	*/
	public function getUser()
	{
	 	return $this->_user;
	}

	/**
	* @param string $usernameColumn Username column name
	*/
	public function setUsernameColumn($attribute)
	{
		// Make sure the given column name exists in the user table
		if( $this->_user->hasAttribute($attribute)===false )
			throw new CException('Cannot find username column.');

		$this->_usernameColumn = $attribute;
	}

	/**
	* @return string Username column name
	*/
	public function getUsernameColumn()
	{
		return $this->_usernameColumn;
	}
}
