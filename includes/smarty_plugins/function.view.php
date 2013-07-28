<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.view.php
 * Type:     function
 * Name:     view
 * Purpose:  build url to a view
 * -------------------------------------------------------------
 */
 
 function smarty_function_view($params, &$smarty)
{
    return view($params['page'], array_replace($params['params'], $params));
}
?>