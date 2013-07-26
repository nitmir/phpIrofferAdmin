<?php
require("includes/require.php");
require('includes/iroffer.php');


$tpl->assign('edit', isset($_GET['edit'])?(int)$_GET['edit']:-1);
$tpl->assign('user', $_SESSION);
if($_SESSION['right']=='ADMIN'){
	$user_list=array();
	$query=db()->query("SELECT * FROM users ORDER BY name");
	while($data=$query->fetch()){
		$user_list[$data['id']]=$data;
		$tpl->assign('user_list', $user_list);
	}
}
$tpl->display("templates/admin_users.tpl");
