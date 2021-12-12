<?php
$theloai_id = $_GET['theloai_id'];
$tacgia_id = $_GET['tacgia_id'];
$temp =" ";
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
if($theloai_id!=""){
    $result_theloai = mysqli_query($conn, "SELECT THELOAI_NAME FROM theloai WHERE THELOAI_ID='$theloai_id'");
    $row_theloai = $result_theloai->fetch_assoc();
    echo "<p class='title_p'>DANH SÁCH TRUYỆN CÓ THỂ LOẠI LÀ : ".$row_theloai['THELOAI_NAME']."</p>";
    $temp = "WHERE chuong.CHUONG_TRANGTHAI!=0 and truyen_theloai.THELOAI_ID=".$theloai_id." ";
}
if($tacgia_id!=""){
    $result_tacgia = mysqli_query($conn, "SELECT TACGIA_HOTEN FROM tacgia WHERE TACGIA_ID='$tacgia_id'");
    $row_tacgia = $result_tacgia->fetch_assoc();
    echo "<p class='title_p'>DANH SÁCH TRUYỆN CÓ TÁC GIẢ LÀ : ".$row_tacgia['TACGIA_HOTEN']."</p>";
    $temp = "WHERE chuong.CHUONG_TRANGTHAI!=0 and truyen_tacgia.TACGIA_ID=".$tacgia_id." ";
}
if($tacgia_id=="" && $theloai_id==""){
    echo "<p class='title_p'>DANH SÁCH TẤT CẢ TRUYỆN</p>";
    $temp = "WHERE chuong.CHUONG_TRANGTHAI!=0 ";
}
// SQL lấy truyện
$sql_truyen_list = "SELECT truyen.TRUYEN_ID, TRUYEN_NAME, TRUYEN_HINHANH, MAX(CHUONG_STT) as SOCHUONG
FROM truyen join chuong on truyen.TRUYEN_ID=chuong.TRUYEN_ID
join truyen_theloai on truyen.TRUYEN_ID=truyen_theloai.TRUYEN_ID
join truyen_tacgia on truyen.TRUYEN_ID=truyen_tacgia.TRUYEN_ID
join theloai on theloai.THELOAI_ID=truyen_theloai.THELOAI_ID
join tacgia on tacgia.TACGIA_ID=truyen_tacgia.TACGIA_ID
".$temp."
GROUP BY truyen.TRUYEN_ID, TRUYEN_NAME, TRUYEN_HINHANH";
$result_truyen_list = $conn->query($sql_truyen_list);
while ($row_truyen_list = $result_truyen_list->fetch_assoc()) {
    echo "<a class='div02b1_a' onclick='page_truyen(" . $row_truyen_list['TRUYEN_ID'] . ")' href='#'><img class='div02b1_img' src='admin/" . $row_truyen_list['TRUYEN_HINHANH'] . "'>
    <p>Chapter " . $row_truyen_list['SOCHUONG'] . "</p>		
    <p>" . $row_truyen_list['TRUYEN_NAME'] . "</p>
    </a>";
}

$conn->close();