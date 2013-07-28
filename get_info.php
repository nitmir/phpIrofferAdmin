<?php
require("includes/require.php");
require('includes/iroffer.php');

if(isset($_GET['id'])&&(int)$_GET['id']>0&&isset($bot_list[(int)$_GET['id']])&&isset($_GET['pack'])){
	$bot=$bot_list[(int)$_GET['id']];
	$conn = new IROFFER($bot['host'], $bot['port'], $bot['password']);
	$result=$conn->info($_GET['pack']);
	print(json_encode($result));
	//~ foreach($result as $line){
		//~ print(htmlspecialchars($line)."\n");
	//~ }
}else {
	echo "error";
	print_r($_GET);
}

