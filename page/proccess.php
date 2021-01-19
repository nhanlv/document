<?php

require('./../config/config.php');
$db = new db();
$Api = $_POST['Api'];
if ($Api == 'UPLOAD_FILE') {
    $files = json_decode($_POST['files']);
    $db->Query("DELETE FROM file_upload");
    foreach ($files as $file) {
        $dataurl = $file->src;
        $filename = $file->filename;
        if (!empty($filename)) {
            $slCode = "INSERT INTO file_upload (`name`, `dataurl`) VALUES ('" . $filename . "','" . $dataurl . "');";
            echo $db->Query($slCode);
        } else {
            echo TRUE;
        }
    }
}




