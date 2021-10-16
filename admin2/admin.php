<?php
header('Cache-Control: no-cache, no-store, must-revalidate'); //HTTP 1.1
header('Pragma: no-cache'); //HTTP 1.0
header('Expires: 0'); // Date in the past
session_start();
if (isset($_COOKIE['username']) and isset($_COOKIE['pass'])) {
    $tendangnhap_cook = $_COOKIE['username'];
    $pass_cook = $_COOKIE['pass'];

    $conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
    $conn->set_charset("utf8");
    $sql_cook = "select * from nguoidung where NGUOIDUNG_USERNAME='$tendangnhap_cook' and NGUOIDUNG_MATKHAU=md5('$pass_cook')";
    $result_cook = $conn->query($sql_cook);
    if ($result_cook->num_rows > 0) {
    } else {
        header('location:login.php');
    }
} else if (isset($_SESSION['username']) and isset($_SESSION['pass'])) {
    $tendangnhap_sess = $_SESSION['username'];
    $pass_sess = $_SESSION['pass'];

    $conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
    $conn->set_charset("utf8");
    $sql_sess = "select * from nguoidung where NGUOIDUNG_USERNAME='$tendangnhap_sess' and NGUOIDUNG_MATKHAU=md5('$pass_sess')";
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
    <link rel="stylesheet" href="addmin.css">
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
                <a href="#" onclick="click_baoloi()">
                    <p>Báo lỗi</p>
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
            <div id="div02_thongtincanhan_lienhe">
                <table border="0">
                    <?php
                    $username = $_COOKIE['username'];
                    $matkhau = $_COOKIE['pass'];

                    $conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
                    $conn->set_charset("utf8");
                    $sql = "select * from nguoidung where NGUOIDUNG_USERNAME = '$username' and NGUOIDUNG_MATKHAU=md5('$matkhau')";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    echo "
                    <tr>
                        <th>Username:</th>
                        <td>".$row['NGUOIDUNG_USERNAME']."</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>".$row['NGUOIDUNG_EMAIL']."</td>
                    </tr>
                    <tr>
                        <th>SĐT:</th>
                        <td>".$row['NGUOIDUNG_SDT']."</td>
                    </tr>
                    <tr>
                        <th>Ngày tham gia:</th>
                        <td>".$row['NGUOIDUNG_NGAYTAO']."</td>
                    </tr>";
                    ?>
                </table>
            </div>
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
        function click_baoloi(){
            document.getElementById('div02_thongtincanhan').style.visibility = "hidden";
        }
        function click_dieukhoan(){
            document.getElementById('div02_thongtincanhan').style.visibility = "hidden";
        }
    </script>
</body>

</html>