<?php
/**
* Rights web user component class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.5
*/
class RightsWebUser extends CWebUser
{
	/**
	* @var RightsModule
	*/
	private $_module;

	/**
	* @var bool User is super user?
	*/
	private $_isSuperUser = false;

	/**
	* Initialization.
	*/
	public function init()
	{
		$this->_module = Yii::app()->getModule('rights');

		parent::init();
	}

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
		// Allow access without checking when the user is a super user
		if( $this->_isSuperUser===true )
			return true;

		// User is super user and therefore allowed access
		if( $this->_module->auth->isSuperUser()===true )
		{
			$this->_isSuperUser = true;
			return true;
		}

		// Otherwise do CWebUser::checkAccess
		return parent::checkAccess($operation, $params, $allowCaching);
	}
}
