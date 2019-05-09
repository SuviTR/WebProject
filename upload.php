<?php
/**
 * User: SuviTR
 * Date: 9.5.2019
 * Time: 13.51
 */
function uploadImage(){

    $target_dir = "img/";
    $target_file = $target_dir . basename($_FILES["upload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $rows['file'] = $target_file;
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["upload"]["tmp_name"]);
        if($check !== false) {
            $rows['Message'] =  "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            $rows['Message'] =  "File is not an image.";
            $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        $rows['Message'] =  "File already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["upload"]["size"] > 500000) {
        $rows['Message'] =  "File is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        $rows['Message'] =  "Only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $rows['Message'] =  "File was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {
            $rows['Message'] =  "The file ". basename( $_FILES["upload"]["name"]). " has been uploaded.";
        } else {
            $rows['Message'] =  "There was an error uploading your file.";
        }
    }

    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($rows);

}
?>