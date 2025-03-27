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