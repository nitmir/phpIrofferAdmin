<?php
/*
* This file is part of phpIrofferAdmin.
*
* (c) 2013 Valentin Samir
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

include('includes/iroffer.php');
include('includes/functions.php');

$query=db()->query("SELECT * FROM bots WHERE id='1'");
while($data=$query->fetch()){
   $conn = new IROFFER($data['host'], $data['port'], $data['password']);
/*   foreach($conn->info(1) as $line){
       print_r($line);
   }
*/
//   print($conn->renumber(109,110));
//print_r($conn->info(1));
}
?>
