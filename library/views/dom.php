<?php
/** 
 * @author noah
 * @date 3/7/11
 * @brief
 * 
 */
 ?>

<table id="<?= $this->_attr['id'] ?>" class="display">
	<thead>
	<tr>
	<? foreach($this->_columns as $column): ?>
		<th><?= $column->header() ?></th>
	<? endforeach; ?>
	</tr>
	</thead>
	<tbody>
	<? foreach($this->_data as $tuple): ?>
	<tr>
	<? foreach($this->_columns as $column): ?>
		<?= $column->render($tuple) ?>
	<? endforeach; ?>
	</tr>
	<? endforeach; ?>
	</tbody>
</table>