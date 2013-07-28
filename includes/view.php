<?php
function needed_params($key, $params){
	for($i=0;isset($key[$i]);$i++){
		if(!isset($params[$key[$i]])){
			die('Params '.$key[$i].' necessary');
		}
	}
}

function build_url($base, $params){
	return $base.http_build_query($params);
}

function view($page, $params=array(), $raw=false){
	switch($page){
		case "main":
			return 'main.php';
		case "bot_listing":
			needed_params(array('bot_id', 'group'), $params);
			return bot_listing($params['bot_id'], $params['group'], $raw);
			break;
		case "files_listing":
			needed_params(array('bot_id', 'path'), $params);
			return files_listing($params['bot_id'], $params['path'], $raw);
			break;
		case "bot_console":
			needed_params(array('bot_id'), $params);
			return bot_console($params['bot_id'], $raw);
			break;
		default:
			die('Unknow view '.$page);
	}
}


function bot_listing($bot_id, $group, $raw){
	$php_file='bot_xdl.php?';
	$params=array('bot_id'=>$bot_id, 'group' => $group);
	if($raw){return array($php_file, $params);}
	else{return build_url($php_file, $params);}
}
function files_listing($bot_id, $path, $raw){
	$php_file='bot_listul.php?';
	$params=array('bot_id'=>$bot_id, 'path' => $path);
	if($raw){return array($php_file, $params);}
	else{return build_url($php_file, $params);}
}
function bot_console($bot_id, $raw){
	$php_file='bot_command.php?';
	$params=array('bot_id'=>$bot_id);
	if($raw){return array($php_file, $params);}
	else{return build_url($php_file, $params);}
}