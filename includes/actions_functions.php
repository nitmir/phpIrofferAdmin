<?php


function action_get_edit_group($param){
}
function action_get_edit_bot($param){
}
function action_get_delete_pack($params){
    if($params['bot']!==false){
        $conn = new IROFFER($params['bot']['host'], $params['bot']['port'], $params['bot']['password']);
        $mess=$conn->remove($params['values'][0]);
        if(preg_match('/Removed Pack ([0-9]+) \[(.*)\]/', $mess, $match)){
            $_SESSION['message_success'] []=sprintf(_('Pack %s (%s) removed'), $match[1], $match[2]);
        } elseif($mess=='Try Specifying a Valid Pack Number'){
            $_SESSION['message_error'] []=sprintf(_('Invalid pack number %s, unable to remove it'), $params['values'][0]);
        } else {
            $_SESSION['message_error'] []=_($mess);
        }
        header('Location: '.view('bot_listing', $params));
        die();
    }
}
function action_get_delete_group($params){
    if($params['bot']!==false){
        $conn = new IROFFER($params['bot']['host'], $params['bot']['port'], $params['bot']['password']);
        $mess=$conn->regroup($params['values'][0], 'MAIN');
        if($mess=='REGROUP: Old: '.$params['values'][0].' New: MAIN'){
            $_SESSION['message_success'] []=sprintf(_('Group %s deleted'), $params['values'][0]);
        } else {
            $_SESSION['message_error'] []=_($mess);
        }
        header('Location: '.view('bot_listing', $params));
        die();
    }
}
function action_get_delete_all_pack_from_group($params){
    if($params['bot']!==false){
        $conn = new IROFFER($params['bot']['host'], $params['bot']['port'], $params['bot']['password']);
        $mess=$conn->removegroup($params['values'][0]);
        if($mess){
            $_SESSION['message_success'] []=sprintf(_('Delete all pack from group %s'), $params['values'][0]);
        }else{
            $_SESSION['message_error'] []=sprintf(_('Error deleting all pack from group %s'), $params['values'][0]);
        }
        $params['group']='';
        header('Location: '.view('bot_listing', $params));
        die();
    }
}
function action_get_add_file($params){
    if($params['bot']!==false){
        $conn = new IROFFER($params['bot']['host'], $params['bot']['port'], $params['bot']['password']);
        $message=$conn->add($params['values'][0]);
        if(preg_match('/Added: \[Pack ([0-9]+)\] \[File (.*)\]/', $message, $match)){
            $_SESSION['message_success'] []=sprintf(_('File %s added at pack #%s'), $match[2], $match[1]);
        } elseif(preg_match('/File \'(.*)\' is already added./', $message, $match)){
            $_SESSION['message_warning'][]=sprintf(_('File %s is already added.'), $match[1]);
        } else {
            $_SESSION['message_error'] []=_($message);
        }
        header('Location: '.view('files_listing', $params));
        die();
    }
}
function action_get_add_dir($params){
    if($params['bot']!==false){
        $conn = new IROFFER($params['bot']['host'], $params['bot']['port'], $params['bot']['password']);
        $message=$conn->adddir($params['values'][0]);
        if(preg_match('/Adding ([0-9]+) files from dir (.*)/', $message, $match)){
            $_SESSION['message_success'] []=sprintf(_('%s files added from dir %s'), $match[1], $match[2]);
        } else {
            $_SESSION['message_error'] []=_($message);
        }
        header('Location: '.view('files_listing', $params));
        die();
    }
}
function action_post_edit_group($params){
    if($params['bot']!==false){
        $conn = new IROFFER($params['bot']['host'], $params['bot']['port'], $params['bot']['password']);
        if($params['values']['description']!=$params['values_old']['description']){
            $mess=$conn->groupdesc($params['values_old']['name'], $params['values']['description']);
            if($mess=='New GROUPDESC: '.$params['values']['description']){
                $_SESSION['message_success'] []=sprintf(_('Description of group %s changed to %s'), $params['values_old']['name'], $params['values']['description']);
            } else {
                $_SESSION['message_error'] []=_($mess);
            }
        }
        if($params['values']['name']!=$params['values_old']['name']){
            $mess=$conn->regroup($params['values_old']['name'], $params['values']['name']);
            if($mess=='REGROUP: Old: '.$params['values_old']['name'].' New: '.$params['values']['name']){
                $_SESSION['message_success'] []=sprintf(_('Group %s renamed to %s'), $params['values_old']['name'], $params['values']['name']);
            } else {
                $_SESSION['message_error'] []=_($mess);
            }
        }
        header('Location: '.view('bot_listing', $params));
        die();
    }
}
function action_post_edit_pack($params){
    if($params['bot']!==false){
        if($params['values_old']['group']=='') $params['values_old']['group']='MAIN';
        if($params['values']['group']=='') $params['values']['group']='MAIN';

        $conn = new IROFFER($params['bot']['host'], $params['bot']['port'], $params['bot']['password']);
        if($params['values_old']['group']!=$params['values']['group']){
            $mess=$conn->group($params['values_old']['pack'], $params['values']['group']);
            if(preg_match('/GROUP: \[Pack '.$params['values_old']['pack'].'\]/', $mess)){
                if($params['values']['group']=='MAIN'){
                    $conn->regroup('MAIN', 'MAIN');
                }
                $_SESSION['message_success'] []=sprintf(_('Pack #%s set to group %s'), $params['values_old']['pack'], $params['values']['group']);
            }else{
                $_SESSION['message_error'] []=_($mess);
            }
        }
        if($params['values_old']['description']!=$params['values']['description']){
            $mess=$conn->chdesc($params['values_old']['pack'], $params['values']['description']);
            if(preg_match('/CHDESC: \[Pack '.$params['values_old']['pack'].'\] Old: .* New: .*/', $mess)){
                $_SESSION['message_success'] []=sprintf(_('Description of pack #%s changed'), $params['values_old']['pack']);
            } else {
                $_SESSION['message_error'] []=_($mess);
            }
        }
        if($params['values_old']['pack']!=$params['values']['pack']){
            $mess=$conn->renumber((int)$params['values_old']['pack'], (int)$params['values']['pack']);
            if($mess=='** Moved pack '.$params['values_old']['pack'].' to '.$params['values']['pack']){
                $_SESSION['message_success'] []=sprintf(_('Pack #%s moved to #%s'), $params['values_old']['pack'], $params['values']['pack']);
            } else {
                $_SESSION['message_error'] []=_($mess);
            }
        }
        header('Location: '.view('bot_listing', $params));
        die();
    }
}

function action_post_edit_bot($params){
    if(isset(botlist()[$params['values']['id']])){
        if($params['values']['password']!=''){
            db()->query("UPDATE bots SET "
                ."name=".db()->quote($params['values']['name']).", "
                ."host=".db()->quote($params['values']['host']).", "
                ."port=".db()->quote($params['values']['port']).", "
                ."password=".db()->quote($params['values']['password']).
            " WHERE id=".db()->quote($params['values']['id'])."")or die(dberror());
        } else {
            db()->query("UPDATE bots SET "
            ."name=".db()->quote($params['values']['name']).", "
            ."host=".db()->quote($params['values']['host']).", "
            ."port=".db()->quote($params['values']['port']).
        " WHERE id=".db()->quote($params['values']['id'])."")or die(dberror());
        }
        header('Location: '.view('bot_management', $params));
        die();
    }
}

function action_post_create_bot($params){
    if(db()->query("INSERT INTO bots (name, host, port, password) VALUES (".
            db()->quote($params['values']['name']).",".
            db()->quote($params['values']['host']).",".
            db()->quote($params['values']['port']).",".
            db()->quote($params['values']['password']).
    ")")){
        $id=db()->lastInsertId();
        db()->query("INSERT INTO `bot_user` (`bot_id`, `user_id`) VALUES (".
            db()->quote($id).",".
            db()->quote($_SESSION['id']).
        ")")or die(dberror());
    } else {
        $query=db()->query("SELECT id FROM bots WHERE "
            ."host=".db()->quote($params['values']['host'])." AND "
            ."port=".db()->quote($params['values']['port'])." AND "
            ."password=".db()->quote($params['values']['password'])
        )or die(dberror());
        if($data=$query->fetch()){
            db()->query("INSERT INTO `bot_user` (`bot_id`, `user_id`) VALUES (".
                db()->quote($data['id']).",".
                db()->quote($_SESSION['id']).
            ")")or die(dberror());
        }else{
            die(_('couple (host, port) already used and wrong password'));
        }
    }
    header('Location: '.view('bot_management', $params));
    die();
}

function action_get_delete_bot($params){
	if($_SESSION['right']=='ADMIN'){
		db()->query("DELETE FROM bots WHERE id=".db()->quote($params['values'][0])."")or die(dberror());
	} else {
		db()->query("DELETE FROM `bot_user` WHERE "
            ."user_id=".db()->quote($_SESSION['id'])." AND "
            ."bot_id=".db()->quote($params['values'][0]).
        "")or die(dberror());
	}
    header('Location: '.view('bot_management', $params));
    die();
}
function action_get_logout($params){
	if(is_logged()){
		foreach(array_keys($_SESSION) as $key){
			unset($_SESSION[$key]);
		}
		$_SESSION=array();
		unset($_SESSION);
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,$params["path"], $params["domain"],$params["secure"], $params["httponly"]);
		}
		session_destroy();
		header('Location: '.view('login'));
		die();
	}
}
