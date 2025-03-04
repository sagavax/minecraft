<?php
       include "includes/dbconnect.php";
       include "includes/functions.php";

       $mod_id = $_POST['mod_id'];

       $mod_name = mysqli_real_escape_string($link, $_POST['mod_name']);

       $update_mod_name = "update mods set cat_name='$mod_name', cat_modified=now() WHERE cat_id=$mod_id";
       mysqli_query($link, $update_mod_name) or die(mysqli_error($link));

       // aktualizuje denník
       $diary_text = "Minecraft IS: Pre mod s id $mod_id: bolo upravene meno modu na $mod_name";
       $update_diary = "INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
       //echo $update_diary;
       mysqli_query($link, $update_diary) or die("MySQLi ERROR: " . mysqli_error($link));