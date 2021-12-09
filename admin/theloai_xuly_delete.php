<?php
// Check cookie
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
if (!isset($_COOKIE['username']) and !isset($_COOKIE['pass'])) {
    exit();
}
// Dữ liệu của cookie
$admin_id = $_COOKIE['id'];
$username = $_COOKIE['username'];
$pass = $_COOKIE['pass'];
// Dữ liệu GET
$theloai_id = $_GET['theloai_id'];
// Connect Mysql
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
// SQL check người dùng có là thành viên và có level 0 or 1 không
$sql = "select ADMIN_USERNAME from admin where ADMIN_ID='$admin_id' and ADMIN_USERNAME='$username' and ADMIN_MATKHAU=md5('$pass') and (ADMIN_LEVEL=0 or ADMIN_LEVEL=1)";
$result = $conn->query($sql);
// Nếu là thành viên và có level 0 or 1 thì thực hiện trong lệnh if dưới đây
if ($result->num_rows > 0) {
    // SQL xóa thể loại 
    $sql_del = "DELETE FROM theloai where THELOAI_ID='$theloai_id'";
    $result_del = $conn->query($sql_del);
    // Kiểm tra xem câu lệnh có thành công không
    if ($result_del === TRUE) {
    }
    else {
        echo "Error deleting record: " . $conn->error;
    }
}
// Nếu không là thành viên thì exit
else {
    echo "EXIT";
    exit();
}
$conn->close();