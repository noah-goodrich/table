<?php
/** 
 * @author noah
 * @date 3/8/11
 * @brief
 * 
*/

namespace Table\Column;

interface iColumn {

	/**
	 * @abstract
	 * @param  $object
	 * @return void
	 */
	public function render($object);
}
