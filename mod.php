<?php
       include "includes/dbconnect.php";
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <script src="js/category.js" defer></script>
    <!-- <script defer src="js/app_event_tracker.js?<?php echo time() ?>"></script> -->
  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  </head>
  
  <body>
  <?php 
   
  include("includes/header.php") ?>
      <div class="main_wrap">
      <div class="tab_menu">
         <?php include("includes/menu.php"); ?>
        </div>
        <div class="content">
          <div class='list'> 
             <?php
                 $mod_id = $_GET['mod_id'];    
                 $get_mod_info = "SELECT * from mods WHERE cat_id = $mod_id";
                 $result=mysqli_query($link, $get_mod_info) or die(mysqli_error(($link)));
                 while($row = mysqli_fetch_array($result)){
                     $mod_name = $row['cat_name'];       
                     $mod_description = $row['cat_description'];       
                     $mod_url = $row['cat_url'];

                    echo "<div class='modification'>";
                        echo "<div class='mod_details'>";
                            echo "<div class='mod_name'><input type='text' name='mod_name' value='$mod_name' readonly></div>";
                            echo "<div class='mod_description'><textarea name=mod_description placeholder='Mod description' readonly>$mod_description</textarea></div>";
                            echo "<div class='mod_url'><input type='text' name='mod_url' placeholder='mod url' value='$mod_url' readonly></div>";
                       echo "</div>"; //div details
                     }    
           
           
            echo "<div class='mod_images_videos_wrap'>";

                     echo "<div class='mod_images_videos_tabs'>";
                            echo "<button type = 'button' class='button small_button' name='mods_images'>Images</button>";
                            echo "<button type = 'button' class='button small_button' name='mods_videos'>Videos</button>";
                            //echo "<button type = 'button' class='button small_button' name='mods_videos_ikmages'>All resources</button>";
                     echo "</div>";
                    
                     
                     echo "<div class='mod_images'>";  
                            
                            echo "<header>
                                   <p>Mod's images</p>
                                   <button class='button small_button' name='back_to_mods' title='back to mods'><i class='fas fa-arrow-left'></i></button>   
                                   <button class='button small_button' name='reload_images' title='reload mod videos'><i class='fas fa-sync'></i></button>
                                   <button class='button small_button' name='add_new_image' title='Add new video'><i class='fa fa-plus'></i></button>";
                            echo "</header>"; 

                            echo "<main>";          
                            
                                   $get_mod_images = "SELECT * from mod_images WHERE mod_id = $mod_id";
                                   $result_images=mysqli_query($link, $get_mod_images) or die(mysqli_error(($link)));
                     
                                   while($row_images = mysqli_fetch_array($result_images)){
                            
                                   $image_id = $row_images['image_id'];
                                   $image_title = $row_images['image_title'];
                                   $image_url = $row_images['image_url'];

                                   echo "<div class='mod_image' image-id=$image_id>";
                                          echo "<button name='delete_image' title='Delete image' class='button small_button jade_button'><i class='fa fa-times'></i></button>";
                                          echo "<img src='$image_url' alt='$image_title'>";
                                   echo "</div>"; //mod_image  

                         }  

                            echo "</main>";   
                     echo "</div>"; //mod_images
               

                     echo "<div class='mod_videos'>";
                              
                              echo "<header>
                                   <p>Mod's videos</p>
                                   <button class='button small_button' name='back_to_mods' title='back to mods'><i class='fas fa-arrow-left'></i></button>   
                                   <button class='button small_button' name='reload_videos' title='reload mod images'><i class='fas fa-sync'></i></button>
                                   <button class='button small_button' name='add_new_video' title='Add new image'><i class='fa fa-plus'></i></button>";
                            echo "</header>"; 
              
                            echo "<main>";
                                   $get_mod_videos = "SELECT * from mod_videos WHERE mod_id = $mod_id";
                                   $result_videos=mysqli_query($link, $get_mod_videos) or die(mysqli_error(($link)));
                                   while($row_videos = mysqli_fetch_array($result_videos)){
                     
                                          $video_id = $row_videos['video_id'];
                                          $video_title = $row_videos['video_title'];
                                          $video_url = $row_videos['video_url'];

                                          echo "<div class='mod_video' video-id=$video_id>";
                                                 $video_url = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i", "<iframe src=\"//www.youtube.com/embed/$1\" frameborder=\"0\" allowfullscreen></iframe>", $video_url);
                                                 
                                                 echo $video_url;

                                          echo "</div>"; //mod_video 
                                   }
                            echo "</main>";   
                     echo "</div>"; //mod_videos

                     /* echo "<div class='mod_images_videos'>";
                            echo "<div class='mod_images_videos_list'></div>";
                     echo "</div>"; //mod_images_videos */
                  echo "</div>"; //mod_images_videos_wrap    
                echo "</div>"; // div modification         
              
                 echo "<div class='mod_in_modpacks'>";
                            echo "<h4>Mod in modpacks:</h4>";
                            $get_modpacks = "SELECT a.mod_id, a.modpack_id, b.modpack_name from modpack_mods a, modpacks b WHERE a.mod_id=$mod_id and a.modpack_id = b.modpack_id";
                            $result_modpacks=mysqli_query($link, $get_modpacks) or die(mysqli_error(($link)));
                            while($row_modpacks = mysqli_fetch_array($result_modpacks)){
                                   $modpack_name = $row_modpacks['modpack_name'];

                                   echo "<button class='button'>$modpack_name</button>";
                     }      
                  echo "</div>";//mod in modpacks
             
                

             ?> 
             
          </div><!--list-->
        </div><!-- content -->
     </div><!-- main wrap -->   

     <dialog id="dialog_new_image">
        <div class="dialog_inner_container">
            <p>Add image to mod</p>
            <input type="text" name="image_title" placeholder="image title" autocomplete="off">   
            <input type="text" name="image_url" placeholder="image url" autocomplete="off">
            <div class="action">
                 <button class="small_button button" name="save_image"><i class="fa fa-plus"></i></button>  
            </div>               
        </div>    
     </dialog>

     <dialog id="dialog_new_video">
        <div class="dialog_inner_container">
            <p>Add video to mod</p>
            <input type="text" name="video_title" placeholder="video title" autocomplete="off">   
            <input type="text" name="video_url" placeholder="video url" autocomplete="off">
            <div class="action">
                 <button class="small_button button" name="save_video"><i class="fa fa-plus"></i></button>  
            </div>               
        </div>    
     </dialog>
   </body>            