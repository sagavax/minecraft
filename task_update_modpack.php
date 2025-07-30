<?php

    include("includes/dbconnect.php");
    include("includes/functions.php");


    $task_id = $_POST["task_id"];
    $modpack_id = $_POST["modpack_id"];

    $update_task_for_modpack = "UPDATE tasks SET modpack_id=$modpack_id WHERE task_id=$task_id";
    $result = mysqli_query($link, $update_task_for_modpack) or die("MySQLi ERROR: ".mysqli_error($link));