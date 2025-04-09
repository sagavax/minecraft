<?php 
session_start();
include "includes/dbconnect.php";
include "includes/functions.php";

if(isset($_POST['add_note'])){
  header('location:note_add.php');
}

if(isset($_POST['add_task'])){
  header('location:task_add.php');
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css"
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script defer src="js/modpack.js?<?php echo time() ?>"></script>
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  </head>
  
  <body>
  
  <?php include("includes/header.php") ?>
     
    <div class="main_wrap">
        <div class="tab_menu">
            <?php include("includes/menu.php"); ?>
        </div>
        
        <div class="content">
            <div id="modpack_details_wrap">
                <!-- <div id="modpack_menu"><ul><li><a href="#">Description</a></li><li><a href="#">Tasks</a></li><li><a href="#">Notes</a></li><li><a href="#">Videos</a></li><li><a href="#">Pictures</a></li></ul></div>-->
                
                <div id="modpack_menu">
                    <div class="modpack_name"></div>
                    <ul>
                      <li class="button small_button" onclick="LoadPage('description')">Description</li>
                      <!--<li class="button small_button" onclick="LoadPage('images')">Imges</li>-->
                      <li class="button small_button" onclick="LoadPage('mods')">Mods</li>
                      <li class="button small_button" onclick="LoadPage('notes')">Notes</li>
                      <li class="button small_button" onclick="LoadPage('tasks')">Tasks</li>
                      <li class="button small_button" onclick="LoadPage('videos')">Videos</li>
                    </ul>
                </div>
                

                <div id="modpack_content">
                  <div class="list">
                    <div class="pic">
                        <img src="<?php echo GetModpackImage(); ?>">
                    </ddiv>
                  </div> 

               </div><!--modpack_content -->

            </div><!--content-->

          </div>    
          <div class="popup_mods_list">
            <header>
              <input type="text" name="serch_mod" onkeyup="popup_search_mod(this.value);" autocomplete="off" spellcheck="false" placeholder="search mod(s) here...">
              <button class='button blue_button' onclick="reload_modal_mods()"><i class="fas fa-sync-alt"></i></button>
              <button class='button blue_button' onclick="hide_popup()"><i class='fa fa-times'></i></button>
            </header>
            <div id="letter_list">
              <ul>
                <?php
                  foreach (range('A', 'Z') as $char) {
                            echo "<li><button class='button small_button blue_button'>$char</button></li>";

                          }
                            echo "<li><button class='button small_button blue_button'>All</button></li>";
                    ?>        
               </ul>   
            </div>
            <main>
              <?php 
              
               $modpack_id = $_GET['modpack_id'];
               $get_mods = "select * from mods where cat_id not in (SELECT mod_id from modpack_mods where modpack_id=$modpack_id) order by cat_name ASC LIMIT 20";
               
                $result=mysqli_query($link, $get_mods);
                while ($row = mysqli_fetch_array($result)) {  
                    $id = $row['cat_id'];
                    $cat_name = $row['cat_name'];
                    echo "<button class='button blue_button' data-id=$id onclic='add_mod_to_modpack($id)'>$cat_name</button>";
                } 

            ?>
            </main>
          </div>
    </div>  
    <script type="text/javascript">
        var modpack_id = <?php echo $modpack_id ?>;
        localStorage.setItem("modpack_id",modpack_id);
    </script>