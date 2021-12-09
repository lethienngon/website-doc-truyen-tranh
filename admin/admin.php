<?php
header('Cache-Control: no-cache, no-store, must-revalidate'); //HTTP 1.1
header('Pragma: no-cache'); //HTTP 1.0
header('Expires: 0'); // Date in the past
//session_start();
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
/*else if (isset($_SESSION['username']) and isset($_SESSION['pass'])) {
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
}*/ else {
    header('location:login.php');
}
// Truyện Select tác giả 
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
$result_truyen_select_tacgia = mysqli_query($conn, "SELECT TACGIA_ID, TACGIA_HOTEN FROM tacgia");
$result_truyen_select_theloai = mysqli_query($conn, "SELECT THELOAI_ID, THELOAI_NAME FROM theloai");
?>

<html>

<head>
    <title>Quản lí web truyện tranh</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="icon" href="admin.ico" size="64x64">
    <link rel="stylesheet" href="admin.css">
    <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
</head>

<body onload="click_ttcn()">
    <!-- Thẻ bao trọn hết phần body (có thể dùng để định dạnh khi click thêm hoặc sửa) -->
    <div id="content">
        <!-- 1) Menu lựa chọn -->
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
                    <a href="#" onclick="click_chuong()">
                        <p>Chương</p>
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
        <!-- 2) Phần nội dung khi chọn một mục trong Menu lựa chọn -->
        <div id="div02">
            <!-- 2.1) Phần nội dung Thông tin cá nhân của Username đang đăng nhập -->
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
                            <td>" . $row['ADMIN_HOTEN'] . "</td>
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
            <!-- 2.2) Phần nội dung Thể loại -->
            <div>
                <div id="div02_theloai">
                    <!-- 2.2.1) Title Thể loại -->
                    <p class="div02_title">Quản lý Thể loại</p>
                    <!-- 2.2.2) Thêm thể loại -->
                    <a id="div02_theloai_add" onclick="div02_theloai_add_click()" href="#"><img src="theloai_add.ico" style="width:16px;height:16px"> Thêm thể loại</a>
                    <!-- 2.2.3) Tìm kiếm thể loại -->
                    <form id="div02_theloai_form_search">
                        <input id="div02_theloai_form_search_input" type="text" name="hoten" onkeyup=div02_theloai_form_search_input_keyup(this.value,1) placeholder="Nhập tên thể loại để tìm kiếm">
                    </form>
                    <!-- 2.2.4) Danh sách thể loại -->
                    <div id="div02_theloai_list"></div>
                </div>
            </div>
            <!-- 2.3) Phần nội dung Tác giả -->
            <div id="div02_tacgia">
                <!-- 2.3.1) Title Tác giả -->
                <p class="div02_title">Quản lý Tác giả</p>
                <!-- 2.3.2) Thêm tác giả -->
                <a id="div02_tacgia_add" onclick="div02_tacgia_add_click()" href="#"><img src="tacgia_add.ico" style="width:16px;height:16px"> Thêm tác giả</a>
                <!-- 2.3.3) Tìm kiếm tác giả -->
                <form id="div02_tacgia_form_search">
                    <input id="div02_tacgia_form_search_input" type="text" name="hoten" onkeyup=div02_tacgia_form_search_input_keyup(this.value,1) placeholder="Nhập họ và tên tác giả để tìm kiếm">
                </form>
                <!-- 2.3.4) Danh sách tác giả -->
                <div id="div02_tacgia_list"></div>
            </div>
            <!-- 2.4) Phần nội dung Truyện -->
            <div id="div02_truyen">
                <!-- 2.4.1) Title Truyện -->
                <p class="div02_title">Quản lý Truyện</p>
                <!-- 2.4.2) Thêm Truyện -->
                <a id="div02_truyen_add" onclick="div02_truyen_add_click()" href="#"><img src="truyen_add.ico" style="width:16px;height:16px"> Thêm Truyện</a>
                <!-- 2.4.3) Tìm kiếm Truyện -->
                <form id="div02_truyen_form_search">
                    <input id="div02_truyen_form_search_input" type="text" name="hoten" onkeyup=div02_truyen_form_search_input_keyup(this.value,1) placeholder="Nhập tên truyện để tìm kiếm">
                </form>
                <!-- 2.4.4) Danh sách Truyện -->
                <div id="div02_truyen_list"></div>
            </div>
            <!-- 2.5) Phần nội dung Chương của Truyện (Hiển thị trong mục Truyện ) -->
            <div id="div02_truyen_chuong">
            </div>
            <!-- 6) Phần nội dung Chương -->
            <div id="div02_chuong">
                <!-- 2.6.1) Title Chương -->
                <p class='div02_title'>Tổng hợp chương</p>
                <!-- 2.6.2) Thêm Chương -->
                <a id='div02_chuong_quanly_truyen' onclick='click_truyen()' href='#'><img src='manage.ico' style='width:16px;height:16px'> Quản lý truyện</a>
                <!-- 2.6.3) Tìm kiếm Chương -->
                <form>
                    <input id='div02_chuong_search' type='text' name='hoten' onkeyup=div02_chuong_form_search(this.value) placeholder='Nhập tên chương để tìm kiếm'>
                </form>
                <!-- 2.6.4) Danh sách Chương -->
                <div id="div02_chuong_list"></div>
            </div>
            <!-- 2.7) Phần nội dung Thành viên -->
            <div id="div02_thanhvien">
                <!-- 2.7.1) Title Thành viên -->
                <p class="div02_title">Quản lý Thành viên</p>
                <!-- 2.7.2) Thêm Thành viên -->
                <a id="div02_thanhvien_add" onclick="div02_thanhvien_add_click()" href="#"><img src="thanhvien_add.ico" style="width:16px;height:16px"> Thêm mới thành viên</a>
                <!-- 2.7.3) Tìm kiếm Thành viên -->
                <form id="div02_thanhvien_form_search">
                    <input id="div02_thanhvien_form_search_input" type="text" name="hoten" onkeyup=div02_thanhvien_form_search_input_keyup(this.value,1) placeholder="Nhập họ và tên để tìm kiếm">
                </form>
                <!-- 2.7.4) Danh sách Thành viên -->
                <div id="div02_thanhvien_list"></div>
            </div>
            <!-- 2.8) Phần nội dung Báo lỗi -->
            <div></div>
        </div>
    </div>
    <!-- 3.1) Form ẩn: Thêm Thể loại -->
    <div id="div02_theloai_form_add">
        <form id="div02_theloai_form_add_form" method="POST" enctype='multipart/form-data' autocomplete="off">
            <table border="0">
                <tr>
                    <td><input type="text" class="div02_theloai_form_add_form_input" name="theloai_name" placeholder="Tên thể loại"></td>
                </tr>
                <tr>
                    <td><textarea rows="20" cols="65" style="margin-top:30px; padding:5px;" name="theloai_mota" placeholder="Mô tả thể loại"></textarea> </td>
                </tr>
                <tr>
                    <td><input id="div02_theloai_form_add_form_submit" type="submit" value="Thêm" name="submit">
                        <input id="div02_theloai_form_add_form_reset" type="reset" value="Làm lại">
                        <input id="div02_theloai_form_add_form_exit" type="button" value="Thoát" onclick="div02_theloai_form_add_form_exit_click()">
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <!-- 3.2) Form ẩn: Chỉnh sửa thể loại -->
    <div id="div02_theloai_form_edit"></div>
    <!-- 3.3) Form ẩn: Xác nhận muốn xóa thể loại này -->
    <div id="divreport_delete_theloai">
        <h3>Bạn có chắc muốn xóa tác giả này không?</h3>
        <button id="divreport_delete_theloai_yes" type="button" onclick="return divreport_delete_theloai_yes();">Có</button>
        <button id="divreport_delete_theloai_no" type="button" onclick="return divreport_delete_theloai_no();">Không</button>
    </div>
    <!-- 4.1) Form ẩn: Thêm Tác giả -->
    <div id="div02_tacgia_form_add">
        <form id="div02_tacgia_form_add_form" method="POST" enctype='multipart/form-data' autocomplete="off">
            <table border="0">
                <tr>
                    <td rowspan="4"><label for="div02_tacgia_form_add_form_hinhanh"><img src="" alt="Bạn chưa chọn ảnh, sẽ tự động dùng ảnh mặc định!" id="div02_tacgia_form_add_form_hinhanh_img" width="450" height="450"></label>
                        <input type="file" id="div02_tacgia_form_add_form_hinhanh" name="tacgia_hinhanh" onchange="div02_tacgia_form_add_form_hinhanh_change()" accept=".jpg, .jpeg, .png" style="visibility:hidden;">
                    </td>
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
    <!-- 4.2) Form ẩn: Chỉnh sửa tác giả -->
    <div id="div02_tacgia_form_edit"></div>
    <!-- 4.3) Form ẩn: Xác nhận muốn xóa Tác giả -->
    <div id="divreport_delete_tacgia">
        <h3>Bạn có chắc muốn xóa tác giả này không?</h3>
        <button id="divreport_delete_tacgia_yes" type="button" onclick="return divreport_delete_tacgia_yes();">Có</button>
        <button id="divreport_delete_tacgia_no" type="button" onclick="return divreport_delete_tacgia_no();">Không</button>
    </div>
    <!-- 5.1) Form ẩn: Thêm truyện -->
    <div id="div02_truyen_form_add">
        <form id="div02_truyen_form_add_form" method="POST" enctype='multipart/form-data' autocomplete="off">
            <table border="0">
                <tr>
                    <td rowspan="6"><label for="div02_truyen_form_add_form_hinhanh"><img src="" alt="Bạn chưa chọn ảnh, sẽ tự động dùng ảnh mặc định!" id="div02_truyen_form_add_form_hinhanh_img" width="450" height="450"></label>
                        <input type="file" id="div02_truyen_form_add_form_hinhanh" name="truyen_hinhanh" onchange="div02_truyen_form_add_form_hinhanh_change()" accept=".jpg, .jpeg, .png" style="visibility:hidden;">
                    </td>
                    <td><input type="text" class="div02_truyen_form_add_form_input" name="truyen_name" placeholder="Nhập tên truyện"></td>
                </tr>
                <tr>
                    <td>
                        <select class="div02_truyen_form_add_form_select_tacgia" name="truyen_select_tacgia[]" multiple="multiple">
                            <?php
                            while ($row_truyen_select_tacgia = $result_truyen_select_tacgia->fetch_assoc()) {
                                echo "<option value='" . $row_truyen_select_tacgia['TACGIA_ID'] . "'>" . $row_truyen_select_tacgia['TACGIA_HOTEN'] . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <select class="div02_truyen_form_add_form_select_theloai" name="truyen_select_theloai[]" multiple="multiple">
                            <?php
                            while ($row_truyen_select_theloai = $result_truyen_select_theloai->fetch_assoc()) {
                                echo "<option value='" . $row_truyen_select_theloai['THELOAI_ID'] . "'>" . $row_truyen_select_theloai['THELOAI_NAME'] . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><textarea rows="15" cols="65" style="margin-top:30px; padding:5px;" name="truyen_mota" placeholder="Mô tả truyện"></textarea> </td>
                </tr>
                <tr>
                    <td><input id="div02_truyen_form_add_form_submit" class="div02_form_submit" type="submit" value="Đăng kí" name="submit">
                        <input id="div02_truyen_form_add_form_reset" class="div02_form_reset" type="reset" value="Làm lại">
                        <input id="div02_truyen_form_add_form_exit" class="div02_form_exit" type="button" value="Thoát" onclick="div02_truyen_form_add_form_exit_click()">
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <!-- 5.2) Form ẩn: Chỉnh sửa truyện -->
    <div id="div02_truyen_form_edit"></div>
    <!-- 5.3) Form ẩn: Xác nhận muốn xóa truyện -->
    <div id="divreport_delete_truyen">
        <h3>Bạn có chắc muốn xóa truyện này không?</h3>
        <button id="divreport_delete_truyen_yes" type="button" onclick="return divreport_delete_truyen_yes();">Có</button>
        <button id="divreport_delete_truyen_no" type="button" onclick="return divreport_delete_truyen_no();">Không</button>
    </div>
    <!-- 6.1) Form ẩn: Xác nhận muốn xóa Chương -->
    <div id="divreport_delete_chuong">
        <h3>Bạn có chắc muốn xóa chương này không?</h3>
        <button id="divreport_delete_chuong_yes" type="button" onclick="return divreport_delete_chuong_yes();">Có</button>
        <button id="divreport_delete_chuong_no" type="button" onclick="return divreport_delete_chuong_no();">Không</button>
    </div>
    <!-- 7.1) Form ẩn: Thêm Thành viên -->
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
    <!-- 7.2) Form ẩn: Chỉnh sửa thành viên -->
    <div id="div02_thanhvien_form_edit"></div>
    <!-- 7.3) Form ẩn: Xác nhận muốn xóa Thành viên -->
    <div id="divreport_delete_thanhvien">
        <h3>Bạn có chắc muốn xóa thành viên này không?</h3>
        <button id="divreport_delete_thanhvien_yes" type="button" onclick="return divreport_delete_thanhvien_yes();">Có</button>
        <button id="divreport_delete_thanhvien_no" type="button" onclick="return divreport_delete_thanhvien_no();">Không</button>
    </div>
    <!-- 8.1) Thông báo 'thao tác thành công' -->
    <div id="divreport_success">
        <p>Thao tác thành công!</p>
    </div>
    <!-- 8.2) Thông báo 'thao tác thất bại' -->
    <div id="divreport_failed">
        <p>Thao tác thất bại!</p>
    </div>
    <script>
        function click_ttcn() {
            div02_truyen_list_table_list_click(truyen_id);
            document.getElementById('div02_thongtincanhan').style.visibility = "visible";
            document.getElementById('div02_theloai').style.visibility = "hidden";
            document.getElementById('div02_tacgia').style.visibility = "hidden";
            document.getElementById('div02_truyen').style.visibility = "hidden";
            document.getElementById('div02_truyen_chuong').style.visibility = "hidden";
            document.getElementById('div02_chuong').style.visibility = "hidden";
            document.getElementById('div02_thanhvien').style.visibility = "hidden";
        }

        function click_theloai() {
            div02_truyen_list_table_list_click(truyen_id);
            document.getElementById('div02_thongtincanhan').style.visibility = "hidden";
            document.getElementById('div02_theloai').style.visibility = "visible";
            document.getElementById('div02_tacgia').style.visibility = "hidden";
            document.getElementById('div02_truyen').style.visibility = "hidden";
            document.getElementById('div02_truyen_chuong').style.visibility = "hidden";
            document.getElementById('div02_chuong').style.visibility = "hidden";
            document.getElementById('div02_thanhvien').style.visibility = "hidden";
            div02_theloai_form_search_input_keyup("", 1);
        }

        function click_tacgia() {
            div02_truyen_list_table_list_click(truyen_id);
            document.getElementById('div02_thongtincanhan').style.visibility = "hidden";
            document.getElementById('div02_theloai').style.visibility = "hidden";
            document.getElementById('div02_tacgia').style.visibility = "visible";
            document.getElementById('div02_truyen').style.visibility = "hidden";
            document.getElementById('div02_truyen_chuong').style.visibility = "hidden";
            document.getElementById('div02_chuong').style.visibility = "hidden";
            document.getElementById('div02_thanhvien').style.visibility = "hidden";
            div02_tacgia_form_search_input_keyup("", 1);
        }

        function click_truyen() {
            div02_truyen_list_table_list_click(truyen_id);
            document.getElementById('div02_thongtincanhan').style.visibility = "hidden";
            document.getElementById('div02_theloai').style.visibility = "hidden";
            document.getElementById('div02_tacgia').style.visibility = "hidden";
            document.getElementById('div02_truyen').style.visibility = "visible";
            document.getElementById('div02_truyen_chuong').style.visibility = "hidden";
            document.getElementById('div02_chuong').style.visibility = "hidden";
            document.getElementById('div02_thanhvien').style.visibility = "hidden";
            div02_truyen_form_search_input_keyup("", 1);
        }

        function click_chuong() {
            div02_truyen_list_table_list_click(truyen_id);
            document.getElementById('div02_thongtincanhan').style.visibility = "hidden";
            document.getElementById('div02_theloai').style.visibility = "hidden";
            document.getElementById('div02_tacgia').style.visibility = "hidden";
            document.getElementById('div02_truyen').style.visibility = "hidden";
            document.getElementById('div02_truyen_chuong').style.visibility = "hidden";
            document.getElementById('div02_chuong').style.visibility = "visible";
            document.getElementById('div02_thanhvien').style.visibility = "hidden";
            div02_chuong_form_search("");
        }

        function click_thanhvien() {
            div02_truyen_list_table_list_click(truyen_id);
            document.getElementById('div02_thongtincanhan').style.visibility = "hidden";
            document.getElementById('div02_theloai').style.visibility = "hidden";
            document.getElementById('div02_tacgia').style.visibility = "hidden";
            document.getElementById('div02_truyen').style.visibility = "hidden";
            document.getElementById('div02_truyen_chuong').style.visibility = "hidden";
            document.getElementById('div02_chuong').style.visibility = "hidden";
            document.getElementById('div02_thanhvien').style.visibility = "visible";
            div02_thanhvien_form_search_input_keyup("", 1);
        }

        function click_baoloi() {
            div02_truyen_list_table_list_click(truyen_id);
            document.getElementById('div02_thongtincanhan').style.visibility = "hidden";
            document.getElementById('div02_theloai').style.visibility = "hidden";
            document.getElementById('div02_tacgia').style.visibility = "hidden";
            document.getElementById('div02_truyen').style.visibility = "hidden";
            document.getElementById('div02_truyen_chuong').style.visibility = "hidden";
            document.getElementById('div02_chuong').style.visibility = "hidden";
            document.getElementById('div02_thanhvien').style.visibility = "hidden";
        }

        /////----------------------------------------------------/////
        // THỂ LOẠI

        // Hiện form thêm thể loại
        function div02_theloai_add_click() {
            document.getElementById('div02_theloai_form_add').style.visibility = "visible";
            document.getElementById('div02_theloai_form_add').style.transition = "0.5s";
            document.getElementById('content').style.filter = "blur(10px)";
            document.getElementById('content').style.pointerEvents = "none";
            document.getElementById('content').style.userSelect = "none";
            document.getElementById('div02_theloai_form_add').style.top = "50%";
        }
        // Ẩn form thêm thể loại
        function div02_theloai_form_add_form_exit_click() {
            document.getElementById('div02_theloai_form_add').style.visibility = "hidden";
            document.getElementById('div02_theloai_form_add').style.transition = "0s";
            document.getElementById('content').style.filter = "none";
            document.getElementById('content').style.pointerEvents = "auto";
            document.getElementById('content').style.userSelect = "auto";
            document.getElementById('div02_theloai_form_add').style.top = "30%";
        }
        // Tìm kiếm thể loại
        function div02_theloai_form_search_input_keyup(value, page) {
            var xmlhttp;
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("div02_theloai_list").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "theloai_xuly_list.php?theloai_name=" + value + "&page=" + page, true);
            xmlhttp.send();
        }
        // Tạo theloai_id để dùng
        theloai_id = "";
        // Hiện form chỉnh sửa thể loại
        function div02_theloai_list_table_edit_click(value) {
            document.getElementById('div02_theloai_form_edit').style.visibility = "visible";
            document.getElementById('content').style.filter = "blur(10px)";
            document.getElementById('content').style.pointerEvents = "none";
            document.getElementById('content').style.userSelect = "none";
            document.getElementById('div02_theloai_form_edit').style.top = "50%";
            document.getElementById('div02_theloai_form_edit').style.transition = "0.5s";
            theloai_id = value;

            var xmlhttp;
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById('div02_theloai_form_edit').innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "theloai_xuly_edit_get.php?theloai_id=" + theloai_id, true);
            xmlhttp.send();
        }
        // Ẩn form chỉnh sửa thể loại
        function div02_theloai_form_edit_form_exit_click() {
            document.getElementById('div02_theloai_form_edit').style.visibility = "hidden";
            document.getElementById('content').style.filter = "none";
            document.getElementById('content').style.pointerEvents = "auto";
            document.getElementById('content').style.userSelect = "auto";
            document.getElementById('div02_theloai_form_edit').style.top = "30%";
            document.getElementById('div02_theloai_form_edit').style.transition = "0s";
        }
        // Hiện thông báo xóa thể loại
        function div02_theloai_list_table_delete_click(value) {
            document.getElementById('divreport_delete_theloai').style.visibility = "visible";
            document.getElementById('content').style.filter = "blur(10px)";
            document.getElementById('content').style.pointerEvents = "none";
            document.getElementById('content').style.userSelect = "none";
            document.getElementById('divreport_delete_theloai').style.transition = "0.5s";
            document.getElementById('divreport_delete_theloai').style.top = "30%";
            theloai_id = value;
        }
        // Chọn yes để delete thể loại
        function divreport_delete_theloai_yes() {
            document.getElementById('divreport_delete_theloai').style.visibility = "hidden";
            document.getElementById('content').style.filter = "none";
            document.getElementById('content').style.pointerEvents = "auto";
            document.getElementById('content').style.userSelect = "auto";
            document.getElementById('divreport_delete_theloai').style.transition = "0s";
            document.getElementById('divreport_delete_theloai').style.top = "10%";
            var xmlhttp;
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    div02_theloai_form_search_input_keyup("", 1);
                }
            }
            xmlhttp.open("GET", "theloai_xuly_delete.php?theloai_id=" + theloai_id, true);
            xmlhttp.send();
        }
        // Chọn no để quay lại
        function divreport_delete_theloai_no() {
            document.getElementById('divreport_delete_theloai').style.visibility = "hidden";
            document.getElementById('content').style.filter = "none";
            document.getElementById('content').style.pointerEvents = "auto";
            document.getElementById('content').style.userSelect = "auto";
            document.getElementById('divreport_delete_theloai').style.transition = "0s";
            document.getElementById('divreport_delete_theloai').style.top = "10%";
        }

        /////----------------------------------------------------/////
        // TÁC GIẢ

        // Hiện form thêm tác giả
        function div02_tacgia_add_click() {
            document.getElementById('div02_tacgia_form_add').style.visibility = "visible";
            document.getElementById('content').style.filter = "blur(10px)";
            document.getElementById('content').style.pointerEvents = "none";
            document.getElementById('content').style.userSelect = "none";
            document.getElementById('div02_tacgia_form_add').style.top = "50%";
            document.getElementById('div02_tacgia_form_add').style.transition = "0.5s";
        }
        // Ẩn form thêm tác giả
        function div02_tacgia_form_add_form_exit_click() {
            document.getElementById('div02_tacgia_form_add').style.visibility = "hidden";
            document.getElementById('content').style.filter = "none";
            document.getElementById('content').style.pointerEvents = "auto";
            document.getElementById('content').style.userSelect = "auto";
            document.getElementById('div02_tacgia_form_add').style.transition = "0s";
            document.getElementById('div02_tacgia_form_add').style.top = "30%";
        }
        // Tìm kiếm tác giả
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
        // Tạo tacgia_id để dùng
        tacgia_id = "";
        // Hiện form chỉnh sửa tác giả
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
        // Ẩn form chỉnh sửa tác giả
        function div02_tacgia_form_edit_form_exit_click() {
            document.getElementById('div02_tacgia_form_edit').style.visibility = "hidden";
            document.getElementById('content').style.filter = "none";
            document.getElementById('content').style.pointerEvents = "auto";
            document.getElementById('content').style.userSelect = "auto";
            document.getElementById('div02_tacgia_form_edit').style.top = "30%";
            document.getElementById('div02_tacgia_form_edit').style.transition = "0.5s";
        }
        // Hiện thông báo xóa tác giả
        function div02_tacgia_list_table_delete_click(value) {
            document.getElementById('divreport_delete_tacgia').style.visibility = "visible";
            document.getElementById('content').style.filter = "blur(10px)";
            document.getElementById('content').style.pointerEvents = "none";
            document.getElementById('content').style.userSelect = "none";
            document.getElementById('divreport_delete_tacgia').style.transition = "0.5s";
            document.getElementById('divreport_delete_tacgia').style.top = "30%";
            tacgia_id = value;
        }
        // Chọn yes để delete tác giả
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
        // Chọn no để quay lại
        function divreport_delete_tacgia_no() {
            document.getElementById('divreport_delete_tacgia').style.visibility = "hidden";
            document.getElementById('content').style.filter = "none";
            document.getElementById('content').style.pointerEvents = "auto";
            document.getElementById('content').style.userSelect = "auto";
            document.getElementById('divreport_delete_tacgia').style.transition = "0s";
            document.getElementById('divreport_delete_tacgia').style.top = "10%";
        }

        /////----------------------------------------------------/////
        // TRUYỆN

        // Hiện form thêm truyện
        function div02_truyen_add_click() {
            document.getElementById('div02_truyen_form_add').style.visibility = "visible";
            document.getElementById('content').style.filter = "blur(10px)";
            document.getElementById('content').style.pointerEvents = "none";
            document.getElementById('content').style.userSelect = "none";
            document.getElementById('div02_truyen_form_add').style.top = "50%";
            document.getElementById('div02_truyen_form_add').style.transition = "0.5s";
        }
        // Ẩn form thêm truyện
        function div02_truyen_form_add_form_exit_click() {
            document.getElementById('div02_truyen_form_add').style.visibility = "hidden";
            document.getElementById('content').style.filter = "none";
            document.getElementById('content').style.pointerEvents = "auto";
            document.getElementById('content').style.userSelect = "auto";
            document.getElementById('div02_truyen_form_add').style.transition = "0s";
            document.getElementById('div02_truyen_form_add').style.top = "30%";
        }
        // Tìm kiếm truyện
        function div02_truyen_form_search_input_keyup(value, page) {
            var xmlhttp;
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("div02_truyen_list").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "truyen_xuly_list.php?truyen_name=" + value + "&page=" + page, true);
            xmlhttp.send();
        }
        // Tạo truyen_id để dùng
        truyen_id = "";
        // Hiện form chỉnh sửa truyện
        function div02_truyen_list_table_edit_click(value) {
            document.getElementById('div02_truyen_form_edit').style.visibility = "visible";
            document.getElementById('content').style.filter = "blur(10px)";
            document.getElementById('content').style.pointerEvents = "none";
            document.getElementById('content').style.userSelect = "none";
            document.getElementById('div02_truyen_form_edit').style.top = "50%";
            document.getElementById('div02_truyen_form_edit').style.transition = "0.5s";
            truyen_id = value;

            var xmlhttp;
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById('div02_truyen_form_edit').innerHTML = xmlhttp.responseText;
                    truyen_select_tacgia_theloai();
                }
            }
            xmlhttp.open("GET", "truyen_xuly_edit_get.php?truyen_id=" + truyen_id, true);
            xmlhttp.send();
        }
        // Ẩn form chỉnh sửa truyện
        function div02_truyen_form_edit_form_exit_click() {
            document.getElementById('div02_truyen_form_edit').style.visibility = "hidden";
            document.getElementById('content').style.filter = "none";
            document.getElementById('content').style.pointerEvents = "auto";
            document.getElementById('content').style.userSelect = "auto";
            document.getElementById('div02_truyen_form_edit').style.top = "30%";
            document.getElementById('div02_truyen_form_edit').style.transition = "0s";
        }
        // Hiện thông báo xóa truyện
        function div02_truyen_list_table_delete_click(value) {
            document.getElementById('divreport_delete_truyen').style.visibility = "visible";
            document.getElementById('content').style.filter = "blur(10px)";
            document.getElementById('content').style.pointerEvents = "none";
            document.getElementById('content').style.userSelect = "none";
            document.getElementById('divreport_delete_truyen').style.transition = "0.5s";
            document.getElementById('divreport_delete_truyen').style.top = "30%";
            truyen_id = value;
        }
        // Chọn no để quay lại
        function divreport_delete_truyen_no() {
            document.getElementById('divreport_delete_truyen').style.visibility = "hidden";
            document.getElementById('content').style.filter = "none";
            document.getElementById('content').style.pointerEvents = "auto";
            document.getElementById('content').style.userSelect = "auto";
            document.getElementById('divreport_delete_truyen').style.transition = "0s";
            document.getElementById('divreport_delete_truyen').style.top = "10%";
        }
        // Chọn yes để xóa truyện
        function divreport_delete_truyen_yes() {
            divreport_delete_truyen_no();
            var xmlhttp;
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    // Cập nhật danh sách truyện sau khi xóa xong
                    div02_truyen_form_search_input_keyup("", 1);
                    // Hiện thông báo xóa thành công hoặc xóa thất bại
                    if (xmlhttp.responseText == '') {
                        divreport_success();
                    } else {
                        divreport_failed();
                    }
                }
            }
            xmlhttp.open("GET", "truyen_xuly_delete.php?truyen_id=" + truyen_id, true);
            xmlhttp.send();
        }
        // Thông tin truyện và danh sách chương
        function div02_truyen_list_table_list_click(value) {
            document.getElementById('div02_truyen').style.visibility = "hidden";
            document.getElementById('div02_truyen_chuong').style.visibility = "visible";
            truyen_id = value;

            var xmlhttp;
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById('div02_truyen_chuong').innerHTML = xmlhttp.responseText;
                    // Dùng khi người dùng ấn vào icon edit ở tổng hợp chương, nếu có ấn vào thì check_form_edit = 1, và thực thi trong if
                    if (check_form_edit == 1) {
                        div02_truyen_chuong_list_table_edit_click(value_chuong_id);
                        // Đặt lại biến cho lần sau
                        check_form_edit = "";
                        value_chuong_id = "";
                    }
                }
            }
            xmlhttp.open("GET", "truyen_chuong_xuly_list.php?truyen_id=" + truyen_id, true);
            xmlhttp.send();
        }

        /////----------------------------------------------------/////
        // CHƯƠNG

        // Tạo ra hai biến để dùng cho hàm bên dưới
        check_form_edit = "";
        value_chuong_id = "";
        // Ẩn đi các bảng và forn để đến Hiện form chỉnh sửa chương
        function div02_chuong_list_table_edit_click(value_truyen_id, value_c) {
            check_form_edit = 1;
            value_chuong_id = value_c;
            truyen_id = value_truyen_id;
            document.getElementById('div02_chuong').style.visibility = "hidden";
            div02_truyen_list_table_list_click(value_truyen_id);
        }
        // Hiện form thêm chương
        function div02_truyen_chuong_form_add_click() {
            document.getElementById('div02_chuong_button').style.visibility = "hidden";
            document.getElementById('div02_chuong_form_search').style.visibility = "hidden";
            document.getElementById('div02_truyen_thongtin').style.visibility = "hidden";
            document.getElementById('div02_truyen_chuong_list_table').style.visibility = "hidden";
            document.getElementById('div02_truyen_chuong_form_edit').style.visibility = "hidden";
            document.getElementById('div02_truyen_chuong_form_add').style.visibility = "visible";
            CKEDITOR.replace("truyen_chuong_noidung", {
                height: 800,
                filebrowserUploadUrl: 'http://localhost:8080/admin/upload.php',
                filebrowserUploadMethod: 'form'
            });
        }
        // Tạo chuong_id để dùng
        chuong_id = "";
        // Hiện form chỉnh sửa chương
        function div02_truyen_chuong_list_table_edit_click(value) {
            document.getElementById('div02_chuong_button').style.visibility = "hidden";
            document.getElementById('div02_chuong_form_search').style.visibility = "hidden";
            document.getElementById('div02_truyen_thongtin').style.visibility = "hidden";
            document.getElementById('div02_truyen_chuong_list_table').style.visibility = "hidden";
            document.getElementById('div02_truyen_chuong_form_add').style.visibility = "hidden";
            document.getElementById('div02_truyen_chuong_form_edit').style.visibility = "visible";
            chuong_id = value;

            var xmlhttp;
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("div02_truyen_chuong_form_edit").innerHTML += xmlhttp.responseText;
                    CKEDITOR.replace("truyen_chuong_noidung_edit", {
                        height: 800,
                        filebrowserUploadUrl: 'http://localhost:8080/admin/upload.php',
                        filebrowserUploadMethod: 'form'
                    });
                }
            }
            xmlhttp.open("GET", "truyen_chuong_xuly_edit_get.php?chuong_id=" + value, true);
            xmlhttp.send();
        }
        // Tìm kiếm chương của truyện
        function div02_chuong_form_search_input_keyup(chuong_name, truyen_id) {
            var xmlhttp;
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("div02_truyen_chuong_list").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "chuong_xuly_list.php?chuong_name=" + chuong_name + "&truyen_id=" + truyen_id, true);
            xmlhttp.send();
        }
        // Tìm kiếm chương của tổng hợp chương
        function div02_chuong_form_search(chuong_name) {
            var xmlhttp;
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("div02_chuong_list").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "tonghop_chuong_xuly_list.php?chuong_name=" + chuong_name, true);
            xmlhttp.send();
        }
        // Hiện thông báo xóa chương
        function div02_truyen_chuong_list_table_delete_click(value) {
            document.getElementById('divreport_delete_chuong').style.visibility = "visible";
            document.getElementById('content').style.filter = "blur(10px)";
            document.getElementById('content').style.pointerEvents = "none";
            document.getElementById('content').style.userSelect = "none";
            document.getElementById('divreport_delete_chuong').style.transition = "0.5s";
            document.getElementById('divreport_delete_chuong').style.top = "30%";
            chuong_id = value;
        }
        // Chọn no để quay lại
        function divreport_delete_chuong_no() {
            document.getElementById('divreport_delete_chuong').style.visibility = "hidden";
            document.getElementById('content').style.filter = "none";
            document.getElementById('content').style.pointerEvents = "auto";
            document.getElementById('content').style.userSelect = "auto";
            document.getElementById('divreport_delete_chuong').style.transition = "0s";
            document.getElementById('divreport_delete_chuong').style.top = "10%";
        }
        // Chọn yes để xóa chương
        function divreport_delete_chuong_yes() {
            divreport_delete_chuong_no();
            var xmlhttp;
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    div02_chuong_form_search_input_keyup("", truyen_id);
                    div02_chuong_form_search("");
                    if (xmlhttp.responseText == '') {
                        divreport_success();
                    } else {
                        divreport_failed();
                    }
                }
            }
            xmlhttp.open("GET", "chuong_xuly_delete.php?chuong_id=" + chuong_id, true);
            xmlhttp.send();
        }
        // Hiện thông báo 'thao tác thành công'
        function divreport_success() {
            document.getElementById('divreport_success').style.visibility = "visible";
            document.getElementById('divreport_success').style.transition = "0.5s";
            document.getElementById('divreport_success').style.bottom = "5%";
            setTimeout("divreport_success_timeout()", 2000);
        }
        // Ẩn thông báo 'thao tác thành công'
        function divreport_success_timeout() {
            document.getElementById('divreport_success').style.visibility = "hidden";
            document.getElementById('divreport_success').style.transition = "0.5s";
            document.getElementById('divreport_success').style.bottom = "-10%";
        }
        // Hiện thông báo 'thao tác thất bại'
        function divreport_failed() {
            document.getElementById('divreport_failed').style.visibility = "visible";
            document.getElementById('divreport_failed').style.transition = "0.5s";
            document.getElementById('divreport_failed').style.bottom = "5%";
            setTimeout("divreport_failed_timeout()", 2000);
        }
        // Ẩn thông báo 'thao tác thất bại'
        function divreport_failed_timeout() {
            document.getElementById('divreport_failed').style.visibility = "hidden";
            document.getElementById('divreport_failed').style.transition = "0.5s";
            document.getElementById('divreport_failed').style.bottom = "-10%";
        }

        /////----------------------------------------------------/////
        // THÀNH VIÊN

        // Hiện form thêm thành viên 
        function div02_thanhvien_add_click() {
            document.getElementById('div02_thanhvien_form_add').style.visibility = "visible";
            document.getElementById('content').style.filter = "blur(10px)";
            document.getElementById('content').style.pointerEvents = "none";
            document.getElementById('content').style.userSelect = "none";
            document.getElementById('div02_thanhvien_form_add').style.top = "50%";
            document.getElementById('div02_thanhvien_form_add').style.transition = "0.5s";
        }
        // Ẩn form thêm thành viên
        function div02_thanhvien_form_add_form_exit_click() {
            document.getElementById('div02_thanhvien_form_add').style.visibility = "hidden";
            document.getElementById('content').style.filter = "none";
            document.getElementById('content').style.pointerEvents = "auto";
            document.getElementById('content').style.userSelect = "auto";
            document.getElementById('div02_thanhvien_form_add').style.transition = "0s";
            document.getElementById('div02_thanhvien_form_add').style.top = "30%";
        }
        // Tìm kiếm thành viên
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
        // Tạo thanhvien_id để sử dụng
        var thanhvien_id = "";
        // Hiện form chỉnh sửa thành viên
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
        // Ẩn form chỉnh sửa thành viên
        function div02_thanhvien_form_edit_form_exit_click() {
            document.getElementById('div02_thanhvien_form_edit').style.visibility = "hidden";
            document.getElementById('content').style.filter = "none";
            document.getElementById('content').style.pointerEvents = "auto";
            document.getElementById('content').style.userSelect = "auto";
            document.getElementById('div02_thanhvien_form_edit').style.top = "30%";
            document.getElementById('div02_thanhvien_form_edit').style.transition = "0.5s";
        }
        // Hiện thông báo xóa thành viên
        function div02_thanhvien_list_table_delete_click(value) {
            document.getElementById('divreport_delete_thanhvien').style.visibility = "visible";
            document.getElementById('content').style.filter = "blur(10px)";
            document.getElementById('content').style.pointerEvents = "none";
            document.getElementById('content').style.userSelect = "none";
            document.getElementById('divreport_delete_thanhvien').style.transition = "0.5s";
            document.getElementById('divreport_delete_thanhvien').style.top = "30%";
            thanhvien_id = value;
        }
        // Chọn yes để delete thành viên
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
        // Chọn no để quay lại
        function divreport_delete_thanhvien_no() {
            document.getElementById('divreport_delete_thanhvien').style.visibility = "hidden";
            document.getElementById('content').style.filter = "none";
            document.getElementById('content').style.pointerEvents = "auto";
            document.getElementById('content').style.userSelect = "auto";
            document.getElementById('divreport_delete_thanhvien').style.transition = "0s";
            document.getElementById('divreport_delete_thanhvien').style.top = "10%";
        }
    </script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="lib/jquery.validate.min.js"></script>
    <script type="text/javascript" src="lib/select2.min.js"></script>
    <link href="lib/select2.min.css" rel="stylesheet" />

    <!-- THỂ LOẠI -->
    <script type="text/javascript">
        // Form thêm thể loại
        $(document).ready(function() {
            $("#div02_theloai_form_add").on("click", "#div02_theloai_form_add_form", function() {
                $("#div02_theloai_form_add_form").validate({
                    rules: {
                        theloai_name: {
                            required: true,
                            maxlength: 255,
                            remote: "theloai_check_name_exist.php?theloai_id=no_value"
                        }
                    },
                    messages: {
                        theloai_name: {
                            required: "Bạn chưa nhập tên thể loại",
                            maxlength: "Tên thể loại không quá 255 kí tự",
                            remote: "Tên thể loại đã tồn tại"
                        }
                    },
                    submitHandler: function(form) {
                        $('#div02_theloai_form_add_form').on('submit', function(e) {
                            e.preventDefault();
                            $.ajax({
                                url: "theloai_xuly_add.php",
                                method: "POST",
                                data: new FormData(this),
                                contentType: false,
                                cache: false,
                                processData: false,
                                success: function(data) {
                                    // Ẩn form thêm thể loại
                                    div02_theloai_form_add_form_exit_click();
                                    // Hiện danh sách thể loại
                                    div02_theloai_form_search_input_keyup("", 1);
                                    // Load lại form thêm thể loại
                                    $("#div02_theloai_form_add").load(" #div02_theloai_form_add > *");
                                }
                            });
                        });
                    }
                });
            });
            // Form chỉnh sửa thể loại
            $("#div02_theloai_form_edit").on("click", "#div02_theloai_form_edit_form", function() {
                $("#div02_theloai_form_edit_form").validate({
                    rules: {
                        theloai_name: {
                            required: true,
                            maxlength: 255,
                            remote: "theloai_check_name_exist.php?theloai_id=" + theloai_id
                        }
                    },
                    messages: {
                        theloai_name: {
                            required: "Bạn chưa nhập tên thể loại",
                            maxlength: "Tên thể loại không quá 255 kí tự",
                            remote: "Tên thể loại đã tồn tại"
                        }
                    },
                    submitHandler: function(form) {
                        $('#div02_theloai_form_edit_form').on('submit', function(e) {
                            e.preventDefault();
                            $.ajax({
                                url: "theloai_xuly_edit_send.php?theloai_id=" + theloai_id,
                                method: "POST",
                                data: new FormData(this),
                                contentType: false,
                                cache: false,
                                processData: false,
                                success: function(data) {
                                    div02_theloai_form_edit_form_exit_click();
                                    div02_theloai_form_search_input_keyup("", 1);
                                }
                            });
                        });
                    }
                });
            });
        });
        // Hiển thị ảnh khi chọn ảnh trong div02_theloai_form_add
        function div02_theloai_form_add_form_hinhanh_change() {
            div02_theloai_form_add_form_hinhanh_img.src = "";
            div02_theloai_form_add_form_hinhanh_img.src = URL.createObjectURL(event.target.files[0]);
        }
        // Hiển thị ảnh khi chọn ảnh trong div02_theloai_form_edit
        function div02_theloai_form_edit_form_hinhanh_change() {
            div02_theloai_form_edit_form_hinhanh_img.src = "";
            div02_theloai_form_edit_form_hinhanh_img.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>

    <!-- TÁC GIẢ -->
    <script type="text/javascript">
        // Thêm rule cho Ngày sinh
        $.validator.addMethod("minAge", function(value, element, min) {
            var today = new Date();
            var birthDate = new Date(value);
            var age = today.getFullYear() - birthDate.getFullYear();

            if (age > min + 1) {
                return true;
            }

            var m = today.getMonth() - birthDate.getMonth();

            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            return age >= min;
        }, "You are not old enough!");

        $(document).ready(function() {
            // Form thêm tác giả
            $("#div02_tacgia_form_add").on("click", "#div02_tacgia_form_add_form", function() {
                $("#div02_tacgia_form_add_form").validate({
                    rules: {
                        tacgia_hoten: {
                            required: true,
                            maxlength: 255,
                            remote: "tacgia_check_hoten_exist.php?tacgia_id=no_value"
                        },
                        tacgia_ngaysinh: {
                            required: true,
                            date: true,
                            minAge: 10
                        }
                    },
                    messages: {
                        tacgia_hoten: {
                            required: "Bạn chưa nhập họ và tên tác giả",
                            maxlength: "Tên tác giả không quá 255 kí tự",
                            remote: "Tên tác giả đã tồn tại"
                        },
                        tacgia_ngaysinh: {
                            required: "Bạn chưa nhập ngày sinh tác giả",
                            date: "Chưa đúng định dạng ngày sinh (dd/mm/yyyy)",
                            minAge: "Có vẻ ngày sinh tác giả đã sai"
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
                                    // Ẩn đi form thêm tác giả
                                    div02_tacgia_form_add_form_exit_click();
                                    // Hiện danh sách tác giả
                                    div02_tacgia_form_search_input_keyup("", 1);
                                    // Load lại form thêm tác giả 
                                    $("#div02_tacgia_form_add").load(" #div02_tacgia_form_add > *");
                                }
                            });
                        });
                    }
                });
            });
            // Form chỉnh sửa tác giả
            $("#div02_tacgia_form_edit").on("click", "#div02_tacgia_form_edit_form", function() {
                $("#div02_tacgia_form_edit_form").validate({
                    rules: {
                        tacgia_hoten: {
                            required: true,
                            maxlength: 255,
                            remote: "tacgia_check_hoten_exist.php?tacgia_id=" + tacgia_id
                        },
                        tacgia_ngaysinh: {
                            required: true,
                            date: true,
                            minAge: 10
                        }
                    },
                    messages: {
                        tacgia_hoten: {
                            required: "Bạn chưa nhập họ và tên tác giả",
                            maxlength: "Tên tác giả không quá 255 kí tự",
                            remote: "Tên tác giả đã tồn tại"
                        },
                        tacgia_ngaysinh: {
                            required: "Bạn chưa nhập ngày sinh tác giả",
                            date: "Chưa đúng định dạng ngày sinh (dd/mm/yyyy)",
                            minAge: "Có vẻ ngày sinh tác giả đã sai"
                        }
                    },
                    submitHandler: function(form) {
                        $('#div02_tacgia_form_edit_form').on('submit', function(e) {
                            e.preventDefault();
                            $.ajax({
                                url: "tacgia_xuly_edit_send.php?tacgia_id=" + tacgia_id,
                                method: "POST",
                                data: new FormData(this),
                                contentType: false,
                                cache: false,
                                processData: false,
                                success: function(data) {
                                    // Ẩn form chỉnh sửa tác giả
                                    div02_tacgia_form_edit_form_exit_click();
                                    // Hiện danh sách tác giả
                                    div02_tacgia_form_search_input_keyup("", 1);
                                }
                            });
                        });
                    }
                });
            });
        });
        // Hiển thị ảnh khi chọn ảnh trong div02_tacgia_form_add
        function div02_tacgia_form_add_form_hinhanh_change() {
            div02_tacgia_form_add_form_hinhanh_img.src = "";
            div02_tacgia_form_add_form_hinhanh_img.src = URL.createObjectURL(event.target.files[0]);
        }
        // Hiển thị ảnh khi chọn ảnh trong div02_tacgia_form_edit
        function div02_tacgia_form_edit_form_hinhanh_change() {
            div02_tacgia_form_edit_form_hinhanh_img.src = "";
            div02_tacgia_form_edit_form_hinhanh_img.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>

    <!-- Truyện -->
    <script type="text/javascript">
        // Form thêm truyện
        $(document).ready(function() {
            // Khi gọi ajax thì validate form dưới đây sẽ không hoạt động vì vậy cần bắt thêm 1 sự kiện khi người dùng gọi ajax
            $("#div02_truyen_form_add").on("click", "#div02_truyen_form_add_form", function() {
                $("#div02_truyen_form_add_form").validate({
                    rules: {
                        truyen_name: {
                            required: true,
                            maxlength: 255,
                            remote: "truyen_check_name_exist.php?truyen_id=no_value"
                        },
                        "truyen_select_tacgia[]": {
                            required: true
                        },
                        "truyen_select_theloai[]": {
                            required: true
                        }
                    },
                    messages: {
                        truyen_name: {
                            required: "Bạn chưa nhập tên truyện",
                            maxlength: "Tên truyện không quá 255 kí tự",
                            remote: "Tên truyện đã tồn tại"
                        },
                        "truyen_select_tacgia[]": {
                            required: "Bạn chưa chọn tác giả"
                        },
                        "truyen_select_theloai[]": {
                            required: "Bạn chưa chọn thể loại"
                        }
                    },
                    submitHandler: function(form) {
                        $('#div02_truyen_form_add_form').on('submit', function(e) {
                            e.preventDefault();
                            $.ajax({
                                url: "truyen_xuly_add.php",
                                method: "POST",
                                data: new FormData(this),
                                contentType: false,
                                cache: false,
                                processData: false,
                                success: function(data) {
                                    // Đóng form thêm truyện
                                    div02_truyen_form_add_form_exit_click();
                                    // Trở về và gọi list trang đầu tiên
                                    div02_truyen_form_search_input_keyup("", 1);
                                    // Reload lại form thêm truyện nếu không sẽ gửi nhiều form chồng lẫn nhau
                                    $("#div02_truyen_form_add").load(" #div02_truyen_form_add > *", function() {
                                        // Vì khi reload lại form thêm truyện thì select2 không hoạt động, cần đặt lại select2
                                        truyen_select_tacgia_theloai();
                                    });
                                    // Hiện thông báo thêm thành công or thêm thất bại
                                    if (data == "") {
                                        divreport_success();
                                    } else {
                                        divreport_failed();
                                    }
                                }
                            })
                        });
                    }
                });
            });
            // Form chỉnh sửa truyện
            $("#div02_truyen_form_edit").on("click", "#div02_truyen_form_edit_form", function() {
                $("#div02_truyen_form_edit_form").validate({
                    rules: {
                        truyen_name: {
                            required: true,
                            maxlength: 255,
                            remote: "truyen_check_name_exist.php?truyen_id=" + truyen_id
                        },
                        "truyen_select_tacgia[]": {
                            required: true
                        },
                        "truyen_select_theloai[]": {
                            required: true
                        }
                    },
                    messages: {
                        truyen_name: {
                            required: "Bạn chưa nhập tên truyện",
                            maxlength: "Tên truyện không quá 255 kí tự",
                            remote: "Tên truyện đã tồn tại"
                        },
                        "truyen_select_tacgia[]": {
                            required: "Bạn chưa chọn tác giả"
                        },
                        "truyen_select_theloai[]": {
                            required: "Bạn chưa chọn thể loại"
                        }
                    },
                    submitHandler: function(form) {
                        $('#div02_truyen_form_edit_form').on('submit', function(e) {
                            e.preventDefault();
                            $.ajax({
                                url: "truyen_xuly_edit_send.php?truyen_id=" + truyen_id,
                                method: "POST",
                                data: new FormData(this),
                                contentType: false,
                                cache: false,
                                processData: false,
                                success: function(data) {
                                    // Ẩn form chỉnh sửa truyện
                                    div02_truyen_form_edit_form_exit_click();
                                    // Hiện ra danh sách truyện
                                    div02_truyen_form_search_input_keyup("", 1);
                                    // Hiện thông báo thêm thành công or thêm thất bại
                                    if (data == "") {
                                        divreport_success();
                                    } else {
                                        divreport_failed();
                                    }
                                }
                            });
                        });
                    }
                });
            });
        });
        // Phần select tác giả và thể loại của truyện
        function truyen_select_tacgia_theloai() {
            // Truyện select tác giả - add
            var $truyen_select_tacgia_add = $(".div02_truyen_form_add_form_select_tacgia").select2({
                placeholder: "Chọn tác giả",
                allowClear: true
            });
            $truyen_select_tacgia_add.on('change', function() {
                $(this).trigger('blur');
            });
            // Truyện select thể loại - add
            var $truyen_select_theloai_add = $(".div02_truyen_form_add_form_select_theloai").select2({
                placeholder: "Chọn thể loại",
                allowClear: true
            });
            $truyen_select_theloai_add.on('change', function() {
                $(this).trigger('blur');
            });
            // Truyện select tác giả - edit
            var $truyen_select_tacgia_edit = $(".div02_truyen_form_edit_form_select_tacgia").select2({
                placeholder: "Chọn tác giả",
                allowClear: true
            });
            $truyen_select_tacgia_edit.on('change', function() {
                $(this).trigger('blur');
            });
            // Truyện select thể loại - edit
            var $truyen_select_theloai_edit = $(".div02_truyen_form_edit_form_select_theloai").select2({
                placeholder: "Chọn thể loại",
                allowClear: true
            });
            $truyen_select_theloai_edit.on('change', function() {
                $(this).trigger('blur');
            });
        }
        // Cần gọi select2 lúc đầu, sau khi thêm 1 truyện muốn thêm 1 truyện nữa thì ready này không còn hoạt động mà sẽ dùng bên trên
        $(document).ready(function select_tacgia() {
            truyen_select_tacgia_theloai();
        });
        // Hiển thị ảnh khi chọn ảnh trong div02_truyen_form_add
        function div02_truyen_form_add_form_hinhanh_change() {
            div02_truyen_form_add_form_hinhanh_img.src = "";
            div02_truyen_form_add_form_hinhanh_img.src = URL.createObjectURL(event.target.files[0]);
        }
        // Hiển thị ảnh khi chọn ảnh trong div02_truyen_form_edit
        function div02_truyen_form_edit_form_hinhanh_change() {
            div02_truyen_form_edit_form_hinhanh_img.src = "";
            div02_truyen_form_edit_form_hinhanh_img.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>

    <!-- Chương -->
    <script type="text/javascript">
        // Form thêm chương
        $(document).ready(function() {
            /* ready chỉ được kích hoạt trước lúc tải xong tài liệu, gọi Ajax thì nội dung không dùng được ready, vì vậy phải thêm dòng dưới */
            $("#div02").on("click", "#div02_truyen_chuong_form_add_form", function() {
                $("#div02_truyen_chuong_form_add_form").validate({
                    rules: {
                        truyen_chuong_sochuong: {
                            required: true,
                            maxlength: 10,
                            number: true,
                            remote: "truyen_chuong_check_sochuong_exist.php?truyen_id=" + truyen_id + "&chuong_id=no_value"
                        },
                        truyen_chuong_name: {
                            required: true,
                            maxlength: 255
                        }
                    },
                    messages: {
                        truyen_chuong_sochuong: {
                            required: "Bạn chưa nhập số chương",
                            maxlength: "Có vẻ bạn đang nhập số chương qua lớn",
                            number: "Bạn chỉ được nhập số",
                            remote: "Số chương này đã tồn tại"
                        },
                        truyen_chuong_name: {
                            required: "Bạn chưa nhập tên chương",
                            maxlength: "Tên chương không vượt quá 255 kí tự"
                        }
                    },
                    submitHandler: function(form) {
                        $('#div02_truyen_chuong_form_add_form').on('submit', function(e) {
                            e.preventDefault();
                            $.ajax({
                                url: "truyen_chuong_xuly_add.php?truyen_id=" + truyen_id,
                                method: "POST",
                                data: new FormData(this),
                                contentType: false,
                                cache: false,
                                processData: false,
                                success: function(data) {
                                    // Hiển thị trang thông tin truyện và danh sách chương khi thêm chương mới xong
                                    div02_truyen_list_table_list_click(truyen_id);
                                    // Hiện thông báo thêm thành công or thêm thất bại
                                    if (data == "") {
                                        divreport_success();
                                    } else {
                                        divreport_failed();
                                    }
                                }
                            });
                        });
                    }
                });
            });
            // Form chỉnh sửa chương
            $("#div02").on("click", "#div02_truyen_chuong_form_edit_form", function() {
                $("#div02_truyen_chuong_form_edit_form").validate({
                    rules: {
                        truyen_chuong_sochuong: {
                            required: true,
                            maxlength: 10,
                            number: true,
                            remote: "truyen_chuong_check_sochuong_exist.php?truyen_id=" + truyen_id + "&chuong_id=" + chuong_id
                        },
                        truyen_chuong_name: {
                            required: true,
                            maxlength: 255
                        }
                    },
                    messages: {
                        truyen_chuong_sochuong: {
                            required: "Bạn chưa nhập số chương",
                            maxlength: "Có vẻ bạn đang nhập số chương qua lớn",
                            number: "Bạn chỉ được nhập số",
                            remote: "Số chương này đã tồn tại"
                        },
                        truyen_chuong_name: {
                            required: "Bạn chưa nhập tên chương",
                            maxlength: "Tên chương không vượt quá 255 kí tự"
                        }
                    },
                    submitHandler: function(form) {
                        $('#div02_truyen_chuong_form_edit_form').on('submit', function(e) {
                            e.preventDefault();
                            $.ajax({
                                url: "truyen_chuong_xuly_edit_send.php?chuong_id=" + chuong_id,
                                method: "POST",
                                data: new FormData(this),
                                contentType: false,
                                cache: false,
                                processData: false,
                                success: function(data) {
                                    // Hiển thị trang thông tin truyện và danh sách chương khi chỉnh sửa xong
                                    div02_truyen_list_table_list_click(truyen_id);
                                    // Hiện thông báo thêm thành công or thêm thất bại
                                    if (data == "") {
                                        divreport_success();
                                    } else {
                                        divreport_failed();
                                    }
                                }
                            });
                        });
                    }
                });
            });
        });
    </script>

    <!-- THÀNH VIÊN -->
    <script type="text/javascript">
        $(document).ready(function() {
            // Form thêm thành viên
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
                                // Ẩn đi form thêm thành viên
                                div02_thanhvien_form_add_form_exit_click();
                                // Hiện ra danh sách thành viên
                                div02_thanhvien_form_search_input_keyup("", 1);
                            }
                        });
                    });
                }
            });
            // Form chỉnh sửa thành viên
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
                                    // Ẩn đi form chỉnh sửa thành viên
                                    div02_thanhvien_form_edit_form_exit_click();
                                    // Hiện danh sách thành viên
                                    div02_thanhvien_form_search_input_keyup("", 1);
                                }
                            });
                        });
                    }
                });
            });
        });
        // Hiển thị ảnh khi chọn ảnh trong form edit user
        function div02_thanhvien_form_edit_form_hinhanh_change() {
            div02_thanhvien_form_edit_form_hinhanh_img.src = "";
            div02_thanhvien_form_edit_form_hinhanh_img.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
</body>

</html>