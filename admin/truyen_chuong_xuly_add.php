<?php
// Du lieu cua bang 'truyen'
$truyen_id = $_GET['truyen_id'];
$admin_id = $_COOKIE['id'];
$chuong_stt = $_POST['truyen_chuong_sochuong'];
$chuong_name = $_POST['truyen_chuong_name'];
$chuong_noidung = $_POST['truyen_chuong_noidung'];

$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
// Du lieu them vao bang 'truyen'
$sql_insert_truyen = "INSERT INTO `chuong`(`TRUYEN_ID`, `ADMIN_ID`, `CHUONG_STT`, `CHUONG_NAME`, `CHUONG_NOIDUNG`) VALUES ('$truyen_id', '$admin_id', '$chuong_stt', '$chuong_name', '$chuong_noidung');";
$result = $conn->query($sql_insert_truyen);
$conn->close();
