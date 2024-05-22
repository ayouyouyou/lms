<?php
  header('Content-Type: application/json;charset=utf-8');
  header('Access-Control-Allow-Origin:*'); // *代表允许任何网址请求
  header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); // 允许请求的类型
  header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
  header('Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin'); // 设置允许自定义请求头的字段

  require_once("conn.php");

  $username = $_POST['username'];
  $password = $_POST['password'];
  $no = $_POST['no'];

  // 先查询是否有此人 再进行 update 操作
  $sql_select = "select * from `user` where `username` = '$username' and `no` = '$no'";
  $result = mysqli_query($conn, $sql_select);
  $rowcount = mysqli_num_rows($result);
  if($rowcount > 0) {
    $sql_update = "update `user` set `password` = '$password' where `username` = '$username' and `no` = $no";
    $update = mysqli_query($conn, $sql_update);
    if($update) {
      echo "success";
    } else {
      echo "failed";
    }
  }else {
    echo "failed";
  }
?>