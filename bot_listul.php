<?php
require("includes/require.php");
require('includes/iroffer.php');

if(isset($_GET['id'])&&(int)$_GET['id']>0&&isset($bot_list[(int)$_GET['id']])){
	$bot=$bot_list[(int)$_GET['id']];
	$conn = new IROFFER($bot['host'], $bot['port'], $bot['password']);
	$tpl->assign('bot', $bot);
	if(!isset($_GET['path'])){ $path=''; }
	else{ $path=$_GET['path']; }
	$tpl->assign('path', $path);
	$tpl->assign('path_parent', implode('/', array_slice(explode('/', $path), 0, -1)));
	$tpl->assign('files', $conn->listul($path));
	$tpl->display("templates/bot_listul.tpl");
}else {
	echo "error";
	print_r($_GET);
}