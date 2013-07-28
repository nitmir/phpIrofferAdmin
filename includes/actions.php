<?php
//url to call for GET action or POST action
$_ACTION = array(
	'edit_pack' => 'edit_pack',
	'delete_pack' => 'delete_pack',
	'edit_group' => 'edit_group',
	'delete_group' => 'delete_group',
	'add_file' => 'add_file',
	'add_dir' => 'add_dir',
	'delete_dir' => 'delete_dir',
	'delete_all_pack_from_group' => 'delete_all_pack_from_group',
);
function action_url($action, $type, $params){
	global $_ACTION;
	if($type=='get'){
		switch($action){
			case $_ACTION['delete_pack']:
				needed_params(array('pack'), $params);
				return action_delete_pack(view('bot_listing', $params, true), $params['pack']);
				break;
			case $_ACTION['edit_group']:
			case $_ACTION['delete_group']:
			case $_ACTION['delete_all_pack_from_group']:
				needed_params(array('param'), $params);
				list($base, $params_)=view('bot_listing', $params, true);
				return build_url($base, array_replace($params_, array('action'=>$action, 'param'=>$params ['param'])));
			case $_ACTION['add_file']:
			case $_ACTION['add_dir']:
			case $_ACTION['delete_dir']:
				needed_params(array('param'), $params);
				list($base, $params_)=view('files_listing', $params, true);
				return build_url($base, array_replace($params_, array('action'=>$action, 'param'=>$params ['param'])));
				break;

		}
	}elseif($type=='post'){
		switch($action){
			case $_ACTION['edit_pack']:
				return view('bot_listing', $params);
				break;
			case $_ACTION['edit_group_post']:
				return view('bot_listing', $params);
		}
	}else{
		die('action type sould be "get" or "post", not '.$type);
	}
}

function action_delete_pack($view, $pack){
	global $_ACTION;
	$params=array_replace($view[1], array('action' => $_ACTION['delete_pack'], 'pack' => $pack));
	return build_url($view[0], $params);
}

function action_edit_group($view, $group_id){
	global $_ACTION;
	$params=array_replace($view[1], array('action' => $_ACTION['edit_group_get'], 'group_id' => $group_id));
	return build_url($view[0], $params);
}

function action_delete_group($view, $group){
	global $_ACTION;
	$params=array_replace($params, array('action' => $_ACTION['delete_group'], 'group' => $group));
	return build_url($view[0], $params);
}

function action_add_file($view, $file){
	global $_ACTION;
	$params=array_replace($view[1], array('action' => $_ACTION['add_file'], 'file' => $file));
	return build_url($view[0], $params);
}
function action_add_dir($view, $dir){
	global $_ACTION;
	$params=array_replace($view[1], array('action' => $_ACTION['add_dir'], 'dir' => $dir));
	return build_url($view[0], $params);
}
function action_delete_dir($view, $dir){
	global $_ACTION;
	$params=array_replace($view[1], array('action' => $_ACTION['delete_dir'], 'dir' => $dir));
	return build_url($view[0], $params);
}