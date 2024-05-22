<?php

header('Content-Type: application/json;charset=utf-8');
header('Access-Control-Allow-Origin:*'); // *代表允许任何网址请求
header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); // 允许请求的类型
header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
header('Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin,Accept'); // 设置允许自定义请求头的字段

    

    require_once("conn.php");

    $role = $_POST['role'];
    
    switch($role) {
      case "admin":
      
        if(isset($_POST['imageUrl']) && isset($_POST['username'])) {
          $username = $_POST['username'];
          $imageUrl = $_POST['imageUrl'];
          if(isset($_POST['name']) && isset($_POST['nickname']) && isset($_POST['telephone']) && isset($_POST['homepage']) && isset($_POST['introduction']) ) {
              // 如果传递了其他字段，则使用原来的更新语句
            $name = $_POST['name'];
            $nickname = $_POST['nickname'];
            $telephone = $_POST['telephone'];
            $homepage = $_POST['homepage'];
            $introduction = $_POST['introduction'];
            
              
            $sql = "update `".$role."_details` set `nickname`='$nickname', `telephone`='$telephone', `homepage`='$homepage', `introduction`='$introduction' ,`name`='$name' where username='$username'";
          } else {
              // 如果只传递了用户名和图片 URL，则使用另一个更新语句
              $sql = "update `".$role."_details` SET `imageUrl`='$imageUrl' WHERE `username`='$username'";
          };
        }
        $edit = mysqli_query($conn, $sql);
        if($edit) {
          echo "success";
        } else {
          echo "failed";
        };break;

      case "user":

        if(isset($_POST['imageUrl']) && isset($_POST['username'])) {
          $username = $_POST['username'];
          $imageUrl = $_POST['imageUrl'];
          if(isset($_POST['name']) && isset($_POST['nickname']) && isset($_POST['telephone']) && isset($_POST['maxborrow']) && isset($_POST['sex']) && isset($_POST['age'])) {
              // 如果传递了其他字段，则使用原来的更新语句
              $name = $_POST['name'];
              $nickname = $_POST['nickname'];
              $telephone = $_POST['telephone'];
              $maxborrow = $_POST['maxborrow'];
              $sex = $_POST['sex'];
              $age = $_POST['age'];
              
              $sql = "UPDATE `".$role."_details` SET `name`='$name', `nickname`='$nickname', `telephone`='$telephone', `maxborrow`='$maxborrow', `sex`='$sex', `age`='$age', `imageUrl`='$imageUrl' WHERE `username`='$username'";
          } else {
              // 如果只传递了用户名和图片 URL，则使用另一个更新语句
              $sql = "UPDATE `".$role."_details` SET `imageUrl`='$imageUrl' WHERE `username`='$username'";
          }
      
          $edit = mysqli_query($conn, $sql);
          if($edit) {
              echo "success";
          } else {
              echo "failed";
          }
      }


        // $sql ="select `".$role."_details`.`id` , `".$role."`.`id` from `submit`='$submit' , `name`='$name', `nickname`='$nickname', `telephone`='$telephone', `maxborrow`='$maxborrow', `sex`='$sex', `age`='$age' where username='$username'";
        
        $edit = mysqli_query($conn, $sql);
        if($edit) {
          echo "success";
        } else {
          echo "failed";
        };break;
        
    }
    // 检查是否有文件上传
if(isset($_FILES['file'])) {
  $username = $_POST['username'];
  $imageUrl=$_POST['imageUrl'];
  // 指定保存文件的目录
  $targetDirectory = "./image/";

  // 生成唯一的文件名
  $targetFileName = uniqid() . '_' . basename($_FILES['file']['name']);

  // 构造保存文件的完整路径
  $targetFilePath = $targetDirectory . $targetFileName;

  // 将文件移动到目标目录中
  if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
      // 文件移动成功，返回图片的路径
      $imageUrl = 'http://localhost/lms_api/image/'.$targetFileName;

      // 更新数据库中的 imageUrl 字段
      $sql = "update `user_details` set `imageUrl` = '$imageUrl' where `username` = '$username'";
      $result = mysqli_query($conn, $sql);

      if ($result) {
          echo json_encode(array("success" => true, "message" => "文件上传成功", "imageUrl" => $imageUrl));
      } else {
          echo json_encode(array("success" => false, "message" => "更新数据库失败"));
      }
  } else {
      // 文件移动失败
      echo json_encode(array("success" => false, "message" => "抱歉，上传文件失败。"));
  }
} else {
  // 没有文件上传
  echo json_encode(array("success" => false, "message" => "没有文件上传"));
}
    // $username = $_POST['username'];
    // $nickname = $_POST['nickname'];
    // $telephone = $_POST['telephone'];
    // $homepage = $_POST['homepage'];
    // $introduction = $_POST['introduction'];
    
    // $sql = "update `".$role."_details` set `nickname`='$nickname', `telephone`='$telephone', `homepage`='$homepage', `introduction`='$introduction' where username='$username'";
    // $edit = mysqli_query($conn, $sql);
    // if($edit) {
    //   echo "success";
    // } else {
    //   echo "failed";
    // }
?>