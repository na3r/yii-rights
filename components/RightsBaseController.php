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
	* Actions to be taken on access denied.
	*/
	protected function accessDenied()
	{
		throw new CHttpException(403, Yii::t('RightsModule.tr', 'You are not authorized to perform this action.'));
	}
}
