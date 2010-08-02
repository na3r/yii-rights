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
	public $overwrite;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('overwrite', 'safe'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'overwrite'	=> Yii::t('RightsModule.setup', 'Overwrite'),
		);
	}

	/**
	* Validator to check whether Rights can be installed.
	* @return boolean the validation result.
	*/
	public function canInstall()
	{
		$installer = Rights::getModule()->getInstaller();
		if( $installer->isInstalled===false || $installer->isInstalled===true && (bool)$this->overwrite!==false )
		{
			return true;
		}
		else
		{
			Yii::app()->user->setFlash('rightsError',
				Yii::t('RightsModule.setup', 'Rights is already installed! Select "Overwrite" to reinstall.')
			);
			return false;
		}
	}
}
