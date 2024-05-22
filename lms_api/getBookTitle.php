<?php
    header('Content-Type: application/json;charset=utf-8');
    header('Access-Control-Allow-Origin:*'); // *代表允许任何网址请求
    header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); // 允许请求的类型
    header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
    header('Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin'); // 设置允许自定义请求头的字段

    require_once("conn.php");

    $name = $_POST['name'];

    if(isset($_POST['name'])) {
      $search = $_POST['name'];
  }

    $sql2 = "select `id`, `name` from `book` where `name` like '%$name%'";
    $result2 = $conn->query($sql2);
    if($res = $result2) {
        if(mysqli_num_rows($res) > 0) {
            while($row = mysqli_fetch_array($res)) {
              $getData[] = array(
                "id"=>$row["id"],
                "name"=>$row["name"]
              );
            }
        }
    }

    if(!isset($getData) || count($getData) == 0)
      echo '{"data":[]}';
    else
      echo json_encode($getData);
    // $arr[] = array(
    //     "data"=>$getData
    // );
    // echo json_encode($arr); // 数据库内数据
?>