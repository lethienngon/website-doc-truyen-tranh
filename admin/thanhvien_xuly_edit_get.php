<?php
// Check cookie
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
if (!isset($_COOKIE['username']) and !isset($_COOKIE['pass'])) {
    exit();
}
// Dữ liệu để check xem người dùng có phải là thành viên không
$id = $_COOKIE['id'];
$username = $_COOKIE['username'];
$pass = $_COOKIE['pass'];
// Dữ liệu GET
$idtv = $_GET['thanhvien_id'];
// Connect Mysql
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
// SQL check người dùng có là thành viên và có level 0 không
$sql = "select ADMIN_USERNAME from admin where ADMIN_ID='$id' and ADMIN_USERNAME='$username' and ADMIN_MATKHAU=md5('$pass') and ADMIN_LEVEL=0";
$result = $conn->query($sql);
// Nếu là thành viên và có level 0 thì thực hiện trong lệnh if dưới đây
if ($result->num_rows > 0) {
    // SQL lấy thông tin thành viên trừ thành viên level 0
    $sql_list = "SELECT ADMIN_HOTEN, ADMIN_EMAIL, ADMIN_SDT, ADMIN_LEVEL, ADMIN_STATUS, ADMIN_HINHANH FROM admin where ADMIN_ID='$idtv' and ADMIN_LEVEL!=0";
    $result_list = $conn->query($sql_list);
    $row_list = $result_list->fetch_assoc();
    if ($result_list->num_rows > 0) {
    echo '<form id="div02_thanhvien_form_edit_form" method="POST" enctype="multipart/form-data" autocomplete="off">
    <table border="0">
        <tr>
        <td rowspan="6"><label for="div02_thanhvien_form_edit_form_hinhanh"><img src="" alt="Bạn chưa chọn ảnh, sẽ tự động dùng ảnh mặc định!" id="div02_thanhvien_form_edit_form_hinhanh_img" width="450" height="450"></label>
        <input type="file" id="div02_thanhvien_form_edit_form_hinhanh" name="anhdaidien" onchange="div02_thanhvien_form_edit_form_hinhanh_change()" accept=".jpg, .jpeg, .png" style="visibility:hidden;"></td>
            <th align="left"><label>Họ và tên</label></th>
            <td><input class="div02_thanhvien_form_edit_form_input" type="text" name="hoten" value="' . $row_list['ADMIN_HOTEN'] . '"></td>
        </tr>
        <tr>
            <th align="left"><label>Email</label></th>
            <td><input class="div02_thanhvien_form_edit_form_input" type="text" name="email" value="' . $row_list['ADMIN_EMAIL'] . '"></td>
        </tr>
        <tr>
            <th align="left"><label>Số điện thoại</label></th>
            <td><input class="div02_thanhvien_form_edit_form_input" type="text" name="sdt" value="' . $row_list['ADMIN_SDT'] . '"></td>
        </tr>
        <tr>
            <th align="left"><label>Quyền</label></th>
            <td><select name="level">
                    <option value="1" ';if ($row_list['ADMIN_LEVEL'] == 1) { echo 'selected'; } echo '>Quyền 01</option>
                    <option value="2" ';if ($row_list['ADMIN_LEVEL'] == 2) { echo 'selected'; } echo '>Quyền 02</option>
                </select>
            </td>
        </tr>
        <tr>
            <th align="left"><label>Trạng thái</label></th>
            <td><select name="status">
                    <option value="0" ';if ($row_list['ADMIN_STATUS'] == 0) { echo 'selected'; } echo '>Khóa</option>
                    <option value="1" ';if ($row_list['ADMIN_STATUS'] == 1) { echo 'selected'; } echo '>Đang hoạt động</option>
                </select>
            </td>
        </tr>
        <tr>
            <th> </th>
            <td><input class="div02_form_submit" type="submit" value="Chỉnh sửa" name="submit">
                <input class="div02_form_exit" type="button" value="Trở về" onclick="div02_thanhvien_form_edit_form_exit_click()">
            </td>
        </tr>
    </table>
</form>';
    }
}
// Nếu không là thành viên có level 0 thì exit
else {
    echo "EXIT";
    exit();
}
$conn->close();
