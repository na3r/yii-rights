<?php
/**
* Auth item form class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.9
*/
class ChildForm extends CFormModel
{
	public $child;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('child', 'required'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'child' => Yii::t('RightsModule.tr', 'Child'),
		);
	}
}
