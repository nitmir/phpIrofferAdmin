<?php
require("includes/require.php");
require('includes/iroffer.php');

if(isset($_GET['id'])&&(int)$_GET['id']>0&&isset($bot_list[(int)$_GET['id']])){
	$bot=$bot_list[(int)$_GET['id']];
	$conn = new IROFFER($bot['host'], $bot['port'], $bot['password']);
	if(isset($_POST['bot_id'])&&$_POST['bot_id']==$bot['id']){
	//it's an edition
		if(isset($_POST['pack_id'])&&isset($_POST['pack'])){
			if($_POST['pack_id']!=$_POST['pack']){
				$mess=$conn->renumber((int)$_POST['pack_id'], (int)$_POST['pack']);
				if($mess=='** Moved pack '.$_POST['pack_id'].' to '.$_POST['pack']){
					$_SESSION['message_success'] []='Pack #'.$_POST['pack_id'].' moved to #'.$_POST['pack'];
				} else {
					$_SESSION['message_error'] []=$mess;
				}
				header('Location: '.$_SERVER['REQUEST_URI'].'#pack_'.((int)$_POST['pack'] - 1));
				die();
			}
		}
		if(isset($_POST['group_old_name'])&&isset($_POST['group_name'])&&isset($_POST['group_old_description'])&&isset($_POST['group_description'])){
			if($_POST['group_old_description']!=$_POST['group_description']){
				$mess=$conn->groupdesc($_POST['group_old_name'], $_POST['group_description']);
				if($mess=='New GROUPDESC: '.$_POST['group_description']){
					$_SESSION['message_success'] []='Description of group '.$_POST['group_old_name'].' changed to '.$_POST['group_description'];
				} else {
					$_SESSION['message_error'] []=$mess;
				}
			}
			if($_POST['group_old_name']!=$_POST['group_name']){
				$mess=$conn->regroup($_POST['group_old_name'], $_POST['group_name']);
				if($mess=='REGROUP: Old: '.$_POST['group_old_name'].' New: '.$_POST['group_name']){
					$_SESSION['message_success'] []='Group '.$_POST['group_old_name'].' renamed to '.$_POST['group_name'];
				} else {
					$_SESSION['message_error'] []=$mess;
				}
			}
			header('Location: '.$_SERVER['REQUEST_URI'].'#group_-1');
			die();
		}
		if(isset($_POST['group_pack_id'])&&isset($_POST['group_pack_select'])&&$_POST['group_pack_select']!=''){
			$mess=$conn->group($_POST['group_pack_id'], $_POST['group_pack_select']);

			if($mess=='GROUP: [Pack '.$_POST['group_pack_id'].'] New: '.$_POST['group_pack_select']){
				$_SESSION['message_success'] []='Pack #'.$_POST['group_pack_id'].' set to group '.$_POST['group_pack_select'];
			}else{
				$_SESSION['message_error'] []=$mess;
			}
			header('Location: '.$_SERVER['REQUEST_URI']);
			die();
		}
	}
	if(isset($_GET['delgroup'])){
		$mess=$conn->regroup($_GET['delgroup'], 'MAIN');
		if($mess=='REGROUP: Old: '.$_GET['delgroup'].' New: MAIN'){
			$_SESSION['message_success'] []='Group '.$_GET['delgroup'].' deleted';
		} else {
			$_SESSION['message_error'] []=$mess;
		}
		header("Location: ".$_SERVER['PHP_SELF']."?id=".$bot['id'].'#group_-1');
		die();
	}
	if(isset($_GET['delpack'])){
		$mess=$conn->remove($_GET['delpack']);
		if(substr($mess,0, 12)=='Removed Pack'){
			$_SESSION['message_success'] []=$mess;
		} else {
			$_SESSION['message_error'] []=$mess;
		}
		header("Location: ".$_SERVER['PHP_SELF']."?id=".$bot['id']."&group=".(isset($_GET['group'])?$_GET['group']:''));
		die();
	}
	if(isset($_GET['delall'])){
		$mess=$conn->removegroup($_GET['delall']);
		if($mess){
			$_SESSION['message_success'] []='Delete all pack from group '.$_GET['delall'];
		}else{
			$_SESSION['message_error'] []='Error delete all pack from group '.$_GET['delall'];
		}
		header("Location: ".$_SERVER['PHP_SELF']."?id=".$bot['id'].'#group_-1');
		die();
	}
	$tpl->assign('bot', $bot);
	$tpl->assign('edit', isset($_GET['edit'])?(int)$_GET['edit']:-1);
	$tpl->assign('editgroup', isset($_GET['editgroup'])?(int)$_GET['editgroup']:-1);
	if(isset($_GET['group'])&&$_GET['group']!=''){
		$tpl->assign('packs', $conn->xdlgroup($_GET['group']));
		$tpl->assign('groups', $conn->xdl($group_only=true));
		$tpl->assign('group', $_GET['group']);
	}else{
		$tpl->assign('group', '');
		list($packs, $groups) = $conn->xdl();
		$tpl->assign('packs', $packs);
		$tpl->assign('groups', $groups);
	}
	display("templates/bot_xdl.tpl");
}else {
	header("Location: main.php");
}