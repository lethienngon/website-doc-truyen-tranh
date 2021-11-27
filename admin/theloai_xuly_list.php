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
$theloai_name = $_GET['theloai_name'];
$item_per_page = 5;
$current_page = $_GET['page'];
$offset = ($current_page - 1) * $item_per_page;

$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
$sql = "select ADMIN_USERNAME from admin where ADMIN_ID='$idtv' and ADMIN_USERNAME='$username' and ADMIN_MATKHAU=md5('$pass') and ADMIN_LEVEL=0";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $sql_count = "select * from theloai where THELOAI_NAME like '%$theloai_name%'";
    $result_count = $conn->query($sql_count);
    $sql_kq = "select * from theloai where THELOAI_NAME like '%$theloai_name%' LIMIT $item_per_page OFFSET $offset";
    $result_kq = $conn->query($sql_kq);
    if ($result_kq->num_rows > 0) {
        $total_page = ceil($result_count->num_rows / $item_per_page);
        echo "<div class='pick_page'>";
        if ($current_page > 3) {
            echo "<a class='pages_tool' href='#' onclick=div02_theloai_form_search_input_keyup('" . $theloai_name . "',1)>First</a>";
        }
        if ($current_page > 1) {
            $prev_page = $current_page - 1;
            echo "<a class='pages_tool' href='#' onclick=div02_theloai_form_search_input_keyup('" . $theloai_name . "'," . $prev_page . ")>Prev</a>";
        }
        for ($num = 1; $num <= $total_page; $num++) {
            if ($num != $current_page) {
                if ($num > $current_page - 3 && $num < $current_page + 3) {
                    echo "<a class='pages' href='#' onclick=div02_theloai_form_search_input_keyup('" . $theloai_name . "'," . $num . ")>" . $num . "</a>";
                }
            } else {
                echo "<strong class='pages' style='background-color:black; color:white; border:2px solid black;'>" . $num . "</strong>";
            }
        }
        if ($current_page < $total_page) {
            $next_page = $current_page + 1;
            echo "<a class='pages_tool' href='#' onclick=div02_theloai_form_search_input_keyup('" . $theloai_name . "'," . $next_page . ")>Next</a>";
        }
        if ($current_page < $total_page - 2) {
            echo "<a class='pages_tool' href='#' onclick=div02_theloai_form_search_input_keyup('" . $theloai_name . "'," . $total_page . ")>Last</a>";
        }
        echo "<strong style='margin-left:20px;'>Tổng số kết quả tìm kiếm: ".$result_count->num_rows."</strong>";
        echo "</div>";
        echo "<table border='0' id='div02_theloai_list_table'>";
        echo "<tr>
              <th>STT</th>
              <th>Tên thể loại</th>
              <th>Mô tả</th>
              <th>Công cụ</th>
          </tr>";
        $stt = $offset;
        while ($row = $result_kq->fetch_assoc()) {
            $stt = $stt + 1;
            echo "<tr>
                 <td id='div02_theloai_list_table_td_id'>" . $stt . "</td>
                 <td id='div02_theloai_list_table_td_name'>" . $row['THELOAI_NAME'] . "</td>
                 <td id='div02_theloai_list_table_td_mota'>" . $row['THELOAI_MOTA'] . "</td>
                 <td id='div02_theloai_list_table_td_congcu'>
                    <a href='#' id='div02_theloai_list_table_edit' onclick='div02_theloai_list_table_edit_click(" . $row['THELOAI_ID'] . ")'><img src='edit.ico' width='20px;' height='20px'></a>
			        <a href='#' id='div02_theloai_list_table_delete' onclick='div02_theloai_list_table_delete_click(" . $row['THELOAI_ID'] . ")'><img src='delete.ico' width='20px' height='20px'></a></td>
                 </tr>";
        }
        echo "</table>";
    }
} else {
    exit();
}
