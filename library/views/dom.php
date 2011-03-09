<?php
/** 
 * @author noah
 * @date 3/7/11
 * @brief
 * 
 */
 ?>
 
<table id="<?= $name ?>">
	<thead>
	<tr>
	<? foreach($columns as $column): ?>
		<th><?= $column->header() ?></th>
	<? endforeach; ?>
	</tr>
	</thead>
	<tbody>
	<? foreach($data as $tuple): ?>
	<tr>
	<? foreach($columns as $column): ?>
		<td></td>
	<? endforeach; ?>
	</tr>
	<? endforeach; ?>
	</tbody>
</table>

<script>
$(document).ready(function() {
	$('#<?= $name ?>').dataTable();
});
</script>