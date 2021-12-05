<?php
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
if (!isset($_COOKIE['username']) and !isset($_COOKIE['pass'])) {
  exit();
}
$id = $_COOKIE['id'];
$username = $_COOKIE['username'];
$pass = $_COOKIE['pass'];
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
$sql = "select ADMIN_USERNAME from admin where ADMIN_ID='$id' and ADMIN_USERNAME='$username' and ADMIN_MATKHAU=md5('$pass') and ADMIN_LEVEL=0";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  $truyen_id = $_GET['truyen_id'];
  $sql_edit = "SELECT * FROM truyen where TRUYEN_ID='$truyen_id'";
  $result_truyen_select_tacgia = mysqli_query($conn, "SELECT TACGIA_ID, TACGIA_HOTEN FROM tacgia");
  $result_truyen_select_theloai = mysqli_query($conn, "SELECT THELOAI_ID, THELOAI_NAME FROM theloai");

  $result_truyen_tacgia = mysqli_query($conn, "SELECT TACGIA_ID FROM `truyen_tacgia` WHERE TRUYEN_ID = '$truyen_id'");
  $result_truyen_theloai = mysqli_query($conn, "SELECT THELOAI_ID FROM `truyen_theloai` WHERE TRUYEN_ID = '$truyen_id'");
  
  $truyen_tacgia = array();
  while($row_truyen_tacgia = $result_truyen_tacgia->fetch_assoc()) {
    $truyen_tacgia[] = $row_truyen_tacgia['TACGIA_ID'];
  }

  $truyen_theloai = array();
  while($row_truyen_theloai = $result_truyen_theloai->fetch_assoc()) {
    $truyen_theloai[] = $row_truyen_theloai['THELOAI_ID'];
  }
  
  $result_edit = $conn->query($sql_edit);
  $row = $result_edit->fetch_assoc();
  if ($result_edit->num_rows > 0) {
    echo '<form id="div02_truyen_form_edit_form" method="POST" enctype="multipart/form-data" autocomplete="off">
        <table border="0">
            <tr>
                <td rowspan="7"><label for="div02_truyen_form_edit_form_hinhanh"><img src="'.$row['TRUYEN_HINHANH'].'" alt="Bạn chưa chọn ảnh, sẽ tự động dùng ảnh mặc định!" id="div02_truyen_form_edit_form_hinhanh_img" width="450" height="450"></label>
                    <input type="file" id="div02_truyen_form_edit_form_hinhanh" name="truyen_hinhanh" onchange="div02_truyen_form_edit_form_hinhanh_change()" accept=".jpg, .jpeg, .png" style="visibility:hidden;">
                </td>
                <td><input type="text" class="div02_truyen_form_edit_form_input" name="truyen_name" value="'.$row['TRUYEN_NAME'].'" placeholder="Nhập tên truyện"></td>
            </tr>
            <tr>
                <td>
                    <select class="div02_truyen_form_edit_form_select_tacgia" name="truyen_select_tacgia[]" multiple="multiple">';
                        while($row_truyen_select_tacgia = $result_truyen_select_tacgia->fetch_assoc()) {
                            echo '<option value="'.$row_truyen_select_tacgia['TACGIA_ID'].'" ';
                                if(in_array($row_truyen_select_tacgia['TACGIA_ID'], $truyen_tacgia)){
                                    echo 'selected';
                                } 
                            echo '>'.$row_truyen_select_tacgia['TACGIA_HOTEN'].'</option>';
                        }
            echo   '</select>
                </td>
            </tr>
            <tr>
                <td>
                    <select class="div02_truyen_form_edit_form_select_theloai" name="truyen_select_theloai[]" multiple="multiple">';
                        while($row_truyen_select_theloai = $result_truyen_select_theloai->fetch_assoc()) {
                            echo '<option value="'.$row_truyen_select_theloai['THELOAI_ID'].'" ';
                                if(in_array($row_truyen_select_theloai['THELOAI_ID'], $truyen_theloai)){
                                    echo 'selected';
                                } 
                            echo '>'.$row_truyen_select_theloai['THELOAI_NAME'].'</option>';
                        }
            echo   '</select>
                </td>
            </tr>
            <tr>
                <td><label>Trạng thái: </label>
                    <select name="truyen_trangthai" style="margin-top:30px;">
                    <option value="0" >Drop</option>
                    <option value="1" >Đang ra</option>
                    <option value="2" >Hoàn thành</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><textarea rows="15" cols="65" style="margin-top:5px; padding:5px;" name="truyen_mota" placeholder="Mô tả truyện">'.$row['TRUYEN_MOTA'].'</textarea> </td>
            </tr>
            <tr>
                <td><input id="div02_truyen_form_edit_form_submit" class="div02_form_submit" type="submit" value="Đăng kí" name="submit">
                    <input id="div02_truyen_form_edit_form_exit" class="div02_form_exit" type="button" value="Thoát" onclick="div02_truyen_form_edit_form_exit_click()">
                </td>
            </tr>
        </table>
    </form>';
  }
} else {
  exit();
}
$conn->close();
