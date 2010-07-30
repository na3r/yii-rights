<?php
/**
* Finnish translations for Rights.
*
* Please contact the author if you find an error in the translation.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.9.1
*/
return array(
	/**
	* components/Rights.php
	*/
	'Operation'=>'',
	'Task'=>'',
	'Role'=>'',
	/**
	* components/RightsFilter.php
	*/
	'You are not authorized to perform this action.'=>'',
	/**
	* controllers/AssignmentController.php
	*/
	':name assigned.'=>'',  // Added in 0.9.5
	':name revoked.'=>'',  // Added in 0.9.5
	'Invalid request. Please do not repeat this request again.'=>'',  // Added in 0.9.5
	/**
	* controllers/AuthItemController.php
	*/
	':name created.'=>'', // Added in 0.9.5
	'Could not create :name, item already exists.'=>'',  // Added in 0.9.5
	':name updated.'=>'',  // Added in 0.9.5
	'Could not rename :oldName to :name, an item with that name already exists.',  // Added in 0.9.5
	'Child :name added.'=>'',  // Added in 0.9.5
	'Child :name removed.'=>'',  // Added in 0.9.5
	':name deleted.'=>'',  // Added in 0.9.5
	'The requested page does not exist.'=>'',  // Added in 0.9.5
	/**
	* views/main/permissions.php
	*/
	'Permissions'=>'',
	'Description'=>'',
	'Revoke'=>'',
	'Inherited'=>'',
	'Assign'=>'',
	'Hover to see from where the permission is inherited.'=>'',
	'Parents'=>'',
	'No auth items found.'=>'',
	/**
	* views/main/operations.php
	*/
	'Operations'=>'',
	'Name'=>'',
	'Business rule'=>'',
	'Data'=>'',
	'Delete'=>'',
	'Are you sure you want to delete this operation?'=>'', // Corrected in 0.9.7
	'Values within square brackets tell how many children each item has.'=>'',
	'No operations found.'=>'',
	/**
	* views/main/tasks.php
	*/
	'Tasks'=>'',
	'Are you sure you want to delete this task?'=>'', // Corrected in 0.9.7
	'No tasks found.'=>'',
	/**
	* views/main/roles.php
	*/
	'Roles'=>'',
	'super user'=>'', // Added in 0.9.7
	'Are you sure you want to delete this role?'=>'', // Corrected in 0.9.7
	'Roles can be organized by dragging and dropping.'=>'', // Added in 0.9.7
	'No roles found.'=>'',
	/**
	* views/authItem/authItemForm.php
	*/
	'Save'=>'',
	/**
	* views/authItem/create.php
	*/
	'Create Auth Item'=>'',
	'Notice: Auth Item type cannot be changed afterwards.'=>'',
	/**
	* views/authItem/update.php
	*/
	'Auth Item'=>'',
	'Update :name'=>'',
	'Relations'=>'', // Added in 0.9.7
	'This item has no parents.'=>'',
	'Children'=>'',
	'Remove'=>'',
	'Are you sure you want to remove this child?'=>'',
	'This item has no children.'=>'',
	'Add Child'=>'',
	'No relations needs to be set for the super user role.'=>'', // Added in 0.9.7
	'Super users are always granted access implicitly.'=>'', // Added in 0.9.7
	/**
	* views/assignment/user.php
	*/
	'Assignments for :username'=>'',
	'Are you sure to revoke this assignment?'=>'',
	'This user has not been assigned any auth items.'=>'',
	'Add Assignment'=>'',
	/**
	* views/assignments/view.php
	*/
	'Assignments'=>'',
	'Username'=>'',
	'No users found.'=>'',
);
