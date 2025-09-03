<?php
    include "includes/dbconnect.php";
    include "includes/functions.php";

    $gallery_id = $_POST['gallery_id'];
    $delete_gallery="DELETE from picture_galleries WHERE gallery_id=$gallery_id";
    $result=mysqli_query($link, $delete_gallery) or die("MySQLi ERROR: ".mysqli_error($link));


    //add to log
    $diary_text="Bola odstranena gallery s ID $gallery_id";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
?>

