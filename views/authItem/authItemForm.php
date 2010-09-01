<?php
/**
* Authorization item form configuration file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
*/
return array(
    'elements'=>array(
        'name'=>array(
            'type'=>'text',
            'hint'=>Yii::t('RightsModule.core', 'Do not change the name unless you know what you are doing!'),
            'maxlength'=>64,
            'style'=>'width:320px',
        ),
        'description'=>array(
            'type'=>'text',
            'hint'=>Yii::t('RightsModule.core', 'A descriptive name for this item.'),
            'style'=>'width:320px',
        ),
        'bizRule'=>array(
    		'type'=>'text',
    		'hint'=>Yii::t('RightsModule.core', 'Code that will be executed when performing access checking.'),
    		'style'=>'width:320px',
    		'visible'=>Rights::module()->enableBizRule===true,
    	),
    	'data'=>array(
	        'type'=>'text',
	        'hint'=>Yii::t('RightsModule.core', 'Additional data available when executing the business rule.'),
	        'style'=>'width:320px',
	        'visible'=>Rights::module()->enableBizRule===true && Rights::module()->enableBizRuleData===true,
	    ),
    ),
    'buttons'=>array(
        'submit'=>array(
            'type'=>'submit',
            'label'=>Yii::t('RightsModule.core', 'Save'),
        ),
		/*
        // FIXME: This should work as a form link but doesn't.
        'delete'=>array(
        	'type'=>'link',
        	'label'=>Yii::t('RightsModule.core', 'Delete'),
        	'attributes'=>array(
        		'submit'=>'authItem/delete',
        		'params'=>array('name'=>isset($_GET['name'])===true ? $_GET['name'] : ''),
        		//'return'=>true,
        		'confirm'=>Yii::t('RightsModule.core', 'Are you sure you want to delete this item?'),
        	),
        	'visible'=>$this->model->scenario==='update',
        ),
		*/
    ),
);
