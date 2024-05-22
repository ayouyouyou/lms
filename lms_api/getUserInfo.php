<?php
    header('Content-Type: application/json;charset=utf-8');
    header('Access-Control-Allow-Origin:*'); // *代表允许任何网址请求
    header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); // 允许请求的类型
    header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
    header('Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin'); // 设置允许自定义请求头的字段

    require_once("conn.php");

    // echo "请求成功";
    $search = null;
    $currentPage = $_GET['currentPage'];
    $pageSize = $_GET['pageSize'];
    $role = $_GET['role'];
    if(isset($_GET['search'])) {
        $search = $_GET['search'];
    }

    $sql1 = "select `id` from `user_details` where `role`='$role'";
    if($res = mysqli_query($conn, $sql1)) {
      $rows = mysqli_num_rows($res);
    }
    $maxPage = ceil($rows/$pageSize); // 总页数

    $sql2 = "select * from `user_details`
        where `role`='$role' and
        (`role` like '%$search%' or 
        `username` like '%$search%' or 
        `name` like '%$search%' or 
        `nickname` like '%$search%' or
        `telephone` like '%$search%') limit ".($currentPage-1)*$pageSize.", ".$pageSize;
    $result2 = $conn->query($sql2);
    if($res = $result2) {
        if(mysqli_num_rows($res) > 0) {
            while($row = mysqli_fetch_array($res)) {
                $getData[] = array("id"=>$row["id"],
                "username"=>$row["username"],
                "name"=>$row["name"],
                "nickname"=>$row["nickname"],
                "telephone"=>$row["telephone"],
                "maxborrow"=>$row["maxborrow"],
                "sex"=>$row["sex"],
                "age"=>$row["age"],
                "imageUrl"=>$row["imageUrl"],);
            }
        }
    }
    $arr[] = array(
        "total"=>$maxPage,
        "data"=>$getData
    );
    echo json_encode($arr); // 数据库内数据
?>