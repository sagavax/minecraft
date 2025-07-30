<?php

    include("includes/dbconnect.php");
    include("includes/functions.php");

    $task_id = $_POST['task_id'];
    $task_text = mysqli_real_escape_string($link, $_POST['task_text']); //$_POST["task_text"];

    $update_task = "UPDATE tasks SET task_text = '$task_text' WHERE task_id = $task_id";
    $result = mysqli_query($link, $update_task) or die("MySQLi ERROR: ".mysqli_error($link));