<?php
$db = new mysqli('localhost:3306','root','root','mydb');
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
  <?php while ($memo = $memos->fetch_assoc()): ?>
  <div>
    <h2><a href="#"><?php echo htmlspecialchars($memo['memo']); ?></a></h2>
    <time><?php echo htmlspecialchars($memo['created']);?></time>
  </div>
  <hr>
  <?php endwhile ?>
</body>

</html>