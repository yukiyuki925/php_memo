<?php
require('dbconnect.php');
$memos = $db->query('select * from memos order by id desc');
if(!$memos){
  die($db->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>メモ帳</title>
</head>

<body>
  <h1>メモ帳</h1>
  <p>→<a href="input.html">新しいメモ</a></p>
  <?php while ($memo = $memos->fetch_assoc()): ?>
  <div>
    <h2><a
        href="memo.php?id=<?php echo $memo['id']; ?>"><?php echo htmlspecialchars(mb_substr($memo['memo'],0,50)); ?></a>
    </h2>
    <time><?php echo htmlspecialchars($memo['created']);?></time>
  </div>
  <hr>
  <?php endwhile ?>
</body>

</html>