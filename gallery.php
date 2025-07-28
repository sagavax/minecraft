<?php

    include("includes/dbconnect.php");

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
    <link rel="stylesheet" href="css/gallery.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script type="text/javascript" src="js/gallery.js" defer=""></script>
    <script type="text/javascript" src="js/message.js" defer=""></script>
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  </head>
  
  <body>
  <?php include("includes/header.php") ?>
      <div class="main_wrap">
        <div class="tab_menu">
          <?php include("includes/menu.php"); ?>
        </div>
        <div class="content">
            <div class="gallery_wrap">
                <?php
                    $sql = "SELECT * FROM pictures";
                    $result = mysqli_query($link, $sql);
                    while($row = mysqli_fetch_array($result)){
                        $picture_id = $row['picture_id'];
                        $picture_name = $row['picture_name'];
                        $picture_description = $row['picture_description'];
                        $picture_path = htmlspecialchars($row['picture_path'], ENT_QUOTES, 'UTF-8');

                        echo "<div class='gallery_item' id='$picture_id'><img src='$picture_path' alt=''><div class='gallery_item_description'>$picture_description</div></div>";
                    }
              ?>
            </div><!-- gallery_wrap -->
        </div><!-- content -->
      </div><!-- main_wrap -->
    </div><!-- main -->
  </body>
</html>


<dialog class="image_full_view">
    <div class="image-name"></div><!-- image-name -->
    <div class="image-container"><!-- image-container -->
            <img src="">
    </div><!-- image-container -->    
    <div class="input-container"><!-- input-container -->
        <input type="text" placeholder="write comment here"><button type='button' name="add_comment" class="button small_button" onclick="addComment(); return false;"><i class='fa fa-plus'></i></button>
     </div><!-- input-container -->
      <div class="image_comments"></div><!-- image_comments -->
</dialog>
