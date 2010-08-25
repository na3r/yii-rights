<?php
class RightsAuthItemDataProvider extends CDataProvider
{
	/**
	 * @var string the primary ActiveRecord class name. The {@link getData()} method
	 * will return a list of objects of this class.
	 */
	public $modelClass = 'AuthItem';
	/**
	 * @var CActiveRecord the AR finder instance (e.g. <code>Post::model()</code>).
	 * This property can be set by passing the finder instance as the first parameter
	 * to the constructor.
	 * @since 1.1.3
	 */
	public $model;

	public $type;

	public function __construct($type, $config=array())
	{
		
	}
}
