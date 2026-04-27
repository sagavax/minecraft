<?php

    $note_id = $_GET['note_id'];
    $note_text = $_GET['note_text'];

    $query = "UPDATE notes SET note_text = '$note_text' WHERE note_id = '$note_id'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    
    //add wall message
    $message = "Note with ID $note_id has been edited.";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$message',now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
?>