<?php
/*
* This file is part of phpIrofferAdmin.
*
* (c) 2013 Valentin Samir
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.nav_active.php
 * Type:     function
 * Name:     nav_active
 * Purpose:  check if a button of the navigation bar sould be marked activ
 * -------------------------------------------------------------
 */

 function smarty_function_nav_active($params, &$smarty)
{
    if(isset($params['name'])&&isset($params['page'])&&$params['name']==$params['page']){
	return ' class="active'.(isset($params['class'])?' '.$params['class']:'').'"';
    } else {
        return (isset($params['class'])?' class="'.$params['class'].'"':'');
    }
}
?>
