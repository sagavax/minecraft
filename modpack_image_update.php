<?php

    include("includes/dbconnect.php");
    include ("includes/functions.php");


    $modpack_id = $_POST['modpack_id'];
    $image_url = mysqli_real_escape_string($link, $_POST['modpack_image']);



    $update_image = "UPDATE modpacks SET modpack_image='$image_url' WHERE modpack_id=$modpack_id";
    $result = mysqli_query($link, $update_image) or die("MySQLi ERROR: ".mysqli_error($link));

    //add to log
    $diary_text="Bol zmeneny obrazok modpacku s id $modpack_id";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));