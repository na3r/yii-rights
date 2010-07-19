<?php
/**
* Authorization base controller class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.6
*/
class RightsBaseController extends CController
{
	/**
	* @var array the breadcrumbs of the current page. The value of this property will
	* be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	* for more details on how to specify this property.
	*/
	public $breadcrumbs = array();

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
	* @return string always allowed actions
	*/
	public function allowedActions()
	{
		return '';
	}
}
