<?php
require("smarty3/Smarty.class.php"); // On inclut la classe Smarty

$tpl = new Smarty();

$tpl->addPluginsDir(dirname(__FILE__).'/smarty_plugins/');

require('view.php');
require('actions.php');

if(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) == 'fr'){
	$lang='fr_FR.utf8';
	$filename = 'default';
	setlocale(LC_ALL, $lang);
	bindtextdomain($filename, './lang/');
	bind_textdomain_codeset($filename, "UTF-8");
	textdomain($filename);
}

function display($page){
	global $tpl, $_PARAMS, $_ACTION, $_CONFIG;
	$tpl->assign('action', $_ACTION);
	$tpl->assign('ROOT', ROOT);
	$tpl->assign('subpage', '');
	$tpl->assign('params', $_PARAMS);
	$tpl->assign('config', $_CONFIG);
	if(isset($_SESSION)){
		$tpl->assign('bot_list', botlist());
		$tpl->assign('user', $_SESSION);
		$tpl->assign('message_error', $_SESSION['message_error']);
		$tpl->assign('message_info', $_SESSION['message_info']);
		$tpl->assign('message_warning', $_SESSION['message_warning']);
		$tpl->assign('message_success', $_SESSION['message_success']);
		$_SESSION['message_error']=array();
		$_SESSION['message_info']=array();
		$_SESSION['message_warning']=array();
		$_SESSION['message_success']=array();
	}else{
		$tpl->assign('bot_list', array());
		$tpl->assign('user', array());
		$tpl->assign('message_error', array());
		$tpl->assign('message_info', array());
		$tpl->assign('message_warning', array());
		$tpl->assign('message_success', array());
	}
	$tpl->display($page);
}
