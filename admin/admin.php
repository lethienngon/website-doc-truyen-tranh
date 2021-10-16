<?php
header('Cache-Control: no-cache, no-store, must-revalidate'); //HTTP 1.1
header('Pragma: no-cache'); //HTTP 1.0
header('Expires: 0'); // Date in the past
session_start();
if (isset($_COOKIE['username']) and isset($_COOKIE['pass'])) {
    $tendangnhap_cook = $_COOKIE['username'];
    $pass_cook = $_COOKIE['pass'];

    $conn = new mysqli("localhost", "root", "", "web_truyen_tranh");
    $conn->set_charset("utf8");
    $sql_cook = "select * from nguoidung where tendangnhap='$tendangnhap_cook' and matkhau=md5('$pass_cook')";
    $result_cook = $conn->query($sql_cook);
    if ($result_cook->num_rows > 0) {
    } else {
        header('location:login.php');
    }
} else if (isset($_SESSION['username']) and isset($_SESSION['pass'])) {
    $tendangnhap_sess = $_SESSION['username'];
    $pass_sess = $_SESSION['pass'];

    $conn = new mysqli("localhost", "root", "", "web_truyen_tranh");
    $conn->set_charset("utf8");
    $sql_sess = "select * from nguoidung where tendangnhap='$tendangnhap_sess' and matkhau=md5('$pass_sess')";
    $result_sess = $conn->query($sql_sess);
    if ($result_sess->num_rows > 0) {
    } else {
        header('location:login.php');
    }
} else {
    header('location:login.php');
}
?>

<html>

<head>
    <title>Quản lí web truyện tranh</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="icon" href="admin.ico" size="64x64">
    <link rel="stylesheet" href="admin.css">
</head>

<body>
    <div id="div01">
        <header id="ad_name">Admin</header>
        <ul>
            <li>
                <a href="#" onclick="click_ttcn()">
                    <p>Thông tin cá nhân</p>
                </a>
            </li>
            <li>
                <a href="#" onclick="click_theloai()">
                    <p>Thể loại</p>
                </a>
            </li>
            <li>
                <a href="#"onclick="click_tacgia()">
                    <p>Tác giả</p>
                </a>
            </li>
            <li>
                <a href="#" onclick="click_truyen()">
                    <p>Truyện</p>
                </a>
            </li>
            <li>
                <a href="#" onclick="click_nguoidung()">
                    <p>Người dùng</p>
                </a>
            </li>
            <li>
                <a href="#" onclick="click_caidat()">
                    <p>Cài đặt hệ thống</p>
                </a>
            </li>
            <li>
                <a href="#" onclick="click_dieukhoan()">
                    <p>Chỉnh sửa điều khoản</p>
                </a>
            </li>
            <li>
                <a href="dangxuat.php">
                    <p>Đăng xuất</p>
                </a>
            </li>
        </ul>
    </div>
    <div id="div02">
        <div id="div02_thongtincanhan">
            <p>Thông tin cá nhân</p>
        </div>
    </div>
    <script>
        function click_ttcn(){
            document.getElementById('div02_thongtincanhan').style.visibility = "visible";
        }
        function click_theloai(){
            document.getElementById('div02_thongtincanhan').style.visibility = "hidden";
        }
        function click_tacgia(){
            document.getElementById('div02_thongtincanhan').style.visibility = "hidden";
        }
        function click_truyen(){
            document.getElementById('div02_thongtincanhan').style.visibility = "hidden";
        }
        function click_nguoidung(){
            document.getElementById('div02_thongtincanhan').style.visibility = "hidden";
        }
        function click_caidat(){
            document.getElementById('div02_thongtincanhan').style.visibility = "hidden";
        }
        function click_dieukhoan(){
            document.getElementById('div02_thongtincanhan').style.visibility = "hidden";
        }
    </script>
</body>

</html>