<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$array = array();

foreach($this->_data as $tuple) {
	$row = array();

	foreach($this->_columns as $col) {
		$row[] = $col->value($tuple);
	}

	$array[] = $row;
}

return $array;