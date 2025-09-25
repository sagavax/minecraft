<?php

    include("includes/dbconnect.php");
    include("includes/functions.php");
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
    <link rel="stylesheet" href="css/message.css?<?php echo time(); ?>">
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
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
          <div class="list">
            <div class="add_new_image">
                 <input type="text" name="image_name" placeholder="Picture title" autocomplete="off">
                    <input type="text" name="image_url" placeholder="Image URL" autocomplete="off" id="image_url">
                    <textarea name="image_description" placeholder="Something about..."></textarea>
                    <div class="action">
                        <button type="button" name="add_new_ext_pic" class="button pull-right">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div><!-- add_new_image -->

                 <div class="image_galleries">
                <div class="gallery_view">
                    <!-- <button type="button" class="button small_button" name="all_galleris">All</button> -->
                    <button type="button" class="button small_button" name="modpacks_galleries">Modpacks</button>
                    <button type="button" class="button small_button" name="vanilla_galleries">Vanilla</button>
                    <button type="button" class="button small_button" name="reload_galleries">Reload</button>
                    <button type="button" class="button small_button" name="new_gallery"><i class="fa fa-plus"></i></button>
                </div>

                <div class="image_galleries_list">
                    <?php  
                    
                    $get_gallery = "SELECT gallery_id, gallery_name FROM picture_galleries";
                        $result = mysqli_query($link, $get_gallery) or die(mysqli_error($link));
                        while($row = mysqli_fetch_array($result)) {
                            echo  "<div gallery-id='" . $row['gallery_id'] . "' class='gallery_list_item button small_button'><i class=='fa fa-image'></i><div class='gallery_name'>" . htmlspecialchars($row['gallery_name']) . "</div><div class='gallery_remove'><i class='fa fa-times'></i></div></div>";
                            
                        }                                                            
                    ?>
                 </div>   
            </div>        
 
            <div class="gallery_wrap">

                <?php
                    $sql = "SELECT * FROM pictures ORDER BY picture_id DESC";
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
          </div><!-- list -->
        </div><!-- content -->
      </div><!-- main_wrap -->
    </div><!-- main -->
  </body>
</html>


<!-- <dialog class="image_full_view">
    <div class="image-name"></div>
    <div class="image-container">
            <img src="">
    </div>   
    <div class="input-container">
        <input type="text" placeholder="write comment here"><button type='button' name="add_comment" class="button small_button" onclick="addComment(); return false;"><i class='fa fa-plus'></i></button>
     </div>
      <div class="image_comments"></div>
</dialog> -->

 <dialog class="modal_new_gallery">
    <div class="inner_new_gallery_layer">
        <input type="text" name="gallery_name" placeholder="gallery name ...." autocomplete="off">
        <textarea name="gallery_description" placeholder="gallery description ...."></textarea>
        <select name="gallery_category">
            <option value="0">--- choose category --- </option>
            <option value="modpacks">Modpacks</option>
            <option value="vanilla">Vannila</option>
        </select>    
        <div class="add_gallery_action"><button type="button" name="close_modal" class="button small_button">Close</button><button type="button" name="create_gallery" class="button small_button"><i class="fa fa-plus"></i>Create</button></div>
  </dialog>

   <dialog class="modal_change_gallery">
      <div class="inner_change_gallery_layer">
          <button type="button" class='close_inner_modal' name='close_gallery_modal'><i class='fa fa-times'></i></button>
          <input type="text" name="gallery_name" placeholder="gallery name ...." autocomplete="off">
          <div class="galleries_list">
              <?php echo GetAllImageGalleries() ?>
          </div>
  </dialog>