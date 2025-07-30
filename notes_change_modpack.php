<?php

    include "includes/dbconnect.php";
    include "includes/functions.php";

    $modpack_id = $_POST['modpack_id'];
    $note_id = $_POST['note_id'];
    $modpack_name = mysqli_real_escape_string($link, $_POST['modpack_name']);

    $update_modpack_name = "UPDATE notes SET modpack_id = '$modpack_id' WHERE note_id = $note_id";
    $result = mysqli_query($link, $update_modpack_name) or die("MySQLi ERROR: ".mysqli_error($link));


    //add to log
    $diary_text="Poznamka s id <strong>$note_id</strong> bola upravena: novy modpack je <strong>$modpack_name</strong>";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));