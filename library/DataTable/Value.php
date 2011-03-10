<?php
/** 
 * @author noah
 * @date 3/8/11
 * @brief
 * 
*/

namespace DataTable;

class Value {

	/**
	 * @param  $determiner
	 * @param  $obj
	 * @return string
	 */
	public function __invoke($determiner, $obj)
	{
		if (empty($determiner) || !is_callable($determiner)) {
			return $determiner;
		}

		return $determiner($obj);
	}
}
