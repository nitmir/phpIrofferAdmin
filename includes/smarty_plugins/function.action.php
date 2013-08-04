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
