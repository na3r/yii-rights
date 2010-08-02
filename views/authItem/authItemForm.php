<?php
/**
* Authorization item form configuration file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
*/
return array(
    'elements'=>array(
    	'type'=>array(
    		'type'=>'dropdownlist',
    		'items'=>Rights::getAuthItemTypeSelectOptions(),
    		'visible'=>$this->model->scenario==='create',
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
        /*
        // FIXME: This should work as a form link but doesn't.
        'delete'=>array(
        	'type'=>'link',
        	'label'=>Yii::t('RightsModule.tr', 'Delete'),
        	'attributes'=>array(
        		//'submit'=>'authItem/delete',
        		//'params'=>array('name'=>isset($_GET['name'])===true ? $_GET['name'] : ''),
        		//'return'=>true,
        		'confirm'=>Yii::t('RightsModule.tr', 'Are you sure you want to delete this item?'),
        	),
        	'visible'=>$this->model->scenario!=='create',
        ),
        */
    ),
);
