<?php
/**
* Finnish translation for Rights core.
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
	'Invalid authorization item type.'=>'Virheellinen auktorisointi elementti tyyppi.',
	/**
	* controllers/AssignmentController.php
	*/
	':name assigned.'=>':name myönnetty.',
	':name revoked.'=>':name evätty.',
	'Invalid request. Please do not repeat this request again.'=>'Virheellinen pyyntö. Älä toista tätä pyyntöä.',
	'You are not authorized to perform this action.'=>'Et ole oikeutettu suorittamaan tätä toimintoa.',
	/**
	* controllers/AuthItemController.php
	*/
	':name created.'=>':name luotu.',
	':name updated.'=>':name päivitetty.',
	'Child :name added.'=>'Lapsi :name lisätty.',
	'Child :name removed.'=>'Lapsi :name poistettu.',
	':name deleted.'=>':name poistettu.',
	'Authorization items created.'=>'Auktorisointi elementit luotu.',
	'The requested page does not exist.'=>'Pyydettyä sivua ei ole olemassa.',
	/**
	* models/AuthItemForm.php
	*/
	'An item with this name already exists.'=>'Nimi on jo käytössä.',
	/**
	* models/AuthItemModel.php
	*/
	'Name'=>'Nimi',
	'Type'=>'Tyyppi',
	'Description'=>'Kuvaus',
	'Business rule'=>'Business sääntö',
	'Data'=>'Data',
	'superuser'=>'ylikäyttäjä',
	'Delete'=>'Poista',
	'Are you sure you want to delete this operation?'=>'Oletko varma että haluat poistaa tämän operaation?',
	'Are you sure you want to delete this task?'=>'Oletko varma että haluat poistaa tämän tehtävän?',
	'Are you sure you want to delete this role?'=>'Oletko varma että haluat poistaa tämän roolin?',
	'Remove'=>'Poista',
	'Revoke'=>'Evää',
	/**
	* views/default/(_)permissions.php
	*/
	'Permissions'=>'Oikeudet',
	'Permission'=>'Oikeus',
	'Inherited'=>'Peritty',
	'Assign'=>'Myönnä',
	'Hover to see from where the permission is inherited.'=>'Vie hiiren kursori päälle nähdäksesi mistä oikeus on peritty.',
	'Parents'=>'Vanhemmat',
	'No authorization items found.'=>'Yhtään auktorisointi elementtiä ei löytynyt.',
	/**
	* views/default/operations.php
	*/
	'Operations'=>'Operaatiot',
	'Create a new operation'=>'Luo operaatio',
	'Values within square brackets tell how many children each item has.'=>'Hakasuluissa olevat luvut kertovat monta lasta kullakin kohteella on.',
	'No operations found.'=>'Yhtään operaatiota ei löytynyt.',
	/**
	* views/default/tasks.php
	*/
	'Tasks'=>'Tehtävät',
	'Create a new task'=>'Luo tehtävä',
	'No tasks found.'=>'Yhtään tehtävää ei löytynyt.',
	/**
	* views/default/roles.php
	*/
	'Roles'=>'Roolit',
	'Create a new role'=>'Luo rooli',
	'No roles found.'=>'Yhtään roolia ei löytynyt.',
	/**
	* views/authItem/authChildForm.php
	*/
	'Add'=>'Lisää',
	/**
	* views/authItem/authItemForm.php
	*/
	'Save'=>'Tallenna',
	/**
	* views/authItem/_generateItems.php
	*/
	'Modules'=>'Moduulit',
	/**
	* views/authItem/create.php
	*/
	'Create :type'=>'Luo :type',
	/**
	* views/authItem/generate.php
	*/
	'Auth Item Generator'=>'Auktorisointi elementti Generaattori',
	'Please select which authorization items you wish to generate.'=>'Valitse mitkä elementit haluat generoida.',
	'Application'=>'Sovellus',
	'Select all'=>'Valitse kaikki',
	'Select none'=>'Poista valinnat',
	'Generate'=>'Generoi',
	/**
	* views/authItem/update.php
	*/
	'Auth Item'=>'Auktorisointi elementti',
	'Update :name'=>'Päivitä :name',
	'Relations'=>'Yhteydet',
	'This item has no parents.'=>'Tällä kohteella ei ole yhtään vanhempaa.',
	'Children'=>'Lapset',
	'This item has no children.'=>'Tällä kohteella ei ole yhtään lasta.',
	'Add Child'=>'Lisää Lapsi',
	'No relations need to be set for the superuser role.'=>'Yhteyksiä ei tarvitse määrittää ylikäyttäjä-roolille.',
	'Super users are always granted access implicitly.'=>'Ylikäyttäjille myönnetään aina pääsy ehdotta.',
	/**
	* views/assignment/user.php
	*/
	'Assignments for :username'=>'Käyttäjän :username toimeksiannot',
	'This user has not been assigned any authorization items.'=>'Tälle käyttäjälle ei ole määrätty yhtään auktorisointi elementtiä.',
	'Add Assignment'=>'Lisää Toimeksianto',
	/**
	* views/assignments/view.php
	*/
	'Assignments'=>'Toimeksiannot',
	'Username'=>'Käyttäjänimi',
	'No users found.'=>'Yhtään käyttäjää ei löytynyt.',
	/**
	* views/_menu.php
	*/
	'Generator'=>'Generaattori',
);
