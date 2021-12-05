<?php
$truyen_name = $_GET['truyen_name'];
$conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
$conn->set_charset("utf8");
$sql = "SELECT TRUYEN_ID FROM truyen where TRUYEN_NAME like '$truyen_name'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
if($result->num_rows > 0 ){
    if( $row['TRUYEN_ID'] != $_GET['truyen_id']){
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