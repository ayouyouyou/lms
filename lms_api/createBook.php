<?php
  header('Content-Type: application/json;charset=utf-8');
  header('Access-Control-Allow-Origin:*'); // *代表允许任何网址请求
  header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); // 允许请求的类型
  header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
  header('Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin'); // 设置允许自定义请求头的字段

  require_once("conn.php");

  $name = $_POST['name'];
  $author = $_POST['author'];
  $publisher = $_POST['publisher'];
  $publish_date = $_POST['publish_date'];
  $tag = $_POST['tag'];

  // 需添加逻辑 若书籍已存在则不创建书籍

  $sql = "insert into `book`(
  `name`, `author`, `publisher`, `publish_date`, `tag`) 
  values 
  ('$name', '$author', '$publisher', '$publish_date', '$tag')";
  $insert = mysqli_query($conn, $sql);
  if($insert) {
    echo "success";
  }else {
    echo "failed";
  }
?>