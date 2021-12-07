<?php
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
// Du lieu them vao bang 'truyen'
$sql_insert_truyen = "select * from chuong where CHUONG_ID=4";
$result = $conn->query($sql_insert_truyen);
$row = $result->fetch_assoc();
echo $row['CHUONG_NOIDUNG'];
$conn->close();
