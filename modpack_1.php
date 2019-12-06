<?php 
      session_start();
     
      include "includes/dbconnect.php";
      include "includes/functions.php";

      if(isset($_POST['add_note'])){
        header('location:note_add.php');
      }

      if(isset($_POST['add_daily_note'])){
        header('location:note_add.php?curr_date=now');
      }

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minecraft IS</title>
    <!--<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>-->
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <script>
        function show_welcome_message(){
          setTimeout(function(){
            document.getElementsByClassName('')[0].style.visibility = 'hidden';
            //alert('hello world!');
          }, 3000);
        }
    </script>
  </head>
  
  <body>
      <div class="header">
          <a href="."><div class="app_picture"><img src="pics/logo.svg" alt="Minecraft logo"></div></a>
      </div>
      <div class="main_wrap">
        <div class="tab_menu">
          <?php include("menu.php"); ?>
        </div>
        <div class="content">
        
       
   <!--         <div class="list">

            <div class="button_wrap"> 
             <form action="" method="post">
                <button name="add_note" type="submit" class="button small_button pull-right" title="New note"><i class="material-icons">note_add</i></button>
                <button name="add_daily_note" type="submit" class="button small_button pull-right" title="Update_note"><i class="fa fa-plus"></i></button>
              </form>
         </div>  -->
         <div class="modpack_list">
          
             <?php
                $sql="SELECT * from modpacks order by load_order ASC";
                $result=mysqli_query($link, $sql);
                while (
                    $row = mysqli_fetch_array($result)){
                        $modpack_id=$row['modpack_id'];
                        $modpack_name=$row['modpack_name'];
                        $modpack_pic=$row['modpack_pic'];

                        echo "<div class='modpack_thumb'>
                            <div class='modpack_thumb_pic'><img src='".$modpack_pic."'></div>
                            <div class='modpack_thumb_name'>$modpack_name</div>
                            <div class='modpack_thumb_action'><a href='modpack.php?modpack_id=$modpack_id' class='span_mod'>Enter</a></div>  
                        </div>";
                    }
                
            ?>
       <!-- </div> -->
          
        </div>
      </div>
  </body> 
