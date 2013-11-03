<?php
/*
* This file is part of phpIrofferAdmin.
*
* (c) 2013 Valentin Samir
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/



// check if $params as all key listed in $keys
function needed_params($keys, $params){
	for($i=0;isset($keys[$i]);$i++){
		if(!isset($params[$keys[$i]])){
			die('Params '.$keys[$i].' necessary');
		}
	}
}

// extrack the array of keys defines in $keys
function sub_array($keys, $array){
	$return=array();
	for($i=0; isset($keys[$i]); $i++){
		$return[$keys[$i]]=$array[$keys[$i]];
	}
	return $return;
}

function encode_url($url){
	return str_replace('%2F', '/', rawurlencode($url));
}

// build the params directory
function params() {
	global $_PARAMS;
	$_PARAMS = array();
        $_PARAMS['lang']='en';
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

function iroffer($bot){
	global $_CONFIG;
	try{
		$conn = new IROFFER($bot->host(), $bot->port(), $bot->password(), $_CONFIG['iroffer_timeout']);
	} catch (IROFFER_ERROR $error){
		messages()->error($error->getMessage());
		header("Location: ".view('main'));
		exit(0);
	}
	return $conn;
}
