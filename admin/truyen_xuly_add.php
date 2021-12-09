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
// Dữ liệu thêm vào bảng truyen
$truyen_name = $_POST['truyen_name'];
$truyen_mota = $_POST['truyen_mota'];
// Check xem hình ảnh tồn tại không, nếu không tự dùng ảnh mặc định
if(!isset($_FILES['truyen_hinhanh']['name']) or $_FILES['truyen_hinhanh']['name']==""){
    $url = "hinhanhtruyen/default.png";
}
else{
    $url = "hinhanhtruyen/".$_FILES['truyen_hinhanh']['name'];
    move_uploaded_file($_FILES['truyen_hinhanh']['tmp_name'],$url);
}
// Connect Mysql
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
// SQL check thanhvien
$sql = "select ADMIN_USERNAME from admin where ADMIN_ID='$id' and ADMIN_USERNAME='$username' and ADMIN_MATKHAU=md5('$pass')";
$result = $conn->query($sql);
// Nếu là thành viên thì thực hiện trong lệnh if dưới đây
if ($result->num_rows > 0) {
    // SQL thêm dữ liệu vào bảng truyen
    $sql_insert_truyen = "INSERT INTO `truyen`(`ADMIN_ID`, `TRUYEN_NAME`, `TRUYEN_MOTA`, `TRUYEN_HINHANH`) VALUES ('$id', '$truyen_name', '$truyen_mota', '$url');";
    $result = $conn->query($sql_insert_truyen);
    // Tạo một biến lấy truyện id sau câu insert
    $truyen_id = "";
    // Lấy truyen_id từ câu Insert mới tạo ra phía trên
    if ($result === TRUE) {
        $truyen_id = $conn->insert_id;
    }
    // Dữ liệu thêm vào bảng 'truyen_tacgia'
    foreach ($_POST['truyen_select_tacgia'] as $tacgia_id) {
        $sql_insert_truyen_tacgia = "INSERT INTO `truyen_tacgia`(`TRUYEN_ID`, `TACGIA_ID`) VALUES ('$truyen_id', '$tacgia_id');";
        $conn->query($sql_insert_truyen_tacgia);
    }
    // Dữ liệu thêm vào bảng 'truyen_theloai'
    foreach ($_POST['truyen_select_theloai'] as $theloai_id) {
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
