<?php
 session_start();
      include "includes/dbconnect.php";
      include "includes/functions.php";
      header("Cache-Control: max-age=0");

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
          echo "<div class='overlay'><div class='logon_information success'><i class='fa fa-check-circle'></i></div></div>"; 
          echo "<script>setTimeout(function(){
            window.location = 'dashboard.php';
          }, 3000)</script>";

          //header("location:dashboard.php");
          } elseif ($overeni==0) {
            echo "<div class='overlay'><div class='logon_information error'><i class='fas fa-times-circle'></i></div></div>";
            echo "<script>setTimeout(function(){
              window.location = 'index.php';
            }, 3000)</script>";
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css"
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="css/index.css?<?php echo time(); ?>">
  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  <style>
    
            
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
