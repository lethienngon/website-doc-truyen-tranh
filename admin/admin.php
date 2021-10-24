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
    $sql_cook = "select * from admin where ADMIN_USERNAME='$tendangnhap_cook' and ADMIN_MATKHAU=md5('$pass_cook')";
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
    $sql_sess = "select * from admin where ADMIN_USERNAME='$tendangnhap_sess' and ADMIN_MATKHAU=md5('$pass_sess')";
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

<body onload="click_ttcn()">
    <div id="content">
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
                    <a href="#" onclick="click_tacgia()">
                        <p>Tác giả</p>
                    </a>
                </li>
                <li>
                    <a href="#" onclick="click_truyen()">
                        <p>Truyện</p>
                    </a>
                </li>
                <li>
                    <a href="#" onclick="click_thanhvien()">
                        <p>Thành viên</p>
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
                <p class="div02_title">Thông tin cá nhân</p>
                <div id="div02_thongtincanhan_lienhe">
                    <table border="0">
                        <?php
                        $username = $_COOKIE['username'];
                        $matkhau = $_COOKIE['pass'];

                        $conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
                        $conn->set_charset("utf8");
                        $sql = "select * from admin where ADMIN_USERNAME = '$username' and ADMIN_MATKHAU=md5('$matkhau')";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        echo "
                    <tr>
                        <th>Username:</th>
                        <td>" . $row['ADMIN_USERNAME'] . "</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>" . $row['ADMIN_EMAIL'] . "</td>
                    </tr>
                    <tr>
                        <th>SĐT:</th>
                        <td>" . $row['ADMIN_SDT'] . "</td>
                    </tr>
                    <tr>
                        <th>Ngày tham gia:</th>
                        <td>" . $row['ADMIN_NGAYTAO'] . "</td>
                    </tr>";
                        ?>
                    </table>
                </div>
            </div>
            <div></div>
            <div></div>
            <div></div>
            <div id="div02_thanhvien">
                <p class="div02_title">Thành viên</p>
                <a id="div02_thanhvien_add" onclick="click_add_user()" href="#"><img src="user_add.ico" style="width:16px;height:16px"> Thêm mới thành viên</a>
            </div>
            <div></div>
            <div></div>
        </div>
    </div>
    <div id="form_add_user">
        <table border="0" width="500px" height="350px" bgcolor="#f7b7f3">
            <form action="#" method="POST" enctype='multipart/form-data' autocomplete="off">
                <tr>
                    <th align="left">Tên đăng nhập</th>
                    <td><input type="text" name="username"></td>
                </tr>
                <tr>
                    <th align="left">Mật khẩu</th>
                    <td><input type="password" name="pass"></td>
                </tr>
                <tr>
                    <th align="left">Gõ lại mật khẩu</th>
                    <td><input type="password" name="passagain"></td>
                </tr>
                <tr>
                    <th align="left">Email</th>
                    <td><input type="text" name="email"></td>
                </tr>
                <tr>
                    <th align="left">Số điện thoại</th>
                    <td><input type="text" name="sdt"></td>
                </tr>
                <tr>
                    <th align="left">Hình đại diện</th>
                    <td><input type="file" id="anhdaidien" name="anhdaidien"></td>
                </tr>
                <tr>
                    <th align="left"><label for="gender">Giới tính</label></th>
                    <td><input type="radio" id="male" name="gender" value="Nam">
                        <label for="male">Nam</label>
                        <input type="radio" id="female" name="gender" value="Nữ">
                        <label for="female">Nữ</label>
                        <input type="radio" id="orther" name="gender" value="Khác">
                        <label for="orther">Khác</label>
                    </td>
                </tr>
                <tr>
                    <th> </th>
                    <td><input type="submit" value="Đăng kí" name="submit">
                        <input type="reset" value="Làm lại">
                        <a id="form_add_user_exit" onclick="click_add_user_exit()" href="#">Thoát</a>
                    </td>
                </tr>
            </form>
        </table>
    </div>
    <script>
        function click_ttcn() {
            document.getElementById('div02_thongtincanhan').style.visibility = "visible";
            document.getElementById('div02_thanhvien').style.visibility = "hidden";
        }

        function click_theloai() {
            document.getElementById('div02_thongtincanhan').style.visibility = "hidden";
            document.getElementById('div02_thanhvien').style.visibility = "hidden";
        }

        function click_tacgia() {
            document.getElementById('div02_thongtincanhan').style.visibility = "hidden";
            document.getElementById('div02_thanhvien').style.visibility = "hidden";
        }

        function click_truyen() {
            document.getElementById('div02_thongtincanhan').style.visibility = "hidden";
            document.getElementById('div02_thanhvien').style.visibility = "hidden";
        }

        function click_thanhvien() {
            document.getElementById('div02_thongtincanhan').style.visibility = "hidden";
            document.getElementById('div02_thanhvien').style.visibility = "visible";
        }

        function click_baoloi() {
            document.getElementById('div02_thongtincanhan').style.visibility = "hidden";
            document.getElementById('div02_thanhvien').style.visibility = "hidden";
        }

        function click_dieukhoan() {
            document.getElementById('div02_thongtincanhan').style.visibility = "hidden";
            document.getElementById('div02_thanhvien').style.visibility = "hidden";
        }

        function click_add_user() {
            document.getElementById('form_add_user').style.visibility = "visible";
            document.getElementById('content').style.filter = "blur(10px)";
            document.getElementById('content').style.pointerEvents = "none";
            document.getElementById('content').style.userSelect = "none";
            document.getElementById('form_add_user').style.top = "40%";
            document.getElementById('form_add_user').style.transition = "0.5s";
        }

        function click_add_user_exit() {
            document.getElementById('form_add_user').style.visibility = "hidden";
            document.getElementById('content').style.filter = "none";
            document.getElementById('content').style.pointerEvents = "auto";
            document.getElementById('content').style.userSelect = "auto";
            document.getElementById('form_add_user').style.transition = "0s";
            document.getElementById('form_add_user').style.top = "20%";
        }
    </script>
</body>

</html>