<?php
    header('Content-Type: application/json;charset=utf-8');
    header('Access-Control-Allow-Origin:*'); // *代表允许任何网址请求
    header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); // 允许请求的类型
    header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
    header('Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin'); // 设置允许自定义请求头的字段

    require_once("conn.php");

    $id = $_POST['id'];
    $total = $_POST["total"];
    $current = $_POST["current"];
    
    $sql = "update `store` set `store_total`='$total', `store_current`='$current' where `store_id`='$id'";
    $edit = mysqli_query($conn, $sql);
    if($edit) {
      echo "success";
    } else {
      echo "failed";
    }
?>