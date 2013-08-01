<?php

//paramètres de connection à la base de donnée
$MYSQL['host']='localhost';
$MYSQL['username']='iroffer';
$MYSQL['password']='password';
$MYSQL['database']='iroffer';

setlocale (LC_TIME, 'fr_FR.utf8','fra');
setlocale (LC_ALL, "fr_FR");


define('ADMIN',10);
define('USER',1);

define('ROOT', '/');
define('REWRITE_URL', true);

$config['level']=array(
	USER => 'USER',
	ADMIN => 'ADMIN',
);
