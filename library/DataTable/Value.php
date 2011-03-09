<?php
/** 
 * @author noah
 * @date 3/8/11
 * @brief
 * 
*/

namespace DataTable;

class Value {

	public function __invoke($determiner, $obj)
	{
		if (is_scalar($determiner)) {
			return $determiner;
		}

		if (is_callable($determiner)) {
			return $determiner;
		}

		return $determiner($obj);
	}
}
