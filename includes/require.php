<?php
/*
* This file is part of phpIrofferAdmin.
*
* (c) 2013 Valentin Samir
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

require('config.php');
ini_set('display_errors', $_CONFIG['display_error']);
require('functions.php');
require('template.php');
require('login_functions.php');

session_name($_CONFIG['session_name']);
session_start();
login_require();
params();
action();
