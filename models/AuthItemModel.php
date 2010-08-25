<?php
/**
* Rights authorization item model class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.9.10
*/
class AuthItemModel extends CModel
{
	public $name;
	public $description;
	public $type;
	public $bizRule;
	public $data;
	public $userId;
	public $owner;
	public $childCount;

	/**
	* Declares attribute labels.
	*/
	public function attributeLabels()
	{
		return array(
			'name'			=> Yii::t('RightsModule.core', 'Name'),
			'description'	=> Yii::t('RightsModule.core', 'Description'),
			'type'			=> Yii::t('RightsModule.core', 'Type'),
			'bizRule'		=> Yii::t('RightsModule.core', 'Business rule'),
			'data'			=> Yii::t('RightsModule.core', 'Data'),
		);
	}

	/**
	* Returns the markup for the name column.
	* @param boolean whether to show the child count.
	* @param boolean whether to show the sortable id.
	* @return string the markup.
	*/
	public function nameColumn($childCount=false, $sortableId=false)
	{
		$markup = CHtml::link(Rights::beautifyName($this->name), array('authItem/update', 'name'=>$this->name, 'redirect'=>urlencode(Rights::getAuthItemRoute($this->type))));
		$markup.= $childCount===true ? $this->childCount() : '';
		$markup.= $sortableId===true ? $this->sortableId() : '';
		return $markup;
	}

	/**
	* Returns the markup for the name column.
	* @param boolean whether to show the child count.
	* @param boolean whether to show the sortable id.
	* @param boolean whether to show the super user indicator.
	* @return string the markup.
	*/
	public function nameRoleColumn($childCount=false, $sortableId=false, $superuserIndicator=false)
	{
		$markup = $this->nameColumn($childCount, $sortableId);
		$markup.= $this->name===Rights::module()->superuserName ? $this->superuserIndicator() : '';
		return $markup;
	}

	/**
	* Returns the markup for the super user indicator.
	* @return string the markup.
	*/
	public function superuserIndicator()
	{
		return '<span class="superuser">(<span class="superuserText">'.Yii::t('RightsModule.core', 'superuser').'</span>)</span>';
	}

	/**
	* Returns the markup for the child count.
	* @return string the markup.
	*/
	public function childCount()
	{
		return $this->childCount>0 ? ' <span class="childCount">[ <span class="childCountNumber">'.$this->childCount.'</span> ]</span>' : '';
	}

	/**
	* Returns the markup for the id required by jQuery UI sortable.
	* @return string the markup.
	*/
	public function sortableId()
	{
	 	return ' <span class="authItemName" style="display:none;">'.$this->name.'</span>';
	}

	/**
	* Returns the markup for the type column.
	* @return string the markup.
	*/
	public function typeColumn()
	{
		return Rights::getAuthItemTypeName($this->type);
	}

	/**
	* Returns the markup for the delete operation column.
	* @return string the markup.
	*/
	public function deleteOperationColumn()
	{
		return CHtml::linkButton(Yii::t('RightsModule.core', 'Delete'), array(
			'submit'=>array('authItem/delete', 'name'=>$this->name, 'redirect'=>urlencode('default/operations')),
			'confirm'=>Yii::t('RightsModule.core', 'Are you sure you want to delete this operation?'),
			'class'=>'deleteLink',
		));
	}

	/**
	* Returns the markup for the delete task column.
	* @return string the markup.
	*/
	public function deleteTaskColumn()
	{
		return CHtml::linkButton(Yii::t('RightsModule.core', 'Delete'), array(
			'submit'=>array('authItem/delete', 'name'=>$this->name, 'redirect'=>urlencode('default/tasks')),
			'confirm'=>Yii::t('RightsModule.core', 'Are you sure you want to delete this task?'),
			'class'=>'deleteLink',
		));
	}

	/**
	* Returns the markup for the delete role column.
	* @return string the markup.
	*/
	public function deleteRoleColumn()
	{
		return CHtml::linkButton(Yii::t('RightsModule.core', 'Delete'), array(
			'submit'=>array('authItem/delete', 'name'=>$this->name, 'redirect'=>urlencode('default/roles')),
			'confirm'=>Yii::t('RightsModule.core', 'Are you sure you want to delete this role?'),
			'class'=>'deleteLink',
		));
	}

	/**
	* Returns the markup for the remove child column.
	* @return string the markup.
	*/
	public function removeChildColumn()
	{
		return CHtml::linkButton(Yii::t('RightsModule.core', 'Remove'), array(
			'submit'=>array('authItem/removeChild', 'name'=>$this->owner->name, 'child'=>$this->name),
			'class'=>'removeLink',
		));
	}

	/**
	* Returns the markup for the revoke assignment column.
	* @return string the markup.
	*/
	public function revokeAssignmentColumn()
	{
		return CHtml::linkButton(Yii::t('RightsModule.core', 'Revoke'), array(
			'submit'=>array('assignment/revoke', 'id'=>$this->userId, 'name'=>$this->name),
			'class'=>'revokeLink',
		));
	}

	/**
	* Returns the list of attribute names.
	* By default, this method returns all public properties of the class.
	* You may override this method to change the default.
	* @return array list of attribute names. Defaults to all public properties of the class.
	*/
	public function attributeNames()
	{
		$className=get_class($this);
		if(!isset(self::$_names[$className]))
		{
			$class=new ReflectionClass(get_class($this));
			$names=array();
			foreach($class->getProperties() as $property)
			{
				$name=$property->getName();
				if($property->isPublic() && !$property->isStatic())
					$names[]=$name;
			}
			return self::$_names[$className]=$names;
		}
		else
			return self::$_names[$className];
	}
}
