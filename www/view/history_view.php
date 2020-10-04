<?php 
header('X-FRAME-OPTIONS: DENY');
$token = get_csrf_token();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>購入履歴</title>
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'history.css'); ?>">
</head>
<body>
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  <h1>購入履歴</h1>
  <div class="container">

    <?php include VIEW_PATH . 'templates/messages.php'; ?>

    <?php if(count($histories) > 0){ ?>
      <table class="table table-bordered">
        <thead class="thead-light">
          <tr>
            <th>注文番号</th>
            <th>購入日時</th>
            <th>合計金額</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($histories as $history){ ?>
          <tr>
            <td><?php print(h($history['history_id'])); ?></td>
            <td><?php print(h($history['create_datetime'])); ?></td>
            <td><?php print(number_format(h($history['total']))); ?></td>
            <td>
              <form method="post" action="history_details.php">
                <input type="submit" value="購入明細表示" class="btn btn-secondary">
                <input type="hidden" name="history_id" value="<?php print(h($history['history_id'])); ?>">
                <input type="hidden" name="create_datetime" value="<?php print(h($history['create_datetime'])); ?>">
                <input type="hidden" name="total" value="<?php print(number_format(h($history['total']))); ?>">
                <input type='hidden' name='token' value='<?php print $token;?>'>
              </form>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    <?php } else { ?>
      <p>購入履歴はありません。</p>
    <?php } ?> 
  </div>
</body>
</html>