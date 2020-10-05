<?php
session_start();
$id =$_SESSION['id'];
include_once 'include_files/dbh.php';

$file = 'uploads/profile'.$id.'*';
$filename = glob($file);
$fileExt=explode('.', $filename[0]);
$fileActExt = $fileExt[1];
$filepath = 'uploads/profile'.$id.'.'.$fileActExt;


if (!unlink($filepath)){
    echo "the profile image was not deleted!";
}else{
        echo "the profile image was deleted!";
}

$sql = "update profileimg set status = 1 where user_id=$id;";
mysqli_query($conn, $sql);
header("location:login.php?delete_success");