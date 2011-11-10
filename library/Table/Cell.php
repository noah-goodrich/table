<?php
/** 
 * @author noah
 * @date 3/8/11
 * @brief
 * 
*/

namespace Table;

class Cell {

	protected $_attr;
	
	protected $_object;

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
				case 'attr':
					$this->_attr = $v;
					break;
				case 'object':
					$this->_object = $v;
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
		$meth = $this->_object;

		return $meth($this->_value, $object);
	}

	/**
	 * @return string
	 */
	public function header()
	{
		$meth = $this->_object;

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
