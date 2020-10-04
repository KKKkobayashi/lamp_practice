<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'history.php';

session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();
$user = get_login_user($db);

//adminユーザーかどうかで場合分け
if(is_admin($user)){
  $histories = get_admin_histories($db);
} else {
  $histories = get_user_histories($db,$user['user_id']);
}

include_once VIEW_PATH . 'history_view.php';