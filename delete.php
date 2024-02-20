<?php
require("dbconnect.php");

$stmt = $db->prepare('delete from memos where id=?');
if(!$stmt){
  die($db->error);
};

$id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);

if(!$id){
  echo 'メモの指定が正しくありません';
  exit();
};

$stmt->bind_param('i',$id);
$success = $stmt->execute();
if(!$success){
  die($db->error);
}

header('Location: index.php');
?>