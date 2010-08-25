<?php
/**
* Rights user behavior class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.9.10
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

	/**
	* Returns a link labeled with the username pointing to the users assignments.
	* @return string the link html.
	*/
	public function getAssignmentNameLink()
	{
		return CHtml::link($this->getName(), array('assignment/user', 'id'=>$this->getId()));
	}

	/**
	* Gets the users assignments.
	* @return string the assignments.
	*/
	public function getAssignments()
	{
		$items = Rights::getAuthorizer()->authManager->getAuthAssignments($this->getId());
		$assignments = $items!==array() ? implode(', ', array_map(array('Rights', 'beautifyName'), array_keys($items))) : '';
		return $assignments;
	}
}
