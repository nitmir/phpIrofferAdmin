<?php

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
				$_SESSION['message_error'] = array();
				$_SESSION['message_warning'] = array();
				$_SESSION['message_success'] = array();
				$_SESSION['message_info'] = array();
				header("Location: ".$_SERVER['REQUEST_URI']);
				die();
			}
		}
	}
	return is_logged();
}
function login_require(){
	if(!login()){
		header("Location: ".view('login'));
		die();
	}
}

function level_require($lvl){
	if($_SESSION['level']<$lvl){
		header("Location: ".view('main'));
		die();
	}
}
