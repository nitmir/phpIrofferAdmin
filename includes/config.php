<?php

//database params
require('config.db.php');

setlocale (LC_TIME, 'fr_FR.utf8','fra');
setlocale (LC_ALL, "fr_FR");


define('ADMIN',10);
define('USER',1);

define('ROOT', '/');
define('REWRITE_URL', true);



$_CONFIG['level']=array(
	USER => 'USER',
	ADMIN => 'ADMIN',
);

$_CONFIG['display_error']=0;
$_CONFIG['session_name']='phpIrofferAdmin';
