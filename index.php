<?php
require('dbconnect.php');

// 最大ページ数を求める
$counts = $db->query('select count(*) as cnt from memos ');
// $countsから値を取り出す
$count = $counts->fetch_assoc();
// 
$max_page = floor(($count['cnt']+1)/5+1);

// 降順に5つのデータをデータベースから抽出し、$stmtに格納
$stmt = $db->prepare('select * from memos order by id desc limit ?, 5');

if (!$stmt):
  die($db->error);
endif;

// URLパラメーターのpageから値を取得し、$pageに格納
$page = filter_input(INPUT_GET,'page',FILTER_SANITIZE_NUMBER_INT);

// $pageに値が入っていなかったら、もしくは不正な値の場合、page=1を表示
$page = ($page ? : 1);

// ５つのデータをページ変遷によって表示
$start = ($page - 1) * 5;

// integer型で ? に$startを代入
$stmt->bind_param('i',$start);

// 処理を実行
$result = $stmt->execute();
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

  <!-- input.htmlに移動するリンク -->
  <p>→<a href="input.html">新しいメモ</a></p>
  <!-- $resultが正しいか判定 -->
  <?php if(!$result): ?>
  <p>表示するメモはありません</p>
  <?php endif ?>

  <!-- 抽出した値から、何を使用するか提示 -->
  <?php $stmt->bind_result($id, $memo, $created); ?>

  <!-- 繰り返し処理で取り出す -->
  <?php while ($stmt->fetch()): ?>
  <div>

    <!-- ？　ページ目を表示 見出しは50文字制約-->
    <h2><a href="memo.php?id=<?php echo $id; ?>"><?php echo htmlspecialchars(mb_substr($memo,0,50)); ?></a>
    </h2>

    <!-- 作成日時を表示 -->
    <time><?php echo htmlspecialchars($created);?></time>
  </div>
  <hr>
  <?php endwhile ?>
  <p>
    <?php if ($page > 1): ?>
    <a href="?page=<?php echo $page - 1; ?>"><?php echo $page - 1 ?>ページ目へ</a> |
    <?php endif; ?>
    <?php if ($page<$max_page): ?>
    <a href="?page=<?php echo $page + 1; ?>"><?php echo $page + 1 ?>ページ目へ</a>
    <?php endif ?>
  </p>
</body>

</html>