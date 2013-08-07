<?php
/*
* This file is part of phpIrofferAdmin.
*
* (c) 2013 Valentin Samir
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
require('models/messages.php');
require('config.php');
ini_set('display_errors', $_CONFIG['display_error']);
require('functions.php');
require('models/bot.php');
require('models/user.php');
require('template.php');
require('login_functions.php');

// build the params directory
function params() {
	global $_PARAMS;
	$_PARAMS = array();
	$_PARAMS['bot_id']=isset($_GET['bot_id'])&&user()->own_bot((int)$_GET['bot_id'])?(int)$_GET['bot_id']:0;
	$_PARAMS['group']=isset($_GET['group'])?$_GET['group']:'';
	$_PARAMS['path']=isset($_GET['path'])?$_GET['path']:'';
	$_PARAMS['action']=isset($_POST['action'])?$_POST['action']:(isset($_GET['action'])?$_GET['action']:'');
	$_PARAMS['values']=isset($_POST['values'])?$_POST['values']:(isset($_GET['values'])?$_GET['values']:array());
	$_PARAMS['values_old']=isset($_POST['values_old'])?$_POST['values_old']:(isset($_GET['values_old'])?$_GET['values_old']:array());

	if($_PARAMS['bot_id']>0){
		$_PARAMS['bot']=user()->bots()[$_PARAMS['bot_id']];
		require('includes/iroffer.php');
	} else {
		$_PARAMS['bot']=new BOT();
	}
}


session_name($_CONFIG['session_name']);
session_start();
login_require();
params();
action();
