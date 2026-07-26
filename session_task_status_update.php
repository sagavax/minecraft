<?php
    include("includes/dbconnect.php");
    include("includes/functions.php");

    $task_id = intval($_POST['task_id']);
    $status = mysqli_real_escape_string($link, $_POST['status']);

    $sql="UPDATE game_session_tasks SET status='$status' WHERE task_id=$task_id";
    mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

    echo "ok";
?>
