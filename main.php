<?php
/*
* This file is part of phpIrofferAdmin.
*
* (c) 2013 Valentin Samir
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

require("includes/require.php");
require('includes/iroffer.php');
$status=array();
foreach(user()->bots() as $bot){
	$conn = new IROFFER($bot->host(), $bot->port(), $bot->password());
	$status[$bot->id()]=$conn->status();
}
$tpl->assign('status', $status);
display("templates/main.tpl");
//~ $page_name='home';
//~ include('includes/header.php'); 
?>
