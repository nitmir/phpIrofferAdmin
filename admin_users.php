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


$tpl->assign('edit', isset($_GET['edit'])?(int)$_GET['edit']:-1);
$tpl->assign('user', $_SESSION);
if($_SESSION['right']=='ADMIN'){
	$query=db()->query("SELECT * FROM users ORDER BY name");
	$tpl->assign('user_list', $query->fetchAll());
}
display("templates/admin_users.tpl");
