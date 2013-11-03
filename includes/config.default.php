<?php
/*
* This file is part of phpIrofferAdmin.
*
* (c) 2013 Valentin Samir
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

/* Should point to the directory (ending with a slash) contening
* the smarty Smarty.class.php file. By default, we assume the dir smarty3/
* is inside the php path (for example it is located to /usr/share/php/smarty3/
* on debian like system)
*/
$_CONFIG['smarty3']='smarty3/';

// Display or not php error, for debuging purpose
$_CONFIG['display_error']=0;

// Name of the session used by php
$_CONFIG['session_name']='phpIrofferAdmin';

//timeout then connecting to iroffer telnet interface in seconds
$_CONFIG['iroffer_timeout']=3;

//possible values are 10, 25, 50, 100, 500 or -1 (for all elements)
$_CONFIG['datatables']['elements_to_display']=25;
