<?php 
      session_start();
      include "includes/dbconnect.php";
      include "includes/functions.php";

      if(isset($_POST['login'])){
        $username=mysqli_real_escape_string($link, $_POST['username']);
        $password=mysqli_real_escape_string($link, $_POST['password']);
       
            
      $sql="select * from users where user_id = '$username' and password = '$password'";
      //echo $sql;
      //$row = mysqli_fetch_array($link,$result);
      $result = mysqli_query($link,$sql);
      $overeni = mysqli_num_rows($result);
      //echo "Pocet riadkov:".$overeni;
      
      if($overeni == 1) {
          $row = mysqli_fetch_array($result);
          echo "<div class='message succeess'>Vitaj v Minecraft IS <i class='far fa-check-circle'></i></div>"; 
          //header("location:dashboard.php");
          } elseif ($overeni==0) {
            echo "<div class='message error'>Bad username or password <i class='far fa-check-circle'></i></div>"; 
            /*echo "<script>alert('Bad username or password');
         location.href='index.php';</script>";*/
          }
      }
      
      ?>
      
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minecraft IS</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  <style>
     
     .login-page {
              width: 360px;
              padding: 8% 0 0;
              margin: auto;
            }
            .form {
              position: relative;
              z-index: 1;
              background: #FFFFFF;
              max-width: 360px;
              margin: 0 auto 100px;
              padding: 45px;
              text-align: center;
              /*box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);*/
            }

            .form input {
              font-family: "Noto Sans", sans-serif;
              outline: 0;
              background: #f2f2f2;
              width: 100%;
              border: 0;
              margin: 0 0 15px;
              padding: 15px;
              box-sizing: border-box;
              font-size: 14px;
            }
            .form button {
              font-family: "Noto Sans", sans-serif;
              text-transform: uppercase;
              outline: 0;
              background: #75c54f;
              width: 100%;
              border: 0;
              padding: 15px;
              color: #FFFFFF;
              font-size: 14px;
              -webkit-transition: all 0.3 ease;
              transition: all 0.3 ease;
              cursor: pointer;
            }
            .form button:hover,.form button:active,.form button:focus {
              background:#126db3;
            }
            .form .message {
              margin: 15px 0 0;
              color: #b3b3b3;
              font-size: 12px;
            }
            .form .message a {
              color: #4CAF50;
              text-decoration: none;
            }
            .form .register-form {
              display: none;
            }
            .container {
              position: relative;
              z-index: 1;
              max-width: 300px;
              margin: 0 auto;
            }
            .container:before, .container:after {
              content: "";
              display: block;
              clear: both;
            }
            .container .info {
              margin: 50px auto;
              text-align: center;
            }
            .container .info h1 {
              margin: 0 0 15px;
              padding: 0;
              font-size: 36px;
              font-weight: 300;
              color: #1a1a1a;
            }
            .container .info span {
              color: #4d4d4d;
              font-size: 12px;
            }
            .container .info span a {
              color: #000000;
              text-decoration: none;
            }
            .container .info span .fa {
              color: #EF3B3A;
            }
            body {
               background: #aadd77; /* fallback for old browsers */
              font-family: "Noto Sans", sans-serif;
            }   
   
  </style>
  </head>
  
  <body>
    <div class="login-page">
          <div class="form">
           <form class="login-form" action="" method="post">
              <input type="text" placeholder="username" name="username" autocomplete="off">
              <input type="password" placeholder="password" name="password" autocomplete="off" />
              <button name="login">login</button>
              </form>
          </div>
        </div> 

  </body> 
