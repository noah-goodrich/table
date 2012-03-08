<?php
/**
 * @author noah
 * @date 3/7/11
 * @brief
 *
 */
 $str = null;

$str.= '<table '.$this->attr().'>'
	 . '<thead>'
	 . '<tr>';

foreach($this->_columns as $column) {
	$str.= '<th>'.$column->header().'</th>';
}
	
$str.= '</tr>'
	 . '</thead>'
	 . '<tbody>';

 foreach($this->_data as $tuple) {
	 $str.= '<tr '.$this->getRowAttr($tuple).'>';

	 foreach ($this->_columns as $column) {
		 $str.= $column->render($tuple);
	 }
	 
	 $str.= '</tr>';
}

	$str.= '</tbody>'
		 . '</table>';

return $str;