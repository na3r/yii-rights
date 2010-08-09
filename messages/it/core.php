<?php
/**
* Italian translation for Rights core.
*
* Please contact the author if you find an error in the translation.
*
* @author Federico Prato <federico.prato@yahoo.it>
* @copyright Copyright © 2010 Federico Prato
* @since 0.9.7
*/
return array(
	/**
	* components/Rights.php
	*/
	'Operation'=>'Operazione',
	'Task'=>'Task',
	'Role'=>'Ruolo',
	/**
	* controllers/AssignmentController.php
	*/
	':name assigned.'=>':name assegnato',
	':name revoked.'=>':name revocato',
	'Invalid request. Please do not repeat this request again.'=>'Richiesta non valida. Per cortesia, non ripeterla.',
	'You are not authorized to perform this action.'=>'Non sei autorizzato a svolgere quest\'azione.',
	/**
	* controllers/AuthItemController.php
	*/
	':name created.'=>':name creato',
	':name updated.'=>':name aggiornato',
	'Child :name added.'=>'Aggiunto il figlio :name',
	'Child :name removed.'=>'Rimosso il figlio :name',
	':name deleted.'=>'Rimosso :name',
	'Authorization items created.'=>'', // FIXME: Translate
	'The requested page does not exist.'=>'La pagina richiesta non esiste',
	/**
	* models/AuthItemForm.php
	*/
	'An item with this name already exists.'=>'', // FIXME: Translate
	/**
	* views/default/(_)permissions.php
	*/
	'Permissions'=>'Permessi',
	'Permission'=>'', // FIXME: Translate
	'Revoke'=>'Revoca',
	'Inherited'=>'Ereditato',
	'Assign'=>'Assegna',
	'Hover to see from where the permission is inherited.'=>'Passa sopra con il mouse per vedere da dove viene ereditato il permesso.',
	'Parents'=>'Parenti',
	'No authorization items found.'=>'Non sono state trovate autorizzazioni.',
	/**
	* views/default/operations.php
	*/
	'Operations'=>'Operazioni',
	'Create a new operation'=>'', // FIXME: Translate
	'Name'=>'Nome',
	'Description'=>'Descrizione',
	'Business rule'=>'Regola',
	'Data'=>'Dati',
	'Delete'=>'Elimina',
	'Are you sure your want to delete this operation?'=>'Sicuro di voler eliminare l\'elemento?',
	'Values within square brackets tell how many children each item has.'=>'Il valore tra parentesi quadre indica quanti figli ha ogni oggetto.',
	'No operations found.'=>'Non sono state trovate operazioni.',
	/**
	* views/default/tasks.php
	*/
	'Tasks'=>'Task',
	'Create a new task'=>'', // FIXME: Translate
	'Are you sure your want to delete this task?'=>'Sicuro di voler eliminare l\'elemento?',
	'No tasks found.'=>'Non sono stati trovati task.',
	/**
	* views/default/roles.php
	*/
	'Roles'=>'Ruoli',
	'Create a new role'=>'', // FIXME: Translate
	'superuser'=>'super utente',
	'Are you sure your want to delete this role?'=>'Sicuro di voler eliminare l\'elemento?',
	'No roles found.'=>'Non sono stati trovati ruoli.',
	/**
	* views/authItem/authChildForm.php
	*/
	'Add'=>'Aggiungi', // FIXME: Confirm
	/**
	* views/authItem/authItemForm.php
	*/
	'Save'=>'Salva',
	/**
	* views/authItem/_generateItems.php
	*/
	'Modules'=>'', // FIXME: Translate
	/**
	* views/authItem/create.php
	*/
	'Create :type'=>'Nuovo :type', // FIXME: Confirm
	/**
	* views/authItem/generate.php
	*/
	'Auth Item Generator'=>'', // FIXME: Translate
	'Please select which authorization items you wish to generate.'=>'', // FIXME: Translate
	'Application'=>'', // FIXME: Translate
	'Select all'=>'', // FIXME: Translate
	'Select none'=>'', // FIXME: Translate
	'Generate'=>'', // FIXME: Translate
	/**
	* views/authItem/update.php
	*/
	'Auth Item'=>'Elemento',
	'Update :name'=>'Modifica :name',
	'Relations'=>'Relazioni',
	'This item has no parents.'=>'Questo oggetto non ha parenti.',
	'Children'=>'Figli',
	'Remove'=>'Rimuovi',
	'This item has no children.'=>'Questo oggetto non ha figli.',
	'Add Child'=>'Aggiungi figlio',
	'No relations need to be set for the superuser role.'=>'Per il ruolo del super utente non è necessario inserire relazioni',
	'Super users are always granted access implicitly.'=>'Ai super utenti è sempre consentito l\accesso.',
	/**
	* views/assignment/user.php
	*/
	'Assignments for :username'=>'Elementi assegnati a :username',
	'This user has not been assigned any authorization items.'=>'A questo utente non sono stati assegnati elementi.',
	'Add Assignment'=>'Nuovo elemento',
	/**
	* views/assignments/view.php
	*/
	'Assignments'=>'Elementi Assegnati',
	'Username'=>'Username',
	'No users found.'=>'Non sono stati trovati utenti.',
);