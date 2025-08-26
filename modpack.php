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
    <link rel="stylesheet" href="css/modpack_images.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="css/modpack_videos.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script defer src="js/modpack.js?<?php echo time() ?>"></script>
    <script defer src="js/modpack_bases.js?<?php echo time() ?>"></script>
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
                      <li class="button small_button" onclick="LoadPage('images')">Images</li>
                      <li class="button small_button" onclick="LoadPage('bases')">Bases</li>
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
                    </div>
                  </div> 

               </div><!--modpack_content -->

            </div><!--content-->

          </div>    
          
          <dialog class="popup_mods_list"><!-- popup mod list -->
            <header>
              <input type="text" name="search_mod" autocomplete="off" spellcheck="false" placeholder="search mod(s) here...">
              <!-- <button class='button blue_button' onclick="reload_modal_mods()"><i class="fas fa-sync-alt"></i></button> -->
              <button class='button blue_button' name="hide_popup" type="button"><i class="fas fa-times"></i></button>
            </header>
            <div id="letter_list">
               <?php
                  foreach (range('A', 'Z') as $char) {
                            echo "<button class='button blue_button rounded_button' name='char'>$char</button>";
                          }                            
                    ?>        
              
            </div>
            <main>
              <?php 
               //display just unassigned mods 
               $modpack_id = $_GET['modpack_id'];
               $get_mods = "select * from mods where cat_id not in (SELECT mod_id from modpack_mods where modpack_id=$modpack_id) order by cat_name ASC LIMIT 20";
               
                $result=mysqli_query($link, $get_mods);
                while ($row = mysqli_fetch_array($result)) {  
                    $id = $row['cat_id'];
                    $cat_name = $row['cat_name'];
                    echo "<button class='button blue_button rounded_button' data-id=$id name='add_mod_to_modpack'>$cat_name</button>";
                } 

            ?>
            </main>
          </dialog>

          <dialog class="dialog_add_new_link"><!-- add new link -->
            <div class="dialog_inner_link_container">
              <!-- <h4>Add new link</h4> -->
              <!-- <input type="text" name="link_name" placeholder="Link name"> -->
              <input type="text" name="link_url" placeholder="Link url"><button type="button" class="button blue_button">Add</button>
            </div>
          </dialog>        

          <dialog id = "modal_new_base">                         
          <div class="new_base_inner_layer">
              <input type="text" name="base_name" placeholder="name of the base ...." autocomplete="off">
              <textarea name="base_description" placeholder="description of the base ...."></textarea>
              <div class="base_location">
                  <div id="base_location_outworld"><h4>Outworld:</h4>
                      <div class="base_coord"><span>X:</span><input type="text" placeholder="X" name="over_x" required></div>
                      <div class="base_coord"><span>Y:</span><input type="text" placeholder="Y" name="over_y" required></div>
                      <div class="base_coord"><span>Z:</span><input type="text" placeholder="Z" name="over_z" required></div>
                  </div><!-- base location outworld -->
              </div>   
              <div class="action">
                  <button type="button" class="button small_button" name="return_to_vanilla">Back</button>
                  <button type="button" class="button small_button" name="add_base">Add base</button>
              </div>
          </div>
        </dialog>
    </div><!--main_wrap-->  

