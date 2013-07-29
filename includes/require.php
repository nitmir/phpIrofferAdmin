<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require('config.php');
require('functions.php');
require('view.php');
require('actions.php');
require('template.php');

session_start();
logout();
login_require();


$bot_list=array();
$query=db()->query("SELECT * FROM bots, bot_user WHERE bots.id=bot_user.bot_id AND bot_user.user_id='".$_SESSION['id']."' ORDER BY name")or die(dberror());
while($data=$query->fetch()){
	$bot_list[$data['id']]=$data;
}

$tpl->assign('action', $_ACTION);
$tpl->assign('user', $_SESSION);
$tpl->assign('bot_list', $bot_list);
$tpl->assign('bot', array('id' => 0));
$tpl->assign('subpage', '');

$_PARAMS = array();
$_PARAMS['bot_id']=isset($_GET['bot_id'])&&isset($bot_list[(int)$_GET['bot_id']])?(int)$_GET['bot_id']:0;
$_PARAMS['group']=isset($_GET['group'])?$_GET['group']:'';
$_PARAMS['path']=isset($_GET['path'])?$_GET['path']:'';
$_PARAMS['action']=isset($_GET['action'])?$_GET['action']:'';
$_PARAMS['param']=isset($_GET['param'])?$_GET['param']:'';

if($_PARAMS['bot_id']>0){
	$_PARAMS['bot']=$bot_list[$_PARAMS['bot_id']];
	require('includes/iroffer.php');
} else {
	$_PARAMS['bot']=false;
}

action_get();

function display($page){
	global $tpl, $_PARAMS;
	$tpl->assign('params', $_PARAMS);
	$tpl->assign('message_error', $_SESSION['message_error']);
	$tpl->assign('message_info', $_SESSION['message_info']);
	$tpl->assign('message_warning', $_SESSION['message_warning']);
	$tpl->assign('message_success', $_SESSION['message_success']);
	$_SESSION['message_error']=array();
	$_SESSION['message_info']=array();
	$_SESSION['message_warning']=array();
	$_SESSION['message_success']=array();
	$tpl->display($page);
}