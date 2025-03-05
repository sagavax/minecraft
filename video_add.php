<?php include "includes/dbconnect.php";
      include "includes/functions.php";

      if(isset($_POST['edit_video'])){
          //var_dump($_POST);
          $video_id=$_POST['video_id'];
          $video_name=mysqli_real_escape_string($link, $_POST['video_title']);
          $video_url=mysqli_real_escape_string($link, $_POST['video_url']);
          $video_category=$_POST['category'];
          $video_modpack=$_POST['modpack'];

          $sql="UPDATE videos SET cat_id=$video_category, modpack_id=$video_modpack, video_title='$video_name', video_url='$video_url' where video_id=$video_id";
          $result=mysqli_query($link, $sql);

        $link1 = mysqli_connect(null, "brick_wall", "h3jSXv3gLf", "brick_wall", null, "/tmp/mariadb55.sock");
        //$link1=mysqli_connect("localhost", "root", "", "brick_wall");
        
        $diary_text="Minecraft IS: Video s <strong>$video_title</strong> bolo upravene";
        $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
        $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
        
        
          
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
                <?php
                    global $link; 
                    $video_id=$_GET['video_id'];
                    $sql="SELECT video_id, video_title, eis_video_id, video_url, cat_id, modpack_id from videos where video_id=$video_id";
               
                    $result=mysqli_query($link, $sql);
                    while($row = mysqli_fetch_array($result)){
                        $cat_id=$row['cat_id'];
                        $modpack_id=$row['modpack_id'];
                        $cat_name=GetModName($cat_id);
                        $modpack_name=GetModPackName($modpack_id);
                        $video_name=$row['video_title'];
                        $video_url=$row['video_url'];
                        $eis_video_id=$row['eis_video_id'];
                  
                    
                    ?>
                 <div id="new_video">
             <form action="" enctype="multipart/form-data" method="post">    
                
                <input type="hidden" name="video_id" value="<?php echo $video_id ?>">
                <input type="text" name="video_title" placeholder='Video title' autocomplete=off value="<?php echo $video_name; ?>">
                <input type="text" name="video_url" placeholder='Video url'  autocomplete=off value="<?php echo $video_url; ?>">
                 <!--<textarea name="video_url" placeholder='video url'></textarea>-->
                 <div class="new_video_select_action_wrap">
                  <div class="new_video_selects_wrap">
                  <select name='category'>
						        <option value=0>-- Select category -- </option>
                      <?php
                         echo "<option value=$cat_id selected='selected'>$cat_name</option>";
                        $sql="SELECT * from category ORDER BY cat_name ASC";
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
                              $sql="SELECT * from modpacks ORDER BY modpack_id ASC";
                             $result=mysqli_query($link, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                  $modpack_id=$row['modpack_id'];
                                  $modpack_name=$row['modpack_name'];
                              echo "<option value=$modpack_id>$modpack_name</option>";
                              }	
                           
                      ?>
                    </select>   
                    <?php 
                    }
                     ?>
                  </div>
                  <div class="new_video_submit_wrap"><button type="submit" name="edit_video" class="button small_button pull-right"><i class="fa fa-plus"></i></button></div>
                </div>

        </div>  
</body>        