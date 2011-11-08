<?php

function debug($var)
{
	echo '<pre>'.print_r($var, true).'</pre>';
}

require __DIR__.'/../library/Table.php';

spl_autoload_register(array('Table', 'autoload'));

$db = new PDO('mysql:dbname=world;host=localhost', 'table', 'table');

$rows = $db->query('select * from City', PDO::FETCH_OBJ);

$table = new Table;

$table->add(
		array(
			array('header' => 'ID', 'value' => function($o) { return $o->ID;}),
			array('header' => function() { return 'Name'; }, 'value' => function($o) {return $o->Name; }),
			array('value' => 'Test Value')
		)			
	)
	->setDataSource($rows);

?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="datatables.css" />
	<link rel="stylesheet" type="text/css" href="datatables_jui.css" />
</head>
<body>
	<? echo $table->render(); ?>
</body>

	<script type="text/javascript" src="jquery.js"></script>
	<script type="text/javascript" src="datatables.js"></script>
	
	<? echo $table->js(); ?>
	
</html>