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
	'Operation'=>'Operaatio',
	'Task'=>'Tehtävä',
	'Role'=>'Rooli',
	/**
	* components/RightsFilter.php
	*/
	'You are not authorized to perform this action.'=>'Et ole oikeutettu suorittamaan tätä toimintoa.',
	/**
	* controllers/AssignmentController.php
	*/
	':name assigned.'=>':name myönnetty.',
	':name revoked.'=>':name evätty.',
	'Invalid request. Please do not repeat this request again.'=>'Virheellinen pyyntö. Älä toista tätä pyyntöä.',
	/**
	* controllers/AuthItemController.php
	*/
	':name created.'=>':name luotu.',
	'Could not create :name, item already exists.'=>'Kohdetta ei pystytty luomaan, kohde on jo olemassa.',
	':name updated.'=>':name päivitetty.',
	'Could not rename :oldName to :name, an item with that name already exists.'=>'Nimeä :oldName ei voitu vaihtaa, kohde nimeltä :name on jo olemassa.',
	'Child :name added.'=>'Lapsi :name lisätty.',
	'Child :name removed.'=>'Lapsi :name poistettu.',
	':name deleted.'=>':name poistettu.',
	'The requested page does not exist.'=>'Pyydettyä sivua ei ole olemassa.',
	/**
	* views/main/permissions.php
	*/
	'Permissions'=>'Oikeudet',
	'Description'=>'Kuvaus',
	'Revoke'=>'Evää',
	'Inherited'=>'Peritty',
	'Assign'=>'Myönnä',
	'Hover to see from where the permission is inherited.'=>'Vie hiiren kursori päälle nähdäksesi mistä oikeus on peritty.',
	'Parents'=>'Vanhemmat',
	'No auth items found.'=>'Yhtään kohdetta ei löytynyt.',
	/**
	* views/main/operations.php
	*/
	'Operations'=>'Operaatiot',
	'Name'=>'Nimi',
	'Business rule'=>'Business sääntö',
	'Data'=>'Data',
	'Delete'=>'Poista',
	'Are you sure you want to delete this operation?'=>'Oletko varma että haluat poistaa tämän operaation?',
	'Values within square brackets tell how many children each item has.'=>'Hakasuluissa olevat luvut kertovat monta lasta kullakin kohteella on.',
	'No operations found.'=>'Yhtään operaatiota ei löytynyt.',
	/**
	* views/main/tasks.php
	*/
	'Tasks'=>'Tehtävät',
	'Are you sure you want to delete this task?'=>'Oletko varma että haluat poistaa tämän tehtävän?',
	'No tasks found.'=>'Yhtään tehtävää ei löytynyt.',
	/**
	* views/main/roles.php
	*/
	'Roles'=>'Roolit',
	'super user'=>'ylikäyttäjä',
	'Are you sure you want to delete this role?'=>'Oletko varma että haluat poistaa tämän roolin?',
	'Roles can be organized by dragging and dropping.'=>'Roolit voidaan uudelleenjärjestää vetämällä ja tiputtamalla.',
	'No roles found.'=>'Yhtään roolia ei löytynyt.',
	/**
	* views/authItem/authItemForm.php
	*/
	'Save'=>'Tallenna',
	/**
	* views/authItem/create.php
	*/
	'Create Auth Item'=>'Luo Valtuutus',
	'Notice: Auth Item type cannot be changed afterwards.'=>'Huom! Valtuutuksen tyyppiä ei voi vaihtaa jälkeenpäin.',
	/**
	* views/authItem/update.php
	*/
	'Auth Item'=>'Valtuutus',
	'Update :name'=>'Päivitä :name',
	'Relations'=>'Yhteydet',
	'This item has no parents.'=>'Tällä kohteella ei ole yhtään vanhempaa.',
	'Children'=>'Lapset',
	'Remove'=>'Poista',
	'Are you sure you want to remove this child?'=>'Oletko varma että haluat poistaa tämän lapsen?',
	'This item has no children.'=>'Tällä kohteella ei ole yhtään lasta.',
	'Add Child'=>'Lisää Lapsi',
	'No relations needs to be set for the super user role.'=>'Yhteyksiä ei tarvitse määrittää ylikäyttäjä-roolille.',
	'Super users are always granted access implicitly.'=>'Ylikäyttäjille myönnetään aina pääsy ehdotta.',
	/**
	* views/assignment/user.php
	*/
	'Assignments for :username'=>'Käyttäjän :username toimeksiannot',
	'Are you sure to revoke this assignment?'=>'Oletko varma että haluat evätä tämän toimeksiannon?',
	'This user has not been assigned any auth items.'=>'Tälle käyttäjälle ei ole määrätty yhtään valtuutusta.',
	'Add Assignment'=>'Lisää Toimeksianto',
	/**
	* views/assignments/view.php
	*/
	'Assignments'=>'Toimeksiannot',
	'Username'=>'Käyttäjänimi',
	'No users found.'=>'Yhtään käyttäjää ei löytynyt.',
);
