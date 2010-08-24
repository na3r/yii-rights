<?php
/**
* Rights user behavior class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.9.9
*/
class RightsUserBehavior extends CModelBehavior
{
	public $idColumn;
	public $nameColumn;

	/**
	* Returns the value of the owner's id column.
	* Attribute name is retrived from the module configuration.
	* @return string the id.
	*/
	public function getId()
	{
		if( $this->idColumn===null )
			$this->idColumn = Rights::module()->userIdColumn;

		$attribute = $this->idColumn;
		return $this->owner->$attribute;
	}

	/**
	* Returns the value of the owner's name column.
	* Attribute name is retrived from the module configuration.
	* @return string the name.
	*/
	public function getName()
	{
		if( $this->nameColumn===null )
			$this->nameColumn = Rights::module()->userNameColumn;

		$attribute = $this->nameColumn;
		return $this->owner->$attribute;
	}
}
