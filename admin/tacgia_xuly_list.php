<?php
// Check cookie
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
if (!isset($_COOKIE['username']) and !isset($_COOKIE['pass'])) {
    exit();
}
// Dữ liệu để check xem người muốn xóa có phải là thành viên không
$id = $_COOKIE['id'];
$username = $_COOKIE['username'];
$pass = $_COOKIE['pass'];
// Dữ liệu GET
$tacgia_hoten = $_GET['tacgia_hoten'];
// Phân trang
$item_per_page = 5;
$current_page = $_GET['page'];
$offset = ($current_page - 1) * $item_per_page;
// Connect Mysql
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
// SQL check người dùng có là thành viên không
$sql = "select ADMIN_USERNAME, ADMIN_LEVEL from admin where ADMIN_ID='$id' and ADMIN_USERNAME='$username' and ADMIN_MATKHAU=md5('$pass')";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
// Nếu là thành viên thì thực hiện trong lệnh if dưới đây
if ($result->num_rows > 0) {
    // SQL điếm số lượng tác giả
    $sql_count = "select * from tacgia where TACGIA_HOTEN like '%$tacgia_hoten%'";
    $result_count = $conn->query($sql_count);
    // SQL lấy danh sách tác giả
    $sql_kq = "select * from tacgia where TACGIA_HOTEN like '%$tacgia_hoten%' LIMIT $item_per_page OFFSET $offset";
    $result_kq = $conn->query($sql_kq);
    // Nếu có thì thực hiện if
    if ($result_kq->num_rows > 0) {
        // Tính tổng số trang để phân trang
        $total_page = ceil($result_count->num_rows / $item_per_page);
        echo "<div class='pick_page'>";
        if ($current_page > 3) {
            echo "<a class='pages_tool' href='#' onclick=div02_tacgia_form_search_input_keyup('" . $tacgia_hoten . "',1)>First</a>";
        }
        if ($current_page > 1) {
            $prev_page = $current_page - 1;
            echo "<a class='pages_tool' href='#' onclick=div02_tacgia_form_search_input_keyup('" . $tacgia_hoten . "'," . $prev_page . ")>Prev</a>";
        }
        for ($num = 1; $num <= $total_page; $num++) {
            if ($num != $current_page) {
                if ($num > $current_page - 3 && $num < $current_page + 3) {
                    echo "<a class='pages' href='#' onclick=div02_tacgia_form_search_input_keyup('" . $tacgia_hoten . "'," . $num . ")>" . $num . "</a>";
                }
            } else {
                echo "<strong class='pages' style='background-color:black; color:white; border:2px solid black;'>" . $num . "</strong>";
            }
        }
        if ($current_page < $total_page) {
            $next_page = $current_page + 1;
            echo "<a class='pages_tool' href='#' onclick=div02_tacgia_form_search_input_keyup('" . $tacgia_hoten . "'," . $next_page . ")>Next</a>";
        }
        if ($current_page < $total_page - 2) {
            echo "<a class='pages_tool' href='#' onclick=div02_tacgia_form_search_input_keyup('" . $tacgia_hoten . "'," . $total_page . ")>Last</a>";
        }
        echo "<strong style='margin-left:20px;'>Tổng số kết quả tìm kiếm: " . $result_count->num_rows . "</strong>";
        echo "</div>";
        // Phần danh sách tác giả
        echo "<table border='1' id='div02_tacgia_list_table'>";
        echo "<tr id='div02_tacgia_list_table_head'>
              <th>STT</th>
              <th>Tên tác giả</th>
              <th>Ảnh đại diện</th>
              <th>Ngày sinh</th>
              <th>Tiểu sử</th>";
        if ($row['ADMIN_LEVEL'] == 0 || $row['ADMIN_LEVEL'] == 1) {
            echo "<th>Công cụ</th>";
        }
        echo  "</tr>";
        $stt = $offset;
        while ($row_list = $result_kq->fetch_assoc()) {
            $stt = $stt + 1;
            echo "<tr>
                 <td id='div02_tacgia_list_table_td_id' >" . $stt . "</td>
                 <td id='div02_tacgia_list_table_td_hoten' >" . $row_list['TACGIA_HOTEN'] . "</td>
                 <td id='div02_tacgia_list_table_td_hinhanh' ><img src=" . $row_list['TACGIA_HINHANH'] . " width='100px' height='80px'></td>
                 <td id='div02_tacgia_list_table_td_ngaysinh' >" . $row_list['TACGIA_NGAYSINH'] . "</td>
                 <td id='div02_tacgia_list_table_td_tieusu' >" . $row_list['TACGIA_TIEUSU'] . "</td>";
            if($row['ADMIN_LEVEL']==0 || $row['ADMIN_LEVEL']==1){
            echo "<td id='div02_tacgia_list_table_td_congcu' ><a href='#' id='div02_tacgia_list_table_edit' onclick='div02_tacgia_list_table_edit_click(" . $row_list['TACGIA_ID'] . ")'><img src='edit.ico' width='20px;' height='20px'></a>
			        <a href='#' id='div02_tacgia_list_table_delete' onclick='div02_tacgia_list_table_delete_click(" . $row_list['TACGIA_ID'] . ")'><img src='delete.ico' width='20px' height='20px'></a>
                  </td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }
}
// Nếu không là thành viên thì exit
else {
    echo "EXIT";
    exit();
}
$conn->close();