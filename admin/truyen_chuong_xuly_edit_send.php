<?php
// Check cookie
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
if (!isset($_COOKIE['username']) and !isset($_COOKIE['pass'])) {
    exit();
}
// Lấy dữ liệu cookie
$idtv = $_COOKIE['id'];
$username = $_COOKIE['username'];
$pass = $_COOKIE['pass'];
// Du lieu cua bang 'truyen'
$chuong_id = $_GET['chuong_id'];
$chuong_stt = $_POST['truyen_chuong_sochuong'];
$chuong_name = $_POST['truyen_chuong_name'];
$chuong_trangthai = $_POST['truyen_chuong_trangthai'];
$chuong_noidung = $_POST['truyen_chuong_noidung_edit'];
// Connet Mysql
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
// Kiểm tra xem người dùng có trong thành viên không
$sql = "select ADMIN_USERNAME from admin where ADMIN_ID='$idtv' and ADMIN_USERNAME='$username' and ADMIN_MATKHAU=md5('$pass')";
$result = $conn->query($sql);
// Nếu là thành viên thì thực hiện trong lệnh if dưới đây
if ($result->num_rows > 0) {
    // Du lieu them vao bang 'truyen'
    $sql_update_chuong = "UPDATE chuong SET CHUONG_STT='$chuong_stt', CHUONG_NAME='$chuong_name', CHUONG_TRANGTHAI='$chuong_trangthai', CHUONG_NOIDUNG='$chuong_noidung' where CHUONG_ID='$chuong_id'";
    $result_update_chuong = $conn->query($sql_update_chuong);
}
// Nếu không là thành viên thì exit
else {
    exit();
    echo "EXIT";
}
$conn->close();
