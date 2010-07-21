<?php
/**
* Auth item form configuration file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
*/
return array(
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
        'bizRule'=>array(
    		'type'=>'text',
    		'style'=>'width:320px',
    		'visible'=>Rights::getConfig('enableBizRule')===true,
    	),
    	'data'=>array(
	        'type'=>'text',
	        'style'=>'width:320px',
	        'visible'=>Rights::getConfig('enableBizRule')===true && Rights::getConfig('enableBizRuleData')===true,
	    ),
    ),
    'buttons'=>array(
        'submit'=>array(
            'type'=>'submit',
            'label'=>Yii::t('RightsModule.tr', 'Save'),
        ),
        'delete'=>array(
        	'type'=>'submit',
        	'label'=>Yii::t('RightsModule.tr', 'Delete'),
        	'visible'=>$this->model->scenario!=='create',
        ),
    ),
);