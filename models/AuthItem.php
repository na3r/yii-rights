<?php
class AuthItem extends CModel
{
	public $name;
	public $description;
	public $type;
	public $bizRule;
	public $data;

	/**
	* Declares attribute labels.
	*/
	public function attributeLabels()
	{
		return array(
			'name'			=> Yii::t('RightsModule.core', 'Name'),
			'description'	=> Yii::t('RightsModule.core', 'Description'),
			'bizRule'		=> Yii::t('RightsModule.core', 'Business rule'),
			'data'			=> Yii::t('RightsModule.core', 'Data'),
		);
	}
}