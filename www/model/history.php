<?php
require_once MODEL_PATH . 'db.php';
require_once MODEL_PATH . 'cart.php';

function insert_purchase_histoy($db,$carts){
  //historyテーブルにinsert
  if(insert_history($db,$carts) === false) {
    return false;
  }
  //histoyテーブル取得
  $history = get_history($db);
  //detailsテーブルinsert
  foreach($carts as $cart){
    if(insert_details(
        $db,
        $history['history_id'], 
        $cart['item_id'],
        $cart['price'],
        $cart['amount']
      ) === false){
      return false;
    }
  }
}

function insert_history($db,$carts){
  $sql = "
    INSERT INTO
      history(user_id) 
    VALUE(?);
  ";
  return execute_query($db, $sql,array($carts[0]['user_id']));
}

function get_history($db){
  $sql = "
    SELECT
      *
    FROM
      history
    WHERE
      history_id = ?
  ";
  return fetch_query($db, $sql,array($db->lastInsertId()));
}

function insert_details($db,$history_id,$item_id,$price,$amount){
  $sql = "
    INSERT INTO
      details(
        history_id,
        item_id,
        price,
        amount
      )
    VALUES(?,?,?,?);
  ";
  return execute_query($db, $sql,array($history_id,$item_id,$price,$amount));
}

?>