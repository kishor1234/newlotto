<?php

$allowed_extension = array("jpg", "gif", "png");
if (in_array(end($_FILES['upload']['name']), $allowed_extension)) {
    $uploadDir = "assets/upload/CKEDITOR";
    chmod($uploadDir, 0777);
    $tmpFile = $_FILES['upload']['tmp_name'];
    $name = time() . '-' . $_FILES['upload']['name'];
    $filename = $uploadDir . '/' . $name;
    $path = getcwd() . "/" . $filename;
    move_uploaded_file($tmpFile, $path);
    $function_number = $_GET['CKEditorFuncNum'];
    $url = $filename;
    $message = '';
    echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($function_number, '$url', '$message');</script>";
}
?>