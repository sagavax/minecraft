<?php
include("includes/dbconnect.php");
    //var_dump($_POST);
    $task_text =mysqli_real_escape_string($link,$_POST['task_text']);
     $zakladna_id = $_POST['base_id'];
    $sql="INSERT INTO vanila_base_tasks (zakladna_id, task_text,added_date) VALUES ($zakladna_id, '$task_text',now())";
    $result=mysqli_query($link,$sql) or die("MySQL ERROR: ".mysqli_error($link));

     $getmax_id = "SELECT max(task_id) as max_id from vanila_base_tasks";
    $result = mysqli_query($link, $getmax_id) or die("MySQLi ERROR: ".mysqli_error($link));
    $row = mysqli_fetch_array($result);   
    $max_id = $row['max_id'];

    echo $max_id;