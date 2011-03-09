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

	protected static $_availableActions = array(
		'add',
		'edit',
		'delete'
	);

	protected $_actions = array();

	protected $_columns = array();

	protected $_data;

	protected $_name;

	protected $_type;

	public function __construct(array $config = array())
	{
		foreach($config as $k => $v) {
			switch($k) {
				case 'type':
					$this->setDataSource($v, $config['data']);
					break;
				case 'name':
					$this->setName($v);
					break;
				case 'baseUrl':
					$this->setBaseUrl($v);
					break;
			}
		}
		
	}

	public function addColumn(array $array)
	{
		if(!isset($array['type'])) {
			$type = 'text';
		} else {
			$type = $array['type'];
		}

		unset($array['type']);

		$class = "\\DataTable\\Column\\".ucfirst($type);

		$this->_columns[$array['name']] = new $class($array);
	}

	public function addColumns(array $array)
	{
		foreach($array as $name => $config) {
			$config['name'] = $name;

			$this->addColumn($config);
		}
	}

	public function render()
	{
		
	}

	public function setBaseUrl($url)
	{
		$this->_baseUrl = $url;
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
}
