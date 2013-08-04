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
	$tpl->assign('files', $conn->listul($_PARAMS['path']));
	display("templates/bot_listul.tpl");
}else {
	header("Location: ".view('main'));
}
