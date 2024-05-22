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
  $actual_return_date = $_POST['actual_return_date'];

  // 查询是否有该用户
  $sql_select_user = "select id from `user` where `username` = '$username'";
  $res_user = mysqli_query($conn, $sql_select_user);
  $row_user = mysqli_fetch_array($res_user);
  // 查询是否有该本书
  $sql_select_book = "select id from `book` where `name` = '$bookname'";
  $res_book = mysqli_query($conn, $sql_select_book);
  $row_book = mysqli_fetch_array($res_book);

  if(mysqli_num_rows($res_user) > 0 && mysqli_num_rows($res_book) > 0) {
    // 查询是否有该条记录
    $sql_select_borrow = "select * from `borrow` where `id` = $id";
    $res_borrow = mysqli_query($conn, $sql_select_borrow);
    if(mysqli_num_rows($res_borrow) > 0) {
      // 1.从 borrow 表中删除
      $sql_delete_borrow = "delete from `borrow` where `id` = $id";
      $delete = mysqli_query($conn, $sql_delete_borrow);
      // 2.添加进 revert 表中  
      // insert into revert(user_id, book_id, borrow_date, should_return_date, actual_return_date) values('$row_user[0]', '$row_book[0]', '$borrow_date', '$should_return_date', '$actual_return_date');
      $sql_insert = "insert into `revert`(`user_id`, `book_id`, `borrow_date`, `should_return_date`, `actual_return_date`) 
      values('$row_user[0]', '$row_book[0]', '$borrow_date', '$should_return_date', '$actual_return_date')";
      $insert = mysqli_query($conn, $sql_insert);

      echo mysqli_error($conn);

      if($insert) {
        echo "success";
      }else {
        echo "insert error";
        // echo "user_id:".$row_user[0].", book_id:".$row_book[0].", actual_return_date:".$actual_return_date;
      }
    } else {
      echo "select error-2";
    }
  }else {
    echo "select error-1";
  }
?>