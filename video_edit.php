<?php include "includes/dbconnect.php";
      include "includes/functions.php";

      if(isset($_POST['edit_video'])){
          
          $video_id=$_POST['video_id'];
          $video_name=mysqli_real_escape_string($link, $_POST['video_title']);
          $video_url=mysqli_real_escape_string($link, $_POST['video_url']);
          $video_category=$_POST['category'];
          $video_modpack=$_POST['modpack'];

          $sql="UPDATE videos SET cat_id=$video_category, modpack_id=$video_modpack, video_title='$video_name', video_url='$video_url' where video_id=$video_id";
          $result=mysqli_query($link, $sql);

           
        $diary_text="Minecraft IS: Video <b>$video_name<b> bolo upravene";
        $create_record="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
        $result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));

        
            echo "<script>
          alert('Video s id $video_id bolo upravene');
          window.location.href='videos.php';
          </script>";
         
          
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
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  </head>
  
  <body>
      <?php include("includes/header.php") ?>
      <div class="main_wrap">
      <div class="tab_menu">
         <?php include("includes/menu.php"); ?>
        </div>
        <div class="content">
            <div class='list'>
              <div class="fab fab-icon-holder" onclick="window.location.href='videos.php';">
                <i class="fa fa-arrow-left"></i>
              </div>
                <?php
                   // global $link; 
                    $video_id=$_GET['video_id'];
                    $sql="SELECT video_id, video_title, video_url, cat_id, modpack_id from videos where video_id=$video_id";
                   //echo $sql;      
                 $result=mysqli_query($link, $sql);
                    while($row = mysqli_fetch_array($result)){
                        $cat_id=$row['cat_id'];
                        $modpack_id=$row['modpack_id'];
                        $cat_name=GetModName($cat_id);
                        $modpack_name=GetModPackName($modpack_id);
                        $video_name=$row['video_title'];
                        $video_url=$row['video_url'];
                        
                        
                     // echo $video_title;
                    
                    ?>
                 <div id="edit_video">
                    <form action="" enctype="multipart/form-data" method="post">    
                        <input type="hidden" name="video_id" value="<?php echo $video_id ?>">
                        <input type="text" name="video_title" placeholder='Video title' autocomplete=off value="<?php echo $video_name; ?>">
                        <input type="text" name="video_url" placeholder='Video url'  autocomplete=off value="<?php echo $video_url; ?>">
                      
                         <select name='category'>
                            <option value=0>-- Select category -- </option>
                              <?php
                                 echo "<option value=$cat_id selected='selected'>$cat_name</option>";
                                $sql="SELECT * from mods ORDER BY cat_name ASC";
                                $result=mysqli_query($link, $sql);
                                  while ($row = mysqli_fetch_array($result)) {
                                    $cat_id=$row['cat_id'];
                                    $cat_name=$row['cat_name'];
                                echo "<option value=$cat_id>$cat_name</option>";
                                } 
                              ?> 
                      </select>
                      <select name="modpack">
                        <option value=0>-- Select mod pack -- </option>     
                          <?php
                             echo "<option value=$modpack_id selected='selected'>$modpack_name</option>";
                              $get_modpacks="SELECT * from modpacks ORDER BY modpack_name ASC";
                             $result=mysqli_query($link, $get_modpacks);
                                while ($row = mysqli_fetch_array($result)) {
                                  $modpack_id=$row['modpack_id'];
                                  $modpack_name=$row['modpack_name'];
                              echo "<option value=$modpack_id>$modpack_name</option>";
                              } 
                           
                      ?>
                      </select>  
                      
                      <select name="edition">
                         <option value='java'>java edition</option>
                         <option value='bedrock'>bedrock edition</option>
                      </select>

                        <div class="modpack_container">
                         <select name="modpack">
                        <!--<option value=0>-- Select modpack -- </option>-->
                          <?php
                              if(isset($_GET['modpack_id'])){
                                $modpack_id=$_GET['modpack_id'];
                                $modpack_name=GetModPackName($modpack_id);
                                echo "<option value=$modpack_id selected='selected'>$modpack_name</option>";
                              } else{  ?> 
                                <option value=99>Vanilla Minecraft</option>   
                              <?php   
                                  $sql="SELECT * from modpacks ORDER BY modpack_id ASC";
                              $result=mysqli_query($link, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                  $modpack_id=$row['modpack_id'];
                                  $modpack_name=$row['modpack_name'];
                              echo "<option value=$modpack_id>$modpack_name</option>";
                              } 
                            } 
                          ?>
                    </select>  
                    <button type="button" title="add new modpack" class="button small_button"><i class="fa fa-plus"></i></button>
                     </div><!--modpack container -->
                       <div class="videos_radio_buttons">
                           <input type="radio" name="video_source" value="YouTube" id="source_youtube" checked><label for="source_youtube">Youtube</label>
                           <input type="radio" name="video_source" value="Tiktok" id="source_tiktok"><label for="source_tiktok">Tiktok</label>
                           <input type="radio" name="video_source" value="Pinterest" id="source_pinterest"><label for="source_pinterest">Pinterest</label>
                     </div>
                     <div class="new_video_submit_wrap"><button type="submit" name="edit_video" class="button pull-right"><i class="fa fa-plus"></i></button></div>
                    </form>  

                    <?php 
                    }
                     ?>
                
                 </div><!-- edit video--> 
                 
                </div><!-- list-->
                </div><!-- content-->
                  
                </div><!-- main wrap -->
      
</body>        