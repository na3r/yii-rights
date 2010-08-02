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
	'Could not create :name, item already exists.'=>'Non è stato possibile creare :name, l\'oggetto esiste già.',
	':name updated.'=>':name aggiornato',
	'Could not rename :oldName to :name, an item with that name already exists.'=>'Non è stato possibile rinominare :oldName in :name, poiché il nome è già in uso.',
	'Child :name added.'=>'Aggiunto il figlio :name',
	'Child :name removed.'=>'Rimosso il figlio :name',
	':name deleted.'=>'Rimosso :name',
	'The requested page does not exist.'=>'La pagina richiesta non esiste',
	/**
	* views/default/(_)permissions.php
	*/
	'Permissions'=>'Permessi',
	'Description'=>'Descrizione',
	'No description'=>'', // ?
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
	'Name'=>'Nome',
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
	'Are you sure your want to delete this task?'=>'Sicuro di voler eliminare l\'elemento?',
	'No tasks found.'=>'Non sono stati trovati task.',
	/**
	* views/default/roles.php
	*/
	'Roles'=>'Ruoli',
	'super user'=>'super utente',
	'Are you sure your want to delete this role?'=>'Sicuro di voler eliminare l\'elemento?',
	'Roles can be organized by dragging and dropping.'=>'È possibile organizzare i ruoli trascinandoli e rilasciandoli',
	'No roles found.'=>'Non sono stati trovati ruoli.',
	/**
	* views/authItem/authChildForm.php
	*/
	'Add'=>'Aggiungi', // Check
	/**
	* views/authItem/authItemForm.php
	*/
	'Save'=>'Salva',
	/**
	* views/authItem/create.php
	*/
	'Create Auth Item'=>'Nuovo Elemento',
	'Notice: Auth Item type cannot be changed afterwards.'=>'Attenzione: in seguito sarà impossibile modificare il tipo di autorizzazione.',
	/**
	* views/authItem/update.php
	*/
	'Auth Item'=>'Elemento',
	'Update :name'=>'Modifica :name',
	'Relations'=>'Relazioni',
	'This item has no parents.'=>'Questo oggetto non ha parenti.',
	'Children'=>'Figli',
	'Remove'=>'Rimuovi',
	'Are you sure you want to remove this child?'=>'Sicuro di voler rimuovere questo figlio?',
	'This item has no children.'=>'Questo oggetto non ha figli.',
	'Add Child'=>'Aggiungi figlio',
	'No relations need to be set for the super user role.'=>'Per il ruolo del super utente non è necessario inserire relazioni',
	'Super users are always granted access implicitly.'=>'Ai super utenti è sempre consentito l\accesso.',
	/**
	* views/assignment/user.php
	*/
	'Assignments for :username'=>'Elementi assegnati a :username',
	'Are you sure to revoke this assignment?'=>'Sicuro di voler revocare questo elemento?',
	'This user has not been assigned any auth items.'=>'A questo utente non sono stati assegnati elementi.',
	'Add Assignment'=>'Nuovo elemento',
	/**
	* views/assignments/view.php
	*/
	'Assignments'=>'Elementi Assegnati',
	'Username'=>'Username',
	'No users found.'=>'Non sono stati trovati utenti.',
);