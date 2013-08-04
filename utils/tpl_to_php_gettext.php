#!/usr/bin/env php
<?php
/*
* This file is part of phpIrofferAdmin.
*
* (c) 2013 Valentin Samir
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

$handle = fopen ("php://stdin","r");
$i=0;
echo "<?php ";
$n=1;
while($line = fgets($handle)){
	preg_match_all("/{'([^']*)'\|gettext[^}]*}/", $line, $matchs);
	for($i=0;isset($matchs[1][$i]);$i++)
		echo "_('".$matchs[1][$i]."');";
	preg_match_all('/{"([^"]*)"\|gettext[^}]*}/', $line, $matchs);
	for($i=0;isset($matchs[1][$i]);$i++)
		echo '_("'.$matchs[1][$i].'");';
	$n++;
	echo "\n";
}
echo "?>\n";
fclose($handle);
?>
