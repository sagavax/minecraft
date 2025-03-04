<?php
       include "includes/dbconnect.php";
       include "includes/functions.php";
       
       $mod_id = $_POST['mod_id'];

       $remove_mod = "DELETE from mods WHERE cat_id=$mod_id";
       $result=mysqli_query($link, $update_description) or die(mysqli_error(($link)));

       $diary_text="Minecraft IS: Mod s id $mod_id bol vymazany";";
       $update_diary="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
       $result = mysqli_query($link, $update_diary) or die("MySQLi ERROR: ".mysqli_error($link));