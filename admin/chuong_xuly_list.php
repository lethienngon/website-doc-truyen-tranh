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
$chuong_name = $_GET['chuong_name'];
$truyen_id = $_GET['truyen_id'];
// Connet Mysql
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
// Kiểm tra xem người dùng có trong thành viên không
$sql = "select ADMIN_USERNAME from admin where ADMIN_ID='$idtv' and ADMIN_USERNAME='$username' and ADMIN_MATKHAU=md5('$pass')";
$result = $conn->query($sql);
// Nếu là thành viên thì thực hiện trong lệnh if dưới đây
if ($result->num_rows > 0) {
    // Lấy dữ liệu để xem khi tìm kiếm tên chương trong một truyện
    $sql_truyen_chuong_list = "SELECT * FROM chuong where TRUYEN_ID='$truyen_id' and CHUONG_NAME like'%$chuong_name%' ORDER BY CHUONG_STT ASC";
    $result_truyen_chuong_list = $conn->query($sql_truyen_chuong_list);
    echo "<table border='1' id='div02_truyen_chuong_list_table'>";
    echo "<tr id='div02_truyen_chuong_list_table_head'>
              <th>Số chương</th>
              <th>Tên chương</th>
              <th>Lượt xem</th>
              <th>Ngày đăng</th>
              <th>Trạng thái</th>
              <th>Công cụ</th>
          </tr>";
    while ($row_truyen_chuong_list = $result_truyen_chuong_list->fetch_assoc()) {
        // Đổi value trạng thái chương thành tên
        $chuong_trangthai_switch = "";
        switch ($row_truyen_chuong_list['CHUONG_TRANGTHAI']) {
            case 0:
                $chuong_trangthai_switch = "<p style='font-weight: bold;'>Đang bị ẩn</p>";
                break;
            case 1:
                $chuong_trangthai_switch = "<p style='color:green; font-weight: bold;'>Đang hoạt động</p>";
                break;
            case 2:
                $chuong_trangthai_switch = "<p style='color:red; font-weight: bold;'>Đang có lỗi</p>";
                break;
            default:
                $chuong_trangthai_switch = "<p style='background-color:red; color:white; font-weight: bold;'>Trạng thái đặt sai!!!</p>";
        }
        echo "<tr>
                 <td id='div02_truyen_chuong_list_table_td_stt' >" . $row_truyen_chuong_list['CHUONG_STT'] . "</td>
                 <td id='div02_truyen_chuong_list_table_td_name' >" . $row_truyen_chuong_list['CHUONG_NAME'] . "</td>
                 <td id='div02_truyen_chuong_list_table_td_luotxem' >" . $row_truyen_chuong_list['CHUONG_LUOTXEM'] . "</td>
                 <td id='div02_truyen_chuong_list_table_td_ngaydang' >" . $row_truyen_chuong_list['CHUONG_NGAYDANG'] . "</td>
                 <td id='div02_truyen_chuong_list_table_td_trangthai' >" . $chuong_trangthai_switch . "</td>
                 <td id='div02_truyen_chuong_list_table_td_congcu' >
                    <a href='#' id='div02_truyen_chuong_list_table_edit' onclick='div02_truyen_chuong_list_table_edit_click(" . $row_truyen_chuong_list['CHUONG_ID'] . ")'><img src='edit.ico' width='20px;' height='20px'></a>
			        <a href='#' id='div02_truyen_chuong_list_table_delete' onclick='div02_truyen_chuong_list_table_delete_click(" . $row_truyen_chuong_list['CHUONG_ID'] . ")'><img src='delete.ico' width='20px' height='20px'></a></td>
                 </tr>";
    }
    echo "</table>";
}
// Nếu không là thành viên thì exit
else {
    echo "EXIT";
    exit();
}
$conn->close();
