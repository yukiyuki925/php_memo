<?php
require('dbconnect.php');

$stmt = $db->prepare('update memos set memo=? where id=?');
if(!$stmt){
  die($db->error);
}
$memo = filter_input(INPUT_POST,'memo',FILTER_DEFAULT);
$id = filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
$stmt->bind_param('si',$memo,$id);
$success = $stmt->execute();
if(!$success){
  die($db->error);
}
header('Location: memo.php?id=' . $id);
?>