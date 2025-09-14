<?php

   include "includes/dbconnect.php";
   include "includes/functions.php";

   $url = mysqli_real_escape_string($link, $_POST['modpack_url']);
   $modpack_id = $_POST['modpack_id'];

   $update_modpack_link = "UPDATE modpacks set modpack_url='$url' where modpack_id=$modpack_id";
   $result = mysqli_query($link, $update_modpack_link) or die(mysqli_error($link)); 

   //add a log entry
   $action = "Modpack URL updated to $url";
   $sql = "INSERT INTO app_log (diary_text, date_added) VALUES ('$action',now())";
   $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
