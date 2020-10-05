

<?php
session_start();
$id =$_SESSION['id'];
if(isset($_POST['submitImg'])){
    $file = $_FILES['file'];
    $filename = $_FILES['file']['name'];
    $tmp = $_FILES['file']['tmp_name'];
    $fileError = $_FILES['file']['error'];
    $fileSize = $_FILES['file']['size'];

    $fileExt = explode('.', $filename);
    $fileActExt = strtolower(end($fileExt));
    $allowed = array('jpg', 'png', 'jpeg', 'pdf','dwg');
    if(in_array($fileActExt, $allowed)){
        if($fileError == 0){
            if($fileSize <1000000000){
                include_once 'include_files/dbh.php';
                $sql = "UPDATE profileimg SET status = 0 where user_id ='$id'";
                mysqli_query($conn,$sql);
                $fileNewName = 'profile'.$id.'.'.$fileActExt;
                move_uploaded_file($tmp, 'uploads/'.$fileNewName);
                header("location:login.php?upload_success");

            }else{
                echo "<p>Can't upload your file because it is more than 1 megabite.</p>";
            }
        }else{
            echo"<p>File error uploading the image</p>";
        }
    }else{
        echo "<p>You cannot upload files of this type!</p>";
    }

}
?>