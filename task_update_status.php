<?php

      include "includes/dbconnect.php";
      include "includes/functions.php";


      $task_id = intval($_POST['task_id']); //$_POST['task_id'];
      $status = mysqli_real_escape_string($link, $_POST['status']); //$_POST['status'];

      $update_task_status = "UPDATE tasks SET task_status='$status' WHERE task_id=$task_id"; 
      $result=mysqli_query($link, $update_task_status) or die("MySQLi ERROR: ".mysqli_error($link));

      //add log
     $diary_text="Ulohe s id $task_id bol upraveny status na $status";
     $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
     $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

      ?>