<?php
// 连接数据库
$conn = mysqli_connect( 'localhost', 'root', '123', 'lms', 3306 );

if ( mysqli_connect_errno( $conn ) ) {
    $str = mysqli_connect_error();
    echo '连接 MySQL 失败:', $str;
} else {
    echo '';
}
// 解决中文乱码
mysqli_set_charset( $conn, 'utf8' );
?>