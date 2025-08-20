<?php

include("includes/dbconnect.php");
include("includes/functions.php");


$base_id+$_POST['base_id'];
 $task_title=mysqli_real_escape_string($link, $_POST['task_title']);
 $task_text=mysqli_real_escape_string($link, $_POST['task_text']);   

 $add_task="INSERT INTO vanila_base_tasks (base_id, task_title, task_text, added_date) VALUES ($base_id,'$task_title',$task_text',now())";
 $result=mysqli_query($link, $add_task);


  $getmax_id = "SELECT max(task_id) as max_id from vanila_base_tasks";
    $result = mysqli_query($link, $getmax_id) or die("MySQLi ERROR: ".mysqli_error($link));
    $row = mysqli_fetch_array($result);   
    $max_id = $row['max_id'];

    echo $max_id;

    $diary_text="Minecraft IS: Bolo vytvoreny base task s id $max_id pre bazu ".GetBanseNameByID($base_id);
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
