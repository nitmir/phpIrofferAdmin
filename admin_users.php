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

$tpl->assign('user_list', user()->all_users());
display("templates/admin_users.tpl");
