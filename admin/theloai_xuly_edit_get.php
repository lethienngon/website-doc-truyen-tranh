<?php
// Check cookie
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
if (!isset($_COOKIE['username']) and !isset($_COOKIE['pass'])) {
  exit();
}
// Lấy dữ liệu từ cookie
$id = $_COOKIE['id'];
$username = $_COOKIE['username'];
$pass = $_COOKIE['pass'];
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
  // SQL lấy danh sách thể loại
  $sql_list = "SELECT * FROM theloai where THELOAI_ID='$theloai_id'";
  $result_list = $conn->query($sql_list);
  $row_list = $result_list->fetch_assoc();
  // Nếu có dữ liệu thì thực hiện lệnh if
  if ($result_list->num_rows > 0) {
    echo '<form id="div02_theloai_form_edit_form" action="" method="POST" enctype="multipart/form-data" autocomplete="off">
            <table border="0">
              <tr>
                <td><input type="text" class="div02_theloai_form_edit_form_input" name="theloai_name" value="' . $row_list['THELOAI_NAME'] . '" placeholder="Tên của thể loại"></td>
              </tr>
              <tr>
                <td><textarea rows="20" cols="65" style="margin-top:30px; padding:5px;" name="theloai_mota" placeholder="Mô tả thể loại">' . $row_list['THELOAI_MOTA'] . '</textarea> </td>
              </tr>
              <tr>
                <td><input class="div02_form_submit" type="submit" value="Chỉnh sửa" name="submit">
                    <input class="div02_form_exit" type="button" value="Trở về" onclick="div02_theloai_form_edit_form_exit_click()">
                </td>
              </tr>
            </table>
          </form>';
  }
}
// Nếu không là thành viên thì exit
else {
  echo "EXIT";
  exit();
}
$conn->close();
