<!-- フォームとデータベースをリンク -->
<!-- フォームの値をデータベースに格納 -->

<?php
// データベースの接続
require('dbconnect.php');

// input.htmlのフォームの値を受け取り、$memoに格納。name属性の('memo')とリンク
$memo = filter_input(INPUT_POST,'memo',FILTER_SANITIZE_SPECIAL_CHARS);

// sqlを使い、フォームの値をデータベースに格納する
$stmt = $db->prepare('insert into memos(memo) values(?)');

if (!$stmt):
  die($db->error);
endif;

// values(?)に入れる値と、その型を指定
$stmt->bind_param('s',$memo);

// sql実行
$ret = $stmt->execute();

if ($ret):
  echo "登録されました";
  echo '<br>→ <a href="index.php">トップへ戻る</a>';
else:
  echo $db->error;
endif;
?>