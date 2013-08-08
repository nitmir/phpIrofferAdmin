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

require('sql.php');
require('models/messages.php');
require('models/bot.php');
require('models/user.php');
require('functions.php');
require('template.php');
require('login_functions.php');


