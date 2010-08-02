<?php
/**
* Rights base controller class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.6
*/
class RightsBaseController extends CController
{
	/**
	* The filter method for 'rights' access filter.
	* This filter is a wrapper of {@link CAccessControlFilter}.
	* @param CFilterChain the filter chain that the filter is on.
	*/
	public function filterRights($filterChain)
	{
		$filter = new RightsFilter;
		$filter->allowedActions = $this->allowedActions();
		$filter->filter($filterChain);
	}

	/**
	* @return string the actions that are always allowed separated by commas.
	*/
	public function allowedActions()
	{
		return '';
	}

	/**
	* Denies the access of the user.
	* This method is invoked when access check fails.
	* @param IWebUser the current user
	*/
	public function accessDenied($user)
	{
		if( $user->getIsGuest()===true )
			$user->loginRequired();
		else
			throw new CHttpException(403, Yii::t('RightsModule.core', 'You are not authorized to perform this action.'));
	}
}
