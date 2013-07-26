<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require('config.php');
require('functions.php');
require('template.php');

session_start();
logout();
login_require();

$bot_list=array();
$query=db()->query("SELECT * FROM bots, bot_user WHERE bots.id=bot_user.bot_id AND bot_user.user_id='".$_SESSION['id']."' ORDER BY name")or die(dberror());
while($data=$query->fetch()){
	$bot_list[$data['id']]=$data;
}

$tpl->assign('bot_list', $bot_list);
$tpl->assign('bot', array('id' => 0));
$tpl->assign('subpage', '');