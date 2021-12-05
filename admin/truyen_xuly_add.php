<?php
// Du lieu cua bang 'truyen'
$admin_id= $_COOKIE['id'];
$truyen_name= $_POST['truyen_name'];
$truyen_mota = $_POST['truyen_mota'];
$url = "hinhanhtruyen/".$_FILES['truyen_hinhanh']['name'];
move_uploaded_file($_FILES['truyen_hinhanh']['tmp_name'],$url);

// Du lieu duoc lay sau cau insert
$truyen_id = "";

$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
// Du lieu them vao bang 'truyen'
$sql_insert_truyen = "INSERT INTO `truyen`(`ADMIN_ID`, `TRUYEN_NAME`, `TRUYEN_MOTA`, `TRUYEN_HINHANH`) VALUES ('$admin_id', '$truyen_name', '$truyen_mota', '$url');";

$result = $conn->query($sql_insert_truyen);
// Lay truyen_id tu cau Insert moi tao ra phia tren
if ($result === TRUE) {
    $truyen_id = $conn->insert_id;
    echo "Thêm record thành công có ID là $truyen_id";
} else {
    echo "Lỗi: " . $sql_insert_truyen . "<br>" . $conn->error;
}
// Du lieu them vao bang 'truyen_tacgia'
foreach($_POST['truyen_select_tacgia'] as $tacgia_id) {
    $sql_insert_truyen_tacgia = "INSERT INTO `truyen_tacgia`(`TRUYEN_ID`, `TACGIA_ID`) VALUES ('$truyen_id', '$tacgia_id');";    
    $conn->query($sql_insert_truyen_tacgia);
}

// Du lieu them vao bang 'truyen_theloai'
foreach($_POST['truyen_select_theloai'] as $theloai_id) {
    $sql_insert_truyen_theloai = "INSERT INTO `truyen_theloai`(`TRUYEN_ID`, `THELOAI_ID`) VALUES ('$truyen_id', '$theloai_id');";    
    $conn->query($sql_insert_truyen_theloai);
}

$conn->close();
