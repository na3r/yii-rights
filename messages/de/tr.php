<?php
/**
* German translations for Rights.
*
* Please contact the author if you find an error in the translation.
*
* @author Armin Pfäffle <mail@armin-pfaeffle.de>
* @copyright Copyright &copy; 2010 Armin Pfäffle
* @since 0.9.6
*/
return array(
	/**
	* components/Rights.php
	*/
	'Operation' => 'Operation',
	'Task' => 'Tätigkeit',
	'Role' => 'Rolle',
	/**
	* components/RightsFilter.php
	*/
	'You are not authorized to perform this action.' => 'Sie sind nicht berechtigt diese Aktion auszuführen.',
	/**
	* controllers/AssignmentController.php
	*/
	':name assigned.'=>':name zugewiesen.',
	':name revoked.'=>':name entzogen.',
	'Invalid request. Please do not repeat this request again.'=>'Ungültige Anfrage. Bitte wiederholen Sie die Anfrage nicht.',
	/**
	* controllers/AuthItemController.php
	*/
	':name created.'=>':name erzeugt.',
	'Could not create :name, item already exists.'=>':name konnte nicht erzeugt werden, da das Element schon existiert.',
	':name updated.'=>':name aktualisiert.',
	'Could not rename :oldName to :name, an item with that name already exists.'=>':oldName kann nicht nach :name umbenannt werden, da schon ein Element mit diesem Namen existiert.',
	'Child :name added.'=>'Kindelement :name hinzugefügt.',
	'Child :name removed.'=>'Kindelement :name entfernt.',
	':name deleted.'=>':name gelöscht.',
	'The requested page does not exist.'=>'The angeforderte Seite existiert nicht.',

	/**
	* views/main/permissions.php
	*/
	'Permissions' => 'Berechtigungen',
	'Description' => 'Beschreibung',
	'Revoke' => 'Entziehen',
	'Inherited' => 'Geerbt',
	'Assign' => 'Zuweisen',
	'Hover to see from where the permission is inherited.' => 'Von wem die Berechtigung geerbt ist kann man durch darüberhovern einsehen.',
	'Parents' => 'Elternelemente',
	'No auth items found.' => 'Keine Autorisierungselemente gefunden.',
	/**
	* views/main/operations.php
	*/
	'Operations' => 'Operationen',
	'Name' => 'Name',
	'Business rule' => 'Geschäftsregel',
	'Data' => 'Daten',
	'Delete' => 'Löschen',
	'Are you sure to delete this operation?' => 'Sind Sie sicher, dass Sie diese Operation löschen möchten?',
	'Values within square brackets tell how many children each item has.' => 'Werte in eckigen Klammern geben die Anzahl der jeweiligen Kindelemente an.',
	'No operations found.' => 'Keine Operationen gefunden.',
	/**
	* views/main/tasks.php
	*/
	'Tasks' => 'Tätigkeiten',
	'Are you sure to delete this task?' => 'Sind Sie sicher, dass Sie diese Tätigkeit löschen möchten?',
	'No tasks found.' => 'Keine Tätigkeiten gefunden.',
	/**
	* views/main/roles.php
	*/
	'Roles' => 'Rollen',
	'Are you sure to delete this role?' => 'Sind Sie sicher, dass Sie diese Rolle löschen möchten?',
	'No roles found.' => 'Keine Rollen gefunden.',
	/**
	* views/authItem/authItemForm.php
	*/
	'Save' => 'Speichern',
	/**
	* views/authItem/create.php
	*/
	'Create Auth Item' => 'Autorisierungselement erzeugen',
	'Notice: Auth Item type cannot be changed afterwards.' => 'Hinweis: Der Typ des Autorisierungselements kann im Nachhinein nicht mehr geändert werden.',
	/**
	* views/authItem/update.php
	*/
	'Auth Item' => 'Autorisierungselement ',
	'Update :name' => ':name aktualisieren',
	'This item has no parents.' => 'Dieses Element hat keine Elternelemente.',
	'Children' => 'Kindelemente',
	'Remove' => 'Entfernen',
	'Are you sure you want to remove this child?' => 'Sind Sie sicher, dass Sie dieses Kindelement entfernen möchten?',
	'This item has no children.' => 'Dieses Element hat keine Kindelemente.',
	'Add Child' => 'Kindelement hinzufügen',
	/**
	* views/assignment/user.php
	*/
	'Assignments for :username' => 'Zuweisung für :username',
	'Are you sure to revoke this assignment?' => 'Sind Sie sicher, dass Sie die Zuweisung zurücknehmen möchten?',
	'This user has not been assigned any auth items.' => 'Diesem User wurden noch keine Autorisierungselemente zugewiesen.',
	'Add Assignment' => 'Zuweisung hinzufügen',
	/**
	* views/assignments/view.php
	*/
	'Assignments' => 'Zuweisung',
	'Username' => 'Benutzername',
	'No users found.' => 'Kein Benutzer gefunden.',
);
