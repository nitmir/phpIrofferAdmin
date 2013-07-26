<?php

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
