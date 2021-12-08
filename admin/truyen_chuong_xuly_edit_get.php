<?php
// Check cookie
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
if (!isset($_COOKIE['username']) and !isset($_COOKIE['pass'])) {
    exit();
}
// Lấy dữ liệu cookie
$idtv = $_COOKIE['id'];
$username = $_COOKIE['username'];
$pass = $_COOKIE['pass'];
// Lấy dữ liệu từ get
$chuong_id = $_GET['chuong_id'];
// Connet Mysql
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
// Kiểm tra xem người dùng có trong thành viên không
$sql = "select ADMIN_USERNAME from admin where ADMIN_ID='$idtv' and ADMIN_USERNAME='$username' and ADMIN_MATKHAU=md5('$pass')";
$result = $conn->query($sql);
// Nếu là thành viên thì thực hiện trong lệnh if dưới đây
if ($result->num_rows > 0) {
    // Liệt kê thông tin truyện
    $sql_truyen_edit_send = "SELECT * FROM chuong WHERE CHUONG_ID='$chuong_id'";
    $result_truyen_edit_send = $conn->query($sql_truyen_edit_send);
    while ($row_truyen_edit_send = $result_truyen_edit_send->fetch_assoc()) {
        echo '
        <form id="div02_truyen_chuong_form_edit_form" method="POST" enctype="multipart/form-data" autocomplete="off">
            <p id="div02_truyen_chuong_form_edit_form_p">Chỉnh sửa chương</p>
            <lable class="div02_truyen_chuong_form_edit_form_label" for="truyen_chuong_sochuong">Số chương</lable></br>
            <input class="div02_truyen_chuong_form_edit_form_input" type="text" name="truyen_chuong_sochuong" value="'.$row_truyen_edit_send['CHUONG_STT'].'" placeholder="Nhập số chương"></br>
            <lable class="div02_truyen_chuong_form_edit_form_label" for="truyen_chuong_name">Tên chương</lable></br>
            <input class="div02_truyen_chuong_form_edit_form_input" type="text" name="truyen_chuong_name" value="'.$row_truyen_edit_send['CHUONG_NAME'].'" placeholder="Nhập tên chương"></br>
            <lable class="div02_truyen_chuong_form_edit_form_label" for="truyen_chuong_trangthai">Trạng thái</lable>
            <select name="truyen_chuong_trangthai" style="margin-top:15px;">
                    <option value="0" ';if($row_truyen_edit_send['CHUONG_TRANGTHAI'] == 0){ echo 'selected';} echo '>Đang bị ẩn</option>
                    <option value="1" ';if($row_truyen_edit_send['CHUONG_TRANGTHAI'] == 1){ echo 'selected';} echo '>Đang hoạt động</option>
                    <option value="2" ';if($row_truyen_edit_send['CHUONG_TRANGTHAI'] == 2){ echo 'selected';} echo '>Đang có lỗi</option>
                    </select>
            <lable class="div02_truyen_chuong_form_edit_form_label" for="truyen_chuong_noidung_edit" >Nội dung</lable></br>
            <textarea id="truyen_chuong_noidung_edit" name="truyen_chuong_noidung_edit" >'.$row_truyen_edit_send['CHUONG_NOIDUNG'].'</textarea></br>
            <input class="div02_form_submit" type="submit" value="Thêm" name="submit">
        </form>';
    }
}
// Nếu không là thành viên thì exit
else {
    exit();
    echo "EXIT";
}
$conn->close();