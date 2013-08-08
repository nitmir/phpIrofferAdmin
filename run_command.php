<?php
/*
* This file is part of phpIrofferAdmin.
*
* (c) 2013 Valentin Samir
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

require("includes/controler.php");

if($_PARAMS['bot']!==false&&isset($_GET['command'])){
	$conn = new IROFFER($_PARAMS['bot']->host(), $_PARAMS['bot']->port(), $_PARAMS['bot']->password());
	$result=array_slice($conn->command($_GET['command']), 0, -3);
	foreach($result as $line){
		print(htmlspecialchars($line)."\n");
	}
}else {
	echo "error";
	print_r($_GET);
}

