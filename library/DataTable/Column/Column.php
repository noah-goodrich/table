<?php
/** 
 * @author noah
 * @date 3/8/11
 * @brief
 * 
*/

namespace DataTable\Column;

use DataTable\Value as Value;

abstract class Column implements iColumn {

	protected $_value;

	protected $_header;

	protected $_classes;

	public function __construct(array $config)
	{
		foreach($config as $k => $v) {
			switch($k) {
				case 'value':
					$this->_value = $v;
					break;
				case 'header':
					$this->_header = $v;
					break;
				case 'classes':
					$this->_classes = $v;
					break;
			}
		}
	}

	public function value($object)
	{
		return Value($this->_value, $object);
	}

	public function classes($object)
	{
		$return = Value($this->_classes, $object);

		if(!is_array($return)) {
			$return = array($return);
		}

		return join(" ", $return);
	}

	public function header()
	{
		return Value($this->_header, func_get_args());
	}
}
