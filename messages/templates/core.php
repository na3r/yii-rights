<?php
/**
* {Language} translation for Rights core.
*
* Please contact the author if you find an error in the translation.
*
* @author {YourName} <{YourEmail}>
* @copyright Copyright &copy; 2010 {YourName}
* @since 0.9.8
*/
return array(
	/**
	* components/Rights.php
	*/
	'Operation'=>'',
	'Task'=>'',
	'Role'=>'',
	'Invalid authorization item type.'=>'',											// Added in 0.9.9
	/**
	* controllers/AssignmentController.php
	*/
	':name assigned.'=>'',															// Added in 0.9.5
	':name revoked.'=>'',															// Added in 0.9.5
	'Invalid request. Please do not repeat this request again.'=>'', 				// Added in 0.9.5
	'You are not authorized to perform this action.'=>'',							// Moved in 0.9.7
	/**
	* controllers/AuthItemController.php
	*/
	':name created.'=>'',															// Added in 0.9.5
	':name updated.'=>'', 															// Added in 0.9.5
	'Child :name added.'=>'',														// Added in 0.9.5
	'Child :name removed.'=>'',														// Added in 0.9.5
	':name deleted.'=>'',															// Added in 0.9.5
	'Authorization items created.'=>'',												// Added in 0.9.9
	'The requested page does not exist.'=>'',										// Added in 0.9.5
	/**
	* models/AuthItemForm.php
	*/
	'An item with this name already exists.'=>'',									// Added in 0.9.8
	'Name of the superuser cannot be changed.'=>'',									// Added in 0.9.10
	/**
	* models/AuthItemModel.php
	*/
	'Name'=>'',																		// Moved in 0.9.10
	'Type'=>'',																		// Added in 0.9.10
	'Description'=>'',																// Moved in 0.9.10
	'Business rule'=>'',															// Moved in 0.9.10
	'Data'=>'',																		// Moved in 0.9.10
	'superuser'=>'',																// Moved in 0.9.10
	'Delete'=>'',																	// Moved in 0.9.10
	'Are you sure you want to delete this operation?'=>'',							// Moved in 0.9.10
	'Are you sure you want to delete this task?'=>'',								// Moved in 0.9.10
	'Are you sure you want to delete this role?'=>'',								// Moved in 0.9.10
	'Remove'=>'',																	// Moved in 0.9.10
	'Revoke'=>'',																	// Moved in 0.9.10
	/**
	* views/default/(_)permissions.php
	*/
	'Permissions'=>'',
	'Permission'=>'',																// Added in 0.9.9
	'Inherited'=>'',
	'Assign'=>'',
	'Hover to see from where the permission is inherited.'=>'',
	'Parents'=>'',
	'No authorization items found.'=>'',											// Corrected in 0.9.8
	/**
	* views/default/operations.php
	*/
	'Operations'=>'',
	'Create a new operation'=>'',													// Added in 0.9.9
	'Values within square brackets tell how many children each item has.'=>'',
	'No operations found.'=>'',
	/**
	* views/default/tasks.php
	*/
	'Tasks'=>'',
	'Create a new task'=>'',														// Added in 0.9.9
	'No tasks found.'=>'',
	/**
	* views/default/roles.php
	*/
	'Roles'=>'',
	'Create a new role'=>'',														// Added in 0.9.9
	'No roles found.'=>'',
	/**
	* views/authItem/authChildForm.php
	*/
	'Add'=>'',
	/**
	* views/authItem/authItemForm.php
	*/
	'Save'=>'',
	/**
	* views/authItem/_generateItems.php
	*/
	'Modules'=>'',																	// Added in 0.9.9
	/**
	* views/authItem/create.php
	*/
	'Create :type'=>'',																// Added in 0.9.9
	/**
	* views/authItem/generate.php
	*/
	'Auth Item Generator'=>'',														// Added in 0.9.9
	'Please select which authorization items you wish to generate.'=>'',			// Added in 0.9.9
	'Application'=>'',																// Added in 0.9.9
	'Select all'=>'',																// Added in 0.9.9
	'Select none'=>'',																// Added in 0.9.9
	'Generate'=>'',																	// Added in 0.9.9
	/**
	* views/authItem/update.php
	*/
	'Auth Item'=>'',
	'Update :name'=>'',
	'Relations'=>'',																// Added in 0.9.7
	'This item has no parents.'=>'',
	'Children'=>'',
	'This item has no children.'=>'',
	'Add Child'=>'',
	'No relations need to be set for the superuser role.'=>'',						// Added in 0.9.7
	'Super users are always granted access implicitly.'=>'',						// Added in 0.9.7
	/**
	* views/assignment/user.php
	*/
	'Assignments for :username'=>'',
	'This user has not been assigned any authorization items.'=>'',
	'Add Assignment'=>'',
	/**
	* views/assignment/view.php
	*/
	'Assignments'=>'',
	'Username'=>'',
	'No users found.'=>'',
	/**
	* views/_menu.php
	*/
	'Generator'=>'',																// Added in 0.9.9
);
