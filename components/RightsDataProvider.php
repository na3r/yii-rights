<?php
/**
* Rights data provider class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.9.9
*/
class RightsDataProvider extends CDataProvider
{
	/**
	* Constructs the data provider.
	* @param string the unique ID that uniquely identifies the data provider among all data providers.
	* @param array put the data items into this provider.
	* @return RightsDataProvider
	*/
	public function __construct($id, $data)
	{
		$this->setId($id);
		$this->setData($data);
	}

	/**
	* Fetches the data from the persistent data storage.
	* @return array list of data items
	*/
	protected function fetchData()
	{
		return $this->getData();
	}

	/**
	* Fetches the data item keys from the persistent data storage.
	* @return array list of data item keys.
	*/
	protected function fetchKeys()
	{
		$keys = array();
		foreach( $this->getData() as $k=>$v )
			$keys[] = $k;

		return $keys;
	}

	/**
	* Calculates the total number of data items.
	* @return integer the total number of data items.
	*/
	protected function calculateTotalItemCount()
	{
		return count($this->getData());
	}
}
