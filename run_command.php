<?php
require("includes/require.php");

if($_PARAMS['bot']!==false&&isset($_GET['command'])){
	$conn = new IROFFER($_PARAMS['bot']['host'], $_PARAMS['bot']['port'], $_PARAMS['bot']['password']);
	$result=array_slice($conn->command($_GET['command']), 0, -3);
	foreach($result as $line){
		print(htmlspecialchars($line)."\n");
	}
}else {
	echo "error";
	print_r($_GET);
}

