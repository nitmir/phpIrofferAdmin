<?php
require("includes/require.php");


//~ $bot=$bot_list[(int)$_GET['id']];
//~ if(isset($_POST['pack_id'])&&isset($_POST['pack'])&&isset($_POST['bot_id'])&&$_POST['bot_id']==$bot['id']){
	//~ if($_POST['pack_id']!=$_POST['pack']){
		//~ $conn->renumber((int)$_POST['pack_id'], (int)$_POST['pack']);
		//~ header('Location: '.$_SERVER['REQUEST_URI'].'#pack_'.((int)$_POST['pack'] - 1));
		//~ die();
	//~ }
//~ }
//~ $tpl->assign('bot', $bot);
if(isset($_POST['name'])&&isset($_POST['host'])&&isset($_POST['port'])&&isset($_POST['password'])){
	if(isset($_POST['bot_id'])){
		if(isset($bot_list[$_POST['bot_id']])){
			db()->query("UPDATE bots SET name=".db()->quote($_POST['name']).", host=".db()->quote($_POST['host']).", port=".db()->quote($_POST['port']).", password=".db()->quote($_POST['password'])." WHERE id=".db()->quote($_POST['bot_id'])."")or die(dberror());
			header('Location: '.$_SERVER['REQUEST_URI']);
			die();
		}
	}else{
		if(db()->query("INSERT INTO bots (name, host, port, password) VALUES (".db()->quote($_POST['name']).", ".db()->quote($_POST['host']).", ".db()->quote($_POST['port']).", ".db()->quote($_POST['password']).")")){
			$id=db()->lastInsertId();
			db()->query("INSERT INTO `bot_user` (`bot_id`, `user_id`) VALUES (".db()->quote($id).", ".db()->quote($_SESSION['id']).")")or die(dberror());
		} else {
			$query=db()->query("SELECT id FROM bots WHERE host=".db()->quote($_POST['host'])." AND port=".db()->quote($_POST['port'])." AND password=".db()->quote($_POST['password'])."")or die(dberror());
			if($data=$query->fetch()){
				db()->query("INSERT INTO `bot_user` (`bot_id`, `user_id`) VALUES (".db()->quote($data['id']).", ".db()->quote($_SESSION['id']).")")or die(dberror());
			}else{
				die('couple (host, port) already used and wrong password');
			}
		}
		header('Location: '.$_SERVER['REQUEST_URI']);
		die();
	}
}

if(isset($_GET['del'])&&isset($bot_list[$_GET['del']])){
	if($_SESSION['right']=='ADMIN'){
		db()->query("DELETE FROM bots WHERE id=".db()->quote($_GET['del'])."")or die(dberror());
	} else {
		db()->query("DELETE FROM `bot_user` WHERE user_id=".db()->quote($_SESSION['id'])." AND bot_id=".db()->quote($_GET['del'])."")or die(dberror());
	}
	header('Location: '.$_SERVER['REQUEST_URI']);
	die();
}
$tpl->assign('edit', isset($_GET['edit'])?(int)$_GET['edit']:-1);
//~ $tpl->assign('packs', $conn->xdl());
$tpl->display("templates/admin_bots.tpl");
