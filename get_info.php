<?php
require("includes/require.php");

if($_PARAMS['bot']!==false&&isset($_GET['pack'])){
	$conn = new IROFFER($_PARAMS['bot']['host'], $_PARAMS['bot']['port'], $_PARAMS['bot']['password']);
	$result=$conn->info($_GET['pack']);
	print(json_encode($result));
}else {
	echo "error";
	print_r($_GET);
}

