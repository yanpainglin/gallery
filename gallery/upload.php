<?php
session_start();
$id= $_SESSION['id'];
if (isset($_POST['submit'])){
    include_once 'include_files/dbh.php';
    $title=$_POST['title'];
    $description=$_POST['description'];
    $file= $_FILES['file'];

    $filename = $_FILES['file']['name'];
    $tmp_name = $_FILES['file']['tmp_name'];
    $fileError = $_FILES['file']['error'];
    $fileSize = $_FILES['file']['size'];
 foreach ($filename as $item=>$value){
    $fileExt = explode('.', $value);
    $fileActExt =strtolower(end($fileExt));
    $allowed =['jpg', 'png', 'jpeg'];
    if(!in_array($fileActExt, $allowed)){
        header("location:gallery.php?unsupported_filetype");
        exit();
    }else{
        if($fileSize[$item] >10000000){
            header("location:gallery.php?large_file_error");
            exit();
        }else{
            $file = uniqid('gallery').'.'.$fileActExt;
            move_uploaded_file($tmp_name[$item], 'images/'.$file);

            $sql = "insert into image(title, image, user_id, description) values(?,?,?,?)";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("location:gallery.php?SQL_ERROR");
                exit();
            }else{
                mysqli_stmt_bind_param($stmt,'ssis', $title,$file,$id,$description);
                mysqli_stmt_execute($stmt);
                header("location:gallery.php?upload_success");
            }
        }
    }

 }
}else{
    exit();
}