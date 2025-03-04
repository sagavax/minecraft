<?php include "includes/dbconnect.php";
      include "includes/functions.php";
?>      
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minecraft IS</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="css/backup_animation.css?<?php echo time(); ?>">
    <!--<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">   
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <script src="https://use.fontawesome.com/be937f19da.js"></script>
    <script defer src="js/maintenance.js?<?php echo time() ?>"></script>
    <script defer src="js/message.js?<?php echo time() ?>"></script>
    <!-- <script defer src="js/app_event_tracker.js?<?php echo time() ?>"></script> -->
    
  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  </head>

<body>

  <?php 
      include("includes/header.php") ?>   
      <div class="main_wrap">
      <div class="tab_menu">
          <?php include("includes/menu.php"); ?>
          <?php echo "<script>sessionStorage.setItem('current_module','maintenance')</script>"; ?>
        </div>
        <div class="content">
          <div class="loading-container">
            <div class="loading-spinner"></div>
          </div>
          <div class='list'>

            <div class="backuped_files">
              <div class="backuped_files_header"><span>System maintenance, backup and restore</span><button class="button small_button" name="remove_backups"><i class="fa fa-times"></i> Remove all backups</button><button class="button small_button" name="make_backup"><i class="fas fa-server"></i> Backup</button></div>
               <div class="files_list">
                 <?php include "maintenance_file_list.php" ?>
               </div> 
            </div>
          </div><!-- list -->
        </div><!--content--> 
      </div><!-- main_wrap-->  
      <div class="message hidden">
           <div class="message_text"></div>
         </div> 
  </body>  

