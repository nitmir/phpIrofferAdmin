<?php
require("includes/require.php");
require('includes/iroffer.php');

if(isset($_GET['id'])&&(int)$_GET['id']>0&&isset($bot_list[(int)$_GET['id']])){
	$bot=$bot_list[(int)$_GET['id']];
	if(isset($_GET['command'])){
		$conn = new IROFFER($bot['host'], $bot['port'], $bot['password']);
		$result=array_slice($conn->command($_GET['command']), 0, -3);
		foreach($result as $line){
			print(htmlspecialchars($line)."\n");
		}
	}
}else {
	echo "error";
	print_r($_GET);
}

