<?php

// Parameters
$CKEditor = $_GET['CKEditor'];
$funcNum = $_GET['CKEditorFuncNum'];

$allowed_extension = array(
    "png", "jpg", "jpeg"
);

// Get image file extension
$file_extension = pathinfo($_FILES["upload"]["name"], PATHINFO_EXTENSION);

if (in_array(strtolower($file_extension), $allowed_extension)) {

    if (move_uploaded_file($_FILES['upload']['tmp_name'], "hinhanhchuong/" . $_FILES['upload']['name'])) {
        // File path
        if (isset($_SERVER['HTTPS'])) {
            $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
        } else {
            $protocol = 'http';
        }
        $url = $protocol . "://" . $_SERVER['SERVER_NAME'] . ":8080/admin/hinhanhchuong/" . $_FILES['upload']['name'];

        echo '<script>window.parent.CKEDITOR.tools.callFunction(' . $funcNum . ', "' . $url . '", "")</script>';
    }
}
