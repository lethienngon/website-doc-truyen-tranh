<?php
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
if (!isset($_COOKIE['username']) and !isset($_COOKIE['pass'])) {
  exit();
}
$idtv = $_GET['id'];
$email = $_POST['email'];
$hoten = $_POST['hoten'];
$sdt = $_POST['sdt'];

$url = "hinhanhthanhvien/".$_FILES['anhdaidien']['name'];
move_uploaded_file($_FILES['anhdaidien']['tmp_name'],$url);

$level = $_POST['level'];
$status = $_POST['status'];

$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
if(!isset($_FILES['anhdaidien']['name']) or $_FILES['anhdaidien']['name']==""){
  $sql = "UPDATE admin SET ADMIN_EMAIL='$email', ADMIN_HOTEN='$hoten', ADMIN_SDT='$sdt', ADMIN_LEVEL=$level, ADMIN_STATUS=$status where ADMIN_ID='$idtv' and ADMIN_LEVEL!=0";
}
else{
  $sql = "UPDATE admin SET ADMIN_EMAIL='$email', ADMIN_HOTEN='$hoten', ADMIN_SDT='$sdt', ADMIN_HINHANH='$url', ADMIN_LEVEL=$level, ADMIN_STATUS=$status where ADMIN_ID='$idtv' and ADMIN_LEVEL!=0";
}
$result = $conn->query($sql);
$conn->close();
?>