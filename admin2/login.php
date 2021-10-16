<?php
header('Cache-Control: no-cache, no-store, must-revalidate'); //HTTP 1.1
header('Pragma: no-cache'); //HTTP 1.0
header('Expires: 0'); // Date in the past
session_start();
if (isset($_COOKIE['username']) and isset($_COOKIE['pass'])) {
    header('location:admin.php');
} else if (isset($_SESSION['username']) and isset($_SESSION['pass'])) {
    header('location:admin.php');
}
?>
<html>

<head>
    <meta charset="utf-8">
    <title>Đăng nhập</title>
    <link rel="icon" href="login.ico" size="64x64">
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <div id="divcenter">
        <h1>Đăng Nhập</h1>
        <table border="0">
            <form id="form" method="POST" enctype='multipart/form-data' onreset='return check2()'>
                <tr>
                    <td>
                        <input id="user" class="input" type="text" name="username" autocomplete="off" placeholder="Tài khoản đăng nhập">
                        <p id="thep1">Bạn chưa nhập Tài khoản đăng nhập</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input id="pass" class="input" type="password" name="password" autocomplete="off" placeholder="Mật khẩu">
                        <p id="thep2">Bạn chưa nhập mật khẩu</p>
                    </td>
                </tr>
                <tr>
                    <th id="submit"><input id="dangnhap" type="submit" name="submit" value="Đăng Nhập"> <input id="reset" type="reset" name="reset" value="Làm mới"></th>
                </tr>
            </form>
        </table>
    </div>
    <div id="divreport">
        <h3>Bạn đã nhập sai Tài khoản hoặc Mật khẩu đăng nhập!!!</h3>
        <button id="bt" type="button" onclick="return ok();">OK</button>
    </div>
    <script>
        function check2() {
            document.getElementById('thep1').style.visibility = "hidden";
            document.getElementById('thep2').style.visibility = "hidden";
        }

        function ok() {
            document.getElementById('divreport').style.visibility = "hidden";
            document.getElementById('divcenter').style.filter = "none";
            document.getElementById('divcenter').style.pointerEvents = "auto";
            document.getElementById('divcenter').style.userSelect = "auto";
            document.getElementById('divreport').style.transition = "0s";
            document.getElementById('divreport').style.top = "20%";
        }
    </script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script>
        $("#form").submit(function(event) {
            event.preventDefault();
            var x = document.getElementById("user").value;
            var y = document.getElementById("pass").value;
            console.log(x);
            console.log(y);
            $.ajax({
                type: "POST",
                url: './login_xuly.php',
                data: $(this).serializeArray(),
                success: function(response) {
                    console.log("resopnse: ", response);
                    response = JSON.parse(response);
                    if (response.status == 0) {
                        if (x != "" && y != "") {
                            document.getElementById('divreport').style.visibility = "visible";
                            document.getElementById('thep1').style.visibility = "hidden";
                            document.getElementById('thep2').style.visibility = "hidden";
                            document.getElementById('divcenter').style.filter = "blur(20px)";
                            document.getElementById('divcenter').style.pointerEvents = "none";
                            document.getElementById('divcenter').style.userSelect = "none";
                            document.getElementById('divreport').style.top = "40%";
                            document.getElementById('divreport').style.transition = "0.5s";
                        } else if (x == "" && y != "") {
                            document.getElementById('thep1').style.visibility = "visible";
                            document.getElementById('thep2').style.visibility = "hidden";
                        } else if (x != "" && y == "") {
                            document.getElementById('thep1').style.visibility = "hidden";
                            document.getElementById('thep2').style.visibility = "visible";
                        } else if (x == "" && y == "") {
                            document.getElementById('thep1').style.visibility = "visible";
                            document.getElementById('thep2').style.visibility = "visible";
                        }
                    } else {
                        location.pathname = "admin2/admin.php";
                    }
                }
            });
        });
    </script>
</body>

</html>