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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  </head>
  
  <body>
      <div class="header">
          <a href="."><div class="app_picture"><img src="pics/logo.svg" alt="Minecraft logo"></div></a>
      </div>
      <div class="main_wrap">
      <div class="tab_menu">
         <?php include("includes/menu.php"); ?>
        </div>
        
        <div class="content">
           
            <div class="list">
                <?php
                    $sql="SELECT * from video where is_favorite=1";
                    $result=mysqli_query($link, $sql);
                    while ($row = mysqli_fetch_array($result)) {
                      $video_id=$row['video_id'];
                      $eis_video_id=$row['eis_video_id'];
                      $video_name=$row['video_title'];
                      $video_url=$row['video_url'];
                      $mod_id=$row['cat_id'];
                      $modpack_id=$row['modpack_id'];
                      
                      echo "<div class='videos'>";
                      echo "</div>";
                    }  
                ?>
            </div>    
        </div> 
</body>     