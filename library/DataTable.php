<?php
/** 
 * @author noah
 * @date 3/2/11
 * @brief
 * 
*/

class DataTable
{
	protected static $_types = array(
		'server-side',
		'dom'
	);

	protected $_data;

	protected $_name;

	protected $_type;


	public function __construct(array $config = array())
	{
		if(isset($config['type'])) {
			$this->setDataSource($config['type'], $config['data']);
		}
	}

	public function setDataSource($sourceType, $sourceData)
	{
		if(!in_array($sourceType, self::$_types)) {
			throw new Exception('Invalid Data Source Type Specified');
		}

		$this->_type = $sourceType;
		$this->_data = $sourceData;
	}

	public function setName($name)
	{
		$this->_name = $name;
	}

	public function render()
	{
		
	}
}
