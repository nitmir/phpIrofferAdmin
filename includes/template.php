<?php
require("smarty3/Smarty.class.php"); // On inclut la classe Smarty
$tpl = new Smarty();

$tpl->addPluginsDir(dirname(__FILE__).'/smarty_plugins/');