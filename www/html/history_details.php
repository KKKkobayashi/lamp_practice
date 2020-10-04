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

$history_id = get_post('history_id');
$date = get_post('create_datetime');
$total = get_post('total');
$token = get_post('token');

if(is_valid_csrf_token($token) === TRUE) {
  //画面表示用の配列取得
  $details = get_details($db,$history_id);
}

include_once VIEW_PATH . 'history_details_view.php';