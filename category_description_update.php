<?php
       include "includes/dbconnect.php";
       include "includes/functions.php";

       $mod_id = $_POST['mod_id'];

       $mod_description = mysqli_real_escape_string($link, $_POST['mod_description']);

       $update_description = "update mods set cat_description='$mod_description', cat_modified=now() WHERE cat_id=$mod_id";
       mysqli_query($link, $update_description) or die(mysqli_error($link));

       // aktualizuje denník
       $diary_text = "Minecraft IS: Pre mod s id $mod_id: bola upravena poznamka";
       $update_diary = "INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
       //echo $update_diary;
       mysqli_query($link, $update_diary) or die("MySQLi ERROR: " . mysqli_error($link));