<?php
require("includes/require.php");


if($_PARAMS['bot']!==false){
	$conn = new IROFFER($_PARAMS['bot']['host'], $_PARAMS['bot']['port'], $_PARAMS['bot']['password']);

	if($_PARAMS['group']!=''){
		$groups=$conn->xdl($group_only=true);
		function valide_group($group, $groups){
			for($i=0;isset($groups[$i]);$i++){
				if($groups[$i]['name']==$group){
					return true;
				}
			}
			return false;
		}
		if(!valide_group($_PARAMS['group'], $groups)){
			header('Location: '.view('bot_listing', array('bot_id'=>$_PARAMS['bot']['id'], 'group' => '')));
			die();
		}
		$packs=$conn->xdlgroup($_PARAMS['group']);
	}else{
		list($packs, $groups) = $conn->xdl();
	}
	$tpl->assign('packs', $packs);
	$tpl->assign('groups', $groups);
	display("templates/bot_xdl.tpl");
}else {
	header("Location: main.php");
}