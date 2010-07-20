<?php
/**
* Auth item form configuration file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
*/
$config = array(
    'elements'=>array(
    	'type'=>array(
    		'type'=>'dropdownlist',
    		'items'=>Rights::getAuthItemTypeSelectOptions(),
    	),
        'name'=>array(
            'type'=>'text',
            'maxlength'=>64,
            'style'=>'width:320px',
        ),
        'description'=>array(
            'type'=>'text',
            'style'=>'width:320px',
        ),
    ),

    'buttons'=>array(
        'submit'=>array(
            'type'=>'submit',
            'label'=>Yii::t('RightsModule.tr', 'Save'),
        ),
    ),
);

// Enable business rules if needed
if( Rights::getConfig('enableBizRule')===true )
{
	$config['elements']['bizRule'] = array(
    	'type'=>'text',
    	'style'=>'width:320px',
    );

	// Also enable data for business rules if needed
	if( Rights::getConfig('enableBizRuleData')===true )
	{
	    $config['elements']['data'] = array(
	        'type'=>'text',
	        'style'=>'width:320px',
	    );
	}
}

return $config;