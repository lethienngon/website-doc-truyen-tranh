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
// Dữ liệu thêm vào chương
$truyen_id = $_GET['truyen_id'];
$admin_id = $_COOKIE['id'];
$chuong_stt = $_POST['truyen_chuong_sochuong'];
$chuong_name = $_POST['truyen_chuong_name'];
$chuong_noidung = $_POST['truyen_chuong_noidung'];
// Connect Mysql
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
// SQL check thanhvien
$sql = "select ADMIN_USERNAME from admin where ADMIN_ID='$id' and ADMIN_USERNAME='$username' and ADMIN_MATKHAU=md5('$pass')";
$result = $conn->query($sql);
// Nếu là thành viên thì thực hiện trong lệnh if dưới đây
if ($result->num_rows > 0) {
    // Dữ liệu thêm vào bảng 'truyen'
    $sql_insert_truyen = "INSERT INTO `chuong`(`TRUYEN_ID`, `ADMIN_ID`, `CHUONG_STT`, `CHUONG_NAME`, `CHUONG_NOIDUNG`) VALUES ('$truyen_id', '$admin_id', '$chuong_stt', '$chuong_name', '$chuong_noidung');";
    $result = $conn->query($sql_insert_truyen);
} 
// Nếu không là thành viên thì exit
else {
    echo "EXIT";
    exit();
}
$conn->close();
