<?php
// Dữ liệu GET
$truyen_id = $_GET['truyen_id'];
$chuong_stt = $_GET['chuong_stt'];
// Connect Mysql
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
// SQL list chương của truyện
$sql_chuong_list = "SELECT CHUONG_STT FROM chuong WHERE TRUYEN_ID='$truyen_id'";
$result_chuong_list = $conn->query($sql_chuong_list);
// SQL lấy tên truyện
$sql_truyen = "SELECT TRUYEN_NAME FROM truyen WHERE TRUYEN_ID='$truyen_id'";
$result_truyen = $conn->query($sql_truyen);
$row_truyen = $result_truyen->fetch_assoc();
// SQL lấy tên chương
$sql_chuong = "SELECT CHUONG_STT, CHUONG_NAME, CHUONG_NGAYDANG FROM chuong WHERE TRUYEN_ID='$truyen_id' and CHUONG_STT='$chuong_stt'";
$result_chuong = $conn->query($sql_chuong);
$row_chuong = $result_chuong->fetch_assoc();
$chuongtruoc = $chuong_stt - 1;
$chuongsau = $chuong_stt + 1;
$chuongmax = "-1";
if ($chuong_stt == 1) {
    $chuongtruoc = 1;
}
if ($chuong_stt == 0) {
    $chuongtruoc = 0;
}

echo "
    <div id='div04_chuong_list_chuong_button'>";
if ($result_chuong->num_rows > 0) {
    echo "
    <h2>" . $row_truyen['TRUYEN_NAME'] . "</h2>
    <h2>CHAPTER " . $row_chuong['CHUONG_STT'] . ": " . $row_chuong['CHUONG_NAME'] . "</h2>
    <h4>Ngày đăng: " . $row_chuong['CHUONG_NGAYDANG'] . "</h4>";
} else {
    echo "<h2></h2>
    <h3></h3>
    <h4></h4>";
}
echo "
    <a class='div04_chuong_list_chuong_button_a' href='#' onclick='page_chuong(" . $truyen_id . "," . $chuongtruoc . ")'><p>Trước</p></a>
    <select onchange='page_chuong(" . $truyen_id . ",value)'>";
while ($row_chuong_list = $result_chuong_list->fetch_assoc()) {
    echo "<option value='" . $row_chuong_list['CHUONG_STT'] . "'";
    if ($row_chuong_list['CHUONG_STT'] == $chuong_stt) {
        echo 'selected';
    }
    echo  ">Chương " . $row_chuong_list['CHUONG_STT'] . "</option>";
    $chuongmax = $row_chuong_list['CHUONG_STT'];
}
if ($chuong_stt == $chuongmax) {
    $chuongsau = $chuongmax;
}
echo "</select>
    <a class='div04_chuong_list_chuong_button_a' href='#' onclick='page_chuong(" . $truyen_id . "," . $chuongsau . ")'><p>Sau</p></a>
    <a id='chuong_baoloi' href='#' onclick='baoloi(" . $truyen_id . "," . $chuong_stt . ")'><p>Báo lỗi</p></a>
    </div>";
// SQL list hình ảnh
$sql_chuong_list_hinhanh = "SELECT CHUONG_NOIDUNG FROM chuong WHERE TRUYEN_ID='$truyen_id' and CHUONG_STT='$chuong_stt'";
$result_chuong_list_hinhanh = $conn->query($sql_chuong_list_hinhanh);
$row_chuong_list_hinhanh = $result_chuong_list_hinhanh->fetch_assoc();
if ($result_chuong_list_hinhanh->num_rows > 0) {
    echo "<div id='div04_chuong_list_hinhanh'>" . $row_chuong_list_hinhanh['CHUONG_NOIDUNG'] . "</div>";
} else {
    echo "<div id='div04_chuong_list_hinhanh'></div>";
}
$conn->close();
