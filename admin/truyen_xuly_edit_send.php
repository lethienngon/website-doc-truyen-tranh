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
// Dữ liệu của bảng 'truyen'
$truyen_name = $_POST['truyen_name'];
$truyen_mota = $_POST['truyen_mota'];
$truyen_trangthai = $_POST['truyen_trangthai'];
$url = "hinhanhtruyen/" . $_FILES['truyen_hinhanh']['name'];
move_uploaded_file($_FILES['truyen_hinhanh']['tmp_name'], $url);
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
    // Dữ liệu được cập nhật vào bảng 'truyen'
    $sql_insert_truyen = "UPDATE truyen SET TRUYEN_NAME='$truyen_name', TRUYEN_MOTA='$truyen_mota', TRUYEN_TRANGTHAI='$truyen_trangthai', TRUYEN_HINHANH='$url' where TRUYEN_ID='$truyen_id'";
    $result_insert_truyen = $conn->query($sql_insert_truyen);
    // Xóa các ràng buộc cũ của bảng truyen_tacgia để thêm vào ràng buộc mới
    $result_truyen_tacgia_delete = mysqli_query($conn, "DELETE FROM truyen_tacgia where TRUYEN_ID='$truyen_id'");
    // Dữ liệu được cập nhật vào bảng 'truyen_tacgia'
    foreach ($_POST['truyen_select_tacgia'] as $tacgia_id) {
        // Thêm lại các ràng buộc mới của bảng truyen_theloai
        $sql_insert_truyen_tacgia = "INSERT INTO `truyen_tacgia`(`TRUYEN_ID`, `TACGIA_ID`) VALUES ('$truyen_id', '$tacgia_id');";
        $conn->query($sql_insert_truyen_tacgia);
    }
    // Xóa các ràng buộc cũ của bảng truyen_theloai để thêm vào ràng buộc mới
    $result_truyen_theloai_delete = mysqli_query($conn, "DELETE FROM truyen_theloai where TRUYEN_ID='$truyen_id'");
    // Dữ liệu được cập nhật vào bảng 'truyen_theloai'
    foreach ($_POST['truyen_select_theloai'] as $theloai_id) {
        // Thêm lại các ràng buộc mới của bảng truyen_theloai
        $sql_insert_truyen_theloai = "INSERT INTO `truyen_theloai`(`TRUYEN_ID`, `THELOAI_ID`) VALUES ('$truyen_id', '$theloai_id');";
        $conn->query($sql_insert_truyen_theloai);
    }
}
// Nếu không là thành viên thì exit
else {
    echo "EXIT";
    exit();
}
$conn->close();
