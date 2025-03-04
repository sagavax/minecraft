<?php include("includes/dbconnect.php");

$task_id = $_POST['task_id'];

$complete_task = "UPDATE vanila_base_tasks SET is_completed=1 WHERE task_id=$task_id";
$result=mysqli_query($link, $complete_task);

$diary_text="Minecraft IS: Bolo bol uspesne zakoceny task s id $task_id";
$sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
