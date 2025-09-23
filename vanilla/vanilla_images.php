<?php
      include("../includes/dbconnect.php");
      include ("../includes/functions.php");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minecraft IS</title>
    <!--<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>-->
    <link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/gallery.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="../favicon-32x32.png">

    <body>
         <?php include("../includes/header.php") ?>
         <div class="main_wrap">
             <div class="tab_menu">
                <?php include("../includes/vanila_menu.php") ?>
          </div>
          <div class="content">
             <div class="list">
                <div class="add_new_image">
                 <h3>Add new image</h3>   
                 <input type="text" name="image_name" placeholder="Picture title" autocomplete="off">
                    <input type="text" name="image_url" placeholder="Image URL" autocomplete="off" id="image_url">
                    <textarea name="image_description" placeholder="Something about..."></textarea>
                    <div class="action">
                        <button type="button" name="add_new_ext_pic" class="button pull-right">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div><!-- add_new_image -->
                <div class="gallery_wrap">
                    <!-- get list of images -->
                    <?php
                       $get_vanilla_images = "SELECT a.* FROM pictures a, pictures_modpacks b WHERE b.modpack_id = 2 AND a.picture_id = b.image_id ORDER BY a.picture_id DESC";
                    $result = mysqli_query($link, $get_vanilla_images) or die(mysqli_error($link));
                    while($row = mysqli_fetch_array($result)){
                        $picture_id = $row['picture_id'];
                        $picture_name = $row['picture_name'];
                        $picture_description = $row['picture_description'];
                        $picture_path = htmlspecialchars($row['picture_path'], ENT_QUOTES, 'UTF-8');

                        echo "<div class='gallery_item' id='$picture_id'><img src='$picture_path' alt=''><div class='gallery_item_description'>$picture_description</div></div>";
                    }
                     ?>   
             </div><!--base omage list -->        
         </div><!-- list -->
        </div><!-- content --> 
        
    </body>