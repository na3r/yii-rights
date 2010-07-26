<?php
/**
* Auth item child form configuration file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
*/
return array(
	'elements'=>array(
		'name'=>array(
			'type'=>'dropdownlist',
			'items'=>array(), // Kind of a hack, but this will be popuplate later
		),
	),
	'buttons'=>array(
		'submit'=>array(
			'type'=>'submit',
			'label'=>Yii::t('RightsModule.tr', 'Add'),
		),
	),
);
