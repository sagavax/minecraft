<?php include "includes/dbconnect.php";
      include "includes/functions.php";
     
      if(isset($_POST['delete_picture'])){
        $picture_id=intval($_POST['picture_id']);
        
        //zistime si z dataazy o aky subor ide
        $base_dir="gallery";
        
        $sql="SELECT picture_name from pictures where picture_id=$picture_id";
        $result=mysqli_query($link, $sql) or die(mysqli_error($link));
        $row = mysqli_fetch_array($result);
        $picture_name=$base_dir."/".$row['picture_name']; //cesta k suboru

        //vymazeme subor z file systemu
        unlink($picture_name);

        //a vymazeme obrazok z databazy
        $sql="DELETE from pictures where picture_id=$picture_id";
        $result=mysqli_query($link, $sql) or die(mysqli_error($link));

        //zapiseme do wallu 
         //databaza na hostingu
      //mistna databaza

        
        $diary_text="Minecraft IS: Bol vymazany obrazok <strong>$picture_name</strong>";
        $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
        $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
        
      
        
       //echo "obrazook bol vymazany";  
       echo "<script>alert('Obrazok id $picture_id bol vymazany')</script>";
       //zobrazime alter
        //echo "<script>alert('');</script>";
      }

    

      if(isset($_POST['add_new_ext_pic'])){
        //var_dump($_POST);
        $image_name = mysqli_real_escape_string($link, $_POST['image_name']);
        $sripped_image_name = strip_tags($image_name);
        $pure_image_name = html_entity_decode($sripped_image_name, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $image_url = mysqli_real_escape_string($link, $_POST['image_url']);
        $image_description = mysqli_real_escape_string($link, $_POST['image_description']);
        
        $add_image="INSERT INTO pictures (picture_title, picture_description, picture_name, picture_path, added_date) VALUES ('$pure_image_name', '$image_description','$image_url','$image_url',now())";
        //echo $add_image;
        $result = mysqli_query($link, $add_image) or die("MySQLi ERROR: ".mysqli_error($link)); 
  
        //get latest id;
        $image_id = mysqli_insert_id($link);
        
        //upated_mods
        $cat_id=0;
        $insert_into_mods = "INSERT INTO pictures_mods (image_id, cat_id, created_date) VALUES ($image_id, $cat_id, now())";
        $result = mysqli_query($link, $insert_into_mods) or die("MySQLi ERROR: ".mysqli_error($link));
        
        //updates modpacks
        $modpack_id=0;
        $insert_into_modpacks = "INSERT INTO pictures_modpacks (image_id, modpack_id, created_date) VALUES ($image_id, $modpack_id,now())";
        $result = mysqli_query($link, $insert_into_modpacks) or die("MySQLi ERROR: ".mysqli_error($link));
        
        //updates tags
        //$insert_into_tags = "INSERT INTO pictures_tags (image_id, tag_id, created_date) VALUES ($image_id, $tag_id, $created_date)";
        //$result = mysqli_query($link, $insert_into_tags) or die("MySQLi ERROR: ".mysqli_error($link));
        
    
        ////vlozim do wallu 
        $diary_text="Minecraft IS: Bol pridany novy obrazok s nazvom <strong>$image_name</strong>";
        $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
        $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
  
        //header("Location: images.php");
        //exit();
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
    <link rel="stylesheet" href="css/message.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <script defer src="js/images.js?<?php echo time(); ?>"></script>
    <script defer src="js/message.js?<?php echo time(); ?>"></script>
     <!-- <script defer src="js/app_event_tracker.js?<?php echo time() ?>"></script> -->
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  </head>

  <body>
  <?php 
    // Include header file
    include("includes/header.php"); 
?>

<div class="main_wrap">
    <div class="tab_menu">
        <?php include("includes/menu.php"); ?>
    </div>
    
    <div class="content">
        <div class="middle_list">

            <!-- Form to add a new image -->
            <div class="add_new_image">
                <form action="" enctype="multipart/form-data" method="post" id="upload_external_image">     
                    <input type="text" name="image_name" placeholder="Picture title" autocomplete="off">
                    <input type="text" name="image_url" placeholder="Image URL" autocomplete="off" id="image_url">
                    <textarea name="image_description" placeholder="Something about..."></textarea>
                    <div class="action">
                        <button type="submit" name="add_new_ext_pic" class="button pull-right">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </form> 
            </div>   

            <!-- Image tags map -->
            <div class="image_tags_map">
                <input type="text" name="search_tag" placeholder="Search a tag" autocomplete="off">
                <?php 
                    $get_videos_tags = "SELECT a.tag_id, b.tag_name FROM video_tags a, tags_list b WHERE a.tag_id NOT IN (0) AND a.tag_id = b.tag_id GROUP BY b.tag_name ORDER BY b.tag_name ASC";
                    $result_tags = mysqli_query($link, $get_videos_tags);
                    while ($row_tags = mysqli_fetch_array($result_tags)) {
                        $tag_id = $row_tags['tag_id'];
                        $tag_name = $row_tags['tag_name'];
                        echo "<button type='button' class='button blue_button small_button' tag-id='{$tag_id}'>{$tag_name}</button>";
                    }
                ?>
            </div>

            <!-- Picture list -->
            <div id="picture_list">
                <?php
                    $itemsPerPage = 10;
                    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $offset = ($current_page - 1) * $itemsPerPage;  

                    $get_all_images = "SELECT * FROM pictures ORDER BY picture_id DESC LIMIT {$itemsPerPage} OFFSET {$offset}";
                    $result = mysqli_query($link, $get_all_images) or die("MySQLi ERROR: " . mysqli_error($link));

                    while ($row = mysqli_fetch_array($result)) {
                        $picture_id = $row['picture_id'];
                        $picture_title = $row['picture_title'];
                        $picture_description = $row['picture_description']; 
                        $picture_path = htmlspecialchars($row['picture_path'], ENT_QUOTES, 'UTF-8');
                        $modpack_name = GetImageModpack($picture_id);

                        echo "<div class='picture' image-id='{$picture_id}'>
                                <div class='picture_name'>{$picture_title}</div>
                                <div class='pic' image-id='{$picture_id}'>
                                    <img src='{$picture_path}'>
                                </div>
                                <div class='picture_footer'>
                                        <div class='picture_action' image-id='{$picture_id}'>
                                        {$modpack_name}
                                        <button name='add_tag' type='button' class='button small_button' title='Add tag'>
                                            <i class='fas fa-tag'></i>
                                        </button>
                                        <button name='add_comment' type='button' class='button small_button' title='Add new comment'>
                                            <i class='fa fa-comment'></i>
                                        </button>
                                        <button name='view_image' type='button' class='button small_button' title='View image'>
                                            <i class='fa fa-eye'></i>
                                        </button>
                                        <button name='delete_image' type='button' class='button small_button' title='Delete picture'>
                                            <i class='fa fa-times'></i>
                                        </button>
                                    </div>
                                </div>
                            </div>";
                    }
                ?>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <?php
                    $count_images = "SELECT COUNT(*) as total FROM pictures";
                    $result = mysqli_query($link, $count_images);
                    $row = mysqli_fetch_array($result);
                    $totalItems = $row['total'];
                    $totalPages = ceil($totalItems / $itemsPerPage);

                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo "<a href='?page={$i}' class='button app_badge'>{$i}</a>";
                    }
                ?>
            </div>
        </div>    
    </div>

    <!-- Modal for changing modpack -->
    <dialog class="modal_change_modpack">
        <div class="inner_change_modpack_layer">
            <button type="button" class="close_inner_modal"><i class="fa fa-times"></i></button>  
            <div class="change_modpack_list">
                <?php
                    $get_modpacks = "SELECT * FROM modpacks ORDER BY modpack_name ASC";
                    $result = mysqli_query($link, $get_modpacks);

                    echo "<button modpack-id='999' class='button small_button'>Unspecified</button>";
                    while ($row = mysqli_fetch_array($result)) {                   
                        $modpack_name = $row['modpack_name'];
                        $modpack_id = $row['modpack_id']; 
                        echo "<button modpack-id='{$modpack_id}' class='button small_button'>{$modpack_name}</button>";
                    }
                ?>
            </div>
        </div>
    </dialog>

    <dialog class="modal_new_tags">
          <div class="inner_layer">
              <button type="button" class="close_inner_modal"><i class="fa fa-times"></i></button>  
              <input type="text" name="tag_name" placeholder="tag name ...." autocomplete="off">
              <div class="video_tags_alphabet">
                <?php 
                        foreach (range('A', 'Z') as $char) {
                          echo "<button type='button' name='letter' class='button small_button'>$char</button>";

                        }
                     ?>  
              </div>
              <div class="tags_list"><?php echo GetAllUnassignedVideosTags()?></div>
              <!-- <div class="loading" style="display: none;">Loading...</div> -->
          </div>
        </dialog>   
</div>
