<?php
include('includes/config.db.php');
include('includes/functions.php');

$PHP_EXTENTIONS = array('PDO', 'pdo_mysql');
$PHP_INCLUDES=array('smarty3/Smarty.class.php', 'includes/config.db.php');
$READABLE_FILES=array();
$WRITABLE_FILES=array('templates_c/');
if(function_exists('db')){
	db()->setAttribute(PDO::ATTR_EMULATE_PREPARES, 0);
	db()->exec(file_get_contents('includes/schema.sql'))or die(dberror());
	$DB_QUERY=array(db(), 'query');
	$SQL_TABLE=array('users', 'bots', 'bot_user');
	$CUSTOM_HTML='<div style="max-width:600px;width:auto">
<h2>Create first user</h2>';
	if(!in_array('users', $FAILED['SQL_TABLE'])&&isset($_POST['action'])&&$_POST['action']=='create_first_user'){
		$CUSTOM_HTML.="User Creation";
		$query=db()->query("SELECT count(*) FROM users");
		if($query->fetch()[0]===0){
			if(db()->query("INSERT INTO users (name, email, password) VALUES ("
                    	.db()->quote($_POST['name']).", "
                    	.db()->quote($_POST['email']).", "
                    	.db()->quote(crypt($_POST['password'])).")")
                	) {
				$CUSTOM_HTML.=' <span style="color:green; font-weight:bold;text-align:right;float: right;">[OK]</span>';
			} else {
				$CUSTOM_HTML.=' <span style="color:red; font-weight:bold;text-align:right;float: right;">[FAILED] ('.dberror().')</span>';
			}
		}else{
			$CUSTOM_HTML.=' <span style="color:red; font-weight:bold;text-align:right;float: right;">[FAILED] (first user already created)</span>';
		}

	}else {
$CUSTOM_HTML.='<form method="post"/>
	<input type="hidden" name="action" value="create_first_user"/>
	<input type="text" name="name" placeholder="Name"/><br/>
	<input type="text" name="email" placeholder="Email"/><br/>
	<input type="password" name="password" placeholder="Password"/><br/>
	<input type="submit" value="send"/>
</form>';
	}
$CUSTOM_HTML.='</div>';
}



$FAILED=array();
if(isset($PHP_EXTENTIONS)&&!empty($PHP_EXTENTIONS)){
	$FAILED['PHP_EXTENTIONS']=test('PHP needed extentions:', $PHP_EXTENTIONS, function ($elt) { return in_array($elt, get_loaded_extensions());});
}

if(isset($PHP_INCLUDES)&&!empty($PHP_INCLUDES)){
	$FAILED['PHP_INCLUDES']=test('Check if files are in include path:', $PHP_INCLUDES, 'stream_resolve_include_path', function ($path) { if(stream_resolve_include_path($path)) return stream_resolve_include_path($path); else return $path;});
}
if(isset($READABLE_FILES)&&!empty($READABLE_FILES)){
	$FAILED['READABLE_FILES']=test('Check for write permission:', $READABLE_FILES,'is_readable');
}
if(isset($WRITABLE_FILES)&&!empty($WRITABLE_FILES)){
	$FAILED['WRITABLE_FILES']=test('Check for write permission:', $WRITABLE_FILES, 'is_writable');
}

if(isset($SQL_TABLE)&&!empty($SQL_TABLE)){
	$tables=get_tables($DB_QUERY);
        $FAILED['SQL_TABLE']=test('SQL tables:', $SQL_TABLE, function ($elt) { global $tables; return in_array($elt, $tables);});
}

if(isset($CUSTOM_HTML)){
	echo $CUSTOM_HTML;
}
function test($title, $array, $test_function, $display_function=false){
	$failed=array();
	echo '<h2>'.$title.'</h2>';
	echo '<ul style="max-width:600px;width:auto">';
	foreach($array as $elt){
		echo '<li style="border-bottom: 1px dotted black">';
		if($display_function!==false)echo call_user_func($display_function, $elt);
		else echo $elt;
		if(call_user_func($test_function, $elt)){
			echo ' <span style="color:green; font-weight:bold;text-align:right;float: right;">[OK]</span>';
		} else {
			echo ' <span style="color:red; font-weight:bold;text-align:right;float: right;">[FAILED]</span>';
			$failed[]=$elt;
		}
		echo '</li>';
	}
	echo '</ul>';
	return $elt;
}

function get_tables($db_query){
	$tables=array();
	$query=call_user_func($db_query, 'show tables');
	while($data=$query->fetch()) $tables[]=$data[0];
	return $tables;
}

