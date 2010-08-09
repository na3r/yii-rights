<?php
/**
* German translation for Rights core.
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
	'Operation'=>'Operation',
	'Task'=>'Tätigkeit',
	'Role'=>'Rolle',
	/**
	* controllers/AssignmentController.php
	*/
	':name assigned.'=>':name zugewiesen.',
	':name revoked.'=>':name entzogen.',
	'Invalid request. Please do not repeat this request again.'=>'Ungültige Anfrage. Bitte wiederholen Sie die Anfrage nicht.',
	'You are not authorized to perform this action.'=>'Sie sind nicht berechtigt diese Aktion auszuführen.',
	/**
	* controllers/AuthItemController.php
	*/
	':name created.'=>':name erzeugt.',
	':name updated.'=>':name aktualisiert.',
	'Child :name added.'=>'Kindelement :name hinzugefügt.',
	'Child :name removed.'=>'Kindelement :name entfernt.',
	':name deleted.'=>':name gelöscht.',
	'The requested page does not exist.'=>'The angeforderte Seite existiert nicht.',
	/**
	* models/AuthItemForm.php
	*/
	'An item with this name already exists.'=>'Ein Element mit diesem Namen existiert schon.',
	/**
	* views/default/(_)permissions.php
	*/
	'Permissions'=>'Berechtigungen',
	'Permission'=>'Berechtigung', // Confirm
	'Revoke'=>'Entziehen',
	'Inherited'=>'Geerbt',
	'Assign'=>'Zuweisen',
	'Hover to see from where the permission is inherited.'=>'Von wem die Berechtigung geerbt ist kann man durch darüberhovern einsehen.',
	'Parents'=>'Elternelemente',
	'No authorization items found.'=>'Keine Autorisierungselemente gefunden.',
	/**
	* views/default/operations.php
	*/
	'Operations'=>'Operationen',
	'Name'=>'Name',
	'Description'=>'Beschreibung',
	'Business rule'=>'Geschäftsregel',
	'Data'=>'Daten',
	'Delete'=>'Löschen',
	'Are you sure to delete this operation?'=>'Sind Sie sicher, dass Sie diese Operation löschen möchten?',
	'Values within square brackets tell how many children each item has.'=>'Werte in eckigen Klammern geben die Anzahl der jeweiligen Kindelemente an.',
	'No operations found.'=>'Keine Operationen gefunden.',
	/**
	* views/default/tasks.php
	*/
	'Tasks'=>'Tätigkeiten',
	'Are you sure to delete this task?'=>'Sind Sie sicher, dass Sie diese Tätigkeit löschen möchten?',
	'No tasks found.'=>'Keine Tätigkeiten gefunden.',
	/**
	* views/default/roles.php
	*/
	'Roles'=>'Rollen',
	'superuser'=>'Super User',
	'Are you sure to delete this role?'=>'Sind Sie sicher, dass Sie diese Rolle löschen möchten?',
	'Roles can be organized by dragging and dropping.'=>'Rollen konnen via Drag & Drop geordnet werden.',
	'No roles found.'=>'Keine Rollen gefunden.',
	/**
	* views/authItem/authChildForm.php
	*/
	'Add'=>'Hinzufügen',
	/**
	* views/authItem/authItemForm.php
	*/
	'Save'=>'Speichern',
	/**
	* views/authItem/create.php
	*/
	'Create Auth Item'=>'Autorisierungselement erzeugen',
	'Notice: Auth Item type cannot be changed afterwards.'=>'Hinweis: Der Typ des Autorisierungselements kann im Nachhinein nicht mehr geändert werden.',
	/**
	* views/authItem/update.php
	*/
	'Auth Item'=>'Autorisierungselement ',
	'Update :name'=>':name aktualisieren',
	'Relations'=>'Relationen',
	'This item has no parents.'=>'Dieses Element hat keine Elternelemente.',
	'Children'=>'Kindelemente',
	'Remove'=>'Entfernen',
	'This item has no children.'=>'Dieses Element hat keine Kindelemente.',
	'Add Child'=>'Kindelement hinzufügen',
	'No relations need to be set for the superuser role.'=>'Für die Super User-Rolle brauchen keine Relationen gesetzt werden.',
	'Super users are always granted access implicitly.'=>'Super User haben implizit immer Zugang.',
	/**
	* views/assignment/user.php
	*/
	'Assignments for :username'=>'Zuweisung für :username',
	'This user has not been assigned any authorization items.'=>'Diesem User wurden noch keine Autorisierungselemente zugewiesen.',
	'Add Assignment'=>'Zuweisung hinzufügen',
	/**
	* views/assignments/view.php
	*/
	'Assignments'=>'Zuweisung',
	'Username'=>'Benutzername',
	'No users found.'=>'Kein Benutzer gefunden.',
);
