<?php
    include("includes/dbconnect.php");
    include("includes/functions.php");

    $note_id = intval($_POST['note_id']);

    $sql="DELETE FROM game_session_notes WHERE id=$note_id";
    mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

    echo "ok";
?>
