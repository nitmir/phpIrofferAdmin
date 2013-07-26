<?php
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
                    die(header('HTTP/1.1 503 Service Unavailable')."<html><head><meta http-equiv=refresh content=\"5 $_SERVER[REQUEST_URI]\"></head><body><table border=0 width=100% height=100%><tr><td><h3 align=center>The server load is very high at the moment. Retrying, please wait...</h3></td></tr></table></body></html>");
                else
                    die(header('HTTP/1.1 503 Service Unavailable')."Too many users. Please press the Refresh button in your browser to retry.");
        default:
            $pdo=false;
            die(header('HTTP/1.1 503 Service Unavailable')."[" . $err. "] dbconn: mysql_connect: " . $info);
        }
    }
    return $pdo;
}

function dberror(){
    list($err,$state,$info)=db()->errorInfo();
    return $err.' '.$state.' '.$info."\n";
}

function is_logged(){
	if(isset($_SESSION['authentificate'])&&$_SESSION['authentificate']===true){
		return true;
	}else{
		return false;
	}
}

function check_pass($pass,$hash){
	return strlen($hash)>12&&crypt($pass, substr($hash,0,12))==$hash;
}
function login(){
	if(!is_logged()&&isset($_POST['iroffer_username'])&&isset($_POST['iroffer_password'])){
		$query=db()->query("SELECT * FROM users WHERE name=".db()->quote($_POST['iroffer_username'])."") or die(dberror());
		if($data=$query->fetch()){
			if(check_pass($_POST['iroffer_password'],$data['password'])){
				db()->exec("UPDATE users SET last_login=NOW(), ip='".$_SERVER['REMOTE_ADDR']."' WHERE id='".$data['id']."'")or die(dberror());
				$_SESSION['authentificate']=true;
				$_SESSION['name']=$data['name'];
				$_SESSION['right']=$data['right'];
				$_SESSION['level']=constant($data['right']);
				$_SESSION['email']=$data['email'];
				$_SESSION['created']=$data['created'];
				$_SESSION['last_login']=$data['last_login'];
				$_SESSION['id']=$data['id'];
				header("Location: ".$_SERVER['REQUEST_URI']);
				die();
			}
		}
	}
	return is_logged();
}
function login_require(){
	if(!login()){
		header("Location: login.php");
		die();
	}
}

function level_require($lvl){
	if($_SESSION['level']<$lvl){
		header("Location: main.php");
		die();
	}
}

function logout(){
	if(is_logged()&&isset($_GET['logout'])){
		foreach(array_keys($_SESSION) as $key){
			unset($_SESSION[$key]);
		}
		$_SESSION=array();
		unset($_SESSION);
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,$params["path"], $params["domain"],$params["secure"], $params["httponly"]);
		}
		session_destroy();
	}
}

?>
