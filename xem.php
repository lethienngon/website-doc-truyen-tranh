<?php
// Dữ liệu GET
$truyen_id = $_GET['truyen_id'];
$chuong_stt = $_GET['chuong_stt'];
// Connect Mysql
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
// SQL list chương của truyện
$sql_update_luotxem = "UPDATE chuong SET CHUONG_LUOTXEM=CHUONG_LUOTXEM+1 WHERE TRUYEN_ID='$truyen_id' and CHUONG_STT='$chuong_stt'";
$result_update_luotxem = $conn->query($sql_update_luotxem);
$truyeniddaxem = $truyen_id;
if (isset($_COOKIE['truyendaxem'])) {
    $truyendaxem = explode(":", $_COOKIE['truyendaxem']);
    foreach ($truyendaxem as $value) {
        if ($value != $truyen_id) {
            $truyeniddaxem = $truyeniddaxem . ":" . $value;
        }
    }
}
setcookie('truyendaxem', $truyeniddaxem, time() + 3600, '/', '', 0, 0);

$conn->close();
