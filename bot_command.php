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

if($_PARAMS['bot']!==false){
	display("templates/bot_command.tpl");
}else {
	echo "error";
	print_r($_GET);
}
