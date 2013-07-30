<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require('config.php');
require('functions.php');
require('login_functions.php');
require('template.php');

session_start();
logout();
login_require();
params();
action();
