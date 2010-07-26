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
	* @var RightsAuthorizer
	*/
	private $_authorizer;

	/**
	* @var bool Whether the user is a super user?
	*/
	public $isSuperUser;

	/**
	* Initialization.
	*/
	public function init()
	{
		$this->_authorizer = Rights::getAuthorizer();

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
		// Check if user is super user if not already checked
		if( isset($this->isSuperUser)===false )
			$this->isSuperUser = $this->_authorizer->isSuperUser();

		// Allow access when the user is a super user
		if( $this->isSuperUser===true )
			return true;

		// Otherwise do CWebUser::checkAccess
		return parent::checkAccess($operation, $params, $allowCaching);
	}
}
