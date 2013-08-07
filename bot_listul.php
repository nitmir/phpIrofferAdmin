<?php
/*
* This file is part of phpIrofferAdmin.
*
* (c) 2013 Valentin Samir
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

require("includes/require.php");


if($_PARAMS['bot']!==false){
	$conn = new IROFFER($_PARAMS['bot']['host'], $_PARAMS['bot']['port'], $_PARAMS['bot']['password']);
	$tpl->assign('groups', $conn->xdl($group_only=true));
	$files=$conn->listul($_PARAMS['path']);
	if(is_array($files)){
		$tpl->assign('files', $files);
	} else {
		if(preg_match('/Can\'t Access Directory: (.*) Not a directory/', $files, $match)){
			$_SESSION['message_error'][]=sprintf(_('%s is not a directory'), str_replace('//', '/', $match[1]));
		} else {
			$_SESSION['message_error'][]=$files;
		}
		$_PARAMS['path']=dirname($_PARAMS['path']);
		header('Location: '.view('files_listing', $_PARAMS));
		die();
	}
	display("templates/bot_listul.tpl");
}else {
	header("Location: ".view('main'));
}
