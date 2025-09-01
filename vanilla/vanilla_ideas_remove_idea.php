<?php include (include "../includes/dbconnect.php");

$idea_id = $_POST['idea_id'];

$remove_idea = "DELETE from vanila_base_ideas WHERE idea_id=$idea_id";
$result = mysqli_query($link,$remove_idea) or die(mysqli_error($link));

$diary_text="Minecraft IS: Idea s id $idea_id bola vymazana";
$create_record="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
$result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));