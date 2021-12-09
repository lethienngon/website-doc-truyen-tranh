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
$truyen_id = $_GET['truyen_id'];
// Connect Mysql
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
// Kiểm tra người dùng có là thành viên trong CSDL không
$sql = "select ADMIN_USERNAME from admin where ADMIN_ID='$admin_id' and ADMIN_USERNAME='$username' and ADMIN_MATKHAU=md5('$pass')";
$result = $conn->query($sql);
// Nếu là thành viên sẽ thực hiện trong if
if ($result->num_rows > 0) {
    // Xóa các ràng buộc cũ của bảng truyen_tacgia để thêm vào ràng buộc mới
    $result_truyen_tacgia_delete = mysqli_query($conn, "DELETE FROM truyen_tacgia where TRUYEN_ID='$truyen_id'");
    // Xóa các ràng buộc cũ của bảng truyen_theloai để thêm vào ràng buộc mới
    $result_truyen_theloai_delete = mysqli_query($conn, "DELETE FROM truyen_theloai where TRUYEN_ID='$truyen_id'");
    // SQL xóa truyện
    $sql_del = "DELETE FROM truyen where TRUYEN_ID='$truyen_id'";
    $result_del = $conn->query($sql_del);
    if ($result_del === TRUE) {
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
// Nếu không là thành viên thì exit
else {
    exit();
    echo "EXIT";
}
$conn->close();
