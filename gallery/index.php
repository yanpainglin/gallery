<?php
session_start();
if(isset($_SESSION['login'])){
  header('Location:gallery.php');
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body{
            margin: 100px auto;
            background: darkseagreen;
        }
        input{
            margin: 6px auto;
            width: 350px;
            height: 40px;
            border: solid 3px darkslateblue;
            border-radius: 10px;
            background: white;
            text-align: center;
            font-size: 1.5rem;
        }
        input[type="submit"]{
            background: darkslateblue;
            color: white;
            font-size: 1.5em;
        }


        header{
            font-size: 50px;
        }p,a{
            font-size: 30px;
                 }
        .error{
            color: red;
        }
        .success{
            color: green;
        }

    </style>
</head>
<body>

<form action="include_files/singup.php" method="POST" align="center">
    <header align="center">Signup Form</header><br><br>
    <?php

        if(isset($_GET['first'])){
            $first= $_GET['first'];
            echo'<input type="text" name="first" placeholder="First Name" value="'.$first.'"><br>';
        }else{
            echo'<input type="text" name="first" placeholder="First Name" ><br>';
        }
        if(isset($_GET['last'])){
            $last= $_GET['last'];
            echo'<input type="text" name="last" placeholder="Last Name" value="'.$last.'"><br>';
        }else{
            echo'<input type="text" name="last" placeholder="Last Name" ><br>';
        }
        if(isset($_GET['email'])){
            $email= $_GET['email'];
            echo'<input type="text" name="email" placeholder="Email Address" value="'.$email.'"><br>';
        }else{
            echo'<input type="text" name="email" placeholder="Email Address" ><br>';
        }
        if(isset($_GET['username'])){
            $username= $_GET['username'];
            echo'<input type="text" name="username" placeholder="Username" value="'.$username.'"><br>';
        }else{
            echo'<input type="text" name="username" placeholder="Username" ><br>';
        }

    ?>

    <input type="password" name="password" placeholder="Password"><br>
    <input type="submit" name="submit" value="Submit"><br>

    <?php
        if(isset($_SESSION['login'])){
            echo" <a href='gallery.php'>login instead?</a>";
        }else{
            echo" <a href='login.php'>login instead?</a>";
        }
    ?>
</form>

<?php
/*
    $fileurl = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($fileurl,'signup=empty') == true){
        echo "<p align='center'class='error'>You did not fill all field!</p>";
    }else if(strpos($fileurl,'signup=char') == true){
        echo "<p align='center'class='error'>Please fil your real name.</p>";
    }else if(strpos($fileurl,'signup=invaild_email') == true){
        echo "<p align='center'class='error'>You fill an invaild email.</p>";
    }else if(strpos($fileurl,'signup=success') == true){
        echo "<p align='center'class='success'>Congratulations!! You have been signed up successfully.</p>";
    }
*/

        if(!isset($_GET['signup'])){
            exit();
        }else{
            $signupCheck = $_GET['signup'];
            if($signupCheck =='empty'){
                echo "<p align='center'class='error'>You did not fill all field!</p>";
            }else if($signupCheck == 'char'){
                echo "<p align='center'class='error'>Please fill your real name.</p>";
            }else if($signupCheck == 'invaild_email'){
                echo "<p align='center'class='error'>You fill an invaild email.</p>";
            }else if($signupCheck == 'success'){
                echo "<p align='center'class='success'>Congratulations!! You have been signed up successfully.</p>";
            }
        }
?>
</body>
</html>
