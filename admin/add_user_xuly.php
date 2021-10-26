<?php
$tendangnhap = $_POST['username'];
$pass = $_POST['pass'];
$email = $_POST['email'];
$sdt = $_POST['sdt'];

$url = "hinhanhthanhvien/".$_FILES['anhdaidien']['name'];
move_uploaded_file($_FILES['anhdaidien']['tmp_name'],$url);

$level = $_POST['level'];
$status = $_POST['status'];

$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
$pass = md5($pass);
$sql = "INSERT INTO `admin`(`ADMIN_USERNAME`, `ADMIN_MATKHAU`, `ADMIN_EMAIL`, `ADMIN_SDT`, `ADMIN_LEVEL`, `ADMIN_STATUS`, `ADMIN_HINHANH`) VALUES ('$tendangnhap','$pass','$email','$sdt','$level','$status','$url')";
$result = $conn->query($sql);
$conn->close();
?>