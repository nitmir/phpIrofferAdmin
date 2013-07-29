<?php
require("includes/require.php");


if($_PARAMS['bot_id']>0){
	$bot=$bot_list[$_PARAMS['bot_id']];
	$conn = new IROFFER($bot['host'], $bot['port'], $bot['password']);
	$tpl->assign('bot', $bot);
	if(!isset($_GET['path'])){ $path=''; }
	else{ $path=$_GET['path']; }
	if(isset($_GET['adddir'])){
		//~ $_SESSION['message_info'] []=$conn->adddir($_GET['adddir']);
		$message=$conn->adddir($_GET['adddir']);
		if(substr($message,0, 6) == 'Adding'){
			$_SESSION['message_success'] []=_($message);
		} else {
			$_SESSION['message_error'] []=_($message);
		}
		header("Location: ".$_SERVER['PHP_SELF']."?id=".$bot['id'].'&path='.$path);
		die();
	}
	if(isset($_GET['add'])){
		$message=$conn->add($_GET['add']);
		if(substr($message,0, 6) == 'Added:'){
			$_SESSION['message_success'] []=_($message);
		} else {
			$_SESSION['message_error'] []=_($message);
		}
		header("Location: ".$_SERVER['PHP_SELF']."?id=".$bot['id'].'&path='.$path);
		die();
	}
	$tpl->assign('path', $path);
	$tpl->assign('path_parent', implode('/', array_slice(explode('/', $path), 0, -1)));
	$tpl->assign('files', $conn->listul($path));
	display("templates/bot_listul.tpl");
}else {
	header("Location: main.php");
}