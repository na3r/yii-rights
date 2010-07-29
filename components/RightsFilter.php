<?php
/**
* Rights filter class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.7
*/
class RightsFilter extends CFilter
{
	protected $_allowedActions;

	/**
	* Performs the pre-action filtering.
	* @param CFilterChain the filter chain that the filter is on.
	* @return boolean whether the filtering process should continue and the action
	* should be executed.
	*/
	protected function preFilter($filterChain)
	{
		// By default we assume that the user is allowed access
		$allow = true;

		$user = Yii::app()->user;
		$controllerId = $filterChain->controller->id;
		$actionId = $filterChain->action->id;

		// Check if the action should always be allowed
		if( in_array($actionId, $this->_allowedActions)===false )
		{
			// Generate the authorization item name
			$authItem = '';

			// We are in a module, append the module id to the auth item name
			$module = $filterChain->controller->module;
			if( $module!==null )
				$authItem .= ucfirst($module->id).'_';

			$authItem .= ucfirst($controllerId).'_'.ucfirst($actionId);

			// Make sure the logged in user has access to the authorization item
			if( $user->checkAccess($authItem)!==true )
				$allow = false;
		}

		// User is not allowed access, deny access
		if( $allow===false )
		{
			$this->accessDenied($user);
			return false;
		}

		// Authorization item did not exist or the user had access, allow access
		return true;
	}

	/**
	* Denies the access of the user.
	* This method is invoked when access check fails.
	* @param IWebUser the current user
	*/
	protected function accessDenied($user)
	{
		if( $user->getIsGuest()===true )
			$user->loginRequired();
		else
			throw new CHttpException(403, Yii::t('RightsModule.tr', 'You are not authorized to perform this action.'));
	}

	/**
	* Sets the allowed actions.
	* @param string the actions that are always allowed separated by commas.
	*/
	public function setAllowedActions($allowedActions)
	{
		$this->_allowedActions = preg_split('/[\s,]+/', $allowedActions, -1, PREG_SPLIT_NO_EMPTY);
	}
}
