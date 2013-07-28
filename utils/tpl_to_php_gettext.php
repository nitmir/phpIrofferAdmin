#!/usr/bin/env php
<?php
$handle = fopen ("php://stdin","r");
$i=0;
echo "<?php\n";
while($line = fgets($handle)){
	preg_match_all("/{'([^']*)'\|gettext[^}]*}/", $line, $matchs);
	for($i=0;isset($matchs[1][$i]);$i++)
		echo "_('".$matchs[1][$i]."');\n";
	preg_match('/{"([^"]*)"\|gettext[^}]*}/', $line, $matchs);
	for($i=0;isset($matchs[1][$i]);$i++)
		echo '_("'.$matchs[1][$i].'\n");\n';
}
echo "?>\n";
fclose($handle);
?>
