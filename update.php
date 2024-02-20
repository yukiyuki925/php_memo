<?php
require("dbconnect.php");
$stmt = $db->prepare('select * from memos where id=?');
if (!$stmt):
  die($db->error);
endif;
$id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$stmt->bind_param('i',$id);
$stmt->execute();

$stmt->bind_result($id,$memo,$created);
$result = $stmt->fetch();
if (!$result){
  die('メモの指定が正しくありません');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>メモの編集</title>
</head>

<body>
  <!-- update_do.phpに接続 -->
  <form action="update_do.php" method="post">
    <!-- webは値を次のページまでしか保持できないので、クッキーやセッションで値を保持する必要がある -->
    <!-- user操作に関わらず値を渡す inputで値を保持-->
    <input type="hidden" name="id" value="<?php echo $id; ?>">

    <!-- name属性にmemoを指定 -->
    <textarea name="memo" cols="50" rows="10"
      placeholder="メモの入力してください"><?php echo htmlspecialchars($memo); ?></textarea><br />
    <button type=" submit">編集する</button>
  </form>
</body>

</html>