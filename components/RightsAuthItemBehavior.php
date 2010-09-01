<?php
/**
* Rights authorization item behavior class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.9.11
*/
class RightsAuthItemBehavior extends CBehavior
{
	public $userId;
	public $parent;
	public $childCount;

	/**
	* Constructs the behavior.
	* @param CAuthItem the parent item.
	* @return RightsAuthItemBehavior
	*/
	public function __construct($userId=null, CAuthItem $parent=null)
	{
		$this->userId = $userId;
		$this->parent = $parent;
	}

	/**
	* Returns the markup for the name column.
	* @param boolean whether to show the child count.
	* @param boolean whether to show the sortable id.
	* @return string the markup.
	*/
	public function nameColumn($childCount=false, $sortableId=false)
	{
		$markup = CHtml::link(Rights::beautifyName($this->owner->name), array('authItem/update', 'name'=>$this->owner->name, 'redirect'=>urlencode(Rights::getAuthItemRoute($this->owner->type))));
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
		$markup.= $this->owner->name===Rights::module()->superuserName ? $this->superuserIndicator() : '';
		return $markup;
	}

	/**
	* Returns the markup for the super user indicator.
	* @return string the markup.
	*/
	public function superuserIndicator()
	{
		return '<span class="superuser">(<span class="superuser-text">'.Yii::t('RightsModule.core', 'superuser').'</span>)</span>';
	}

	/**
	* Returns the markup for the child count.
	* @return string the markup.
	*/
	public function childCount()
	{
		if( $this->childCount===null )
			$this->childCount = count($this->owner->getChildren());

		return $this->childCount>0 ? ' <span class="child-count">[ <span class="child-count-number">'.$this->childCount.'</span> ]</span>' : '';
	}

	/**
	* Returns the markup for the id required by jQuery UI sortable.
	* @return string the markup.
	*/
	public function sortableId()
	{
	 	return ' <span class="auth-item-name" style="display:none;">'.$this->owner->name.'</span>';
	}

	/**
	* Returns the markup for the type column.
	* @return string the markup.
	*/
	public function typeColumn()
	{
		return Rights::getAuthItemTypeName($this->owner->type);
	}

	/**
	* Returns the markup for the delete operation column.
	* @return string the markup.
	*/
	public function deleteOperationColumn()
	{
		return CHtml::linkButton(Yii::t('RightsModule.core', 'Delete'), array(
			'submit'=>array('authItem/delete', 'name'=>$this->owner->name, 'redirect'=>urlencode('default/operations')),
			'confirm'=>Yii::t('RightsModule.core', 'Are you sure you want to delete this operation?'),
			'class'=>'delete-link',
		));
	}

	/**
	* Returns the markup for the delete task column.
	* @return string the markup.
	*/
	public function deleteTaskColumn()
	{
		return CHtml::linkButton(Yii::t('RightsModule.core', 'Delete'), array(
			'submit'=>array('authItem/delete', 'name'=>$this->owner->name, 'redirect'=>urlencode('default/tasks')),
			'confirm'=>Yii::t('RightsModule.core', 'Are you sure you want to delete this task?'),
			'class'=>'delete-link',
		));
	}

	/**
	* Returns the markup for the delete role column.
	* @return string the markup.
	*/
	public function deleteRoleColumn()
	{
		return CHtml::linkButton(Yii::t('RightsModule.core', 'Delete'), array(
			'submit'=>array('authItem/delete', 'name'=>$this->owner->name, 'redirect'=>urlencode('default/roles')),
			'confirm'=>Yii::t('RightsModule.core', 'Are you sure you want to delete this role?'),
			'class'=>'delete-link',
		));
	}

	/**
	* Returns the markup for the remove parent column.
	* @return string the markup.
	*/
	public function removeParentColumn()
	{
		return CHtml::linkButton(Yii::t('RightsModule.core', 'Remove'), array(
			'submit'=>array('authItem/removeChild', 'name'=>$this->owner->name, 'child'=>$this->parent->name),
			'class'=>'remove-link',
		));
	}

	/**
	* Returns the markup for the remove child column.
	* @return string the markup.
	*/
	public function removeChildColumn()
	{
		return CHtml::linkButton(Yii::t('RightsModule.core', 'Remove'), array(
			'submit'=>array('authItem/removeChild', 'name'=>$this->parent->name, 'child'=>$this->owner->name),
			'class'=>'remove-link',
		));
	}

	/**
	* Returns the markup for the revoke assignment column.
	* @return string the markup.
	*/
	public function revokeAssignmentColumn()
	{
		return CHtml::linkButton(Yii::t('RightsModule.core', 'Revoke'), array(
			'submit'=>array('assignment/revoke', 'id'=>$this->userId, 'name'=>$this->owner->name),
			'class'=>'revoke-link',
		));
	}

	/**
	* Returns the markup for the revoke permission column.
	* @param CAuthItem $role the role the permission is for.
	* @return string the markup.
	*/
	public function revokePermissionColumn($role)
	{
		$this->parent = $role;

		$app = Yii::app();
		$baseUrl = Rights::module()->baseUrl.'/';
		$csrf = ($csrf = $this->getCsrfValidationParam())!==null ? ', '.$csrf : '';
		$onclick = <<<EOD
jQuery.ajax({
	type:'POST',
	url:'{$app->createUrl($baseUrl.'authItem/revoke', array('name'=>$this->parent->name, 'child'=>$this->owner->name))}',
	data:{
		ajax:1
		$csrf
	},
	success:function() {
		$("#permissions").load('{$app->createUrl($baseUrl.'default/permissions')}', {
			ajax:1
			$csrf
		});
	}
});

return false;
EOD;

		return CHtml::link(Yii::t('RightsModule.core', 'Revoke'), '#', array(
			'onclick'=>$onclick,
			'class'=>'revoke-link',
		));
	}

	/**
	* Returns the markup for the assign permission column.
	* @param CAuthItem $role the role the permission is for.
	* @return string the markup.
	*/
	public function assignPermissionColumn($role)
	{
		$this->parent = $role;

		$app = Yii::app();
		$baseUrl = Rights::module()->baseUrl.'/';
		$csrf = ($csrf = $this->getCsrfValidationParam())!==null ? ', '.$csrf : '';
		$onclick = <<<EOD
jQuery.ajax({
	type:'POST',
	url:'{$app->createUrl($baseUrl.'authItem/assign', array('name'=>$this->parent->name, 'child'=>$this->owner->name))}',
	data:{
		ajax:1
		$csrf
	},
	success:function() {
		$("#permissions").load('{$app->createUrl($baseUrl.'default/permissions')}', {
			ajax:1
			$csrf
		});
	}
});

return false;
EOD;
		return CHtml::link(Yii::t('RightsModule.core', 'Assign'), '#', array(
			'onclick'=>$onclick,
			'class'=>'assign-link',
		));
	}

	/**
	* Returns the markup for the inherited permission column.
	* @param array the parents for this item.
	* @param boolean whether to display the parent item type.
	* @return string the markup.
	*/
	public function inheritedPermissionColumn($parents, $typeVisible=false)
	{
		$items = array();
		foreach( $parents as $name=>$item )
			$items[] = Rights::beautifyName($name).($typeVisible===true ? ' ('.Rights::getAuthItemTypeName($item->type).')' : '');

		return '<span class="inherited-item" title="'.implode(', ', $items).'">'.Yii::t('RightsModule.core', 'Inherited').' *</span>';
	}

	/**
	* Returns the cross-site request forgery parameter
	* if csrf-validation is enabled.
	* @return string the csrf parameter.
	*/
	public static function getCsrfValidationParam()
	{
		if( Yii::app()->request->enableCsrfValidation===true )
		{
	        $csrfTokenName = Yii::app()->request->csrfTokenName;
	        $csrfToken = Yii::app()->request->csrfToken;
	        return "'$csrfTokenName':'$csrfToken'";
		}
		else
		{
			return null;
		}
	}
}
