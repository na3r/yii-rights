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

		return $this->owner->{$this->idColumn};
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

		return $this->owner->{$this->nameColumn};
	}

	/**
	* Returns a link labeled with the username pointing to the users assignments.
	* @return string the link markup.
	*/
	public function getAssignmentNameLink()
	{
		return CHtml::link($this->getName(), array('assignment/user', 'id'=>$this->getId()));
	}

	/**
	* Gets the users assignments.
	* @param boolean whether to include the authorization item type.
	* @return string the assignments markup.
	*/
	public function getAssignments($includeType=false)
	{
		$assignedItems = array();

		$authorizer = Rights::getAuthorizer();
		$assignments = $authorizer->authManager->getAuthAssignments($this->getId());

		// We need to include the type in the markup
		if( $includeType===true )
		{
			$items = $authorizer->authManager->getAuthItemsByNames(array_keys($assignments));
			foreach( $items as $n=>$i )
				$assignedItems[] = Rights::beautifyName($n).' (<span class="typeText">'.Rights::getAuthItemTypeName($i->type).'</span>)';
		}
		else
		{
			foreach( $assignments as $n=>$a )
				$assignedItems[] = Rights::beautifyName($n);
		}

		return implode(', ', $assignedItems);
	}
}
