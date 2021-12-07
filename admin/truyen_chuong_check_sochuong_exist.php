<?php
$chuong_id = $_GET['chuong_id'];
$truyen_id = $_GET['truyen_id'];
$chuong_stt = $_GET['truyen_chuong_sochuong'];
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
$sql = "SELECT CHUONG_ID FROM chuong where TRUYEN_ID='$truyen_id' and CHUONG_STT='$chuong_stt'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
if($result->num_rows > 0 ){
    if( $row['CHUONG_ID'] != $chuong_id){
        echo json_encode(false);
    }
    else {
        echo json_encode(true);
    }
}
else{
    echo json_encode(true);
}
$conn->close();
?>