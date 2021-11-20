<?php
$tacgia_hoten = $_POST['tacgia_hoten'];
$tacgia_ngaysinh = $_POST['tacgia_ngaysinh'];
$tacgia_tieusu = $_POST['tacgia_tieusu'];

if(!isset($_FILES['tacgia_hinhanh']['name']) or $_FILES['tacgia_hinhanh']['name']==""){
    $url = "hinhanhtacgia/default_tacgia.png";
}
else{
    $url = "hinhanhtacgia/".$_FILES['tacgia_hinhanh']['name'];
    move_uploaded_file($_FILES['tacgia_hinhanh']['tmp_name'],$url);
}

$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
$sql = "INSERT INTO `tacgia`(`TACGIA_HOTEN`, `TACGIA_NGAYSINH`, `TACGIA_TIEUSU`, `TACGIA_HINHANH`) VALUES ('$tacgia_hoten', '$tacgia_ngaysinh', '$tacgia_tieusu', '$url')";
$result = $conn->query($sql);
$conn->close();
