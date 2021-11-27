<?php
$theloai_name = $_GET['theloai_name'];
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
$sql = "SELECT THELOAI_ID FROM theloai where THELOAI_NAME like '$theloai_name'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
if($result->num_rows > 0 ){
    if( $row['THELOAI_ID'] != $_GET['theloai_id']){
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