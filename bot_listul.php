<?php
require("includes/require.php");


if($_PARAMS['bot']!==false){
	$conn = new IROFFER($_PARAMS['bot']['host'], $_PARAMS['bot']['port'], $_PARAMS['bot']['password']);

	$tpl->assign('files', $conn->listul($_PARAMS['path']));
	display("templates/bot_listul.tpl");
}else {
	header("Location: main.php");
}