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

	protected $_valueObj;

	protected $_value;

	protected $_header;

	protected $_classes;

	public function __construct(array $config)
	{
		$this->_valueObj = new Value;
		
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

	/**
	 * @param  $object
	 * @return string
	 */
	public function value($object)
	{
		$meth = $this->_valueObj;

		return $meth($this->_value, $object);
	}

	/**
	 * @param  $object
	 * @return string
	 */
	public function classes($object)
	{
		$meth = $this->_valueObj;

		$return = $meth($this->_classes, $object);

		if(!is_array($return)) {
			$return = array($return);
		}

		return join(" ", $return);
	}

	/**
	 * @return string
	 */
	public function header()
	{
		$meth = $this->_valueObj;

		return $meth($this->_header, func_get_args());
	}

	/**
	 * @param  $object
	 * @return void
	 */
	public function render($object)
	{
		$file = get_class($this);
		$file = explode("\\", $file);

		unset($file[0]);

		$file = dirname(dirname(__DIR__)).'/views/'.strtolower(join("/", $file)).'.php';
		
		require $file;
	}
}
