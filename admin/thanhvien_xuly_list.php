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
$hoten = $_GET['thanhvien_hoten'];
// Phân trang
$item_per_page = 5;
$current_page = $_GET['page'];
$offset = ($current_page - 1) * $item_per_page;
// Connect Mysql
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
// SQL check người dùng có là thành viên và có level 0 không
$sql = "select ADMIN_USERNAME from admin where ADMIN_ID='$id' and ADMIN_USERNAME='$username' and ADMIN_MATKHAU=md5('$pass') and ADMIN_LEVEL=0";
$result = $conn->query($sql);
// Nếu là thành viên và có level 0 thì thực hiện trong lệnh if dưới đây
if ($result->num_rows > 0) {
    // Lấy tổng số thành viên để điếm
    $sql_count = "select * from admin where ADMIN_LEVEL!=0 and ADMIN_HOTEN like '%$hoten%'";
    $result_count = $conn->query($sql_count);
    // Kết quả danh sách thành viên
    $sql_kq = "select * from admin where ADMIN_LEVEL!=0 and ADMIN_HOTEN like '%$hoten%' LIMIT $item_per_page OFFSET $offset";
    $result_kq = $conn->query($sql_kq);
    // Nếu có bất kì hàng nào sẽ in vào bảng
    if ($result_kq->num_rows > 0) {
        $total_page = ceil($result_count->num_rows / $item_per_page);
        echo "<div class='pick_page'>";
        if ($current_page > 3) {
            echo "<a class='pages_tool' href='#' onclick=div02_thanhvien_form_search_input_keyup('" . $hoten . "',1)>First</a>";
        }
        if ($current_page > 1) {
            $prev_page = $current_page - 1;
            echo "<a class='pages_tool' href='#' onclick=div02_thanhvien_form_search_input_keyup('" . $hoten . "'," . $prev_page . ")>Prev</a>";
        }
        for ($num = 1; $num <= $total_page; $num++) {
            if ($num != $current_page) {
                if ($num > $current_page - 3 && $num < $current_page + 3) {
                    echo "<a class='pages' href='#' onclick=div02_thanhvien_form_search_input_keyup('" . $hoten . "'," . $num . ")>" . $num . "</a>";
                }
            } else {
                echo "<strong class='pages' style='background-color:black; color:white; border:2px solid black;'>" . $num . "</strong>";
            }
        }
        if ($current_page < $total_page) {
            $next_page = $current_page + 1;
            echo "<a class='pages_tool' href='#' onclick=div02_thanhvien_form_search_input_keyup('" . $hoten . "'," . $next_page . ")>Next</a>";
        }
        if ($current_page < $total_page - 2) {
            echo "<a class='pages_tool' href='#' onclick=div02_thanhvien_form_search_input_keyup('" . $hoten . "'," . $total_page . ")>Last</a>";
        }
        echo "<strong style='margin-left:20px;'>Tổng số kết quả tìm kiếm: ".$result_count->num_rows."</strong>";
        echo "</div>";
        echo "<table border='1' id='div02_thanhvien_list_table'>";
        echo "<tr>
              <th>STT</th>
              <th>Họ và tên</th>
              <th>Ảnh đại diện</th>
              <th>Email</th>
              <th>Số điện thoại</th>
              <th>Quyền</th>
              <th>Trạng Thái</th>
              <th>Ngày tham gia</th>
              <th>Công cụ</th>
          </tr>";
        $stt = $offset;
        while ($row_kq = $result_kq->fetch_assoc()) {
            $stt = $stt + 1;
            // Đổi value trạng thái thành viên thành tên
            $thanhvien_trangthai_switch = "";
            switch ($row_kq['ADMIN_STATUS']) {
                case 0:
                    $thanhvien_trangthai_switch = "<p style='color:red; font-weight: bold;'>Khóa</p>";
                    break;
                case 1:
                    $thanhvien_trangthai_switch = "<p style='color:blue; font-weight: bold;'>Hoạt động</p>";
                    break;
                default:
                    $thanhvien_trangthai_switch = "<p style='background-color:red; color:white; font-weight: bold;'>Trạng thái đặt sai!!!</p>";
            }
            echo "<tr>
                 <td id='div02_thanhvien_list_table_td_stt'>" . $stt . "</td>
                 <td id='div02_thanhvien_list_table_td_hoten'>" . $row_kq['ADMIN_HOTEN'] . "</td>
                 <td class='div02_thanhvien_list_table_td01'><img src=" . $row_kq['ADMIN_HINHANH'] . " width='100px' height='80px'></td>
                 <td class='div02_thanhvien_list_table_td01'>" . $row_kq['ADMIN_EMAIL'] . "</td>
                 <td class='div02_thanhvien_list_table_td01'>" . $row_kq['ADMIN_SDT'] . "</td>
                 <td class='div02_thanhvien_list_table_td02'>" . $row_kq['ADMIN_LEVEL'] . "</td>
                 <td class='div02_thanhvien_list_table_td02'>" . $thanhvien_trangthai_switch . "</td>
                 <td class='div02_thanhvien_list_table_td01'>" . $row_kq['ADMIN_NGAYTAO'] . "</td>
                 <td id='div02_thanhvien_list_table_td_congcu'><a href='#' id='div02_thanhvien_list_table_edit' onclick='div02_thanhvien_list_table_edit_click(" . $row_kq['ADMIN_ID'] . ")'><img src='edit.ico' width='20px;' height='20px'></a>
			         <a href='#' id='div02_thanhvien_list_table_delete' onclick='div02_thanhvien_list_table_delete_click(" . $row_kq['ADMIN_ID'] . ")'><img src='delete.ico' width='20px' height='20px'></a>
                </td>
                 </tr>";
        }
        echo "</table>";
    }
}
// Nếu không là thành viên có level 0 thì exit
else {
    echo "EXIT";
    exit();
}
$conn->close();
