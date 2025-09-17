<?php

    include "includes/dbconnect.php";
    include "includes/functions.php";

    $modpack_id = $_POST['modpack_id'];
    $note_id = $_POST['note_id'];
    $modpack_name = mysqli_real_escape_string($link, $_POST['modpack_name']);

    //check if modpack for this note exists
    $check_modpack = "SELECT * FROM notes_modpacks WHERE note_id = $note_id";
    $result = mysqli_query($link, $check_modpack) or die("MySQLi ERROR: ".mysqli_error($link));
    $num_rows = mysqli_num_rows($result);
    //update existing
    if ($num_rows > 0) {
        $update_modpack = "UPDATE notes_modpacks SET modpack_id = '$modpack_id' WHERE note_id = $note_id";
        $result = mysqli_query($link, $update_modpack) or die("MySQLi ERROR: ".mysqli_error($link));
    } else {
        //insert new
        $update_modpack = "INSERT INTO notes_modpacks (note_id, modpack_id, added_date) VALUES ($note_id, $modpack_id, NOW())";
        $result = mysqli_query($link, $update_modpack) or die("MySQLi ERROR: ".mysqli_error($link));
    }

    $update_modpack = "INSERT INTO notes_modpacks (note_id, modpack_id,added_date) VALUES ($note_id, $modpack_id, NOW())";
    //$update_modpack = "UPDATE notes_ SET modpack_id = '$modpack_id' WHERE note_id = $note_id";
    $result = mysqli_query($link, $update_modpack) or die("MySQLi ERROR: ".mysqli_error($link));


    //add to log
    $diary_text="Poznamka s id <strong>$note_id</strong> bola upravena: novy modpack je <strong>$modpack_name</strong>";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));