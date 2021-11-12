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
  $idtv = $_GET['id'];
  $sql_del = "SELECT ADMIN_HOTEN, ADMIN_EMAIL, ADMIN_SDT, ADMIN_LEVEL, ADMIN_STATUS, ADMIN_HINHANH FROM admin where ADMIN_ID='$idtv' and ADMIN_LEVEL!=0";
  $result_del = $conn->query($sql_del);
  $row = $result_del->fetch_assoc();
  if ($result_del->num_rows > 0) {
    echo '<form id="form_edit_user_form" method="POST" enctype="multipart/form-data" autocomplete="off">
    <table border="0">
        <tr>
            <th rowspan="7"><img src="'.$row['ADMIN_HINHANH'].'" alt="Bạn chưa chọn ảnh, sẽ tự động dùng ảnh mặc định!" id="edit_image" width="450" height="450"></th>
            <th align="left"><label>Họ và tên</label></th>
            <td><input class="edit_user_input" type="text" name="hoten" value="'.$row['ADMIN_HOTEN'].'"></td>
        </tr>
        <tr>
            <th align="left"><label>Email</label></th>
            <td><input class="edit_user_input" type="text" name="email" value="'.$row['ADMIN_EMAIL'].'"></td>
        </tr>
        <tr>
            <th align="left"><label>Số điện thoại</label></th>
            <td><input class="edit_user_input" type="text" name="sdt" value="'.$row['ADMIN_SDT'].'"></td>
        </tr>
        <tr>
            <th align="left"><label>Hình đại diện</label></th>
            <td><input type="file" id="edit_anhdaidien" name="anhdaidien" onchange="chooesFile()" accept=".jpg, .jpeg, .png"></td>
        </tr>
        <tr>
            <th align="left"><label>Quyền</label></th>
            <td><select name="level">
                    <option value="1" ';if($row['ADMIN_LEVEL'] == 1){ echo 'selected';} echo '>1</option>
                    <option value="2" ';if($row['ADMIN_LEVEL'] == 2){ echo 'selected';} echo '>2</option>
                    <option value="3" ';if($row['ADMIN_LEVEL'] == 3){ echo 'selected';} echo '>3</option>
                </select>
            </td>
        </tr>
        <tr>
            <th align="left"><label>Trạng thái</label></th>
            <td><select name="status">
                    <option value="0" ';if($row['ADMIN_LEVEL'] == 1){ echo 'selected';} echo '>Khóa</option>
                    <option value="1" ';if($row['ADMIN_LEVEL'] == 2){ echo 'selected';} echo '>Đang hoạt động</option>
                </select>
            </td>
        </tr>
        <tr>
            <th> </th>
            <td><input id="form_edit_user_submit" type="submit" value="Chỉnh sửa" name="submit">
                <input id="form_edit_user_exit" type="button" value="Trở về" onclick="click_edit_user_exit()">
            </td>
        </tr>
    </table>
</form>';
  }
} else {
  exit();
}
$conn->close();
