<?php
    session_start();
    if(isset($_SESSION['login'])){
        include_once 'include_files/dbh.php';
        $id= $_SESSION['id'];
        $sql = "select * from users where id = '$id'";
        $result= mysqli_query($conn, $sql);
        $row= mysqli_fetch_assoc($result);

    }else{
        header("location:login.php");
        exit;
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gallery</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!--header-->
    <header>
        <div id="header">
            <a href="gallery.php" >
                <img src="images/logo.png"class="logo" alt="logo-image">
            </a>

            <?php

                $sqlImg = "select * from profileimg where user_id ='$id'";
                $resultImg = mysqli_query($conn, $sqlImg);
                $rowImg = mysqli_fetch_assoc($resultImg);
                $first = $row['first_name'];
                $last = $row['last_name'];
                if($rowImg['status'] == 0){
                    $file = 'uploads/profile'.$id.'*';
                    $filename = glob($file);
                    $fileEXt = explode('.', $filename[0]);
                    $fileActExt = strtolower(end($fileEXt));
                    $filepath = 'uploads/profile'.$id.'.'.$fileActExt;

                    echo"  <div id='menubar'>
                                <span id='sidepanel' onclick='toggle()'> <img src='uploads/sidebar.png' alt='sidepanel.png'> </span>
                                <div class='nav'>
                                  <div id='profile'>
                                    <a href='login.php'><img src=$filepath /></a>
                                    <a href='login.php'><h4>$first$last</h4></a>
                                    <a href='logout.php' class='logout-button'><b>Log Out</b></a>
                                  </div>
                                </div>
                            </div>
                          ";
                }else{
                    echo"
                          <div id='menubar'>
                              <span id='sidepanel' onclick='toggle()'> <img src='uploads/sidebar.png' alt='sidepanel.png'> </span>
                              <div class='nav'>
                                  <div id='profile'>
                                    <a href='login.php'><img src='uploads/defaultprofile.png'/></a>
                                    <a href='login.php'><h4>$first$last</h4></a>
                                    <a href='logout.php' class='logout-button'><b>Log Out</b></a>
                                  </div>
                              </div>
                            </div>
                          ";
                }
            ?>

        </div>
    </header>

<!--//section , sidebar ,gallery-->
    <section id="wrap">
       <span id="upload-button"><button onclick="showForm()">Upload</button></span>

        <div id="sidebar">
            <div class="form" >
                    <span id="closebtn" onclick="closeForm()">&#10006;</span>
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <h2>Upload New Images</h2>
                    <input id="autofocus" type=" text" placeholder="Title" name="title">
                    <br><br>
                    <input type="file" multiple name="file[]" >
                    <br><br>
                    <textarea name="description"  placeholder="Description"></textarea>
                    <input type="submit" value="Upload" name="submit">
                </form>
            </div>
        </div>

        <div id="gallery">
          <div class="singleImage">
                 <img src="" alt="">
            </div>
            <?php
                $sql = "select DISTINCT created_at from image where user_id = $id order by created_at DESC ";
                $stmt =mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt,$sql)){
                    header('location:gallery.php?SQL_error');
                    exit();
                }else{
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if(mysqli_num_rows($result) > 0){

                        while ($rowDate = mysqli_fetch_assoc($result)){
                            $date = $rowDate['created_at'];
                            $showDate = date("M d , Y", strtotime($date));
                            $sql2="select * from image where created_at = '$date' and user_id='$id' ";
                            $resultDate =mysqli_query($conn, $sql2);
                             echo "
                                   <div class='date-container'>
                                            <div class='date'>
                                                   <div><hr></div> <h4>$showDate</h4> <div><hr></div>
                                            </div>
                                  ";

                        while ($row = mysqli_fetch_assoc($resultDate)){
                            $image = 'images/'.$row['image'];
                            $title = $row['title'];
                            $description= $row['description'];

                            echo"
                                <div class='photo'>
                                    <a href='#' onclick='showimage()'><img class='img' src='$image' alt='gallery-image'/><br></a>
                                    <p ><i>$title</i></p>
                                </div>
                                ";
                        }
                        echo "</div>";
                    }
                    }else{
                        echo "<h1 style='margin: 200px auto'; > Upload images to see here!! </h1>";
                        }
                }
            ?>

        </div>
    </section>


    <script>
        function showForm(){
            document.getElementById('sidebar').style.display="block";
            document.getElementById('upload-button').style.display="none";
            document.getElementById('closebtn').style.display="block";
            document.getElementById('gallery').style.opacity="0.2";
            document.getElementById('gallery').style.position="fixed";
        }
        function closeForm(){
            document.getElementById('sidebar').style.display="none";
            document.getElementById('upload-button').style.display="block";
            document.getElementById('closebtn').style.display="none";
            document.getElementById('gallery').style.opacity="1";
            document.getElementById('gallery').style.position="absolute";
        }

        function toggle(){
          document.getElementById('menubar').classList.toggle('active');
        }
    </script>
</body>
</html>
