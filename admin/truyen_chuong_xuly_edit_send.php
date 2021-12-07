<?php
// Du lieu cua bang 'truyen'
$chuong_id = $_GET['chuong_id'];
$chuong_stt = $_POST['truyen_chuong_sochuong'];
$chuong_name = $_POST['truyen_chuong_name'];
$chuong_noidung = $_POST['truyen_chuong_noidung_edit'];

$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
// Du lieu them vao bang 'truyen'
$sql_update_truyen = "UPDATE chuong SET CHUONG_STT='$chuong_stt', CHUONG_NAME='$chuong_name', CHUONG_NOIDUNG='$chuong_noidung' where CHUONG_ID='$chuong_id'";
$result = $conn->query($sql_update_truyen);
$conn->close();