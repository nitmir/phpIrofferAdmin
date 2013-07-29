<?php
require("includes/require.php");


if($_PARAMS['bot_id']>0){
	$bot=$bot_list[$_PARAMS['bot_id']];
	$conn = new IROFFER($bot['host'], $bot['port'], $bot['password']);
	if(isset($_POST['bot_id'])&&$_POST['bot_id']==$bot['id']){
	//it's an edition
		if(isset($_POST['pack_id'])&&isset($_POST['pack'])){
			if($_POST['pack_id']!=$_POST['pack']){
				$mess=$conn->renumber((int)$_POST['pack_id'], (int)$_POST['pack']);
				if($mess=='** Moved pack '.$_POST['pack_id'].' to '.$_POST['pack']){
					$_SESSION['message_success'] []=sprintf(_('Pack #%s moved to #%s'), $_POST['pack_id'], $_POST['pack']);
				} else {
					$_SESSION['message_error'] []=_($mess);
				}
			}
		}
		if(isset($_POST['pack_id'])&&isset($_POST['group'])&&isset($_POST['old_group'])){
			if($_POST['group']!=$_POST['old_group']){
				$mess=$conn->group($_POST['pack_id'], $_POST['group']);
				if(preg_match('/GROUP: \[Pack '.$_POST['pack_id'].'\]/', $mess)){
					if($_POST['group']=='MAIN'){
						$conn->regroup('MAIN', 'MAIN');
					}
					$_SESSION['message_success'] []=sprintf(_('Pack #%s set to group %s'), $_POST['pack_id'], $_POST['group']);
				}else{
					$_SESSION['message_error'] []=_($mess);
				}
			}
		}
		if(isset($_POST['pack_id'])&&isset($_POST['pack_description'])&&isset($_POST['old_pack_description'])){
			if($_POST['pack_description']!=$_POST['old_pack_description']){
				$mess=$conn->chdesc($_POST['pack_id'], $_POST['pack_description']);
				if(preg_match('/CHDESC: \[Pack '.$_POST['pack_id'].'\] Old: .* New: .*/', $mess)){
					$_SESSION['message_success'] []=sprintf(_('Description of pack #%s changed'), $_POST['pack_id']);
				} else {
					$_SESSION['message_error'] []=_($mess);
				}
			}
		}
		if(isset($_POST['group_old_name'])&&isset($_POST['group_name'])&&isset($_POST['group_old_description'])&&isset($_POST['group_description'])){
			if($_POST['group_old_description']!=$_POST['group_description']){
				$mess=$conn->groupdesc($_POST['group_old_name'], $_POST['group_description']);
				if($mess=='New GROUPDESC: '.$_POST['group_description']){
					$_SESSION['message_success'] []=sprintf(_('Description of group %s changed to %s'), $_POST['group_old_name'], $_POST['group_description']);
				} else {
					$_SESSION['message_error'] []=_($mess);
				}
			}
			if($_POST['group_old_name']!=$_POST['group_name']){
				$mess=$conn->regroup($_POST['group_old_name'], $_POST['group_name']);
				if($mess=='REGROUP: Old: '.$_POST['group_old_name'].' New: '.$_POST['group_name']){
					$_SESSION['message_success'] []=sprintf(_('Group %s renamed to %s'), $_POST['group_old_name'], $_POST['group_name']);
				} else {
					$_SESSION['message_error'] []=_($mess);
				}
			}
			header('Location: '.$_SERVER['REQUEST_URI'].'#group_-1');
			die();
		}
		header('Location: '.$_SERVER['REQUEST_URI']);
		die();
	}
	if(isset($_GET['delall'])){
		$mess=$conn->removegroup($_GET['delall']);
		if($mess){
			$_SESSION['message_success'] []=sprintf(_('Delete all pack from group %s'), $_GET['delall']);
		}else{
			$_SESSION['message_error'] []=sprintf(_('Error deleting all pack from group %s'), $_GET['delall']);
		}
		header("Location: ".$_SERVER['PHP_SELF']."?id=".$bot['id'].'#group_-1');
		die();
	}
	$tpl->assign('bot', $bot);
	$tpl->assign('edit', isset($_GET['edit'])?(int)$_GET['edit']:-1);
	$tpl->assign('editgroup', isset($_GET['editgroup'])?(int)$_GET['editgroup']:-1);
	if(isset($_GET['group'])&&$_GET['group']!=''){
		$groups=$conn->xdl($group_only=true);
		$valide_group=false;
		for($i=0;isset($groups[$i]);$i++){
			if($groups[$i]['name']==$_GET['group']){
				$valide_group=true;
			}
		}
		if(!$valide_group){
			header('Location: '.view('bot_listing', array('bot_id'=>$bot['id'], 'group' => ''))); 
			die();
		}
		$tpl->assign('packs', $conn->xdlgroup($_GET['group']));
		$tpl->assign('groups', $groups);
		$tpl->assign('group', $_GET['group']);
	}else{
		$_PARAMS['group']='';
		$tpl->assign('group', '');
		list($packs, $groups) = $conn->xdl();
		$tpl->assign('packs', $packs);
		$tpl->assign('groups', $groups);
	}
	display("templates/bot_xdl.tpl");
}else {
	header("Location: main.php");
}