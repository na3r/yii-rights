<?php
class RightsAuthManager extends CDbAuthManager
{
	public $itemWeightTable = 'AuthItemWeight';

	/**
	* Returns the authorization items of the specific type and user.
	* @param integer the item type (0: operation, 1: task, 2: role). Defaults to null,
	* meaning returning all items regardless of their type.
	* @param mixed the user ID. Defaults to null, meaning returning all items even if
	* they are not assigned to a user.
	* @param boolean whether to sort the results according to item weights or not.
	* Sort is not supported when type is provided.
	* @return array the authorization items of the specific type.
	*/
	public function getAuthItems($type=null, $userId=null, $sort=false)
	{
		// Get the auth items
		$items = parent::getAuthItems($type, $userId);

		// We need to sort the items by their weights
		if( $sort===true && $type!==null )
		{
			$sql = "SELECT * FROM {$this->itemWeightTable} WHERE type=:type ORDER BY weight ASC";
			$command = $this->db->createCommand($sql);
			$command->bindValue(':type', $type);

			$sortedItems = array();
			foreach( $command->queryAll() as $row )
				if( isset($items[ $row['itemname'] ])===true )
					$sortedItems[ $row['itemname'] ] = $items[ $row['itemname'] ];

			// Append the items without a weight last
			foreach( $items as $name=>$item )
				if( isset($sortedItems[ $name ])===false )
					$sortedItems[ $name ] = $item;

			// Replace items with the sorted items
			$items = $sortedItems;
		}

		return $items;
	}

	/**
	* Updates the authorization item weights.
	* @param array the result returned from jui-sortable.
	*/
	public function updateItemWeights($result)
	{
		foreach( $result as $weight=>$itemname )
		{
			// Check if the item already has a weight
			$sql = "SELECT COUNT(*) FROM {$this->itemWeightTable} WHERE itemname=:itemname";
			$command = $this->db->createCommand($sql);
			$command->bindValue(':itemname', $itemname);
			if( $command->queryScalar()>0 )
			{
				$sql = "UPDATE {$this->itemWeightTable} SET weight=:weight WHERE itemname=:itemname";
				$command = $this->db->createCommand($sql);
				$command->bindValue(':weight', $weight);
				$command->bindValue(':itemname', $itemname);
				$command->execute();
			}
			// Item does not have a weight, insert it
			else
			{
				if( ($item = $this->getAuthItem($itemname))!==null )
				{
					$sql = "INSERT INTO {$this->itemWeightTable} (itemname, type, weight) VALUES (:itemname, :type, :weight)";
					$command = $this->db->createCommand($sql);
					$command->bindValue(':itemname', $itemname);
					$command->bindValue(':type', $item->getType());
					$command->bindValue(':weight', $weight);
					$command->execute();
				}
				else
				{
				 	throw new CException('Requested authorization item does not exist.');
				}
			}
		}
	}
}