<?php 
require("includes/require.php");
$tpl->assign('server', nl2br(print_r($_SERVER, true)));
$tpl->display("templates/main.tpl");
//~ $page_name='home';
//~ include('includes/header.php'); 
?>