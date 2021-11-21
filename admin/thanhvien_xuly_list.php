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
$hoten = $_GET['thanhvien_hoten'];
$item_per_page = 5;
$current_page = $_GET['page'];
$offset = ($current_page - 1) * $item_per_page;

$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
$sql = "select ADMIN_USERNAME from admin where ADMIN_ID='$idtv' and ADMIN_USERNAME='$username' and ADMIN_MATKHAU=md5('$pass') and ADMIN_LEVEL=0";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $sql_count = "select * from admin where ADMIN_LEVEL!=0 and ADMIN_HOTEN like '%$hoten%'";
    $result_count = $conn->query($sql_count);
    $sql_kq = "select * from admin where ADMIN_LEVEL!=0 and ADMIN_HOTEN like '%$hoten%' LIMIT $item_per_page OFFSET $offset";
    $result_kq = $conn->query($sql_kq);
    if ($result_kq->num_rows > 0) {
        $total_page = ceil($result_count->num_rows / $item_per_page);
        echo "<table border='0' id='div02_thanhvien_list_table'>";
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
        while ($row = $result_kq->fetch_assoc()) {
            $stt = $stt + 1;
            echo "<tr>
                 <td>" . $stt . "</td>
                 <td width='220px'>" . $row['ADMIN_HOTEN'] . "</td>
                 <td width='100px'><img src=" . $row['ADMIN_HINHANH'] . " width='100px' height='80px'></td>
                 <td width='200px'>" . $row['ADMIN_EMAIL'] . "</td>
                 <td width='110px'>" . $row['ADMIN_SDT'] . "</td>
                 <td>" . $row['ADMIN_LEVEL'] . "</td>
                 <td>" . $row['ADMIN_STATUS'] . "</td>
                 <td>" . $row['ADMIN_NGAYTAO'] . "</td>
                 <td><a href='#' id='div02_thanhvien_list_table_edit' onclick='div02_thanhvien_list_table_edit_click(" . $row['ADMIN_ID'] . ")'><img src='edit.ico' width='20px;' height='20px'></a>
			         <a href='#' id='div02_thanhvien_list_table_delete' onclick='div02_thanhvien_list_table_delete_click(" . $row['ADMIN_ID'] . ")'><img src='delete.ico' width='20px' height='20px'></a></td>
                 </tr>";
        }
        echo "</table>";
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
    }
} else {
    exit();
}
