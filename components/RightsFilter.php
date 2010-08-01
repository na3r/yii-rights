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

		$user = Yii::app()->getUser();
		$controller = $filterChain->controller;
		$action = $filterChain->action;

		// Check if the action should always be allowed
		if( in_array($action->id, $this->_allowedActions)===false )
		{
			$authItem = '';

			// Append the module id to the authorization item name if necessary
			if( ($module = $controller->getModule())!==null )
				$authItem .= ucfirst($module->id).'_';

			// Append the controller and action id to the authorization item name
			$authItem .= ucfirst($controller->id).'_'.ucfirst($action->id);

			// Make sure the current user has access to the authorization item
			if( $user->checkAccess($authItem)!==true )
				$allow = false;
		}

		// User is not allowed access, deny access
		if( $allow===false )
		{
			$controller->accessDenied($user);
		 	return false;
		}

		// Authorization item did not exist or the user had access, allow access
		return true;
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
