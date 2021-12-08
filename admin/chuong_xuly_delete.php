<?php
// Check cookie
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
if (!isset($_COOKIE['username']) and !isset($_COOKIE['pass'])) {
    exit();
}
// Dữ liệu để check xem người muốn xóa có phải là thành viên không
$id = $_COOKIE['id'];
$username = $_COOKIE['username'];
$pass = $_COOKIE['pass'];
// Connect Mysql
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
// SQL check thanhvien
$sql = "select ADMIN_USERNAME from admin where ADMIN_ID='$id' and ADMIN_USERNAME='$username' and ADMIN_MATKHAU=md5('$pass')";
$result = $conn->query($sql);
// Nếu là thành viên thì thực hiện trong lệnh if dưới đây
if ($result->num_rows > 0) {
   // Lấy id của chương đễ xóa
   $chuong_id = $_GET['chuong_id'];
   // SQL xóa chương
   $sql_del = "DELETE FROM chuong where CHUONG_ID='$chuong_id'";
   $result_del = $conn->query($sql_del);
}
// Nếu không là thành viên thì exit
else{
    exit();
    echo "EXIT";
}
$conn->close();