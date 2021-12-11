<?php
// Dữ liệu GET
$truyen_name = $_GET['truyen_name'];
if ($truyen_name != "") {
    // Connect Mysql
    $conn = new mysqli("localhost", "root", "", "db_web_truyen_tranh");
    $conn->set_charset("utf8");
    // SQL list chương của truyện
    $sql_truyen_search = "SELECT TRUYEN_ID, TRUYEN_NAME, TRUYEN_HINHANH FROM truyen WHERE TRUYEN_NAME like '%$truyen_name%' LIMIT 5";
    $result_truyen_search = $conn->query($sql_truyen_search);
    if ($result_truyen_search->num_rows > 0) {
        echo "<ul style='list-style-type: none;'>";
        while ($row_truyen_search = $result_truyen_search->fetch_assoc()) {
            echo "<li>
                <a href='#' onclick='page_truyen(".$row_truyen_search['TRUYEN_ID'].")'>
                <img src='" . $row_truyen_search['TRUYEN_HINHANH'] . "'><p>" . $row_truyen_search['TRUYEN_NAME'] . "</p>
                </a>
                </li>";
        }
        echo "</ul>";
    }
}
