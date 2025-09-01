<?php
    include("includes/dbconnect.php");
    include("includes/functions.php");

    $link_name = mysqli_real_escape_string($link, $_POST['link_name']);
    $link_id = $_POST['link_id'];


    $change_link_name = "UPDATE modpack_mods_links SET link_name = '$link_name' WHERE link_id = $link_id";
    $result = mysqli_query($link, $change_link_name) or die("MySQLi ERROR: ".mysqli_error($link));


    //add to log
    $diary_text="ink name with id $link_id has been changed to $link_name!";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

?>


