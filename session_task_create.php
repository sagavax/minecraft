<?php
    include("includes/dbconnect.php");
    include("includes/functions.php");

    $session_id = intval($_POST['session_id']);
    $task_text = mysqli_real_escape_string($link, $_POST['task_text']);
    $priorita = mysqli_real_escape_string($link, $_POST['priorita']);

    $sql="INSERT INTO game_session_tasks (session_id, task_text, priorita, status, created_at) VALUES ($session_id, '$task_text', '$priorita', 'open', now())";
    mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

    echo mysqli_insert_id($link);
?>
