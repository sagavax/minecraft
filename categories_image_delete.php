<?php

    include("includes/dbconnect.php");
    include("includes/functions.php");  


    $image_id = $_POST['image_id'];


    $delete_image = "DELETE from mod_images WHERE image_id=$image_id";
    $result = mysqli_query($link, $delete_image) or die(mysqli_error($link));


    //add to log
    $diary_text=" Bol vymazany obrazok s ID $image_id";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";   
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));