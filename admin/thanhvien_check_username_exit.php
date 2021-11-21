<?php
$username = $_GET['username'];
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
$sql = "SELECT ADMIN_USERNAME FROM admin where ADMIN_USERNAME like '$username'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
if($result->num_rows > 0 ){
    echo json_encode(false);
}
else{
    echo json_encode(true);
}
$conn->close();
?>