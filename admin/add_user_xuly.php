<?php
$tendangnhap = $_POST['username'];
$pass = $_POST['pass'];
$email = $_POST['email'];
$hoten = $_POST['hoten'];
$sdt = $_POST['sdt'];

if(!isset($_FILES['anhdaidien']['name']) or $_FILES['anhdaidien']['name']==""){
    $url = "hinhanhthanhvien/default_user.png";
}
else{
    $url = "hinhanhthanhvien/".$_FILES['anhdaidien']['name'];
    move_uploaded_file($_FILES['anhdaidien']['tmp_name'],$url);
}

$level = $_POST['level'];
$status = $_POST['status'];

$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
$pass = md5($pass);
$sql = "INSERT INTO `admin`(`ADMIN_USERNAME`, `ADMIN_MATKHAU`, `ADMIN_EMAIL`, `ADMIN_HOTEN`, `ADMIN_SDT`, `ADMIN_LEVEL`, `ADMIN_STATUS`, `ADMIN_HINHANH`) VALUES ('$tendangnhap','$pass','$email', '$hoten', '$sdt','$level','$status','$url')";
$result = $conn->query($sql);
$conn->close();
