<?php
    include("includes/dbconnect.php");
    include("includes/functions.php");


    $note_id = $_POST['note_id'];


    $remove_coordinates = "DELETE from notes_coordinates where note_id=$note_id";
    $result = mysqli_query($link, $remove_coordinates) or die("MySQLi ERROR: ".mysqli_error($link));


    //add to log
    $diary_text="Koordinaty pre poznamku s id $note_id boli vymazane";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));