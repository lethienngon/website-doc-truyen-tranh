<?php
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
if (!isset($_COOKIE['username']) and !isset($_COOKIE['pass'])) {
  exit();
}
$theloai_name= $_POST['theloai_name'];
$theloai_mota = $_POST['theloai_mota'];

$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
$theloai_id = $_GET['theloai_id'];
$sql = "UPDATE theloai SET THELOAI_NAME='$theloai_name', THELOAI_MOTA='$theloai_mota' where THElOAI_ID='$theloai_id'";
$result = $conn->query($sql);
$conn->close();