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
// Dữ liệu thêm vào bảng tác giả
$tacgia_hoten = $_POST['tacgia_hoten'];
$tacgia_ngaysinh = $_POST['tacgia_ngaysinh'];
$tacgia_tieusu = $_POST['tacgia_tieusu'];
// Kiểm tra xem có ảnh không, nếu không sẽ dùng ảnh mặc định
if (!isset($_FILES['tacgia_hinhanh']['name']) or $_FILES['tacgia_hinhanh']['name'] == "") {
    $url = "hinhanhtacgia/default_tacgia.png";
} else {
    $url = "hinhanhtacgia/" . $_FILES['tacgia_hinhanh']['name'];
    move_uploaded_file($_FILES['tacgia_hinhanh']['tmp_name'], $url);
}
// Connect Mysql
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
// SQL check người dùng có là thành viên và có level 0 or 1 không
$sql = "select ADMIN_USERNAME from admin where ADMIN_ID='$id' and ADMIN_USERNAME='$username' and ADMIN_MATKHAU=md5('$pass') and (ADMIN_LEVEL=0 or ADMIN_LEVEL=1)";
$result = $conn->query($sql);
// Nếu là thành viên và có level 0 or 1 thì thực hiện trong lệnh if dưới đây
if ($result->num_rows > 0) {
    $sql_insert = "INSERT INTO `tacgia`(`TACGIA_HOTEN`, `TACGIA_NGAYSINH`, `TACGIA_TIEUSU`, `TACGIA_HINHANH`) VALUES ('$tacgia_hoten', '$tacgia_ngaysinh', '$tacgia_tieusu', '$url')";
    $result_insert = $conn->query($sql_insert);
    // Kiểm tra xem câu lệnh có thành công không
    if ($result_insert === TRUE) {
    }
    else {
        echo "Error deleting record: " . $conn->error;
    }
}
// Nếu không là thành viên và có level 0 or 1 thì exit
else {
    echo "EXIT";
    exit();
}
$conn->close();
