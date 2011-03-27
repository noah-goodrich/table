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
	<? foreach($this->columns() as $column): ?>
		<th><?= $column->header() ?></th>
	<? endforeach; ?>
	<? if(count($this->actions())): ?>
		<th>Options</th>
	<? endif; ?>
	</tr>
	</thead>
	<tbody>
	<? foreach($this->_data as $tuple): ?>
	<tr>
	<? foreach($this->columns() as $column): ?>
		<td><?= $column->render($tuple) ?></td>
	<? endforeach; ?>
	<? if(count($this->actions())): ?>
		<td>
		<? foreach($this->actions() as $option): ?>
			<?= $option->render($tuple) ?>
		<? endforeach ?>
		</td>
	<? endif; ?>
	</tr>
	<? endforeach; ?>
	</tbody>
</table>

<script>
$(document).ready(function() {
	$('#<?= $this->_name ?>').dataTable();
});
</script>