<?php
// Check cookie
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
if (!isset($_COOKIE['username']) and !isset($_COOKIE['pass'])) {
    exit();
}
// Dữ liệu để check xem người dùng có phải là thành viên không
$id = $_COOKIE['id'];
$username = $_COOKIE['username'];
$pass = $_COOKIE['pass'];
// Dữ liệu GET
$idtv = $_GET['thanhvien_id'];
// Connect Mysql
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
// SQL check người dùng có là thành viên và có level 0 không
$sql = "select ADMIN_USERNAME from admin where ADMIN_ID='$id' and ADMIN_USERNAME='$username' and ADMIN_MATKHAU=md5('$pass') and ADMIN_LEVEL=0";
$result = $conn->query($sql);
// Nếu là thành viên và có level 0 thì thực hiện trong lệnh if dưới đây
if ($result->num_rows > 0) {
    // SQL xóa thành viên
    $sql_del = "DELETE FROM admin where ADMIN_ID='$idtv' and ADMIN_LEVEL!=0";
    $result_del = $conn->query($sql_del);
    // Kiểm tra xem câu lệnh có thành công không
    if ($result_del === TRUE) {
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
// Nếu không là thành viên thì exit
else {
    echo "EXIT";
    exit();
}
$conn->close();