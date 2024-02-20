<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>メモ詳細</title>
</head>

<body>
  <?php
  // データベース接続
  require('dbconnect.php');

  // 詳細を表示したいデータを抽出
  $stmt = $db->prepare('select * from memos where id=?');
  if (!$stmt){
    die($db->error);
  }
  // URLパラメータからidを取得し＄idに格納
  $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
  if (!$id) {
    echo '表示するメモを指定してください';
    exit();
  }
  // integer型で＄idを？にぶち込む
  $stmt->bind_param('i',$id);

  // 処理を実行
  $stmt->execute();

  // $id, $memo, $createdを使用する宣言
  $stmt->bind_result($id, $memo, $created);

  // $resultにfetchで取り出した値を格納
  $result = $stmt->fetch();
  if (!$result) { 
    echo '指定されたメモは見つかりませんでした';
    exit();
}
  ?>

  <!-- 選択した値を表示 -->
  <div>
    <pre><?php echo htmlspecialchars($memo); ?></pre>
  </div>
  <small>
    <pre><?php echo htmlspecialchars($created); ?></pre>
  </small>

  <p>
    <a href="update.php?id=<?php echo $id; ?>">編集する</a> |
    <a href="delete.php?id=<?php echo $id; ?>">削除する</a> |
    <a href="/php_memo/?page=1">一覧へ</a>
  </p>
</body>

</html>