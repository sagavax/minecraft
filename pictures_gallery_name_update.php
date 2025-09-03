<?php

    include("includes/dbconnect.php");
    include("includes/functions.php");

    $gallery_id = $_POST['gallery_id'];
    $new_gallery_name = mysqli_real_escape_string($link, $_POST['new_gallery_name']); //$_POST['new_gallery_name'];

    $change_gallery_name = "UPDATE gallery SET gallery_name = '$new_gallery_name' WHERE gallery_id = $gallery_id";
    $result = mysqli_query($link, $change_gallery_name) or die("MySQLi ERROR: " . mysqli_error($link));

    //add to log
    $diary_text="Bola zmenena galeria na $new_gallery_name";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
?>