<?php
require("includes/require.php");
require('includes/iroffer.php');

if(isset($_GET['id'])&&(int)$_GET['id']>0&&isset($bot_list[(int)$_GET['id']])){
	$bot=$bot_list[(int)$_GET['id']];
	$conn = new IROFFER($bot['host'], $bot['port'], $bot['password']);
	if(isset($_POST['pack_id'])&&isset($_POST['pack'])&&isset($_POST['bot_id'])&&$_POST['bot_id']==$bot['id']){
		if($_POST['pack_id']!=$_POST['pack']){
			$conn->renumber((int)$_POST['pack_id'], (int)$_POST['pack']);
			header('Location: '.$_SERVER['REQUEST_URI'].'#pack_'.((int)$_POST['pack'] - 1));
			die();
		}
	}
	$tpl->assign('bot', $bot);
	$tpl->assign('edit', isset($_GET['edit'])?(int)$_GET['edit']:-1);
	if(isset($_GET['group'])&&$_GET['group']!=''){
		$tpl->assign('packs', $conn->xdlgroup($_GET['group']));
		$tpl->assign('groups', array());
		$tpl->assign('group', $_GET['group']);
	}else{
		$tpl->assign('group', '');
		list($packs, $groups) = $conn->xdl();
		$tpl->assign('packs', $packs);
		$tpl->assign('groups', $groups);
	}
	$tpl->display("templates/bot_xdl.tpl");
}else {
	echo "error";
	print_r($_GET);
}