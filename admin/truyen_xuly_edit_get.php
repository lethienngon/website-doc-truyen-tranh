<?php
// Check cookie
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
if (!isset($_COOKIE['username']) and !isset($_COOKIE['pass'])) {
    exit();
}
// Lấy dữ liệu cookie
$id = $_COOKIE['id'];
$username = $_COOKIE['username'];
$pass = $_COOKIE['pass'];
// Lấy dữ liệu từ GET
$truyen_id = $_GET['truyen_id'];
// Connect Mysql
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
// Câu SQL kiểm tra người dùng có là thành viên không
$sql = "select ADMIN_USERNAME from admin where ADMIN_ID='$id' and ADMIN_USERNAME='$username' and ADMIN_MATKHAU=md5('$pass')";
$result = $conn->query($sql);
// Nếu là thành viên sẽ thực hiện trong if
if ($result->num_rows > 0) {
    // Câu SQL lấy ra danh sách truyện
    $sql_edit = "SELECT * FROM truyen where TRUYEN_ID='$truyen_id'";
    // Lấy dữ liệu TACGIA_ID, TACGIA_HOTEN của tất cả tác giả
    $result_truyen_select_tacgia = mysqli_query($conn, "SELECT TACGIA_ID, TACGIA_HOTEN FROM tacgia");
    // Lấy dữ liệu THELOAI_ID, THELOAI_HOTEN của tất cả thể loại
    $result_truyen_select_theloai = mysqli_query($conn, "SELECT THELOAI_ID, THELOAI_NAME FROM theloai");
    // Lấy dữ liệu TACGIA_ID của bảng truyen_tacgia
    $result_truyen_tacgia = mysqli_query($conn, "SELECT TACGIA_ID FROM `truyen_tacgia` WHERE TRUYEN_ID = '$truyen_id'");
    // Lấy dữ liệu THELOAI_ID của bảng truyen_theloai
    $result_truyen_theloai = mysqli_query($conn, "SELECT THELOAI_ID FROM `truyen_theloai` WHERE TRUYEN_ID = '$truyen_id'");
    // So sánh dữ liệu trong hai bảng tacgia và truyen_tacgia nếu giống nhau thì cho vào $truyen_tacgia
    $truyen_tacgia = array();
    while ($row_truyen_tacgia = $result_truyen_tacgia->fetch_assoc()) {
        $truyen_tacgia[] = $row_truyen_tacgia['TACGIA_ID'];
    }
    // So sánh dữ liệu trong hai bảng theloai và truyen_theloai nếu giống nhau thì cho vào $truyen_theloai
    $truyen_theloai = array();
    while ($row_truyen_theloai = $result_truyen_theloai->fetch_assoc()) {
        $truyen_theloai[] = $row_truyen_theloai['THELOAI_ID'];
    }
    // Kết quả từ câu SQL lấy dữ liệu từ bảng truyen cho vào bảng
    $result_edit = $conn->query($sql_edit);
    $row_edit = $result_edit->fetch_assoc();
    if ($result_edit->num_rows > 0) {
        echo '<form id="div02_truyen_form_edit_form" method="POST" enctype="multipart/form-data" autocomplete="off">
        <table border="0">
            <tr>
                <td rowspan="7"><label for="div02_truyen_form_edit_form_hinhanh"><img src="' . $row_edit['TRUYEN_HINHANH'] . '" alt="Bạn chưa chọn ảnh, sẽ tự động dùng ảnh mặc định!" id="div02_truyen_form_edit_form_hinhanh_img" width="450" height="450"></label>
                    <input type="file" id="div02_truyen_form_edit_form_hinhanh" name="truyen_hinhanh" onchange="div02_truyen_form_edit_form_hinhanh_change()" accept=".jpg, .jpeg, .png" style="visibility:hidden;">
                </td>
                <td><input type="text" class="div02_truyen_form_edit_form_input" name="truyen_name" value="' . $row_edit['TRUYEN_NAME'] . '" placeholder="Nhập tên truyện"></td>
            </tr>
            <tr>
                <td>
                    <select class="div02_truyen_form_edit_form_select_tacgia" name="truyen_select_tacgia[]" multiple="multiple">';
        // Dữ liệu được chọn từ việc so sánh hai bảng tacgia và truyen_tacgia
        while ($row_truyen_select_tacgia = $result_truyen_select_tacgia->fetch_assoc()) {
            echo '<option value="' . $row_truyen_select_tacgia['TACGIA_ID'] . '" ';
            if (in_array($row_truyen_select_tacgia['TACGIA_ID'], $truyen_tacgia)) {
                echo 'selected';
            }
            echo '>' . $row_truyen_select_tacgia['TACGIA_HOTEN'] . '</option>';
        }
        echo   '</select>
                </td>
            </tr>
            <tr>
                <td>
                    <select class="div02_truyen_form_edit_form_select_theloai" name="truyen_select_theloai[]" multiple="multiple">';
        // Dữ liệu được chọn từ việc so sánh hai bảng theloai và truyen_theloai
        while ($row_truyen_select_theloai = $result_truyen_select_theloai->fetch_assoc()) {
            echo '<option value="' . $row_truyen_select_theloai['THELOAI_ID'] . '" ';
            if (in_array($row_truyen_select_theloai['THELOAI_ID'], $truyen_theloai)) {
                echo 'selected';
            }
            echo '>' . $row_truyen_select_theloai['THELOAI_NAME'] . '</option>';
        }
        echo   '</select>
                </td>
            </tr>
            <tr>
                <td><label>Trạng thái: </label>
                    <select name="truyen_trangthai" style="margin-top:30px;">
                    <option value="0" ';if($row_edit['TRUYEN_TRANGTHAI'] == 0){ echo 'selected';} echo '>Tạm dừng</option>
                    <option value="1" ';if($row_edit['TRUYEN_TRANGTHAI'] == 1){ echo 'selected';} echo '>Đang ra</option>
                    <option value="2" ';if($row_edit['TRUYEN_TRANGTHAI'] == 2){ echo 'selected';} echo '>Hoàn thành</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><textarea rows="10" cols="65" style="margin-top:5px; padding:5px;" name="truyen_mota" placeholder="Mô tả truyện">' . $row_edit['TRUYEN_MOTA'] . '</textarea> </td>
            </tr>
            <tr>
                <td><input id="div02_truyen_form_edit_form_submit" class="div02_form_submit" type="submit" value="Chỉnh sửa" name="submit">
                    <input id="div02_truyen_form_edit_form_exit" class="div02_form_exit" type="button" value="Thoát" onclick="div02_truyen_form_edit_form_exit_click()">
                </td>
            </tr>
        </table>
    </form>';
    }
}
// Nếu không là thành viên thì exit
else {
    exit();
    echo "EXIT";
}
$conn->close();
