<?php
require('dbconnect.php');
$stmt = $db->prepare('select * from memos order by id desc limit ?, 5');
if (!$stmt):
  die($db->error);
endif;
$page = filter_input(INPUT_GET,'page',FILTER_SANITIZE_NUMBER_INT);
$page = ($page ? : 1);
$start = ($page - 1) * 5;
$stmt->bind_param('i',$start);
$stmt->execute();
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
  <?php $stmt->bind_result($id, $memo, $created); ?>
  <?php while ($stmt->fetch()): ?>
  <div>
    <h2><a href="memo.php?id=<?php echo $id; ?>"><?php echo htmlspecialchars(mb_substr($memo,0,50)); ?></a>
    </h2>
    <time><?php echo htmlspecialchars($created);?></time>
  </div>
  <hr>
  <?php endwhile ?>
</body>

</html>