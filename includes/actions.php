<?php
//url to call for GET action or POST action

// intern representation => action name in url
$_ACTION = array(
    'edit_pack' => 'edit_pack',
    'delete_pack' => 'delete_pack',
    'edit_group' => 'edit_group',
    'delete_group' => 'delete_group',
    'delete_all_pack_from_group' => 'delete_all_pack_from_group',
    'add_file' => 'add_file',
    'add_dir' => 'add_dir',
    'delete_dir' => 'delete_dir',
    'edit_bot' => 'edit_bot',
    'delete_bot' => 'delete_bot',
    'create_bot' => 'create_bot',
    'login' => 'login',
    'logout' => 'logout',
);
$_ACTION_VIEW = array(
    $_ACTION['edit_pack'] => 'bot_listing',
    $_ACTION['delete_pack'] => 'bot_listing',
    $_ACTION['edit_group'] => 'bot_listing',
    $_ACTION['delete_group'] => 'bot_listing',
    $_ACTION['delete_all_pack_from_group'] => 'bot_listing',
    $_ACTION['add_file'] => 'files_listing',
    $_ACTION['add_dir'] => 'files_listing',
    $_ACTION['delete_dir'] => 'files_listing',
    $_ACTION['edit_bot'] => 'bot_management',
    $_ACTION['delete_bot'] => 'bot_management',
    $_ACTION['create_bot'] => 'bot_management',
    $_ACTION['login'] => 'main',
    $_ACTION['logout'] => 'main',
);
$_ACTION_REVERSE = array();
foreach($_ACTION as $key => $value){ $_ACTION_REVERSE[$value]=$key; }

function action_url($action, $type, $params){
    global $_ACTION_VIEW, $_ACTION_REVERSE;
    if(isset($_ACTION_REVERSE[$action])){
        if($type=='get'){
            needed_params(array('values'), $params);
            list($base, $params_)=view($_ACTION_VIEW[$_ACTION_REVERSE[$action]], $params, true);
            if(REWRITE_URL){
                if(count($params ['values'])>1) die('Only support one value as action parameter');
                return build_url($base.($base!=''&&$base[strlen($base)-1]!='/'?'/':'').'action/'.$action.'/'.$params ['values'][0], $params_);
            }else{
                return build_url($base, array_replace($params_, array('action'=>$action, 'values'=>$params ['values'])));
            }
        }elseif($type=='post'){
            return view($_ACTION_VIEW[$action], $params);
        }else{
            die('action type sould be "get" or "post", not '.$type);
        }
    } else {
        print_r($_ACTION_REVERSE);
        die('Unknow action '.$action);
    }
}

function action_post() {
    global $_ACTION, $_PARAMS, $_ACTION_REVERSE;
    if($_PARAMS['action']!=''){
        if(function_exists('action_post_'.$_ACTION_REVERSE[$_PARAMS['action']])){
            call_user_func('action_post_'.$_ACTION_REVERSE[$_PARAMS['action']], $_PARAMS);
        } else {
            die('action_post_'.$_ACTION_REVERSE[$_PARAMS['action']]);
        }
    }
}
function action_get(){
    global $_ACTION, $_PARAMS, $_ACTION_REVERSE;
    if($_PARAMS['action']!=''){
        if(function_exists('action_get_'.$_ACTION_REVERSE[$_PARAMS['action']])){
            call_user_func('action_get_'.$_ACTION_REVERSE[$_PARAMS['action']], $_PARAMS);
        }  else {
            die('action_get_'.$_ACTION_REVERSE[$_PARAMS['action']]);
        }
    }
}

function action() {
    if($_SERVER['REQUEST_METHOD']=='GET'){
        action_get();
    } elseif($_SERVER['REQUEST_METHOD']=='POST'){
        action_post();
    }
}

require('actions_functions.php');