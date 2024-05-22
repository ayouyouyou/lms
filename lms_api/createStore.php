<?php
  header('Content-Type: application/json;charset=utf-8');
  header('Access-Control-Allow-Origin:*'); // *代表允许任何网址请求
  header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); // 允许请求的类型
  header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
  header('Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin'); // 设置允许自定义请求头的字段

  require_once("conn.php");

  $id = $_POST['id'];
  $name = $_POST['name'];
  $total = $_POST['total'];
  $current = $total;

  // 1. 查询是否在stock表中已存在该书信息
  // select * from stock where id='$id'
  // 2. 插入操作
  if(isset($id)) {
    $sql_select = "select * from store where store_id = '$id'";
    $res_query = mysqli_query($conn, $sql_select);
    if(mysqli_num_rows($res_query) > 0) {
      echo "existed";
    } else {
        $sql_insert = "insert into `store`(
          `store_id`, `store_total`, `store_current`) 
          values 
          ($id, '$total', '$current')";
          $insert = mysqli_query($conn, $sql_insert);
        if($insert) {
          echo "success";
        }else {
          echo "failed";
        }
    } 
  }
  else {
    echo"failed";
  }
?>