<?php
require("includes/require.php");

if($_PARAMS['bot']!==false){
	display("templates/bot_command.tpl");
}else {
	echo "error";
	print_r($_GET);
}