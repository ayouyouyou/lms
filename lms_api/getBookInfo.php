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
    if(isset($_GET['search'])) {
        $search = $_GET['search'];
    }

    // select id from book;
    $sql1 = "select `id` from `book`";
    if($res = mysqli_query($conn, $sql1)) {
      $rows = mysqli_num_rows($res);
    }
    $maxPage = ceil($rows/$pageSize); // 总页数

    // select * from book where name='%$search%' and author='%$search%' and publisher='%$search%' and publish_date='%$search%' and tag='%$search%';
    $sql2 = "select * from `book` where 
        `name` like'%$search%' or `author` like '%$search%' or 
        `publisher` like '%$search%' or 
        `publish_date` like '%$search%' or 
        `tag` like '%$search%' limit ".($currentPage-1)*$pageSize.", ".$pageSize;
    $result2 = $conn->query($sql2);
    if($res = $result2) {
        if(mysqli_num_rows($res) > 0) {
            while($row = mysqli_fetch_array($res)) {
                $getData[] = array(
                  "id"=>$row["id"],
                  "name"=>$row["name"],
                  "author"=>$row["author"],
                  "publisher"=>$row["publisher"],
                  "publish_date"=>$row["publish_date"],
                  "position"=>$row["position"],
                  "tag"=>$row["tag"]);
            }
        }
    }
    $arr[] = array(
        "total"=>$maxPage,
        "data"=>$getData
    );
    echo json_encode($arr); // 数据库内数据
?>