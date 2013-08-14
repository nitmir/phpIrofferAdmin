<?php
/*
* This file is part of phpIrofferAdmin.
*
* (c) 2013 Valentin Samir
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

function action_get_edit_group($param){
}
function action_get_edit_bot($param){
}
function action_get_edit_user($params){
}
function action_get_refresh_bots($params){
	user()->bots(true);
	header('Location: '.view('bot_management', $params));
        die();
}
function action_post_manage_user_bot($params){
    global $_ACTION;
    print_r($_POST);
    if(user()->right()=='ADMIN'){
	$delete=array();
	$insert=array();
	$user = USER::byID($params['values']['user']);
	foreach($params['values']['bots'] as $id){
		if(!in_array($id, $params['values_old']['bots'])){
			$user->add_bot($id);
		}
	}
	foreach($params['values_old']['bots'] as $id){
		if(!in_array($id, $params['values']['bots'])){
			$user->delete_bot($id);
		}
	}
	if($user->id() == user()->id()){
		user()->bots(true);
	}
	header('Location: '.action_url($_ACTION['manage_user_bot'], 'get', array('values' => array($params['values']['user']))).'#user_'.$params['values']['ancre']);
	die();
    }
}
function action_get_manage_user_bot($params){
    global $_PARAMS;
    if(user()->right()=='ADMIN'){
        $_PARAMS['all_bots']=BOT::all_bots();
        $_PARAMS['user_bots']=BOT::by_user($params['values'][0]);
    }
}
function action_get_delete_pack($params){
    if($params['bot']!==false){
        $conn = new IROFFER($params['bot']->host(), $params['bot']->port(), $params['bot']->password());
        $mess=$conn->remove($params['values'][0]);
        if(preg_match('/Removed Pack ([0-9]+) \[(.*)\]/', $mess, $match)){
            messages()->success(sprintf(_('Pack %s (%s) removed'), $match[1], $match[2]));
        } elseif($mess=='Try Specifying a Valid Pack Number'){
            messages()->error(sprintf(_('Invalid pack number %s, unable to remove it'), $params['values'][0]));
        } else {
            messages()->error(_($mess));
        }
        header('Location: '.view('bot_listing', $params));
        die();
    }
}
function action_get_delete_group($params){
    if($params['bot']!==false){
        $conn = new IROFFER($params['bot']->host(), $params['bot']->port(), $params['bot']->password());
        $mess=$conn->regroup($params['values'][0], 'MAIN');
        if($mess=='REGROUP: Old: '.$params['values'][0].' New: MAIN'){
            messages()->success(sprintf(_('Group %s deleted'), $params['values'][0]));
        } else {
            messages()->error(_($mess));
        }
        header('Location: '.view('bot_listing', $params));
        die();
    }
}
function action_get_delete_all_pack_from_group($params){
    if($params['bot']!==false){
        $conn = new IROFFER($params['bot']->host(), $params['bot']->port(), $params['bot']->password());
        $mess=$conn->removegroup($params['values'][0]);
        if($mess){
            messages()->success(sprintf(_('Delete all pack from group %s'), $params['values'][0]));
        }else{
            messages()->error(sprintf(_('Error deleting all pack from group %s'), $params['values'][0]));
        }
        $params['group']='';
        header('Location: '.view('bot_listing', $params));
        die();
    }
}
function action_get_add_file($params){
    if($params['bot']!==false){
        $conn = new IROFFER($params['bot']->host(), $params['bot']->port(), $params['bot']->password());
        $message=$conn->add($params['values'][0]);
        if(preg_match('/Added: \[Pack ([0-9]+)\] \[File (.*)\]/', $message, $match)){
            messages()->success(sprintf(_('File %s added at pack #%s'), $match[2], $match[1]));
        } elseif(preg_match('/File \'(.*)\' is already added./', $message, $match)){
            messages()->warning(sprintf(_('File %s is already added.'), $match[1]));
	} elseif(preg_match('@(.*) is not a file@', $message, $match)){
		messages()->error(sprintf(_('%s is not a file'), str_replace('//', '/', $match[1])));
        } else {
            messages()->error(_($message));
        }
        header('Location: '.view('files_listing', $params));
        die();
    }
}
function action_post_add_dir($params){
    if($params['bot']!==false){
        $conn = new IROFFER($params['bot']->host(), $params['bot']->port(), $params['bot']->password());
        switch($params['values']['add_type']){
            case 'ADDGROUP': 
                if($params['values']['group']!=''){
                    $message=$conn->addgroup($params['values']['group'], $params['values']['dir']);
                } else {
                    messages()->error(_('Please choose a non empty group name'));
                    header('Location: '.view('files_listing', $params));
                    die();
                }
                break;
            case 'ADDNEW': $message=$conn->addnew($params['values']['dir']); break;
            case 'ADDDIR': $message=$conn->adddir($params['values']['dir']); break;
	    case 'ADD':
		$params['values'][0]=$params['values']['dir'];
		action_get_add_file($params);
		break;
            default: $message=_('Invalid method for adddir'); break;
        }
        if(preg_match('/Adding ([0-9]+) files from dir (.*)/', $message, $match)){
            messages()->success(sprintf(_('%s files added from dir %s'), $match[1], $match[2]));
        } elseif ($message=='--> ADMIN QUIT requested (DCC Chat: telnet) (network: 1)'){
            messages()->warning(_('Nothing to do'));
	} elseif(preg_match('/Can\'t Access Directory: (.*) Not a directory/', $message, $match)){
		messages()->error(sprintf(_('%s is not a directory'), str_replace('//', '/', $match[1])));
        } else {
            messages()->error(_($message));
        }
        header('Location: '.view('files_listing', $params));
        die();
    }
}
function action_get_delete_dir($params){
    if($params['bot']!==false){
        $conn = new IROFFER($params['bot']->host(), $params['bot']->port(), $params['bot']->password());
        $message=$conn->removedir($params['values'][0]);
        if ($message=='--> ADMIN QUIT requested (DCC Chat: telnet) (network: 1)'){
            messages()->success(_('No error reported'));
        } else {
            messages()->error(_($message));
        }
        header('Location: '.view('files_listing', $params));
        die();
    }
}
function action_post_edit_group($params){
    if($params['bot']!==false){
        $conn = new IROFFER($params['bot']->host(), $params['bot']->port(), $params['bot']->password());
        if($params['values']['description']!=$params['values_old']['description']){
            $mess=$conn->groupdesc($params['values_old']['name'], $params['values']['description']);
            if($mess=='New GROUPDESC: '.$params['values']['description']){
                messages()->success(sprintf(_('Description of group %s changed to %s'), $params['values_old']['name'], $params['values']['description']));
            } else {
                messages()->error(_($mess));
            }
        }
        if($params['values']['name']!=$params['values_old']['name']){
            $mess=$conn->regroup($params['values_old']['name'], $params['values']['name']);
            if($mess=='REGROUP: Old: '.$params['values_old']['name'].' New: '.$params['values']['name']){
                messages()->success(sprintf(_('Group %s renamed to %s'), $params['values_old']['name'], $params['values']['name']));
            } else {
                messages()->error(_($mess));
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

        $conn = new IROFFER($params['bot']->host(), $params['bot']->port(), $params['bot']->password());
        if($params['values_old']['group']!=$params['values']['group']){
            $mess=$conn->group($params['values_old']['pack'], $params['values']['group']);
            if(preg_match('/GROUP: \[Pack '.$params['values_old']['pack'].'\]/', $mess)){
                if($params['values']['group']=='MAIN'){
                    $conn->regroup('MAIN', 'MAIN');
                }
                messages()->success(sprintf(_('Pack #%s set to group %s'), $params['values_old']['pack'], $params['values']['group']));
            }else{
                messages()->error(_($mess));
            }
        }
        if($params['values_old']['description']!=$params['values']['description']){
            $mess=$conn->chdesc($params['values_old']['pack'], $params['values']['description']);
            if(preg_match('/CHDESC: \[Pack '.$params['values_old']['pack'].'\] Old: .* New: .*/', $mess)){
                messages()->success(sprintf(_('Description of pack #%s changed'), $params['values_old']['pack']));
            } else {
                messages()->error(_($mess));
            }
        }
        if($params['values_old']['pack']!=$params['values']['pack']){
            $mess=$conn->renumber((int)$params['values_old']['pack'], (int)$params['values']['pack']);
            if($mess=='** Moved pack '.$params['values_old']['pack'].' to '.$params['values']['pack']){
                messages()->success(sprintf(_('Pack #%s moved to #%s'), $params['values_old']['pack'], $params['values']['pack']));
            } else {
                messages()->error(_($mess));
            }
        }
        header('Location: '.view('bot_listing', $params));
        die();
    }
}

function action_post_edit_bot($params){
    if(user()->own_bot($params['values']['id'])){
	BOT::withRow($params['values'])->update($params['values']);
	user()->bots(true);
        header('Location: '.view('bot_management', $params));
        die();
    }
}

function action_post_create_bot($params){
    user()->create_bot($params['values']['name'], $params['values']['host'], $params['values']['port'], $params['values']['password']);
    header('Location: '.view('bot_management', $params));
    die();
}

function action_get_delete_bot($params){
    if(user()->right()=='ADMIN'){
	BOT::withID($params['values'][0])->delete();
    } else {
        user()->delete_bot($params['values'][0]);
    }
    header('Location: '.view('bot_management', $params));
    die();
}
function action_get_logout($params){
    if(user()->valid()){
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

function action_post_edit_user($params){
    if($params['values']['id']==user()->id() || user()->right() == 'ADMIN'){
        $succs=array();
        $erros=array();

	$name=false;
	$email=false;
	$password=false;
	$right=false;

	$user=USER::byID($params['values']['id']);

       // Update right
       if($params['values']['right']!=$params['values_old']['right']&&user()->right() == 'ADMIN'){
           $right=trim($params['values']['right']);
           $succs[]=sprintf(_('Right of %s updated to %s'), $params['values_old']['name'], $params['values']['right']);
       }

        // Update name
        if(strlen($params['values']['name'])>=3){
            if($params['values']['name']!=$params['values_old']['name']){
		$name=trim($params['values']['name']);
                $succs[]=sprintf(_('Name of %s updated to %s'), $params['values_old']['name'], $params['values']['name']);
            }
        } else {
            $errors []=_('Names sould be longer than 3 character');
        }
        // Update email
        if($params['values']['email'] != $params['values_old']['email']){
	    $email=trim($params['values']['email']);
            $succs[]=sprintf(_('Email of %s updated to %s'), $params['values_old']['name'], $params['values']['email']);
        }
        //Update Password
        if($params['values']['password1']!='' || $params['values']['password2']!=''){
            if($params['values']['password1']==$params['values']['password2']){
		$password=$params['values']['password1'];
                $succs[]=sprintf(_('Password of %s updated'), $params['values_old']['name']);
            } else {
                $errors []=_('Passwords mismatch, no updated');
            }
        }
        // Do the upate
        if($user->update($name, $email, $password, $right)){
            if($user->id()==user()->id()){
                user()->load();
            }
            messages()->success($succs);
            messages()->error($errors);
        }
        header('Location: '.view('users'));
        die();
    }
}

function action_post_create_user($params){
    if(user()->right() == 'ADMIN'){
        if($params['values']['password1']==$params['values']['password2']&&$params['values']['password1']!=''){
            if(strlen($params['values']['name'])>=3){
                if(USER::create($params['values']['name'], $params['values']['email'], $params['values']['password1'])) {
                    messages()->success(sprintf(_('User %s created'), $params['values']['name']));
                } else {
                    messages()->error(sprintf(_('Creation error: %s'), dberror()));
                }
            }else{
                messages()->error(_('Names sould be longer than 3 character'));
            }
        } else {
            messages()->error(_('Passwords mismatch, user creation abort'));
        }

        header('Location: '.view('users'));
        die();
    }
}

function action_get_delete_user($params){
	if(user()->right() == 'ADMIN'){
		try{
			$user=USER::byID($params['values'][0]);
			if($user->delete()){
				messages()->success(sprintf(_('User %s deleted'), $user->name()));
			} else {
				messages()->error(sprintf(_('Deletion error: %s'), dberror()));
			}
		}catch(Exception $e){
			messages()->error(sprintf(_('Deletion error: %s'), $e));
		}
		header('Location: '.view('users'));
		die();
	}
}
