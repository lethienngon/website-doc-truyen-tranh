<?php
header('Cache-Control: no-cache, no-store, must-revalidate'); //HTTP 1.1
header('Pragma: no-cache'); //HTTP 1.0
header('Expires: 0'); // Date in the past
session_start();
// Check Cookie
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
} 
// Check Session
else if (isset($_SESSION['username']) and isset($_SESSION['pass'])) {
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
    <!-- Thẻ bao trọn hết phần body (có thể dùng để định dạnh khi click thêm hoặc sửa) -->
    <div id="content">
        <!-- 1)Menu lựa chọn -->
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
                    <a href="dangxuat.php">
                        <p>Đăng xuất</p>
                    </a>
                </li>
            </ul>
        </div>
        <!-- 2)Phần nội dung khi chọn một mục trong Menu lực chọn -->
        <div id="div02">
            <!-- 2.1)Phần nội dung Thông tin cá nhân của Username đang đăng nhập -->
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
            <!-- 2.2)Phần nội dung Thể loại -->
            <div></div>
            <!-- 2.3)Phần nội dung Tác giả -->
            <div id="div02_tacgia">
                <!-- 2.3.1)Title Tác giả -->
                <p class="div02_title">Tác giả</p>
                <!-- 2.3.2)Thêm tác giả -->
                <a id="div02_tacgia_add" onclick="click_add_tacgia()" href="#"><img src="tacgia_add.ico" style="width:16px;height:16px"> Thêm tác giả</a>
                <!-- 2.3.3)Tìm kiếm tác giả -->
                <form id="form_search_tacgia">
                    <input id="search_tacgia_input" type="text" name="hoten" onkeyup=list_tacgia(this.value,1) placeholder="Nhập họ và tên tác giả để tìm kiếm">
                </form>
                <!-- 2.3.4)Danh sách tác giả -->
                <div id="list_tacgia_name"></div>
                <!-- 2.3.5)Chỉnh sửa tác giả -->
                <div id="form_edit_tacgia"></div>
            </div>
            <!-- 2.4)Phần nội dung Truyện -->
            <div></div>
            <!-- 2.5)Phần nội dung Thành viên -->
            <div id="div02_thanhvien">
                <!-- 2.5.1)Title Thành viên -->
                <p class="div02_title">Thành viên</p>
                <!-- 2.5.2)Thêm Thành viên -->
                <a id="div02_thanhvien_add" onclick="click_add_user()" href="#"><img src="user_add.ico" style="width:16px;height:16px"> Thêm mới thành viên</a>
                <!-- 2.5.3)Tìm kiếm thành viên -->
                <form id="form_search_hoten">
                    <input id="search_hoten_input" type="text" name="hoten" onkeyup=list_user(this.value,1) placeholder="Nhập họ và tên để tìm kiếm">
                </form>
                <!-- 2.5.4)Danh sách thành viên -->
                <div id="list_user_name"></div>
                <!-- 2.5.5)Chỉnh sửa thành viên -->
                <div id="form_edit_user"></div>
            </div>
            <!-- 2.6)Phần nội dung Báo lỗi -->
            <div></div>
        </div>
    </div>
    <!-- 3)Form ẩn : Thêm Tác giả -->
    <div id="form_add_tacgia">
        <form id="form_add_tacgia_form" method="POST" enctype='multipart/form-data' autocomplete="off">
            <table border="0">
                <tr>
                    <td rowspan="4"><label for="tacgia_hinhanh"><img src="" alt="Bạn chưa chọn ảnh, sẽ tự động dùng ảnh mặc định!" id="tacgia_add_image" width="450" height="450"></label>
                        <input type="file" id="tacgia_hinhanh" name="tacgia_hinhanh" onchange="tacgia_chooesFile()" accept=".jpg, .jpeg, .png" style="visibility:hidden;"></td>
                    <td><input type="text" class="tacgia_add_input" name="tacgia_hoten" placeholder="Nhập Họ và tên tác giả"></td>
                </tr>
                <tr>
                    <td><input type="date" class="tacgia_add_input" name="tacgia_ngaysinh" placeholder="Nhập ngày sinh tác giả"></td>
                </tr>
                <tr>
                    <td><textarea rows="20" cols="65" style="padding: 5px;" name="tacgia_tieusu" placeholder="Nhập tiểu sử tác giả"></textarea> </td>
                </tr>
                <tr>
                    <td><input id="form_add_tacgia_submit" type="submit" value="Đăng kí" name="submit">
                        <input id="form_add_tacgia_reset" type="reset" value="Làm lại">
                        <input id="form_add_tacgia_exit" type="button" value="Thoát" onclick="click_add_tacgia_exit()">
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <!-- 4)Form ẩn : Thêm Thành viên -->
    <div id="form_add_user">
        <form id="form_add_user_form" method="POST" enctype='multipart/form-data' autocomplete="off">
            <table border="0">
                <tr>
                    <th align="left"><label>Tên đăng nhập</label></th>
                    <td><input type="text" name="username"></td>
                </tr>
                <tr>
                    <th align="left"><label>Mật khẩu</label></th>
                    <td><input id="pass_add_user" type="password" name="pass"></td>
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
                    <td><input type="file" id="anhdaidien" name="anhdaidien" accept=".jpg, .jpeg, .png"></td>
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
    <!-- 5)Form ẩn : Xác nhận muốn xóa Thành viên -->
    <div id="divreport_del_user">
        <h3>Bạn có chắc muốn xóa thành viên này không?</h3>
        <button id="del_user_yes" type="button" onclick="return del_yes();">Có</button>
        <button id="del_user_no" type="button" onclick="return del_no();">Không</button>
    </div>
    <script>
        function click_ttcn() {
            document.getElementById('div02_thongtincanhan').style.visibility = "visible";
            document.getElementById('div02_tacgia').style.visibility = "hidden";
            document.getElementById('div02_thanhvien').style.visibility = "hidden";
        }

        function click_theloai() {
            document.getElementById('div02_thongtincanhan').style.visibility = "hidden";
            document.getElementById('div02_tacgia').style.visibility = "hidden";
            document.getElementById('div02_thanhvien').style.visibility = "hidden";
        }

        function click_tacgia() {
            document.getElementById('div02_thongtincanhan').style.visibility = "hidden";
            document.getElementById('div02_tacgia').style.visibility = "visible";
            document.getElementById('div02_thanhvien').style.visibility = "hidden";
        }

        function click_truyen() {
            document.getElementById('div02_thongtincanhan').style.visibility = "hidden";
            document.getElementById('div02_tacgia').style.visibility = "hidden";
            document.getElementById('div02_thanhvien').style.visibility = "hidden";
        }

        function click_thanhvien() {
            document.getElementById('div02_thongtincanhan').style.visibility = "hidden";
            document.getElementById('div02_tacgia').style.visibility = "hidden";
            document.getElementById('div02_thanhvien').style.visibility = "visible";
            list_user("", 1);
        }

        function click_baoloi() {
            document.getElementById('div02_thongtincanhan').style.visibility = "hidden";
            document.getElementById('div02_tacgia').style.visibility = "hidden";
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

        function list_user(value, page) {
            var xmlhttp;
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("list_user_name").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "list_user.php?hoten=" + value + "&page=" + page, true);
            xmlhttp.send();
        }
        var idtv = "";

        function del_user(value) {
            document.getElementById('divreport_del_user').style.visibility = "visible";
            document.getElementById('content').style.filter = "blur(10px)";
            document.getElementById('content').style.pointerEvents = "none";
            document.getElementById('content').style.userSelect = "none";
            document.getElementById('divreport_del_user').style.transition = "0.5s";
            document.getElementById('divreport_del_user').style.top = "30%";
            idtv = value;
        }

        function del_yes() {
            document.getElementById('divreport_del_user').style.visibility = "hidden";
            document.getElementById('content').style.filter = "none";
            document.getElementById('content').style.pointerEvents = "auto";
            document.getElementById('content').style.userSelect = "auto";
            document.getElementById('divreport_del_user').style.transition = "0s";
            document.getElementById('divreport_del_user').style.top = "10%";
            var xmlhttp;
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    list_user("", 1);
                }
            }
            xmlhttp.open("GET", "delete_user.php?id=" + idtv, true);
            xmlhttp.send();
        }

        function del_no() {
            document.getElementById('divreport_del_user').style.visibility = "hidden";
            document.getElementById('content').style.filter = "none";
            document.getElementById('content').style.pointerEvents = "auto";
            document.getElementById('content').style.userSelect = "auto";
            document.getElementById('divreport_del_user').style.transition = "0s";
            document.getElementById('divreport_del_user').style.top = "10%";
        }

        function edit_user(value) {
            document.getElementById('form_edit_user').style.visibility = "visible";
            document.getElementById('list_user_name').style.visibility = "hidden";
            idtv = value;

            var xmlhttp;
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById('form_edit_user').innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "edit_user.php?id=" + idtv, true);
            xmlhttp.send();
        }

        function click_edit_user_exit() {
            document.getElementById('form_edit_user').style.visibility = "hidden";
            document.getElementById('list_user_name').style.visibility = "visible";
        }

        //2.Tác giả
        function click_add_tacgia() {
            document.getElementById('form_add_tacgia').style.visibility = "visible";
            document.getElementById('content').style.filter = "blur(10px)";
            document.getElementById('content').style.pointerEvents = "none";
            document.getElementById('content').style.userSelect = "none";
            document.getElementById('form_add_tacgia').style.top = "50%";
            document.getElementById('form_add_tacgia').style.transition = "0.5s";
        }
        function click_add_tacgia_exit() {
            document.getElementById('form_add_tacgia').style.visibility = "hidden";
            document.getElementById('content').style.filter = "none";
            document.getElementById('content').style.pointerEvents = "auto";
            document.getElementById('content').style.userSelect = "auto";
            document.getElementById('form_add_tacgia').style.transition = "0s";
            document.getElementById('form_add_tacgia').style.top = "30%";
        }
    </script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="lib/jquery.validate.min.js"></script>
    <!-- Thành viên -->
    <script type="text/javascript">
        $(document).ready(function() {
            $("#form_add_user_form").validate({
                rules: {
                    username: {
                        required: true,
                        minlength: 8,
                        remote: "check_username_exit.php"
                    },
                    pass: {
                        required: true,
                        minlength: 8
                    },
                    passagain: {
                        equalTo: "#pass_add_user"
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
    <script type="text/javascript">
        /* Kiểm tra thông tin nhập vào form edit user và gửi data đến file edit_user_xuly.php*/
        $(document).ready(function() {
            /* ready chỉ được kích hoạt trước lúc tải xong tài liệu, gọi Ajax thì nội dung không dùng được ready, vì vậy phải thêm dòng dưới */
            $("#form_edit_user").on("click", "#form_edit_user_form", function() {
                $("#form_edit_user_form").validate({
                    rules: {
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
                        $('#form_edit_user_form').on('submit', function(e) {
                            e.preventDefault();
                            $.ajax({
                                url: "edit_user_xuly.php?id=" + idtv,
                                method: "POST",
                                data: new FormData(this),
                                contentType: false,
                                cache: false,
                                processData: false,
                                success: function(data) {
                                    click_edit_user_exit();
                                    list_user("", 1);
                                }
                            });
                        });
                    }
                });
            });
        });
        /* Hiển thị ảnh khi chọn ảnh trong form edit user */
        function chooesFile() {
            edit_image.src = "";
            edit_image.src = URL.createObjectURL(event.target.files[0]);
        }
        /* Hiển thị ảnh khi chọn ảnh trong form add tacgia */
        function tacgia_chooesFile() {
            tacgia_add_image.src = "";
            tacgia_add_image.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>

    <!-- Tác giả -->
    <script type="text/javascript">
        $(document).ready(function() {
            $("#form_add_tacgia_form").validate({
                rules: {
                    tacgia_hoten: {
                        required: true
                    },
                    tacgia_ngaysinh: {
                        required: true,
                        date: true
                    }
                },
                messages: {
                    tacgia_hoten: {
                        required: "Bạn chưa nhập họ và tên tác giả"
                    },
                    tacgia_ngaysinh: {
                        required: "Bạn chưa nhập ngày sinh tác giả",
                        date: "Chưa đúng định dạng ngày sinh (dd/mm/yyyy)"
                    }
                },
                submitHandler: function(form) {
                    $('#form_add_tacgia_form').on('submit', function(e) {
                        e.preventDefault();
                        $.ajax({
                            url: "add_tacgia_xuly.php",
                            method: "POST",
                            data: new FormData(this),
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function(data) {
                                click_add_tacgia_exit();
                            }
                        });
                    });
                }
            });
        });
    </script>
</body>

</html>