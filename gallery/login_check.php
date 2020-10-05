<?php
session_start();

        if(isset($_POST['submit'])){
            include_once 'include_files/dbh.php';

            $email =$_POST['email'];
            $password=$_POST['password'];


            $sql = "select * from users where email=?;";
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt,$sql)){
                echo "SQL error";
            }else{
                mysqli_stmt_bind_param($stmt, 's', $email);
                mysqli_stmt_execute($stmt);
                $result =mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($result)>0){
                    $row = mysqli_fetch_assoc($result);
                    $hashed_pass =$row['user_password'];
                    if(password_verify($password,$hashed_pass)){
                        $id = $row['id'];
                        $_SESSION['login'] = true;
                        $_SESSION['id'] = $row['id'];
                        header("location:gallery.php");
                    }else{
                        header("location:login.php?incorrect_password");
                    }

                }else{
                    header("location: login.php?incorrect_email");
                }
            }
        }else{
            exit();
        }



