<?php
    include("includes/dbconnect.php");
    include("includes/functions.php");

    $task_id = intval($_POST['task_id']);

    $sql="DELETE FROM game_session_tasks WHERE task_id=$task_id";
    mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

    echo "ok";
?>
