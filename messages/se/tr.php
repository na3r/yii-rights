<?php
/**
* Swedish translations for Rights.
*
* Please contact the author if you find an error in the translation.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.9.3
*/
return array(
	/**
	* components/Rights.php
	*/
	'Operation'=>'Operation',
	'Task'=>'Uppgift',
	'Role'=>'Roll',
	/**
	* components/RightsFilter.php
	*/
	'You are not authorized to perform this action.'=>'Du har inte rätt att utföra denna funktion.',
	/**
	* controllers/AssignmentController.php
	*/
	':name assigned.'=>':name tilldelad.',
	':name revoked.'=>':name upphävd',
	'Invalid request. Please do not repeat this request again.'=>'Ogiltigt förfrågan. Upprepa inte förfrågan pånytt.',
	/**
	* controllers/AuthItemController.php
	*/
	':name created.'=>':name skapad.',
	'Could not create :name, item already exists.'=>':name kunde inte skapas, elementet finns redan.',
	':name updated.'=>':name uppdaterad.',
	'Could not rename :oldName to :name, an item with that name already exists.'=>'Kan inte ändra :oldName till :name, ett element med detta namn finns redan.',
	'Child :name added.'=>'Barn :name tillagd.',
	'Child :name removed.'=>'Barn :name borttagen.',
	':name deleted.'=>':name raderad.',
	'The requested page does not exist.'=>'Förfrågade sidan finns inte.',
	/**
	* views/main/permissions.php
	*/
	'Permissions'=>'Rättigheter',
	'Description'=>'Beskrivning',
	'Revoke'=>'Upphäv',
	'Inherited'=>'Ärvd',
	'Assign'=>'Tilldela',
	'Hover to see from where the permission is inherited.'=>'För musen ovan för att se varifrån rättigheten är ärvd.',
	'Parents'=>'Föräldrar',
	'No auth items found.'=>'Inga auktoriserings element hittades.',
	/**
	* views/main/operations.php
	*/
	'Operations'=>'Operationer',
	'Name'=>'Namn',
	'Business rule'=>'Business regel',
	'Data'=>'Data',
	'Delete'=>'Radera',
	'Are you sure to delete this operation?'=>'Är du säker att du vill radera denna operation?',
	'Values within square brackets tell how many children each item has.'=>'Värden i hakparenteser berättar hur många barn varje element har.',
	'No operations found.'=>'Inga operationer hittades.',
	/**
	* views/main/tasks.php
	*/
	'Tasks'=>'Uppgifter',
	'Are you sure to delete this task?'=>'Är du säker att du vill radera denna uppgift?',
	'No tasks found.'=>'Inga uppgifter hittades.',
	/**
	* views/main/roles.php
	*/
	'Roles'=>'Roller',
	'Are you sure to delete this role?'=>'Är du säker att du vill radera denna roll?',
	'No roles found.'=>'Inga roller hittades.',
	/**
	* views/authItem/authItemForm.php
	*/
	'Save'=>'Spara',
	/**
	* views/authItem/create.php
	*/
	'Create Auth Item'=>'Skapa Auktoriserings Element',
	'Notice: Auth Item type cannot be changed afterwards.'=>'Notera: Auktoriserings elementets typ kan inte ändras i efterhand.',
	/**
	* views/authItem/update.php
	*/
	'Auth Item'=>'Auktoriserings Element',
	'Update :name'=>'Uppdatera :name',
	'This item has no parents.'=>'Detta element har inga föräldrar.',
	'Children'=>'Barn',
	'Remove'=>'Ta bort',
	'Are you sure you want to remove this child?'=>'Är du säker att du vill radera detta barn?',
	'This item has no children.'=>'Denna element har inga barn.',
	'Add Child'=>'Lägg till Barn',
	/**
	* views/assignment/user.php
	*/
	'Assignments for :username'=>'Uppdrag för användare :username',
	'Are you sure to revoke this assignment?'=>'Är du säker att du vill upphäva detta uppdrag?',
	'This user has not been assigned any auth items.'=>'Denna användare har inte tilldelats några auktoriserings element.',
	'Add Assignment'=>'Lägg till Uppdrag',
	/**
	* views/assignments/view.php
	*/
	'Assignments'=>'Uppdrag',
	'Username'=>'Användarnamn',
	'No users found.'=>'Inga användare hittades.',
);
