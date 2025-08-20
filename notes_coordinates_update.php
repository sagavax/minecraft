<?php

    include("includes/dbconnect.php");
    include("includes/functions.php");


    
    $note_id = $_POST['note_id'];
    $coord_x = $_POST['coord_x'];
    $coord_y = $_POST['coord_y'];
    $coord_z = $_POST['coord_z'];


    $query = "INSERT INTO note_coords (note_id,coord_x,coord_y, coord_z, added_date) VALUES ($note_id,'$coord_x', '$coord_y', '$coord_z',now())";
    $result = mysqli_query($link, $query) or die("MySQLi ERROR: ".mysqli_error($link));

    //add to log
    $diary_text="Koordinaty pre poznamku s id $note_id boli zmenene";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
?>