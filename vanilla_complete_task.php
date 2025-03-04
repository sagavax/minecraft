<?php include("includes/dbconnect.php");
      include ("includes/functions.php");


      $task_id = $_GET["task_id"];
      
      $update_task="UPDATE vanila_base_tasks SET is_completed=1 WHERE task_id = $task_id";
      $result = mysqli_query($link, $update_task) or die("MySQLi ERROR: ".mysqli_error($link));
      echo "<script>alert('Task has been marked as completed');</script>";