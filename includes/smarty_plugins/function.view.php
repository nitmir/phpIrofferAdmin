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
