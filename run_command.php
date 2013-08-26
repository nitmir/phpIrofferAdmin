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
session_write_close();

if($_PARAMS['bot']!==false&&isset($_GET['command'])){
	try{
		$conn = new IROFFER($_PARAMS['bot']->host(), $_PARAMS['bot']->port(), $_PARAMS['bot']->password(), $_CONFIG['iroffer_timeout']);
	} catch (IROFFER_ERROR $error){
                print("\n".htmlspecialchars($error->getMessage())."\n");
		exit(0);
        }
	$result=array_slice($conn->command($_GET['command']), 0, -3);
	foreach($result as $line){
		print(htmlspecialchars($line)."\n");
	}
}else {
	echo "error";
	print_r($_GET);
}

