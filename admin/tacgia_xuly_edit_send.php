<?php
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
if (!isset($_COOKIE['username']) and !isset($_COOKIE['pass'])) {
  exit();
}
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
$tacgia_id = $_GET['tacgia_id'];
$sql = "UPDATE tacgia SET TACGIA_HOTEN='$tacgia_hoten', TACGIA_NGAYSINH='$tacgia_ngaysinh', TACGIA_TIEUSU='$tacgia_tieusu', TACGIA_HINHANH='$url' where TACGIA_ID='$tacgia_id'";
$result = $conn->query($sql);
$conn->close();