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
                <a id="div02_tacgia_add" onclick="div02_tacgia_add_click()" href="#"><img src="tacgia_add.ico" style="width:16px;height:16px"> Thêm tác giả</a>
                <!-- 2.3.3)Tìm kiếm tác giả -->
                <form id="div02_tacgia_form_search">
                    <input id="div02_tacgia_form_search_input" type="text" name="hoten" onkeyup=div02_tacgia_form_search_input_keyup(this.value,1) placeholder="Nhập họ và tên tác giả để tìm kiếm">
                </form>
                <!-- 2.3.4)Danh sách tác giả -->
                <div id="div02_tacgia_list"></div>
            </div>
            <!-- 2.4)Phần nội dung Truyện -->
            <div></div>
            <!-- 2.5)Phần nội dung Thành viên -->
            <div id="div02_thanhvien">
                <!-- 2.5.1)Title Thành viên -->
                <p class="div02_title">Thành viên</p>
                <!-- 2.5.2)Thêm Thành viên -->
                <a id="div02_thanhvien_add" onclick="div02_thanhvien_add_click()" href="#"><img src="thanhvien_add.ico" style="width:16px;height:16px"> Thêm mới thành viên</a>
                <!-- 2.5.3)Tìm kiếm thành viên -->
                <form id="div02_thanhvien_form_search">
                    <input id="div02_thanhvien_form_search_input" type="text" name="hoten" onkeyup=div02_thanhvien_form_search_input_keyup(this.value,1) placeholder="Nhập họ và tên để tìm kiếm">
                </form>
                <!-- 2.5.4)Danh sách thành viên -->
                <div id="div02_thanhvien_list"></div>
            </div>
            <!-- 2.6)Phần nội dung Báo lỗi -->
            <div></div>
        </div>
    </div>
    <!-- 4.1)Form ẩn: Thêm Tác giả -->
    <div id="div02_tacgia_form_add">
        <form id="div02_tacgia_form_add_form" method="POST" enctype='multipart/form-data' autocomplete="off">
            <table border="0">
                <tr>
                    <td rowspan="4"><label for="div02_tacgia_form_add_form_hinhanh"><img src="" alt="Bạn chưa chọn ảnh, sẽ tự động dùng ảnh mặc định!" id="div02_tacgia_form_add_form_hinhanh_img" width="450" height="450"></label>
                        <input type="file" id="div02_tacgia_form_add_form_hinhanh" name="tacgia_hinhanh" onchange="div02_tacgia_form_add_form_hinhanh_change()" accept=".jpg, .jpeg, .png" style="visibility:hidden;"></td>
                    <td><input type="text" class="div02_tacgia_form_add_form_input" name="tacgia_hoten" placeholder="Họ và tên của tác giả"></td>
                </tr>
                <tr>
                    <td><input type="date" class="div02_tacgia_form_add_form_input" name="tacgia_ngaysinh"></td>
                </tr>
                <tr>
                    <td><textarea rows="20" cols="65" style="margin-top:20px; padding:5px;" name="tacgia_tieusu" placeholder="Tiểu sử của tác giả"></textarea> </td>
                </tr>
                <tr>
                    <td><input id="div02_tacgia_form_add_form_submit" type="submit" value="Đăng kí" name="submit">
                        <input id="div02_tacgia_form_add_form_reset" type="reset" value="Làm lại">
                        <input id="div02_tacgia_form_add_form_exit" type="button" value="Thoát" onclick="div02_tacgia_form_add_form_exit_click()">
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <!-- 4.2)Form ẩn: Chỉnh sửa tác giả -->
    <div id="div02_tacgia_form_edit"></div>
    <!-- 4.3)Form ẩn: Xác nhận muốn xóa Thành viên -->
    <div id="divreport_delete_thanhvien">
        <h3>Bạn có chắc muốn xóa thành viên này không?</h3>
        <button id="divreport_delete_thanhvien_yes" type="button" onclick="return divreport_delete_thanhvien_yes();">Có</button>
        <button id="divreport_delete_thanhvien_no" type="button" onclick="return divreport_delete_thanhvien_no();">Không</button>
    </div>
    <!-- 5.1)Form ẩn: Thêm Thành viên -->
    <div id="div02_thanhvien_form_add">
        <form id="div02_thanhvien_form_add_form" method="POST" enctype='multipart/form-data' autocomplete="off">
            <table border="0">
                <tr>
                    <th align="left"><label>Tên đăng nhập</label></th>
                    <td><input type="text" name="username"></td>
                </tr>
                <tr>
                    <th align="left"><label>Mật khẩu</label></th>
                    <td><input id="div02_thanhvien_form_add_form_password" type="password" name="pass"></td>
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
                    <td><input type="file" id="div02_thanhvien_form_add_form_anhdaidien" name="anhdaidien" accept=".jpg, .jpeg, .png"></td>
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
                    <td><input id="div02_thanhvien_form_add_form_submit" type="submit" value="Đăng kí" name="submit">
                        <input id="div02_thanhvien_form_add_form_reset" type="reset" value="Làm lại">
                        <input id="div02_thanhvien_form_add_form_exit" type="button" value="Thoát" onclick="div02_thanhvien_form_add_form_exit_click()">
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <!-- 5.2)Form ẩn: Chỉnh sửa thành viên -->
    <div id="div02_thanhvien_form_edit"></div>
    <!-- 5.3)Form ẩn: Xác nhận muốn xóa Tác giả -->
    <div id="divreport_delete_tacgia">
        <h3>Bạn có chắc muốn xóa tác giả này không?</h3>
        <button id="divreport_delete_tacgia_yes" type="button" onclick="return divreport_delete_tacgia_yes();">Có</button>
        <button id="divreport_delete_tacgia_no" type="button" onclick="return divreport_delete_tacgia_no();">Không</button>
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
            div02_tacgia_form_search_input_keyup("", 1);
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
            div02_thanhvien_form_search_input_keyup("", 1);
        }

        function click_baoloi() {
            document.getElementById('div02_thongtincanhan').style.visibility = "hidden";
            document.getElementById('div02_tacgia').style.visibility = "hidden";
            document.getElementById('div02_thanhvien').style.visibility = "hidden";
        }
        //THÀNH VIÊN
        //Hiện form thêm thành viên 
        function div02_thanhvien_add_click() {
            document.getElementById('div02_thanhvien_form_add').style.visibility = "visible";
            document.getElementById('content').style.filter = "blur(10px)";
            document.getElementById('content').style.pointerEvents = "none";
            document.getElementById('content').style.userSelect = "none";
            document.getElementById('div02_thanhvien_form_add').style.top = "50%";
            document.getElementById('div02_thanhvien_form_add').style.transition = "0.5s";
        }
        //Ẩn form thêm thành viên
        function div02_thanhvien_form_add_form_exit_click() {
            document.getElementById('div02_thanhvien_form_add').style.visibility = "hidden";
            document.getElementById('content').style.filter = "none";
            document.getElementById('content').style.pointerEvents = "auto";
            document.getElementById('content').style.userSelect = "auto";
            document.getElementById('div02_thanhvien_form_add').style.transition = "0s";
            document.getElementById('div02_thanhvien_form_add').style.top = "30%";
        }
        //Tìm kiếm thành viên
        function div02_thanhvien_form_search_input_keyup(value, page) {
            var xmlhttp;
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("div02_thanhvien_list").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "thanhvien_xuly_list.php?thanhvien_hoten=" + value + "&page=" + page, true);
            xmlhttp.send();
        }
        //Tạo thanhvien_id để sử dụng
        var thanhvien_id = "";
        //Hiện form chỉnh sửa thành viên
        function div02_thanhvien_list_table_edit_click(value) {
            document.getElementById('div02_thanhvien_form_edit').style.visibility = "visible";
            document.getElementById('content').style.filter = "blur(10px)";
            document.getElementById('content').style.pointerEvents = "none";
            document.getElementById('content').style.userSelect = "none";
            document.getElementById('div02_thanhvien_form_edit').style.top = "50%";
            document.getElementById('div02_thanhvien_form_edit').style.transition = "0.5s";
            thanhvien_id = value;

            var xmlhttp;
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById('div02_thanhvien_form_edit').innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "thanhvien_xuly_edit_get.php?thanhvien_id=" + thanhvien_id, true);
            xmlhttp.send();
        }
        //Ẩn form chỉnh sửa thành viên
        function div02_thanhvien_form_edit_form_exit_click() {
            document.getElementById('div02_thanhvien_form_edit').style.visibility = "hidden";
            document.getElementById('content').style.filter = "none";
            document.getElementById('content').style.pointerEvents = "auto";
            document.getElementById('content').style.userSelect = "auto";
            document.getElementById('div02_thanhvien_form_edit').style.top = "30%";
            document.getElementById('div02_thanhvien_form_edit').style.transition = "0.5s";
        }
        //Hiện thông báo xóa thành viên
        function div02_thanhvien_list_table_delete_click(value) {
            document.getElementById('divreport_delete_thanhvien').style.visibility = "visible";
            document.getElementById('content').style.filter = "blur(10px)";
            document.getElementById('content').style.pointerEvents = "none";
            document.getElementById('content').style.userSelect = "none";
            document.getElementById('divreport_delete_thanhvien').style.transition = "0.5s";
            document.getElementById('divreport_delete_thanhvien').style.top = "30%";
            thanhvien_id = value;
        }
        //Chọn yes để delete thành viên
        function divreport_delete_thanhvien_yes() {
            document.getElementById('divreport_delete_thanhvien').style.visibility = "hidden";
            document.getElementById('content').style.filter = "none";
            document.getElementById('content').style.pointerEvents = "auto";
            document.getElementById('content').style.userSelect = "auto";
            document.getElementById('divreport_delete_thanhvien').style.transition = "0s";
            document.getElementById('divreport_delete_thanhvien').style.top = "10%";
            var xmlhttp;
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    div02_thanhvien_form_search_input_keyup("", 1);
                }
            }
            xmlhttp.open("GET", "thanhvien_xuly_delete.php?thanhvien_id=" + thanhvien_id, true);
            xmlhttp.send();
        }
        //Chọn no để quay lại
        function divreport_delete_thanhvien_no() {
            document.getElementById('divreport_delete_thanhvien').style.visibility = "hidden";
            document.getElementById('content').style.filter = "none";
            document.getElementById('content').style.pointerEvents = "auto";
            document.getElementById('content').style.userSelect = "auto";
            document.getElementById('divreport_delete_thanhvien').style.transition = "0s";
            document.getElementById('divreport_delete_thanhvien').style.top = "10%";
        }

        //TÁC GIẢ
        //Hiện form thêm tác giả
        function div02_tacgia_add_click() {
            document.getElementById('div02_tacgia_form_add').style.visibility = "visible";
            document.getElementById('content').style.filter = "blur(10px)";
            document.getElementById('content').style.pointerEvents = "none";
            document.getElementById('content').style.userSelect = "none";
            document.getElementById('div02_tacgia_form_add').style.top = "50%";
            document.getElementById('div02_tacgia_form_add').style.transition = "0.5s";
        }
        //Ẩn form thêm tác giả
        function div02_tacgia_form_add_form_exit_click() {
            document.getElementById('div02_tacgia_form_add').style.visibility = "hidden";
            document.getElementById('content').style.filter = "none";
            document.getElementById('content').style.pointerEvents = "auto";
            document.getElementById('content').style.userSelect = "auto";
            document.getElementById('div02_tacgia_form_add').style.transition = "0s";
            document.getElementById('div02_tacgia_form_add').style.top = "30%";
        }
        //Tìm kiếm tác giả
        function div02_tacgia_form_search_input_keyup(value, page) {
            var xmlhttp;
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("div02_tacgia_list").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "tacgia_xuly_list.php?tacgia_hoten=" + value + "&page=" + page, true);
            xmlhttp.send();
        }
        //Tạo tacgia_id để dùng
        tacgia_id = "";
        //Hiện form chỉnh sửa tác giả
        function div02_tacgia_list_table_edit_click(value) {
            document.getElementById('div02_tacgia_form_edit').style.visibility = "visible";
            document.getElementById('content').style.filter = "blur(10px)";
            document.getElementById('content').style.pointerEvents = "none";
            document.getElementById('content').style.userSelect = "none";
            document.getElementById('div02_tacgia_form_edit').style.top = "50%";
            document.getElementById('div02_tacgia_form_edit').style.transition = "0.5s";
            tacgia_id = value;

            var xmlhttp;
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById('div02_tacgia_form_edit').innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "tacgia_xuly_edit_get.php?tacgia_id=" + tacgia_id, true);
            xmlhttp.send();
        }
        //Ẩn form chỉnh sửa tác giả
        function div02_tacgia_form_edit_form_exit_click() {
            document.getElementById('div02_tacgia_form_edit').style.visibility = "hidden";
            document.getElementById('content').style.filter = "none";
            document.getElementById('content').style.pointerEvents = "auto";
            document.getElementById('content').style.userSelect = "auto";
            document.getElementById('div02_tacgia_form_edit').style.top = "30%";
            document.getElementById('div02_tacgia_form_edit').style.transition = "0.5s";
        }
        //Hiện thông báo xóa tác giả
        function div02_tacgia_list_table_delete_click(value) {
            document.getElementById('divreport_delete_tacgia').style.visibility = "visible";
            document.getElementById('content').style.filter = "blur(10px)";
            document.getElementById('content').style.pointerEvents = "none";
            document.getElementById('content').style.userSelect = "none";
            document.getElementById('divreport_delete_tacgia').style.transition = "0.5s";
            document.getElementById('divreport_delete_tacgia').style.top = "30%";
            tacgia_id = value;
        }
        //Chọn yes để delete tác giả
        function divreport_delete_tacgia_yes() {
            document.getElementById('divreport_delete_tacgia').style.visibility = "hidden";
            document.getElementById('content').style.filter = "none";
            document.getElementById('content').style.pointerEvents = "auto";
            document.getElementById('content').style.userSelect = "auto";
            document.getElementById('divreport_delete_tacgia').style.transition = "0s";
            document.getElementById('divreport_delete_tacgia').style.top = "10%";
            var xmlhttp;
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    div02_tacgia_form_search_input_keyup("", 1);
                }
            }
            xmlhttp.open("GET", "tacgia_xuly_delete.php?tacgia_id=" + tacgia_id, true);
            xmlhttp.send();
        }
        //Chọn no để quay lại
        function divreport_delete_tacgia_no() {
            document.getElementById('divreport_delete_tacgia').style.visibility = "hidden";
            document.getElementById('content').style.filter = "none";
            document.getElementById('content').style.pointerEvents = "auto";
            document.getElementById('content').style.userSelect = "auto";
            document.getElementById('divreport_delete_tacgia').style.transition = "0s";
            document.getElementById('divreport_delete_tacgia').style.top = "10%";
        }
    </script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="lib/jquery.validate.min.js"></script>
    <!-- THÀNH VIÊN -->
    <script type="text/javascript">
        $(document).ready(function() {
            $("#div02_thanhvien_form_add_form").validate({
                rules: {
                    username: {
                        required: true,
                        minlength: 8,
                        remote: "thanhvien_check_username_exit.php"
                    },
                    pass: {
                        required: true,
                        minlength: 8
                    },
                    passagain: {
                        equalTo: "#div02_thanhvien_form_add_form_password"
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
                    $('#div02_thanhvien_form_add_form').on('submit', function(e) {
                        e.preventDefault();
                        $.ajax({
                            url: "thanhvien_xuly_add.php",
                            method: "POST",
                            data: new FormData(this),
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function(data) {
                                div02_thanhvien_form_add_form_exit_click();
                                div02_thanhvien_form_search_input_keyup("", 1);
                            }
                        });
                    });
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            /* ready chỉ được kích hoạt trước lúc tải xong tài liệu, gọi Ajax thì nội dung không dùng được ready, vì vậy phải thêm dòng dưới */
            $("#div02_thanhvien_form_edit").on("click", "#div02_thanhvien_form_edit_form", function() {
                $("#div02_thanhvien_form_edit_form").validate({
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
                        $('#div02_thanhvien_form_edit_form').on('submit', function(e) {
                            e.preventDefault();
                            $.ajax({
                                url: "thanhvien_xuly_edit_send.php?thanhvien_id=" + thanhvien_id,
                                method: "POST",
                                data: new FormData(this),
                                contentType: false,
                                cache: false,
                                processData: false,
                                success: function(data) {
                                    div02_thanhvien_form_edit_form_exit_click();
                                    div02_thanhvien_form_search_input_keyup("", 1);
                                }
                            });
                        });
                    }
                });
            });
        });
        /* Hiển thị ảnh khi chọn ảnh trong form edit user */
        function div02_thanhvien_form_edit_form_hinhanh_change() {
            div02_thanhvien_form_edit_form_hinhanh_img.src = "";
            div02_thanhvien_form_edit_form_hinhanh_img.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>

    <!-- TÁC GIẢ -->
    <script type="text/javascript">
        $(document).ready(function() {
            $("#div02_tacgia_form_add_form").validate({
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
                    $('#div02_tacgia_form_add_form').on('submit', function(e) {
                        e.preventDefault();
                        $.ajax({
                            url: "tacgia_xuly_add.php",
                            method: "POST",
                            data: new FormData(this),
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function(data) {
                                div02_tacgia_form_add_form_exit_click();
                                div02_tacgia_form_search_input_keyup("", 1);
                            }
                        });
                    });
                }
            });
        });
        /* Hiển thị ảnh khi chọn ảnh trong div02_tacgia_form_add */
        function div02_tacgia_form_add_form_hinhanh_change() {
            div02_tacgia_form_add_form_hinhanh_img.src = "";
            div02_tacgia_form_add_form_hinhanh_img.src = URL.createObjectURL(event.target.files[0]);
        }
        $(document).ready(function() {
            /* ready chỉ được kích hoạt trước lúc tải xong tài liệu, gọi Ajax thì nội dung không dùng được ready, vì vậy phải thêm dòng dưới */
            $("#div02_tacgia_form_edit").on("click", "#div02_tacgia_form_edit_form", function() {
                $("#div02_tacgia_form_edit_form").validate({
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
                    $('#div02_tacgia_form_edit_form').on('submit', function(e) {
                        e.preventDefault();
                        $.ajax({
                            url: "tacgia_xuly_edit_send.php?tacgia_id="+ tacgia_id,
                            method: "POST",
                            data: new FormData(this),
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function(data) {
                                div02_tacgia_form_edit_form_exit_click();
                                div02_tacgia_form_search_input_keyup("", 1);
                            }
                        });
                    });
                }
                });
            });
        });
        /* Hiển thị ảnh khi chọn ảnh trong div02_tacgia_form_edit */
        function div02_tacgia_form_edit_form_hinhanh_change() {
            div02_tacgia_form_edit_form_hinhanh_img.src = "";
            div02_tacgia_form_edit_form_hinhanh_img.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
</body>

</html>