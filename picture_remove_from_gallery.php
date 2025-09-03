<?php

        include "includes/dbconnect.php";
        include "includes/functions.php";


        $image_id = $_POST['image_id'];

        $remove_from_gallery = "DELETE FROM pictures_gallery_images WHERE picture_id=$image_id";
        $result = mysqli_query($link, $remove_from_gallery) or die(mysqli_error($link));

        //add to log
        $diary_text="Bol odstraneny obrazok s ID $image_id z gallerie";
        $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";   
        $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

