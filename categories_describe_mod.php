<?php
       include "includes/dbconnect.php";
       include "includes/functions.php";
       
       $mod_id = $_POST['mod_id'];
       $mod_description = mysqli_real_escape_string($link, $_POST['mod_description']);
       $mod_url = mysqli_real_escape_string($link, $_POST['mod_url']);
       $mod_image = mysqli_real_escape_string($link, $_POST['mod_image']);

       // aktualizuje popis kategórie
       $update_description = "UPDATE mods SET cat_description='$mod_description', cat_url='$mod_url', cat_modified=now() WHERE cat_id = $mod_id";
       mysqli_query($link, $update_description) or die(mysqli_error($link));

       // pridá obrázok
       $add_image = "INSERT INTO mod_images (mod_id, image_url, added_date) VALUES ($mod_id, '$mod_image', now())";
       echo $add_image;
       mysqli_query($link, $add_image) or die(mysqli_error($link));

       // aktualizuje denník
       $diary_text = "Minecraft IS: Mod s id $mod_id bol updatovany";
       $update_diary = "INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
       echo $update_diary;
       mysqli_query($link, $update_diary) or die("MySQLi ERROR: " . mysqli_error($link));


