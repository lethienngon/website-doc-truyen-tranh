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
  $tacgia_id = $_GET['tacgia_id'];
  $sql_del = "SELECT * FROM tacgia where TACGIA_ID='$tacgia_id'";
  $result_del = $conn->query($sql_del);
  $row = $result_del->fetch_assoc();
  if ($result_del->num_rows > 0) {
    echo '<form id="div02_tacgia_form_edit_form" method="POST" enctype="multipart/form-data" autocomplete="off">
            <table border="0">
              <tr>
                <td rowspan="4"><label for="div02_tacgia_form_edit_form_hinhanh"><img src="'.$row['TACGIA_HINHANH'].'" alt="Bạn chưa chọn ảnh, sẽ tự động dùng ảnh mặc định!" id="div02_tacgia_form_edit_form_hinhanh_img" width="450" height="450"></label>
                    <input type="file" id="div02_tacgia_form_edit_form_hinhanh" name="tacgia_hinhanh" onchange="div02_tacgia_form_edit_form_hinhanh_change()" accept=".jpg, .jpeg, .png" style="visibility:hidden;"></td>
                <td><input type="text" class="div02_tacgia_form_edit_form_input" name="tacgia_hoten" value="'.$row['TACGIA_HOTEN'].'" placeholder="Họ và tên của tác giả"></td>
              </tr>
              <tr>
                <td><input type="date" class="div02_tacgia_form_edit_form_input" name="tacgia_ngaysinh" value="'.$row['TACGIA_NGAYSINH'].'" ></td>
              </tr>
              <tr>
                <td><textarea rows="20" cols="65" style="margin-top:20px; padding:5px;" name="tacgia_tieusu" placeholder="Tiểu sử của tác giả">'.$row['TACGIA_TIEUSU'].'</textarea> </td>
              </tr>
              <tr>
                <td><input id="div02_tacgia_form_edit_form_submit" type="submit" value="Chỉnh sửa" name="submit">
                    <input id="div02_tacgia_form_edit_form_exit" type="button" value="Trở về" onclick="div02_tacgia_form_edit_form_exit_click()">
                </td>
              </tr>
            </table>
          </form>';
  }
} else {
  exit();
}
$conn->close();
