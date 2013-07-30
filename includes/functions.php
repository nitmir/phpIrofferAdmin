<?php
// return an PDO object to the database
function db(){
    static $pdo = false;
    global $MYSQL;
    if($pdo!==false){
        return $pdo;
    }
    if(!$pdo = new PDO('mysql:host='.$MYSQL['host'].';dbname='.$MYSQL['database'], $MYSQL['username'], $MYSQL['password'])){
    list($err,$_,$info)=$pdo->errorInfo();
        switch ($err){
            case 1040:
            case 2002:
                $pdo=false;
                if ($_SERVER['REQUEST_METHOD'] == "GET")
                    die(header('HTTP/1.1 503 Service Unavailable')."<html><head><meta http-equiv=refresh content=\"5 $_SERVER[REQUEST_URI]\"></head><body><table border=0 width=100% height=100%><tr><td><h3 align=center>"._('The server load is very high at the moment. Retrying, please wait...')."</h3></td></tr></table></body></html>");
                else
                    die(header('HTTP/1.1 503 Service Unavailable')._("Too many users. Please press the Refresh button in your browser to retry."));
        default:
            $pdo=false;
            die(header('HTTP/1.1 503 Service Unavailable')."[" . $err. "] dbconn: mysql_connect: " . $info);
        }
    }
    return $pdo;
}


// to display sql error
function dberror(){
    list($err,$state,$info)=db()->errorInfo();
    return $err.' '.$state.' '.$info."\n";
}

// check if $params as all key listed in $keys
function needed_params($keys, $params){
	for($i=0;isset($keys[$i]);$i++){
		if(!isset($params[$keys[$i]])){
			die('Params '.$keys[$i].' necessary');
		}
	}
}

// extrack the array of kers defines in $keys
function sub_array($keys, $array){
	$return=array();
	for($i=0; isset($keys[$i]); $i++){
		$return[$keys[$i]]=$array[$keys[$i]];
	}
	return $return;
}

// build the list of bot controled by the user
function botlist(){
	static $bot_list=false;
	if($bot_list!==false){
		return $bot_list;
	} else {
		$bot_list=array();
		$query=db()->query("SELECT * FROM bots, bot_user WHERE bots.id=bot_user.bot_id AND bot_user.user_id='".$_SESSION['id']."' ORDER BY name")or die(dberror());
		while($data=$query->fetch()){
			$bot_list[$data['id']]=$data;
		}
		return $bot_list;
	}
}

// build the params directory
function params() {
	global $_PARAMS;
	$_PARAMS = array();
	$_PARAMS['bot_id']=isset($_GET['bot_id'])&&isset(botlist()[(int)$_GET['bot_id']])?(int)$_GET['bot_id']:0;
	$_PARAMS['group']=isset($_GET['group'])?$_GET['group']:'';
	$_PARAMS['path']=isset($_GET['path'])?$_GET['path']:'';
	$_PARAMS['action']=isset($_POST['action'])?$_POST['action']:(isset($_GET['action'])?$_GET['action']:'');
	$_PARAMS['values']=isset($_POST['values'])?$_POST['values']:(isset($_GET['values'])?$_GET['values']:array());
	$_PARAMS['values_old']=isset($_POST['values_old'])?$_POST['values_old']:(isset($_GET['values_old'])?$_GET['values_old']:array());

	if($_PARAMS['bot_id']>0){
		$_PARAMS['bot']=botlist()[$_PARAMS['bot_id']];
		require('includes/iroffer.php');
	} else {
		$_PARAMS['bot']=false;
	}
}