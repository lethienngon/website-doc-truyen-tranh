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
$truyen_id = $_GET['truyen_id'];

// Connet Mysql
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");

// Kiểm tra xem người dùng có trong thành viên không
$sql = "select ADMIN_USERNAME from admin where ADMIN_ID='$idtv' and ADMIN_USERNAME='$username' and ADMIN_MATKHAU=md5('$pass')";
$result = $conn->query($sql);
if ($result->num_rows > 0) {

    // Liệt kê thông tin truyện
    $sql_truyen_list = "SELECT truyen.*,ADMIN_HOTEN FROM truyen 
    join admin on truyen.ADMIN_ID=admin.ADMIN_ID
    WHERE truyen.TRUYEN_ID = '$truyen_id'";
    $result_truyen_list = $conn->query($sql_truyen_list);
    while ($row_truyen_list = $result_truyen_list->fetch_assoc()) {
        $truyen_name =  $row_truyen_list['TRUYEN_NAME'];
        $admin_hoten = $row_truyen_list['ADMIN_HOTEN'];
        $truyen_trangthai = $row_truyen_list['TRUYEN_TRANGTHAI'];
        $truyen_ngaydang = $row_truyen_list['TRUYEN_NGAYDANG'];
        $truyen_hinhanh = $row_truyen_list['TRUYEN_HINHANH'];
        $truyen_mota = $row_truyen_list['TRUYEN_MOTA'];
    }
    $truyen_tacgia = "";
    $truyen_theloai = "";
    // Lấy danh sách tác giả của truyện có số id là truyen_id
    $sql_select_tacgia = "SELECT TACGIA_HOTEN FROM `truyen` JOIN `truyen_tacgia`on truyen.TRUYEN_ID=truyen_tacgia.TRUYEN_ID JOIN `tacgia` ON truyen_tacgia.TACGIA_ID=tacgia.TACGIA_ID WHERE truyen_tacgia.TRUYEN_ID='$truyen_id'";
    $result_select_tacgia = $conn->query($sql_select_tacgia);
    while ($row_select_tacgia = $result_select_tacgia->fetch_assoc()) {
        $truyen_tacgia = $truyen_tacgia.$row_select_tacgia['TACGIA_HOTEN'].", "; 
    }
    $truyen_tacgia = substr($truyen_tacgia,0,-2);
    // Lấy danh sách thể loại của truyện có số id là truyen_id
    $sql_select_theloai = "SELECT THELOAI_NAME FROM `truyen` JOIN `truyen_theloai`on truyen.TRUYEN_ID=truyen_theloai.TRUYEN_ID JOIN `theloai` ON truyen_theloai.THELOAI_ID=theloai.THELOAI_ID WHERE truyen_theloai.TRUYEN_ID='$truyen_id'";
    $result_select_theloai = $conn->query($sql_select_theloai);
    while ($row_select_theloai = $result_select_theloai->fetch_assoc()) {
        $truyen_theloai = $truyen_theloai.$row_select_theloai['THELOAI_NAME'].", "; 
    }
    $truyen_theloai = substr($truyen_theloai,0,-2);
    // Đổi value trạng thái thành tên
    $truyen_trangthai_switch="";
    switch ($truyen_trangthai){
        case 0: $truyen_trangthai_switch = "Tạm dừng"; break;
        case 1: $truyen_trangthai_switch = "Đang ra"; break;
        case 2: $truyen_trangthai_switch = "Hoàn thành"; break;
        default: $truyen_trangthai_switch = "Có lỗi truy xuất CSDL";
    }
        echo "<p class='div02_title'>".$truyen_name."</p>
        <a id='div02_chuong_add' onclick='div02_chuong_add_click()' href='#'><img src='chuong_add.ico' style='width:16px;height:16px'> Thêm chương</a>
        <a id='div02_chuong_tonghop' onclick='click_chuong()' href='#'><img src='chuong_add.ico' style='width:16px;height:16px'> Tổng hợp chương</a>
        <a id='div02_chuong_truyen' onclick='click_truyen()' href='#'><img src='chuong_add.ico' style='width:16px;height:16px'> Quản lý truyện</a>
        <form id='div02_chuong_form_search'>
            <input id='div02_chuong_form_search_input' type='text' name='hoten' onkeyup=div02_chuong_form_search_input_keyup(this.value,".$truyen_id.") placeholder='Nhập tên chương để tìm kiếm'>
        </form>
        <div id='div02_truyen_thongtin'>
            <img src='".$truyen_hinhanh."' width='250px' height='250px'>
            <p><b>Tác giả:</b> ".$truyen_tacgia."</p>
            <p><b>Thể loại:</b> ".$truyen_theloai."</p>
            <p><b>Người đăng:</b> ".$admin_hoten."</p>
            <p><b>Ngày đăng:</b> ".$truyen_ngaydang."</p>
            <p><b>Trạng thái:</b> ".$truyen_trangthai_switch."</p>
            <p><b>Mô tả:</b> ".$truyen_mota."</p>
        </div>";
        $sql_truyen_chuong_list = "SELECT * FROM chuong where TRUYEN_ID='$truyen_id'";
        $result_truyen_chuong_list = $conn->query($sql_truyen_chuong_list);
        echo "<div id='div02_truyen_chuong_list'>";
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
            echo "<tr>
                 <td id='div02_truyen_chuong_list_table_td_stt' >" . $row_truyen_chuong_list['CHUONG_STT'] . "</td>
                 <td id='div02_truyen_chuong_list_table_td_name' >" . $row_truyen_chuong_list['CHUONG_NAME'] . "</td>
                 <td id='div02_truyen_chuong_list_table_td_luotxem' >" . $row_truyen_chuong_list['CHUONG_LUOTXEM'] . "</td>
                 <td id='div02_truyen_chuong_list_table_td_ngaydang' >" . $row_truyen_chuong_list['CHUONG_NGAYDANG'] . "</td>
                 <td id='div02_truyen_chuong_list_table_td_trangthai' >" . $row_truyen_chuong_list['CHUONG_TRANGTHAI'] . "</td>
                 <td id='div02_truyen_chuong_list_table_td_congcu' >
                 <a href='#' id='div02_truyen_chuong_list_table_list' onclick='div02_truyen_chuong_list_table_list_click(" . $row_truyen_chuong_list['TRUYEN_ID'] . ")'><img src='list.ico' width='20px;' height='20px'></a>
                    <a href='#' id='div02_truyen_chuong_list_table_edit' onclick='div02_truyen_chuong_list_table_edit_click(" . $row_truyen_chuong_list['TRUYEN_ID'] . ")'><img src='edit.ico' width='20px;' height='20px'></a>
			        <a href='#' id='div02_truyen_chuong_list_table_delete' onclick='div02_truyen_chuong_list_table_delete_click(" . $row_truyen_chuong_list['TRUYEN_ID'] . ")'><img src='delete.ico' width='20px' height='20px'></a></td>
                 </tr>";
        }
        echo "</table>
        </div>";
} else {
    exit();
}
