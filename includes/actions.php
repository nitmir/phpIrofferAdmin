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
            case $_ACTION['edit_group']:
                return view('bot_listing', $params);
                break;
        }
    }else{
        die('action type sould be "get" or "post", not '.$type);
    }
}

function action_get(){
    global $_ACTION, $_PARAMS;
    $actions_done=array();
    if(isset($_GET['action'])){
        switch($_GET['action']){
            case $_ACTION['delete_pack']:
                if($_PARAMS['bot']!==false){
                    $conn = new IROFFER($_PARAMS['bot']['host'], $_PARAMS['bot']['port'], $_PARAMS['bot']['password']);
                    $mess=$conn->remove($_GET['param']);
                    if(preg_match('/Removed Pack ([0-9]+) \[(.*)\]/', $mess, $match)){
                        $_SESSION['message_success'] []=sprintf(_('Pack %s (%s) removed'), $match[1], $match[2]);
                    } elseif($mess=='Try Specifying a Valid Pack Number'){
                        $_SESSION['message_error'] []=sprintf(_('Invalid pack number %s, unable to remove it'), $_GET['param']);
                    } else {
                        $_SESSION['message_error'] []=_($mess);
                    }
                    header('Location: '.view('bot_listing', $_PARAMS));
                    die();
                }
                break;
            case $_ACTION['delete_group']:
                if($_PARAMS['bot']!==false){
                    $conn = new IROFFER($_PARAMS['bot']['host'], $_PARAMS['bot']['port'], $_PARAMS['bot']['password']);
                    $mess=$conn->regroup($_GET['param'], 'MAIN');
                    if($mess=='REGROUP: Old: '.$_GET['param'].' New: MAIN'){
                        $_SESSION['message_success'] []=sprintf(_('Group %s deleted'), $_GET['param']);
                    } else {
                        $_SESSION['message_error'] []=_($mess);
                    }
                    header('Location: '.view('bot_listing', $_PARAMS));
                    die();
                }
                break;
            case $_ACTION['add_file']:
                if($_PARAMS['bot']!==false){
                    $conn = new IROFFER($_PARAMS['bot']['host'], $_PARAMS['bot']['port'], $_PARAMS['bot']['password']);
                    $message=$conn->add($_GET['param']);
                    if(preg_match('/Added: \[Pack ([0-9]+)\] \[File (.*)\]/', $message, $match)){
                        $_SESSION['message_success'] []=sprintf(_('File %s added at pack #%s'), $match[2], $match[1]);
                    } elseif(preg_match('/File \'(.*)\' is already added./', $message, $match)){
                        $_SESSION['message_warning'][]=sprintf(_('File %s is already added.'), $match[1]);
                    } else {
                        $_SESSION['message_error'] []=_($message);
                    }
                    header('Location: '.view('files_listing', $_PARAMS));
                    die();
                }
                break;
        }
    }
}