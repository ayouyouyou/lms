<?php
    header('Content-Type: application/json;charset=utf-8');
    header('Access-Control-Allow-Origin:*'); // *代表允许任何网址请求
    header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); // 允许请求的类型
    header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
    header('Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin'); // 设置允许自定义请求头的字段

    require_once("conn.php");

    $id = $_POST['id'];
    $username = $_POST['username'];
    $bookname = $_POST['bookname'];
    $borrow_date = $_POST['borrow_date'];
    $should_return_date = $_POST['should_return_date'];
    
    // 查询是否有该用户
    $sql_select_user = "select `id` from `user` where `username` = '$username'";
    $res_user = mysqli_query($conn, $sql_select_user);
    $row_user = mysqli_fetch_array($res_user);
    // 查询是否有该本书
    $sql_select_book = "select `id` from `book` where `name` = '$bookname'";
    $res_book = mysqli_query($conn, $sql_select_book);
    $row_book = mysqli_fetch_array($res_book);
    
    if(mysqli_num_rows($res_user) > 0 && mysqli_num_rows($res_book) > 0) {
      $sql = "update `borrow` set `user_id`='$row_user[0]', `book_id`='$row_book[0]', `borrow_date`='$borrow_date', `should_return_date`='$should_return_date' where `id`='$id'";
      $edit = mysqli_query($conn, $sql);
      if($edit) {
        echo "success";
      } else {
        echo $row_user[0];
      }
    }else {
      echo "no user or no book";
    }
?>