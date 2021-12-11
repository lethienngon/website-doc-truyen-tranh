<?php
// Dữ liệu GET
$truyen_id = $_GET['truyen_id'];
$chuong_stt = $_GET['chuong_stt'];
// Connect Mysql
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
// SQL list chương của truyện
$sql_update = "UPDATE chuong SET CHUONG_TRANGTHAI='2' where TRUYEN_ID='$truyen_id' and CHUONG_STT='$chuong_stt'";
$result_update = $conn->query($sql_update);
if ($result_update === TRUE) {
} else {
  echo "Error deleting record: " . $conn->error;
}
