<?php

    include("includes/dbconnect.php");
    include("includes/functions.php");


    $base_id = $_POST['base_id'];
    $task_id = $_POST['task_id'];


    $remove_base_task = "DELETE FROM vanilla_base_tasks WHERE base_id=$base_id AND task_id=$task_id";
    $result = mysqli_query($link, $remove_base_task) or die("MySQLi ERROR: ".mysqli_error($link));


    //add to log
    $diary_text=" Base task with id $task_id has been removed from base ".GetbaseNameById($base_id);
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));