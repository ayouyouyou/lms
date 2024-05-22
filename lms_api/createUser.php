<?php
  header('Content-Type: application/json;charset=utf-8');
  header('Access-Control-Allow-Origin:*'); // *代表允许任何网址请求
  header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); // 允许请求的类型
  header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
  header('Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin'); // 设置允许自定义请求头的字段

  require_once("conn.php");

  $role = $_POST['role'];
  $username = $_POST['username'];
  $name = $_POST['name'];
  $nickname = $_POST['nickname'];
  $age = $_POST['age'];
  $telephone = $_POST['telephone'];
  $maxborrow = $_POST['maxborrow'];
  $sex = $_POST['sex'];
  $imageUrl=$_POST['imageUrl'];

  $sql_select = "select username from user where username = '$username'";
  $res = mysqli_query($conn, $sql_select);
  if(mysqli_num_rows($res) == 0) {
    $sql = "insert into `user_details`(
      `role`, `username`, `name`, `nickname`, `telephone`, `maxborrow`, `sex`, `age`,`imageUrl`) 
      values 
      ('$role', '$username', '$name', '$nickname', '$telephone', '$maxborrow', '$sex', '$age','$imageUrl')";
    $insert = mysqli_query($conn, $sql);
    if($insert) {
      echo "success";
    }else {
      echo "failed";
    }
  }else {
    echo "existed";
  }
?>