<?php
/**
* Installation form class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.9.8
*/
class InstallForm extends CFormModel
{
	public $superUsers;
	public $overwrite;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('superUsers', 'required'),
			array('overwrite', 'safe'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'superUsers'	=> Yii::t('RightsModule.setup', 'Super users'),
			'overwrite'		=> Yii::t('RightsModule.setup', 'Overwrite'),
		);
	}
}
