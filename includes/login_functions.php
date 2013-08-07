<?php
/*
* This file is part of phpIrofferAdmin.
*
* (c) 2013 Valentin Samir
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

function is_logged(){
	if(user()){
		return user()->valid();
	}else{
		return false;
	}
}


function session($id){
	user()->load();
}


function login(){
	if(!is_logged()&&isset($_POST['iroffer_username'])&&isset($_POST['iroffer_password'])){
		user($_POST['iroffer_username'])->valid($_POST['iroffer_password']);
		header("Location: ".$_SERVER['REQUEST_URI']);
		die();
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
	if(user()->level()<$lvl){
		header("Location: ".view('main'));
		die();
	}
}
