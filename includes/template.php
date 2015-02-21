<?php
/*
* This file is part of phpIrofferAdmin.
*
* (c) 2013 Valentin Samir
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

require($_CONFIG['smarty3']."Smarty.class.php"); // On inclut la classe Smarty

$tpl = new Smarty();

$tpl->addPluginsDir(dirname(__FILE__).'/smarty_plugins/');

require('view.php');
require('actions.php');

function set_language(){
    global $_PARAMS;
    if(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) == 'fr'){
        $_PARAMS['lang']='fr';
        $lang='fr_FR.utf8';
        $filename = 'default';
        setlocale(LC_ALL, $lang);
        bindtextdomain($filename, './lang/');
        bind_textdomain_codeset($filename, "UTF-8");
        textdomain($filename);
    }
}

function display($page){
	global $tpl, $_PARAMS, $_ACTION, $_CONFIG;
	$tpl->assign('action', $_ACTION);
	$tpl->assign('ROOT', ROOT);
	$tpl->assign('subpage', '');
	$tpl->assign('params', $_PARAMS);
	$tpl->assign('config', $_CONFIG);
	$tpl->assign('messages', messages());
	$tpl->assign('user', user());
	$tpl->inheritance_merge_compiled_includes = false;
	$tpl->display($page);
}
