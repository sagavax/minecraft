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

     if(isset($_POST['add_modpack'])) 
     header('location:modpack_add.php'); 
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script type="text/javascript" src="js/modpacks.js" defer=""></script>
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
  <?php include("includes/header.php") ?>
      <div class="main_wrap">
        <div class="tab_menu">
          <?php include("includes/menu.php"); ?>
        </div>
        <div class="content">
        
       
        <div class="modpack_list_wrap">
            <!-- <div class="fab fab-icon-holder" onclick="window.location.href='modpack_add.php';"> -->
            <div class="fab fab-icon-holder" onclick="document.getElementById('new_modpack').showModal();">
                <i class="fa fa-plus"></i>
              </div>    
         
         <div class="dashboard_header">Modpack list</div>
         <div class="search_wrap"><input type="search" placeholder="Search modpack here" autocomplete="off" spellcheck="false"></div>


         <div class="tab_view">
             <button class="button small_button" name="show_list">List</button>
             <button class="button small_button" name="show_grid">Grid</button> 
             <button class="button small_button" name="active">Active</button>
             <button class="button small_button" name="inactive">Inactive</button>
             <button class="button small_button" name="all">All</button>
             <button class="button small_button" name="suggested">Sugested</button>
         </div>

         <div class="modpack_list">
          
             <?php
                //$sql="SELECT * from modpacks where order by load_order ASC";
                $sql="SELECT * from modpacks where is_active=1 and modpack_id not in (1) UNION ALL 
                SELECT * from modpacks where is_active=0";
                $result=mysqli_query($link, $sql);
                while (
                    $row = mysqli_fetch_array($result)){
                        $modpack_id=$row['modpack_id'];
                        $modpack_name=$row['modpack_name'];
                        $modpack_image=$row['modpack_image'];
                        $is_active = $row['is_active'];

                       echo "<div class='modpack_thumb'>
                        <div class='modpack_thumb_pic'><img src='" . $modpack_image . "'></div>
                        <div class='modpack_thumb_name'>$modpack_name</div>
                        <div class='modpack_thumb_action'>
                            <button type='button' name='enter_modpack' class='white_outlined_button' data-id='$modpack_id'>Enter</button>
                            <button type='button' name='modpack_status' data-id='$modpack_id' class='white_outlined_button is_active" . ($is_active == 1 ? ' active' : ' inactive') . "'>" .
                                ($is_active == 1 ? "<i class='fa fa-check'></i>" : "<i class='fa fa-times'></i>") .
                            "</button>
                        </div>
                    </div>";
                    }
                
            ?>
       </div>
          
        </div>
      </div>
      
      <dialog id="new_modpack">
           <h3>Add new modpack:<h3>
              <input type="text" name="modpack_name" placeholder="Modpack's name" autocomplete="off"> 
              <input type="text" name="modpack_version" placeholder="Modpack's version" autocomplete="off">
              <input type="text" name="modpack_author" placeholder="Modpack's author" autocomplete="off" >
              <textarea name="modpack_description" placeholder="Modpack's description"></textarea>
              <input type="text" name="modpack_url"  placeholder="Modpack's url" autocomplete="off">
              <input type="text" name="modpack_image" placeholder="Modpack's image" autocomplete="off">
                <!-- input type="file" name="modpack_pic"  placeholder="Modpack's picture"> -->
              <div class="action">
                 <button type="submit" name="add_new_modpack" class="button pull-right"><i class="fa fa-plus"></i></button>
                 <button type="submit" name="move_back" class="button pull-right"><i class="fa fa-arrow-left"></i></button>
              </div>
             
       </dialog>
</body> 
