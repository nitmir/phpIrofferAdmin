<?php
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