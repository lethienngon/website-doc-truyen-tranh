<?php
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
if (!isset($_COOKIE['username']) and !isset($_COOKIE['pass'])) {
  exit();
}
$id = $_COOKIE['id'];
$username = $_COOKIE['username'];
$pass = $_COOKIE['pass'];
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
$sql = "select ADMIN_USERNAME from admin where ADMIN_ID='$id' and ADMIN_USERNAME='$username' and ADMIN_MATKHAU=md5('$pass') and ADMIN_LEVEL=0";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  $theloai_id = $_GET['theloai_id'];
  $sql_del = "SELECT * FROM theloai where THELOAI_ID='$theloai_id'";
  $result_del = $conn->query($sql_del);
  $row = $result_del->fetch_assoc();
  if ($result_del->num_rows > 0) {
    echo '<form id="div02_theloai_form_edit_form" action="" method="POST" enctype="multipart/form-data" autocomplete="off">
            <table border="0">
              <tr>
                <td><input type="text" class="div02_theloai_form_edit_form_input" name="theloai_name" value="'.$row['THELOAI_NAME'].'" placeholder="Tên của thể loại"></td>
              </tr>
              <tr>
                <td><textarea rows="20" cols="65" style="margin-top:30px; padding:5px;" name="theloai_mota" placeholder="Mô tả thể loại">'.$row['THELOAI_MOTA'].'</textarea> </td>
              </tr>
              <tr>
                <td><input id="div02_theloai_form_edit_form_submit" type="submit" value="Chỉnh sửa" name="submit">
                    <input id="div02_theloai_form_edit_form_exit" type="button" value="Trở về" onclick="div02_theloai_form_edit_form_exit_click()">
                </td>
              </tr>
            </table>
          </form>';
  }
} else {
  exit();
}
$conn->close();
