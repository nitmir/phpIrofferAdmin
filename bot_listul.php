<?php
/*
* This file is part of phpIrofferAdmin.
*
* (c) 2013 Valentin Samir
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

require("includes/controler.php");

if($_PARAMS['bot']!==false){
	$conn = iroffer($_PARAMS['bot']);
	$tpl->assign('groups', $conn->xdl($group_only=true));
	$files=$conn->listul($_PARAMS['path']);
	if(is_array($files)){
		$tpl->assign('files', $files);
	} else {
		if(preg_match('/Can\'t Access Directory: (.*) Not a directory/', $files, $match)){
			messages()->error(sprintf(_('%s is not a directory'), str_replace('//', '/', $match[1])));
		} else {
			messages()->error($files);
		}
		$_PARAMS['path']=dirname($_PARAMS['path']);
		header('Location: '.view('files_listing', $_PARAMS));
		die();
	}
	display("templates/bot_listul.tpl");
}else {
	header("Location: ".view('main'));
}
