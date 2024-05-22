<?php
    header('Content-Type: application/json;charset=utf-8');
    header('Access-Control-Allow-Origin:*'); // *代表允许任何网址请求
    header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); // 允许请求的类型
    header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
    header('Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin'); // 设置允许自定义请求头的字段

    require_once("conn.php");

    $role = $_POST['role'];
    $username = $_POST['username'];
    $imageUrl = $_POST['imageUrl'];

        $sql="select * from `".$role."_details` where `username`='$username'" ;

        $get = mysqli_query($conn, $sql);
       if ($get) {
    // 如果查询成功，获取结果集中的第一行数据（假设每个用户只有一条记录）
    $row = mysqli_fetch_assoc($get);
    // 如果查询结果非空，则返回用户的头像路径
    if ($row) {
        echo json_encode(array("success" => true, "imageUrl" => $row['imageUrl']));
    } else {
        // 如果查询结果为空，则说明没有找到对应用户的记录
        echo json_encode(array("success" => false, "message" => "用户不存在"));
    }
} else {
    // 查询失败
    echo json_encode(array("success" => false, "message" => "查询失败"));
}
          

    ?>