<?php
/**
* Hungarian translation for Rights core.
*
* Please contact the author if you find an error in the translation.
*
* @author Zsolti Győri <gyori.zsolt@gmail.com>
* @copyright Copyright &copy; 2010 Zsolti Győri
* @since 0.9.9
*/
return array(
	/**
	* components/Rights.php
	*/
	'Operation'=>'Művelet',
	'Task'=>'Feladat',
	'Role'=>'Szerepkör',
	'Invalid authorization item type.'=>'Érvénytelen hitelesítési elem típus.',
	/**
	* controllers/AssignmentController.php
	*/
	':name assigned.'=>':name hozzárendelve.',
	':name revoked.'=>':name visszavonva.',
	'Invalid request. Please do not repeat this request again.'=>'Érvénytelen kérés. Kérlek ne ismételd meg mégegyszer.',
	'You are not authorized to perform this action.'=>'Nincs jogosultságod a kért művelet végrehajtására.',
	/**
	* controllers/AuthItemController.php
	*/
	':name created.'=>':name létrehozva.',
	':name updated.'=>':name frissítve.',
	'Child :name added.'=>':name gyermek létrehozva.',
	'Child :name removed.'=>':name gyermek eltávolítva.',
	':name deleted.'=>':name törölve.',
	'Authorization items created.'=>'Létrehozott hitelesítési elemek.',
	'The requested page does not exist.'=>'A kért oldal nem létezik.',
	/**
	* models/AuthItemForm.php
	*/
	'An item with this name already exists.'=>'Ezzel a névvel már létezik elem.',
	/**
	* views/default/(_)permissions.php
	*/
	'Permissions'=>'Jogosultságok',
	'Permission'=>'Jogosultság',
	'Revoke'=>'Visszavon',
	'Inherited'=>'Örökölt',
	'Assign'=>'Hozzárendel',
	'Hover to see from where the permission is inherited.'=>'Vidd fölé az egeret, hogy meglásd honnan örökölt.',
	'Parents'=>'Szülők',
	'No authorization items found.'=>'Nincs megjeleníthető hitelesítési elem.',
	/**
	* views/default/operations.php
	*/
	'Operations'=>'Műveletek',
	'Create a new operation'=>'Új művelet',
	'Name'=>'Megnevezés',
	'Description'=>'Leírás',
	'Business rule'=>'Business rule',
	'Data'=>'Adat',
	'Delete'=>'Törlés',
	'Are you sure you want to delete this operation?'=>'Biztosan törölni szeretnéd ezt a műveletet?',
	'Values within square brackets tell how many children each item has.'=>'A szögletes zárójelben lévő értékek a gyermekek számát jelentik.',
	'No operations found.'=>'Nem található művelet.',
	/**
	* views/default/tasks.php
	*/
	'Tasks'=>'Feladatok',
	'Create a new task'=>'Új feladat létrehozása',
	'Are you sure you want to delete this task?'=>'Biztosan törölni szeretnéd ezt a műveletet?',
	'No tasks found.'=>'Nincs megjeleníthető feladat.',
	/**
	* views/default/roles.php
	*/
	'Roles'=>'Szerepkörök',
	'Create a new role'=>'Új szerepkör',
	'superuser'=>'szuper felhasználó',
	'Are you sure you want to delete this role?'=>'Biztosan törölni szeretnéd ezt a szerepkört?',
	'No roles found.'=>'Nem található szerepkör.',
	/**
	* views/authItem/authChildForm.php
	*/
	'Add'=>'Új',
	/**
	* views/authItem/authItemForm.php
	*/
	'Save'=>'Ment',
	/**
	* views/authItem/_generateItems.php
	*/
	'Modules'=>'Modulok',
	/**
	* views/authItem/create.php
	*/
	'Create :type'=>':type létrehozása',
	/**
	* views/authItem/generate.php
	*/
	'Auth Item Generator'=>'Hitelesítési elem generátor',
	'Please select which authorization items you wish to generate.'=>'Kérlek válaszd ki mely hitelesítési elemeket szeretnéd generálni.',
	'Application'=>'Alkalmazás',
	'Select all'=>'Mindet kiválaszt',
	'Select none'=>'Egyiket sem',
	'Generate'=>'Generál',
	/**
	* views/authItem/update.php
	*/
	'Auth Item'=>'Hitelesítési elem',
	'Update :name'=>':name frissítése',
	'Relations'=>'Kapcsolatok',
	'This item has no parents.'=>'Ennek az elemnek nincs szülője.',
	'Children'=>'Gyermekek',
	'Remove'=>'Eltávolít',
	'This item has no children.'=>'Ennek az elemnek nincsenek gyermekei.',
	'Add Child'=>'Új gyermek',
	'No relations need to be set for the superuser role.'=>'A szuper felhasználó szerepköréhez nem kell hozzárendelned semmit.',
	'Super users are always granted access implicitly.'=>'A szuper felhasználóknak automatikusan korlátlan hozzáférésük van.',
	/**
	* views/assignment/user.php
	*/
	'Assignments for :username'=>':username hozzárendelései',
	'This user has not been assigned any authorization items.'=>'Ehhez a felhasználóhoz nincs hozzárendelve egy hitelesítési elem sem.',
	'Add Assignment'=>'Új hozzárendelés',
	/**
	* views/assignment/view.php
	*/
	'Assignments'=>'Hozzárendelések',
	'Username'=>'Felhasználónév',
	'No users found.'=>'Nincs megjeleníthető felhasználó.',
	/**
	* views/_menu.php
	*/
	'Generator'=>'Generátor',
);
