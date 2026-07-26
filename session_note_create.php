<?php
    include("includes/dbconnect.php");
    include("includes/functions.php");

    $session_id = intval($_POST['session_id']);
    $note_header = mysqli_real_escape_string($link, $_POST['note_header']);
    $note_text = mysqli_real_escape_string($link, $_POST['note_text']);

    $sql="INSERT INTO game_session_notes (session_id, note_header, note_text, created_at) VALUES ($session_id, '$note_header', '$note_text', now())";
    mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

    echo mysqli_insert_id($link);
?>
