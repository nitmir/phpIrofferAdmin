<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.action.php
 * Type:     function
 * Name:     action
 * Purpose:  build url for an action
 * -------------------------------------------------------------
 */
 
 function smarty_function_action($params, &$smarty)
{
    
    return action_url($params['action'], $params['type'], array_replace($params['params'], $params));
}
?>