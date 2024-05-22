<?php
    header('Content-Type: application/json;charset=utf-8');
    header('Access-Control-Allow-Origin:*'); // *代表允许任何网址请求
    header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); // 允许请求的类型
    header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
    header('Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin'); // 设置允许自定义请求头的字段

    require_once("conn.php");

    $search = null;
    $currentPage = $_GET['currentPage'];
    $pageSize = $_GET['pageSize'];
    if(isset($_GET['search'])) {
        $search = $_GET['search'];
    }

    // select id from book;
    $sql1 = "select `id` from `revert`";
    if($res = mysqli_query($conn, $sql1)) {
      $rows = mysqli_num_rows($res);
    }
    $maxPage = ceil($rows/$pageSize); // 总页数

    $sql2 = "select `revert`.`id`, `user`.`username`, `book`.`name`, 
    `revert`.`borrow_date`, `revert`.`should_return_date`, 
    `revert`.`actual_return_date` from (`revert` inner join `book` 
    on `book`.`id` = `revert`.`book_id`) inner join `user` 
    on `user`.`id` = `revert`.`user_id` 
    where `book`.`name` like '%$search%' or `user`.`username` like '%$search%' 
    order by `actual_return_date` limit ".($currentPage-1)*$pageSize.", ".$pageSize;
    $result2 = $conn->query($sql2);
    if($res = $result2) {
        if(mysqli_num_rows($res) > 0) {
            while($row = mysqli_fetch_array($res)) {
                $getData[] = array(
                  "id"=>$row["id"],
                  "username"=>$row["username"],
                  "bookname"=>$row["name"],
                  "borrow_date"=>$row["borrow_date"],
                  "should_return_date"=>$row["should_return_date"],
                  "actual_return_date"=>$row["actual_return_date"]);
            }
        }
    }
    $arr[] = array(
        "total"=>$maxPage,
        "data"=>$getData
    );
    echo json_encode($arr); // 数据库内数据
?>