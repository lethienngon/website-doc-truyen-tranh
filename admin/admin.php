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
        <form id="form_add_user_form" method="POST" enctype='multipart/form-data' autocomplete="off">
            <table border="0">
                <tr>
                    <th align="left"><label>Tên đăng nhập</label></th>
                    <td><input id="user" type="text" name="username"></td>
                </tr>
                <tr>
                    <th align="left"><label>Mật khẩu</label></th>
                    <td><input id="pass" type="password" name="pass"></td>
                </tr>
                <tr>
                    <th align="left"><label>Gõ lại mật khẩu</label></th>
                    <td><input type="password" name="passagain"></td>
                </tr>
                <tr>
                    <th align="left"><label>Họ và tên</label></th>
                    <td><input type="text" name="hoten"></td>
                </tr>
                <tr>
                    <th align="left"><label>Email</label></th>
                    <td><input type="text" name="email"></td>
                </tr>
                <tr>
                    <th align="left"><label>Số điện thoại</label></th>
                    <td><input type="text" name="sdt"></td>
                </tr>
                <tr>
                    <th align="left"><label>Hình đại diện</label></th>
                    <td><input type="file" id="anhdaidien" name="anhdaidien"></td>
                </tr>
                <tr>
                    <th align="left"><label>Quyền</label></th>
                    <td><select name="level">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th align="left"><label>Trạng thái</label></th>
                    <td><select name="status">
                            <option value="0">Khóa</option>
                            <option value="1">Đang hoạt động</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th> </th>
                    <td><input id="form_add_user_submit" type="submit" value="Đăng kí" name="submit">
                        <input id="form_add_user_reset" type="reset" value="Làm lại">
                        <input id="form_add_user_exit" type="button" value="Thoát" onclick="click_add_user_exit()">
                    </td>
                </tr>
            </table>
        </form>

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
            document.getElementById('form_add_user').style.top = "50%";
            document.getElementById('form_add_user').style.transition = "0.5s";
        }

        function click_add_user_exit() {
            document.getElementById('form_add_user').style.visibility = "hidden";
            document.getElementById('content').style.filter = "none";
            document.getElementById('content').style.pointerEvents = "auto";
            document.getElementById('content').style.userSelect = "auto";
            document.getElementById('form_add_user').style.transition = "0s";
            document.getElementById('form_add_user').style.top = "30%";
        }
    </script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="lib/jquery.validate.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#form_add_user_form").validate({
                rules: {
                    username: {
                        required: true,
                        minlength: 8 , 
                        remote: "check_username_exit.php"
                    },
                    pass: {
                        required: true,
                        minlength: 8
                    },
                    passagain: {
                        equalTo: "#pass"
                    },
                    hoten: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    sdt: {
                        required: true,
                        number: true
                    }
                },
                messages: {
                    username: {
                        required: "Bạn chưa nhập tên đăng nhập",
                        minlength: "Username phải có ít nhất 8 kí tự",
                        remote: "Username đã tồn tại"
                    },
                    pass: {
                        required: "Bạn chưa nhập mật khẩu",
                        minlength: "Mật khẩu phải có ít nhất 8 kí tự"
                    },
                    passagain: {
                        equalTo: "Mật khẩu không khớp"
                    },
                    hoten: {
                        required: "Bạn chưa nhập họ và tên"
                    },
                    email: {
                        required: "Bạn chưa nhập email",
                        email: "Chưa đúng định dạng email"
                    },
                    sdt: {
                        required: "Bạn chưa nhập số điện thoại",
                        number: "Bạn chỉ được nhập kí tự số"
                    }
                },
                submitHandler: function(form) {
                    $('#form_add_user_form').on('submit', function(e) {
                        e.preventDefault();
                        $.ajax({
                            url: "add_user_xuly.php",
                            method: "POST",
                            data: new FormData(this),
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function(data) {
                                click_add_user_exit();
                            }
                        });
                    });
                }
            });
        });
    </script>
</body>

</html>