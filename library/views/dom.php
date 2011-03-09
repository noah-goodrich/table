<?php
/** 
 * @author noah
 * @date 3/7/11
 * @brief
 * 
 */
 ?>

<table id="<?= $this->_name ?>">
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
		<td><?= $column->render($tuple) ?></td>
	<? endforeach; ?>
	</tr>
	<? endforeach; ?>
	</tbody>
</table>

<script>
$(document).ready(function() {
	$('#<?= $this->_name ?>').dataTable();
});
</script>