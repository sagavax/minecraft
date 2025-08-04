<?php

    include ("includes/dbconnect.php");
    include ("includes/functions.php");

    $note_id = $_POST['note_id'];
    $note_title = mysqli_real_escape_string($link, $_POST['note_header']);

    $update_note_title = "UPDATE notes SET note_header = '$note_title' WHERE note_id = $note_id";
    $result = mysqli_query($link, $update_note_title) or die("MySQLi ERROR: " . mysqli_error($link));
?>