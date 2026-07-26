<?php
    include("includes/dbconnect.php");
    include("includes/functions.php");

    $session_id = intval($_POST['session_id']);

    $sql="DELETE FROM game_session_notes WHERE session_id=$session_id";
    mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

    $sql="DELETE FROM game_session_tasks WHERE session_id=$session_id";
    mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

    $sql="DELETE FROM game_sessions_bases WHERE session_id=$session_id";
    mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

    $sql="DELETE FROM game_sessions WHERE id=$session_id";
    mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

    $diary_text="Minecraft IS: Bola vymazana game session s id <strong>$session_id</strong>";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

    echo "ok";
?>
