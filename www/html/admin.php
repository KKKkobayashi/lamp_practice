<?php
//定数ファイル読み込み
require_once '../conf/const.php';
//各種関数ファイル読み込み
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

//cookieのセッションスタート
session_start();

//sessionが存在するかどうか
if(is_logined() === false){
  //ログインページ読み込み
  redirect_to(LOGIN_URL);
}
//DB接続
$db = get_db_connect();

//userテーブルからsessionのユーザーIDに一致する1レコード取得
$user = get_login_user($db);

//adminユーザーだったらTRUE
if(is_admin($user) === false){
  redirect_to(LOGIN_URL);
}

//itemsテーブルから全商品取得。
$items = get_all_items($db);

//商品管理ページ読み込み
include_once VIEW_PATH . '/admin_view.php';
