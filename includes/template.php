<?php
require("smarty3/Smarty.class.php"); // On inclut la classe Smarty
$tpl = new Smarty();

$tpl->addPluginsDir(dirname(__FILE__).'/smarty_plugins/');

if(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) == 'fr'){
	$lang='fr_FR.utf8';
	$filename = 'default';
	setlocale(LC_ALL, $lang);
	bindtextdomain($filename, './lang/');
	bind_textdomain_codeset($filename, "UTF-8");
	textdomain($filename);
}