<?php
    session_start();
    $tendangnhap = $_POST['username'];
	$pass = $_POST['password'];

	$conn = new mysqli("localhost","root","","web_truyen_tranh");
	$conn->set_charset("utf8");
	$sql = "select * from nguoidung where tendangnhap='$tendangnhap' and matkhau=md5('$pass')";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	if($result->num_rows > 0 ){
		setcookie('id',$row['id'],time()+3600,'/','',0,0);
		setcookie('username',$tendangnhap,time()+3600,'/','',0,0);
		setcookie('pass',$pass,time()+3600,'/','',0,0);
		$_SESSION['id'] = $row['id'];
		$_SESSION['username'] = $tendangnhap;
		$_SESSION['pass'] = $pass;

		echo json_encode(array(
			'status' => 1 , 
			'mesage' => 'Thông tin đăng nhập đúng!!!'
		));
		exit;
    }
	else{
		echo json_encode(array(
			'status' => 0 , 
			'mesage' => 'Thông tin đăng nhập không đúng!!!'
		));
		exit;
	}
	$conn->close();
?>