<?php
    header('Content-Type: application/json;charset=utf-8');
    header('Access-Control-Allow-Origin:*'); // *代表允许任何网址请求
    header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); // 允许请求的类型
    header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
    header('Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin'); // 设置允许自定义请求头的字段

    require_once("conn.php");

    $role = $_POST['role'];
    $username = $_POST['username'];

    // sprintf
    if($role == 'admin') {
      // $sql_select=sprintf("select  * from `%s_details` inner join `%s` on `%s_details`.`username`=`%s`.`username` where `%s`.`username`='%s' or `%s_details`.`username`='%s'",$role,$username);
      $sql_select = sprintf("select * from `%s_details` where `username`='%s'",$role,$username);
      $res = mysqli_query($conn, $sql_select);
      if($res) {
        while($row = mysqli_fetch_array($res)) {
          $getNotice[] = array(
            "id"=>$row["id"],
            "username"=>$row["username"],
            "name"=>$row["name"],
            "nickname"=>$row["nickname"],
            "telephone"=>$row["telephone"],
            'homepage'=>$row["homepage"],
            'introduction'=>$row["introduction"],
            'date'=>$row['date'],
           
          );
        }
      }
    }else if($role == 'user') {
      $sql_select = sprintf("select * from `%s_details` where `username`='%s'", $role, $username);
      $res = mysqli_query($conn, $sql_select);
      if($res) {
        while($row = mysqli_fetch_array($res)) {
          $getNotice[] = array(
            "id"=>$row["id"],
            "username"=>$row["username"],
            "name"=>$row["name"],
            "nickname"=>$row["nickname"],
            "telephone"=>$row["telephone"],
            "maxborrow"=>$row["maxborrow"],
            "sex"=>$row["sex"],
            "age"=>$row["age"],
            "imageUrl"=>$row["imageUrl"],
          );
        }
      }
    }
    
    
    
    echo json_encode($getNotice);
?>