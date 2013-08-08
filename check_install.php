<?php
/*
* This file is part of phpIrofferAdmin.
*
* (c) 2013 Valentin Samir
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

@include('includes/functions.php');

$PHP_EXTENTIONS = array('PDO', 'pdo_mysql');
$PHP_INCLUDES=array('smarty3/Smarty.class.php', 'includes/config.php');
$READABLE_FILES=array();
$WRITABLE_FILES=array('templates_c/');

$SQL_TABLE=array('users', 'bots', 'bot_user');

$MISC=array(
	'root_path' => array(
		function () {
			global $FAILED, $MYSQL;
			if(!in_array('includes/config.php', $FAILED['PHP_INCLUDES'])){
				include('includes/config.php');
				$root=dirname($_SERVER['SCRIPT_NAME']);
				if($root!='/')$root.='/';
				return 'Relatif root path ('.ROOT.' == '.$root.')';
			} else {
				return 'Relatif root path';
			}
		},
		function () {
			$root=dirname($_SERVER['SCRIPT_NAME']);
			if($root!='/')$root.='/';
			return ROOT==$root;
		}
	),
	'database_connection' => array(
		'Database connection',
		function(){
		try { return function_exists('db')&&db(); } catch(PDOException $e){ echo ' '.nl2br($e);return false; }}
	),
	'database_table' => array(
		'Import sql scheme',
		function () {
			global $FAILED;
			if(!in_array('database_connection', $FAILED['MISC'])){
				if(db()->query(file_get_contents('includes/schema.sql'))){
					return true;
				} else {
					return false;
				}
			}
		}
	),

	'first_user' => array(
		'First user Creation',
		function() {
			global $FAILED;
			if(!in_array('database_table', $FAILED['MISC'])){
				$query=db()->query("SELECT count(*) FROM users");
				if(!$query) return false;
				if($query->fetch()[0]==='0'){
					if(isset($_POST['action'])&&$_POST['action']=='create_first_user'){
						if(db()->query("INSERT INTO users (`right`, name, email, password) VALUES ('ADMIN', "
						.db()->quote($_POST['name']).", "
						.db()->quote($_POST['email']).", "
						.db()->quote(crypt($_POST['password'])).")")
						) {
							return true;
						} else {
							return false;
						}
					} else {
						echo '<form method="post"/>
							<input type="hidden" name="action" value="create_first_user"/>
							<input type="text" name="name" placeholder="Name"/><br/>
							<input type="text" name="email" placeholder="Email"/><br/>
							<input type="password" name="password" placeholder="Password"/><br/>
							<input type="submit" value="send"/>
						</form>';
					}
				} else {
					return true;
				}
			}

		}
	),

);


	$CUSTOM_HTML.='</ul>';
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

if(isset($MISC)&&!empty($MISC)){
	$FAILED['MISC']=array();
	echo '<h2>Misc:</h2>';
	echo '<ul style="max-width:600px;width:auto">';
	foreach($MISC as $key =>$test){
		echo '<li style="border-bottom: 1px dotted black">';
		if($test[0] instanceof  Closure){
			echo call_user_func($test[0]);
		} else {
			echo $test[0];
		}
		if(call_user_func($test[1])){
			echo ' <span style="color:green; font-weight:bold;text-align:right;float: right;">[OK]</span>';
		} else {
			echo ' <span style="color:red; font-weight:bold;text-align:right;float: right;">[FAILED]</span>';
			$FAILED['MISC'][]=$key;
		}
	}
	echo '</ul>';
}

if(isset($SQL_TABLE)&&!empty($SQL_TABLE)){
	$tables=get_tables();
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
	return $failed;
}

function get_tables($db_query){
	$tables=array();
	$query=db()->query('show tables');
	while($data=$query->fetch()) $tables[]=$data[0];
	return $tables;
}
