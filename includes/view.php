<?php
/*
* This file is part of phpIrofferAdmin.
*
* (c) 2013 Valentin Samir
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

$_VIEW=array(
	'bot_listing' => array(
		'php_file' => 'bot_xdl.php',
		'url_rewrite' => function ($_1, $_2) { return sprintf('bot-%s/list/%s', encode_url($_1), encode_url($_2));},
		'params' => array('bot_id', 'group')
	),
	'files_listing' => array(
		'php_file' => 'bot_listul.php',
		'url_rewrite' => function ($_1, $_2) { return sprintf('bot-%s/files%s', encode_url($_1), $_2==''?'/':encode_url($_2));},
		'params' => array('bot_id', 'path')
	),
	'bot_console' => array(
		'php_file' => 'bot_command.php',
		'url_rewrite' => function ($_1) { return sprintf('bot-%s/console/', encode_url($_1));},
		'params' => array('bot_id')
	),
	'bot_management' => array(
		'php_file' => 'admin_bots.php',
		'url_rewrite' => function () { return 'bots/';},
		'params' => array()
	),
	'main' => array(
		'php_file' => 'main.php',
		'url_rewrite' => function () { return '';},
		'params' => array()
	),
	'login' => array(
		'php_file' => 'login.php',
		'url_rewrite' => function () { return 'login/';},
		'params' => array()
	),
	'users' => array(
		'php_file' => 'admin_users.php',
		'url_rewrite' => function () { return 'users/';},
		'params' => array()
	),
);


function build_url($base, $params){
	return ROOT.$base.(!empty($params)?'?':'').http_build_query($params);
}


function view($page, $params=array(), $raw=false){
	global $_VIEW;
	if(isset($_VIEW[$page])){
		needed_params($_VIEW[$page]['params'], $params);
		if(REWRITE_URL&&isset($_VIEW[$page]['url_rewrite'])){
			$base=call_user_func_array($_VIEW[$page]['url_rewrite'], sub_array($_VIEW[$page]['params'], $params));
			$params=array();
		} else {
			$base=$_VIEW[$page]['php_file'];
			$params=sub_array($_VIEW[$page]['params'], $params);
		}
		if($raw){
			return array($base, $params);
		} else {
			return build_url($base, $params);
		}
	}
}
