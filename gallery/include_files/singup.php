<?php
session_start();
if(isset($_POST['submit'])){
    include_once 'dbh.php';

    $first = $_POST['first'];
    $last = $_POST['last'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

    if(empty($first) || empty($last) || empty($email) || empty($username) || empty($password)){
        header("location: ../index.php?signup=empty&first=$first&last=$last&username=$username&email=$email");
        exit();
    }else if (!preg_match('/[a-zA-Z]/', $first) || !preg_match('/[a-zA-Z]/', $last)){
        header("location: ../index.php?signup=char&email=$email&username=$username");
        exit();
    } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        header("location:../index.php?signup=invaild_email&first=$first&last=$last&username=$username");
        exit();
    }else{
        $sql = "insert into users (first_name, last_name, email, user_role,user_password) values (?,?,?,?,?);";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            echo 'SQL error';
        }else{
            mysqli_stmt_bind_param($stmt, 'sssss',$first,$last, $email,$username,$hashed_pass);
            mysqli_stmt_execute($stmt);
        }
        $sql1 = "select * from users where email=? and user_role=?";
        $stmtImage = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmtImage,$sql1)){
            echo "SQL error";
        }else{
            mysqli_stmt_bind_param($stmtImage, 'ss', $email,$username);
            mysqli_stmt_execute($stmtImage);
            $result =mysqli_stmt_get_result($stmtImage);
            if(mysqli_num_rows($result) > 0){
                $row=mysqli_fetch_assoc($result);
                $id = $row['id'];
                $status = 1;
                $sql2="insert into profileimg (user_id, status) values (?, ?)";
                $stmtImageInsert = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmtImageInsert,$sql2)){
                    echo'SQl error';
                }else{
                    mysqli_stmt_bind_param($stmtImageInsert, 'si',$id, $status);
                    mysqli_stmt_execute($stmtImageInsert);

                    $_SESSION['login'] =true;
                    $_SESSION['id'] = $id;
                    header("location:../gallery.php?signup_success");
                }
            }else{
                header("location:../index.php?signup=error");
            }
        }


    }
}else{
    header('location: ../index.phph?signup=error');
}