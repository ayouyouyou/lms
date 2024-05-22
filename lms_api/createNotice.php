<?php
header( 'Content-Type: application/json;charset=utf-8' );
header( 'Access-Control-Allow-Origin:*' );
// *代表允许任何网址请求
header( 'Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE' );
// 允许请求的类型
header( 'Access-Control-Allow-Credentials: true' );
// 设置是否允许发送 cookies
header( 'Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin' );
// 设置允许自定义请求头的字段

require_once( 'conn.php' );

$date = $_POST['date'];
$title = $_POST['title'];
$content = $_POST['content'];

$sql = "insert into `notice`(`date`, `title`, `content`) values ('$date', '$title', '$content')";
$insert = mysqli_query( $conn, $sql );
if ( $insert >0 ) {
    echo 'success';
} else {
    echo 'failed';
}
?>