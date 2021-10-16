<?php
  //Lay du lieu ve
  $tendangnhap = $_POST['username'];
  $password = $_POST['pass'];
  $passcon = $_POST['passagain'];
  if($tendangnhap != '' && $password != '' && $passcon != ''){
      if($password==$passcon){
          $conn = new mysqli("localhost","root","","db_web_truyen_tranh");
	      $conn->set_charset("utf8");
	      //Ma hoa chuoi bang md5
	      $SQL = "Select NGUOIDUNG_USERNAME from nguoidung where NGUOIDUNG_USERNAME='$tendangnhap'";
	      $RESULT = $conn->query($SQL);
	      //echo $RESULT->num_rows;
	      if($RESULT->num_rows == 0 /*&& $RESULT != false*/){
	          $password = md5($password);
	          $sql = "INSERT INTO nguoidung(NGUOIDUNG_USERNAME,NGUOIDUNG_MATKHAU) values('$tendangnhap','$password')";
	          $result = $conn->query($sql);
	          $conn->close();
		      header('location:login.php');
	      }
	      else{
		      echo "<h2>Tên đăng nhập đã tồn tại trong CSDL!!!</h2>";
	      }
	  }
	  else{
		  echo "<h2>Bạn gõ lại mật khẩu không đúng!!!</h2>";
	  }
  }
  //Neu nguoi dung nhap khong du thong tin thi tro lai trang cu
  else{
     //header('Location:buoi1_bt2_Form.html');
	 echo"<h2>Bạn phải nhập đủ thông tin!!!</h2>";
  }
?>