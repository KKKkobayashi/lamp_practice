<?php
require_once MODEL_PATH . 'db.php';
require_once MODEL_PATH . 'cart.php';

function insert_purchase_histoy($db,$carts){
  //historyテーブルにinsert
  if(insert_history($db,$carts) === false) {
    set_error('購入履歴の作成に失敗しました。');
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
      set_error('購入履歴の詳細の作成に失敗しました。');
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

function get_user_histories($db, $user_id = null){
  if($user_id !== null){
    $where = "WHERE history.user_id = ?";
  } else {
    $where = "";
  }
  $sql = "
  SELECT
    history.history_id,
    history.create_datetime,
    sum(price*amount) as total
  FROM
    history
  INNER JOIN
    details
  ON
    history.history_id = details.history_id
  {$where}
  GROUP BY
    history.history_id
  ORDER BY
    history.history_id
  DESC
  ";
  if($user_id !== null){
    return fetch_all_query($db, $sql,array($user_id));  
  } else {
    return fetch_all_query($db, $sql);
  }
}

function get_details($db,$history_id){
  $sql = "
  SELECT
    items.name,
    details.price,
    details.amount,
   	details.price*details.amount as sub_total
  FROM
    details
  INNER JOIN
	  items
  ON
    details.item_id = items.item_id
  WHERE
    details.history_id = ?
  ";
  return fetch_all_query($db, $sql,array($history_id));
}
function get_rankings_limit_third($db){
  $sql = "
  SELECT
    items.name,
    sum(details.amount) as sum_amount
  FROM
    details
  JOIN
	  items
  ON
    details.item_id = items.item_id
  GROUP BY
    details.item_id
  ORDER BY
    sum_amount
  DESC
  LIMIT 
    3
  ";
  return fetch_all_query($db, $sql);
}
?>