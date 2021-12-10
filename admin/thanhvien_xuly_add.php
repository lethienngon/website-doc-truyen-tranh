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
// Dữ liệu thêm vào bảng admin
$tendangnhap = $_POST['username'];
$matkhau = $_POST['pass'];
$email = $_POST['email'];
$hoten = $_POST['hoten'];
$sdt = $_POST['sdt'];
// Check xem có hình ảnh không, nếu không sẽ dùng ảnh mặc định
if (!isset($_FILES['anhdaidien']['name']) or $_FILES['anhdaidien']['name'] == "") {
    $url = "hinhanhthanhvien/default_user.png";
} else {
    $url = "hinhanhthanhvien/" . $_FILES['anhdaidien']['name'];
    move_uploaded_file($_FILES['anhdaidien']['tmp_name'], $url);
}
// Connect Mysql
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
// SQL check người dùng có là thành viên và có level 0 không
$sql = "select ADMIN_USERNAME from admin where ADMIN_ID='$id' and ADMIN_USERNAME='$username' and ADMIN_MATKHAU=md5('$pass') and ADMIN_LEVEL=0";
$result = $conn->query($sql);
// Nếu là thành viên và có level 0 thì thực hiện trong lệnh if dưới đây
if ($result->num_rows > 0) {
    $matkhau = md5($matkhau);
    $sql_add = "INSERT INTO `admin`(`ADMIN_USERNAME`, `ADMIN_MATKHAU`, `ADMIN_EMAIL`, `ADMIN_HOTEN`, `ADMIN_SDT`, `ADMIN_HINHANH`) VALUES ('$tendangnhap','$matkhau','$email', '$hoten', '$sdt','$url')";
    $result_add = $conn->query($sql_add);
    if ($result_add === TRUE) {
    }
    else {
        echo "Error deleting record: " . $conn->error;
    }
}
// Nếu không là thành viên có level 0 thì exit
else {
    echo "EXIT";
    exit();
}
$conn->close();
