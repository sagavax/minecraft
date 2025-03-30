<?php

    include "includes/dbconnect.php";
    include "includes/functions.php";

    $modpack_id = $_POST['modpack_id'];
    $note_id = $_POST['note_id'];

    $update_modpack_name = "UPDATE notes SET modpack_name = '$modpack_name' WHERE note_id = $note_id";
    $result = mysqli_query($link, $update_modpack_name) or die("MySQLi ERROR: ".mysqli_error($link));


    //add to log
    $diary_text="Minecraft IS: Poznamka s id <strong>$note_id</strong> bola upravena";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));