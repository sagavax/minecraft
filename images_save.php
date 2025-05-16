<?php include "includes/dbconnect.php";
      include "includes/functions.php";

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