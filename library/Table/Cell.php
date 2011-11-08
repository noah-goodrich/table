<?php
/** 
 * @author noah
 * @date 3/8/11
 * @brief
 * 
*/

namespace Table;

use Table\Value as Value;

class Cell {

	protected $_attr;
	
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
				case 'attr':
					$this->_attr = $v;
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
		return '<td>'.$this->value($object).'</td>';
	}
}
