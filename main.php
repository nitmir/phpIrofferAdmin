<?php 
require("includes/require.php");
require('includes/iroffer.php');
$status=array();
foreach(botlist() as $bot){
	$conn = new IROFFER($bot['host'], $bot['port'], $bot['password']);
	$status[$bot['id']]=$conn->status();
}
$tpl->assign('status', $status);
display("templates/main.tpl");
//~ $page_name='home';
//~ include('includes/header.php'); 
?>