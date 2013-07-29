<?php
require("includes/require.php");


if($_PARAMS['bot_id']>0){
	$bot=$bot_list[$_PARAMS['bot_id']];
	$conn = new IROFFER($bot['host'], $bot['port'], $bot['password']);
	$tpl->assign('bot', $bot);
	display("templates/bot_command.tpl");
}else {
	echo "error";
	print_r($_GET);
}