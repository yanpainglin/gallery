<?php
    session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login page</title>
    <style>
        body{
            margin: 100px auto;
            background: white;
            background: darkseagreen;
        }
        input{
            margin: 6px auto;
            width: 350px;
            height: 40px;
            border: solid 3px darkslateblue;
            border-radius: 20px;
            background: white;
            text-align: center;
            font-size: 1.5rem;
        }
        input[type="submit"]{
            background: darkslateblue;
            color: white;
            font-size: 1.5em;
        }
        input[type="file"]{
           border: none;
            border-radius: 0px;
        }
        header{
            font-size: 40px;
            color: darkslateblue;
        }
        center a{
            padding: 10px 20px;
            font-size: 30px;
            text-decoration: none;
            border-radius: 30px;
            background: darkslateblue;
            color: white;
        }
        p{
            font-size: 2rem;
        }
        .success{
            color: green;
            font-size: 1.5rem;
        }
        i{
            color: darkslateblue;
        }
        div{
            text-align: center;
        }
        div img{
          width: 150px;
          height: 150px;
          border: solid 1px black;
          border-radius: 100%;
          padding: 5px;
        }
        .error{
            color: red;
            font-size: 20px;
        }
        .title{
            text-align: center;
            font-size: 2.5rem;
            color: darkslateblue;
        }
        .button{
            background: darkred;
        ;
    </style>
</head>
<body>
<?php

    if(isset($_SESSION['login'])){
        include_once 'include_files/dbh.php';
        $id= $_SESSION['id'];
        $sql = "select * from users where id=$id";
        $result = mysqli_query($conn, $sql);
        $row=mysqli_fetch_assoc($result);
        $first=$row['first_name'];
        $last = $row['last_name'];

        if(mysqli_num_rows($result) > 0){
            $sqlImg = "select * from profileimg where user_id = '$id'";
            $resultImg = mysqli_query($conn, $sqlImg);
            $rowImg = mysqli_fetch_assoc($resultImg);

            if ($rowImg['status'] == 0){
                $file = 'uploads/profile'.$id.'*';
                $filename = glob($file);
                $fileExt=explode('.', $filename[0]);
                $fileActExt = $fileExt[1];
                $filepath = 'uploads/profile'.$id.'.'.$fileActExt;
                echo"<div>";
                    echo "<img src='$filepath'>"."<br>";
                    echo "<p class='title'>$first $last</p>";
                echo "</div>";
            }else{
                echo"<div>";
                    echo "<img src='uploads/defaultprofile.png'>"."<br>";
                    echo "<p class='title'>$first $last</p>";
                echo "</div>";
            }
        }
        $lowerfirst =strtolower($first);
        $lowerlast =strtolower($last);
        echo "<p align='center'>You are now logged in as <i>$lowerfirst$lowerlast</i></p> ";

        echo'<form action="file_upload.php?" method="post" align = "center"enctype="multipart/form-data">
                <input type="file" name="file"><br>
                <input type="submit" name="submitImg" value="Upload">
            </form><br><br>';
            echo '<center><a class="button" href="delete.php" >Delete profile image</a></center><br><br>';
        echo"<center> <a href='logout.php'>Logout</a></center>";
    }else{
?>
    <form action="login_check.php" method="POST" align="center">
        <header >Log In To Your Account.</header>
        <br><br><br>
        <input type="email" name="email" placeholder="Email Address" ><br>
        <?php
        $fielurl = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        if(strpos($fielurl, 'incorrect_email')){
            echo "<p class='error' align='center'>There is no user with the email you provided!!</p>";
        }
        ?>
        <input type="password" name="password" placeholder="Password"><br>
        <?php
            $fielurl = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            if(strpos($fielurl, 'incorrect_password')){
                echo "<p class='error' align='center'> Incorrect password</p>";
            }
        ?>
        <input type="submit" value="Login" name="submit"><br>
        <a href="index.php">Don't have an account? Sign up here.</a>

    </form>
<?php
    }
?>



</body>
</html>
