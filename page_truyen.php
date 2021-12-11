<?php
// Dữ liệu GET
$truyen_id = $_GET['truyen_id'];
// Connect Mysql
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
// SQL list truyện
$sql_truyen_list = "SELECT TRUYEN_NAME, TRUYEN_TRANGTHAI, TRUYEN_HINHANH, TRUYEN_MOTA, SUM(CHUONG_LUOTXEM) as 'LUOTXEM'
                    FROM truyen join chuong on truyen.TRUYEN_ID=chuong.TRUYEN_ID
                    WHERE truyen.TRUYEN_ID = '$truyen_id'
                    GROUP BY TRUYEN_NAME, TRUYEN_TRANGTHAI, TRUYEN_HINHANH, TRUYEN_MOTA";
$result_truyen_list = $conn->query($sql_truyen_list);
// SQL list chương của truyện
$sql_chuong_list = "SELECT CHUONG_ID, CHUONG_STT, CHUONG_LUOTXEM, CHUONG_NGAYDANG, TRUYEN_ID
                    FROM chuong where TRUYEN_ID='$truyen_id'
                    ORDER BY CHUONG_STT DESC";
$result_chuong_list = $conn->query($sql_chuong_list);
    while ($row_truyen_list = $result_truyen_list->fetch_assoc()) {
        $truyen_name =  $row_truyen_list['TRUYEN_NAME'];
        $truyen_trangthai = $row_truyen_list['TRUYEN_TRANGTHAI'];
        $truyen_hinhanh = $row_truyen_list['TRUYEN_HINHANH'];
        $truyen_luotxem = $row_truyen_list['LUOTXEM'];
        $truyen_mota = $row_truyen_list['TRUYEN_MOTA'];
    }
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
    // Đổi value trạng thái truyện thành tên
    $truyen_trangthai_switch = "";
    switch ($truyen_trangthai) {
        case 0:
            $truyen_trangthai_switch = "<i style='color:red; font-weight: bold;'>Tạm dừng</i>";
            break;
        case 1:
            $truyen_trangthai_switch = "<i style='color:blue; font-weight: bold;'>Đang ra</i>";
            break;
        case 2:
            $truyen_trangthai_switch = "<i style='color:green; font-weight: bold;'>Hoàn thành</i>";
            break;
        default:
            $truyen_trangthai_switch = "<i style='background-color:red; color:white; font-weight: bold;'>Trạng thái đặt sai!!!</i>";
    }
    // Hiển thị thông tin truyện + button add + search + title
    echo "
        <div id='div03_truyen_thongtin'>
        <table border='0'>
            <tr>
                <td><img id='div03_truyen_thongtin_image' src='admin/" . $truyen_hinhanh . "'></td>
                <td id='div03_truyen_thongtin_td02'>
                    <p id='div03_truyen_thongtin_name'>" . $truyen_name . "</p>
                    <p class='div03_truyen_thongtin_p'><b>Tác giả:</b> " . $truyen_tacgia . "</p>
                    <p class='div03_truyen_thongtin_p'><b>Thể loại:</b> " . $truyen_theloai . "</p>
                    <p class='div03_truyen_thongtin_p'><b>Trạng thái:</b> " . $truyen_trangthai_switch . "</p>
                    <p class='div03_truyen_thongtin_p'><b>Lượt xem:</b> " . $truyen_luotxem . "</p>
                </td>
            </tr>
        </table>
        <p id='div03_truyen_thongtin_mota'><b>Mô tả:</b></br> " . $truyen_mota . "</p>
        </div>
        <div id='div03_truyen_list_chuong'>
            <p class='title_p'>DANH SÁCH CHƯƠNG</p>
            <ul style='list-style-type: none;'>";
            while ($row_chuong_list = $result_chuong_list->fetch_assoc()) {
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $temp = substr($row_chuong_list['CHUONG_NGAYDANG'], 0, -9);
                $first_date = strtotime(date($temp));
                $second_date = strtotime(date('Y-m-d'));
                $datediff = abs($first_date - $second_date);
                echo   "<li class='div03_truyen_list_chuong_li'>
                            <a class='div03_truyen_list_chuong_a' href='#' onclick='page_chuong(".$row_chuong_list['TRUYEN_ID'].", ".$row_chuong_list['CHUONG_STT'].")'>
                                <div>Chapter ".$row_chuong_list['CHUONG_STT']."</div>
                                <div>".$row_chuong_list['CHUONG_LUOTXEM']." lượt xem</div>
                                <div>".floor($datediff / (60*60*24))." ngày trước</div>
                            </a>
                        </li>";
            }
    echo    "</ul>
        </div>";
