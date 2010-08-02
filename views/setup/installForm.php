<?php
/**
* Install form configuration file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.9.8
*/
return array(
	'elements'=>array(
		'superUsers'=>array(
			'type'=>'dropdownlist',
			'items'=>array(),
			'multiple'=>'multiple',
			'style'=>'width:320px',
		),
		'overwrite'=>array(
			'type'=>'checkbox',
		),
	),
	'buttons'=>array(
		'submit'=>array(
			'type'=>'submit',
			'label'=>Yii::t('RightsModule.setup', 'Install'),
		),
	),
);