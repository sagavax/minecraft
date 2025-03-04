<?php include("includes/dbconnect.php");

$idea_id = $_POST['idea_id'];

$remove_idea = "DELETE from vanila_base_ideas WHERE idea_id=$idea_id";
$result=mysqli_query($link, $remove_idea);

$diary_text="Minecraft IS: Bolo vymazana base idea s id $idea_id";
$sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));