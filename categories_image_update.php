<?php
       include "includes/dbconnect.php";
       include "includes/functions.php";

       $mod_id = $_POST['mod_id'];

       $image_url = mysqli_real_escape_string($link, $_POST['image_url']);
       $image_title = mysqli_real_escape_string($link, $_POST['image_title']);


       $add_image = "INSERT INTO mod_images (mod_id, image_title, image_url, added_date) VALUES ($mod_id, '$image_title','$image_url', now())";
       mysqli_query($link, $add_image) or die(mysqli_error($link));

       // aktualizuje denník
       $diary_text = "Minecraft IS: Mod s id $mod_id: bol pridany obrazok";
       $update_diary = "INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
       //echo $update_diary;
       mysqli_query($link, $update_diary) or die("MySQLi ERROR: " . mysqli_error($link));