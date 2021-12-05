<?php
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
if (!isset($_COOKIE['username']) and !isset($_COOKIE['pass'])) {
    exit();
}
$idtv = $_COOKIE['id'];
$username = $_COOKIE['username'];
$pass = $_COOKIE['pass'];
$truyen_name = $_GET['truyen_name'];
$item_per_page = 10;
$current_page = $_GET['page'];
$offset = ($current_page - 1) * $item_per_page;

$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
$sql = "select ADMIN_USERNAME from admin where ADMIN_ID='$idtv' and ADMIN_USERNAME='$username' and ADMIN_MATKHAU=md5('$pass') and ADMIN_LEVEL=0";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $sql_count = "select * from truyen where TRUYEN_NAME like '%$truyen_name%'";
    $result_count = $conn->query($sql_count);
    $sql_kq = "select * from truyen where TRUYEN_NAME like '%$truyen_name%' LIMIT $item_per_page OFFSET $offset";
    $result_kq = $conn->query($sql_kq);
    if ($result_kq->num_rows > 0) {
        $total_page = ceil($result_count->num_rows / $item_per_page);
        echo "<div class='pick_page'>";
        if ($current_page > 3) {
            echo "<a class='pages_tool' href='#' onclick=div02_truyen_form_search_input_keyup('" . $truyen_name . "',1)>First</a>";
        }
        if ($current_page > 1) {
            $prev_page = $current_page - 1;
            echo "<a class='pages_tool' href='#' onclick=div02_truyen_form_search_input_keyup('" . $truyen_name . "'," . $prev_page . ")>Prev</a>";
        }
        for ($num = 1; $num <= $total_page; $num++) {
            if ($num != $current_page) {
                if ($num > $current_page - 3 && $num < $current_page + 3) {
                    echo "<a class='pages' href='#' onclick=div02_truyen_form_search_input_keyup('" . $truyen_name . "'," . $num . ")>" . $num . "</a>";
                }
            } else {
                echo "<strong class='pages' style='background-color:black; color:white; border:2px solid black;'>" . $num . "</strong>";
            }
        }
        if ($current_page < $total_page) {
            $next_page = $current_page + 1;
            echo "<a class='pages_tool' href='#' onclick=div02_truyen_form_search_input_keyup('" . $truyen_name . "'," . $next_page . ")>Next</a>";
        }
        if ($current_page < $total_page - 2) {
            echo "<a class='pages_tool' href='#' onclick=div02_truyen_form_search_input_keyup('" . $truyen_name . "'," . $total_page . ")>Last</a>";
        }
        echo "<strong style='margin-left:20px;'>Tổng số kết quả tìm kiếm: " . $result_count->num_rows . "</strong>";
        echo "</div>";
        echo "<table border='1' id='div02_truyen_list_table'>";
        echo "<tr id='div02_truyen_list_table_head'>
              <th>STT</th>
              <th>Tên truyện</th>
              <th>Tác giả</th>
              <th>Thể loại</th>
              <th>Ngày đăng</th>
              <th>Trạng thái</th>
              <th>Công cụ</th>
          </tr>";
        $stt = $offset;
        while ($row = $result_kq->fetch_assoc()) {
            $stt = $stt + 1;
            $truyen_id = $row['TRUYEN_ID'];
            $truyen_tacgia = "";
            $truyen_theloai = "";
            // Lấy danh sách tác giả của truyện có số id là truyen_id
            $sql_select_tacgia = "SELECT TACGIA_HOTEN FROM `truyen` JOIN `truyen_tacgia`on truyen.TRUYEN_ID=truyen_tacgia.TRUYEN_ID JOIN `tacgia` ON truyen_tacgia.TACGIA_ID=tacgia.TACGIA_ID WHERE truyen_tacgia.TRUYEN_ID='$truyen_id'";
            $result_select_tacgia = $conn->query($sql_select_tacgia);
            while ($row_select_tacgia = $result_select_tacgia->fetch_assoc()) {
                $truyen_tacgia = $truyen_tacgia . $row_select_tacgia['TACGIA_HOTEN'] . ", ";
            }
            $truyen_tacgia = substr($truyen_tacgia, 0, -2);
            // Lấy danh sách thể loại của truyện có số id là truyen_id
            $sql_select_theloai = "SELECT THELOAI_NAME FROM `truyen` JOIN `truyen_theloai`on truyen.TRUYEN_ID=truyen_theloai.TRUYEN_ID JOIN `theloai` ON truyen_theloai.THELOAI_ID=theloai.THELOAI_ID WHERE truyen_theloai.TRUYEN_ID='$truyen_id'";
            $result_select_theloai = $conn->query($sql_select_theloai);
            while ($row_select_theloai = $result_select_theloai->fetch_assoc()) {
                $truyen_theloai = $truyen_theloai . $row_select_theloai['THELOAI_NAME'] . ", ";
            }
            $truyen_theloai = substr($truyen_theloai, 0, -2);
            $truyen_trangthai_switch = "";
            switch ($row['TRUYEN_TRANGTHAI']) {
                case 0:
                    $truyen_trangthai_switch = "Tạm dừng";
                    break;
                case 1:
                    $truyen_trangthai_switch = "Đang ra";
                    break;
                case 2:
                    $truyen_trangthai_switch = "Hoàn thành";
                    break;
                default:
                    $truyen_trangthai_switch = "Có lỗi truy xuất CSDL";
            }
            echo "<tr>
                 <td id='div02_truyen_list_table_td_stt' >" . $stt . "</td>
                 <td id='div02_truyen_list_table_td_name' >" . $row['TRUYEN_NAME'] . "</td>
                 <td id='div02_truyen_list_table_td_tacgia' >" . $truyen_tacgia . "</td>
                 <td id='div02_truyen_list_table_td_theloai' >" . $truyen_theloai . "</td>
                 <td id='div02_truyen_list_table_td_ngaydang' >" . $row['TRUYEN_NGAYDANG'] . "</td>
                 <td id='div02_truyen_list_table_td_trangthai' >" . $truyen_trangthai_switch . "</td>
                 <td id='div02_truyen_list_table_td_congcu' >
                 <a href='#' id='div02_truyen_list_table_list' onclick='div02_truyen_list_table_list_click(" . $row['TRUYEN_ID'] . ")'><img src='list.ico' width='20px;' height='20px'></a>
                    <a href='#' id='div02_truyen_list_table_edit' onclick='div02_truyen_list_table_edit_click(" . $row['TRUYEN_ID'] . ")'><img src='edit.ico' width='20px;' height='20px'></a>
			        <a href='#' id='div02_truyen_list_table_delete' onclick='div02_truyen_list_table_delete_click(" . $row['TRUYEN_ID'] . ")'><img src='delete.ico' width='20px' height='20px'></a></td>
                 </tr>";
        }
        echo "</table>";
    }
} else {
    exit();
}
