<?php
$theloai_name= $_POST['theloai_name'];
$theloai_mota = $_POST['theloai_mota'];

$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
$sql = "INSERT INTO `theloai`(`THELOAI_NAME`, `THELOAI_MOTA`) VALUES ('$theloai_name', '$theloai_mota')";
$result = $conn->query($sql);
$conn->close();
