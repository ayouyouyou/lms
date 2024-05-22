<?php
    header('Content-Type: application/json;charset=utf-8');
    header('Access-Control-Allow-Origin:*'); // *代表允许任何网址请求
    header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); // 允许请求的类型
    header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
    header('Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin'); // 设置允许自定义请求头的字段

    require_once("conn.php");

    $id = $_POST['id'];
    $name = $_POST['name'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $publish_date = $_POST['publish_date'];
    $tag = $_POST['tag'];
    
    // update book set name='$name', author='$author', publisher='$publisher', publish_date='$publish_date', tag='$tag' where id=$id;
    $sql = "update `book` set `name`='$name',
      `author`='$author',
      `publisher`='$publisher',
      `publish_date`='$publish_date', `tag`='$tag'
      where `id`='$id'";
    $edit = mysqli_query($conn, $sql);
    if($edit) {
      echo "success";
    } else {
      echo "failed";
    }
?>