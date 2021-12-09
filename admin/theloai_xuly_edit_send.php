<?php
// Check cookie
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
if (!isset($_COOKIE['username']) and !isset($_COOKIE['pass'])) {
  exit();
}
// Dữ liệu để check xem người muốn xóa có phải là thành viên không
$id = $_COOKIE['id'];
$username = $_COOKIE['username'];
$pass = $_COOKIE['pass'];
// Dữ liệu cập nhật thể loại
$theloai_name = $_POST['theloai_name'];
$theloai_mota = $_POST['theloai_mota'];
// Dữ liệu GET
$theloai_id = $_GET['theloai_id'];
// Connect Mysql
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
// SQL check người dùng có là thành viên và có level 0 or 1 không
$sql = "select ADMIN_USERNAME from admin where ADMIN_ID='$id' and ADMIN_USERNAME='$username' and ADMIN_MATKHAU=md5('$pass') and (ADMIN_LEVEL=0 or ADMIN_LEVEL=1)";
$result = $conn->query($sql);
// Nếu là thành viên và có level 0 or 1 thì thực hiện trong lệnh if dưới đây
if ($result->num_rows > 0) {
  $sql_update = "UPDATE theloai SET THELOAI_NAME='$theloai_name', THELOAI_MOTA='$theloai_mota' where THElOAI_ID='$theloai_id'";
  $result_update = $conn->query($sql_update);
  // Kiểm tra xem câu lệnh có thành công không
  if ($result_update === TRUE) {
  }
  else {
      echo "Error deleting record: " . $conn->error;
  }
}
// Nếu không là thành viên thì exit
else {
  echo "EXIT";
  exit();
}
$conn->close();
