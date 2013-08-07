<?php
/*
* This file is part of phpIrofferAdmin.
*
* (c) 2013 Valentin Samir
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

// return an PDO object to the database
function db(){
    static $pdo = false;
    global $MYSQL;
    if($pdo!==false){
        return $pdo;
    }
    if(!isset($MYSQL)||empty($MYSQL)){
	return false;
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

function session_started(){
	return session_status() == PHP_SESSION_ACTIVE;
}


// to display sql error
function dberror(){
    list($err,$state,$info)=db()->errorInfo();
    //~ return $err.' '.$state.' '.$info."\n";
    return $info."\n";
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



function encode_url($url){
	return str_replace('%2F', '/', rawurlencode($url));
}
