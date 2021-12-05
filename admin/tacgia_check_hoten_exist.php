<?php
$tacgia_hoten = $_GET['tacgia_hoten'];
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
$sql = "SELECT TACGIA_ID FROM tacgia where TACGIA_HOTEN like '$tacgia_hoten'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
if($result->num_rows > 0 ){
    if( $row['TACGIA_ID'] != $_GET['tacgia_id']){
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