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

		unset($config['url']);

		parent::__construct($config);
	}

	public function url($object)
	{
		$meth = $this->_valueObj;

		return $meth($this->_url, $object);
	}
}
