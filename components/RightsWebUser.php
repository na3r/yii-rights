<?php
/**
* Rights web user class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.5
*/
class RightsWebUser extends CWebUser
{
	/**
	* @property boolean whether the user is a superuser.
	*/
	private $_isSuperuser;

	/**
	* Performs access check for this user.
	* @param string the name of the operation that need access check.
	* @param array name-value pairs that would be passed to business rules associated
	* with the tasks and roles assigned to the user.
	* @param boolean whether to allow caching the result of access checki.
	* This parameter has been available since version 1.0.5. When this parameter
	* is true (default), if the access check of an operation was performed before,
	* its result will be directly returned when calling this method to check the same operation.
	* If this parameter is false, this method will always call {@link CAuthManager::checkAccess}
	* to obtain the up-to-date access result. Note that this caching is effective
	* only within the same request.
	* @return boolean whether the operations can be performed by this user.
	*/
	public function checkAccess($operation, $params=array(), $allowCaching=true)
	{
		// Allow access when the user is a superuser
		if( $this->getIsSuperuser()===true )
			return true;

		// Otherwise do CWebUser::checkAccess
		return parent::checkAccess($operation, $params, $allowCaching);
	}

	/**
	* @return boolean whether the user is a superuser.
	*/
	public function getIsSuperuser()
	{
		if( isset($this->_isSuperuser)===false )
			$this->_isSuperuser = Rights::getAuthorizer()->isSuperuser(Yii::app()->user->id);

		return $this->_isSuperuser;
	}

	/**
	* @param boolean whether the user is a superuser.
	*/
	public function setIsSuperuser($value)
	{
		$this->_isSuperuser = $value;
	}
}
