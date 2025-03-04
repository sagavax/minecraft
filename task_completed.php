<?php include "includes/dbconnect.php";
      include "includes/functions.php";


$task_id = $_POST['task_id'];

$task_completed = "UPDATE to_do SET is_completed=1 where task_id=$task_id";
$result=mysqli_query($link, $task_completed) or die("MySQLi ERROR: ".mysqli_error($link));