<?php
/** 
 * @author noah
 * @date 3/8/11
 * @brief Anchor Columns output an <a href=""></a> 
*/

namespace DataTable\Column;

class Anchor extends Column {

	protected $_url;

	public function __construct(array $config)
	{
		$this->_url = $config['url'];
	}

	public function url($object)
	{
		return Value($this->_url, $object);
	}
}
