<?php include "includes/dbconnect.php";
      include "includes/functions.php";


$task_id = $_POST['task_id'];

$task_completed = "UPDATE tasks SET is_completed=1 where task_id=$task_id";
$result=mysqli_query($link, $task_completed) or die("MySQLi ERROR: ".mysqli_error($link));


//add to log
$diary_text="Minecraft IS: Task with id $task_id has been completed!";
$sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));