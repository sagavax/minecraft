<?php
       include "includes/dbconnect.php";
       include "includes/functions.php";

       $mod_id = $_POST['mod_id'];

       $mod_url = mysqli_real_escape_string($link, $_POST['mod_url']);

       $update_url = "update mods set cat_url='$mod_url', cat_modified=now() WHERE cat_id=$mod_id";
       mysqli_query($link, $update_url) or die(mysqli_error($link));

       // aktualizuje denník
       $diary_text = "Minecraft IS: Pre mod s id $mod_id: bolo upravene url na $mod_url";
       $update_diary = "INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
       //echo $update_diary;
       mysqli_query($link, $update_diary) or die("MySQLi ERROR: " . mysqli_error($link));