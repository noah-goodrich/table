<?php
/** 
 * @author noah
 * @date 3/8/11
 * @brief
 * 
*/

namespace Table;

class Value {

	/**
	 * @param  $determiner
	 * @param  $obj
	 * @return string
	 */
	public function __invoke($determiner, $obj)
	{
		if (empty($determiner) || ! $determiner instanceof Closure) {
			return $determiner;
		}

		return $determiner($obj);
	}
}
