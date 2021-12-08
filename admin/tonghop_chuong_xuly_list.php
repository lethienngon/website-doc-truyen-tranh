<?php
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

// Connet Mysql
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");

// Kiểm tra xem người dùng có trong thành viên không
$sql = "select ADMIN_USERNAME from admin where ADMIN_ID='$idtv' and ADMIN_USERNAME='$username' and ADMIN_MATKHAU=md5('$pass')";
$result = $conn->query($sql);
if ($result->num_rows > 0) {

        $sql_chuong_list = "SELECT chuong.*, TRUYEN_NAME FROM chuong join truyen on chuong.TRUYEN_ID=truyen.truyen_ID where CHUONG_NAME like'%$chuong_name%' ORDER BY TRUYEN_NAME, CHUONG_STT ASC";
        $result_chuong_list = $conn->query($sql_chuong_list);
        echo "<table border='1' id='div02_chuong_list_table'>";
        echo "<tr id='div02_chuong_list_table_head'>
              <th>Số chương</th>
              <th>Tên chương</th>
              <th>Thuộc truyện</th>
              <th>Lượt xem</th>
              <th>Ngày đăng</th>
              <th>Trạng thái</th>
              <th>Công cụ</th>
          </tr>";
        while ($row_chuong_list = $result_chuong_list->fetch_assoc()) {
            echo "<tr>
                 <td id='div02_chuong_list_table_td_stt' >" . $row_chuong_list['CHUONG_STT'] . "</td>
                 <td id='div02_chuong_list_table_td_name' >" . $row_chuong_list['CHUONG_NAME'] . "</td>
                 <td id='div02_chuong_list_table_td_truyen' >" . $row_chuong_list['TRUYEN_NAME'] . "</td>
                 <td id='div02_chuong_list_table_td_luotxem' >" . $row_chuong_list['CHUONG_LUOTXEM'] . "</td>
                 <td id='div02_chuong_list_table_td_ngaydang' >" . $row_chuong_list['CHUONG_NGAYDANG'] . "</td>
                 <td id='div02_chuong_list_table_td_trangthai' >" . $row_chuong_list['CHUONG_TRANGTHAI'] . "</td>
                 <td id='div02_chuong_list_table_td_congcu' >
                    <a href='#' id='div02_chuong_list_table_edit' onclick='div02_chuong_list_table_edit_click(" . $row_chuong_list['TRUYEN_ID'] . ")'><img src='edit.ico' width='20px;' height='20px'></a>
			        <a href='#' id='div02_chuong_list_table_delete' onclick='div02_chuong_list_table_delete_click(" . $row_chuong_list['TRUYEN_ID'] . ")'><img src='delete.ico' width='20px' height='20px'></a></td>
                 </tr>";
        }
        echo "</table>";
} else {
    exit();
}
