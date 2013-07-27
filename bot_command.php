<?php
require("includes/require.php");
require('includes/iroffer.php');

if(isset($_GET['id'])&&(int)$_GET['id']>0&&isset($bot_list[(int)$_GET['id']])){
	$bot=$bot_list[(int)$_GET['id']];
	$conn = new IROFFER($bot['host'], $bot['port'], $bot['password']);
	$tpl->assign('bot', $bot);
	display("templates/bot_command.tpl");
}else {
	echo "error";
	print_r($_GET);
}