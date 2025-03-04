<?php include("includes/dbconnect.php");

$note_id = $_POST['note_id'];

$remove_note = "DELETE from vanila_base_notes WHERE note_id=$note_id";
$result=mysqli_query($link, $remove_note);

$diary_text="Minecraft IS: Bolo vymazana base poznamka s id $note_id";
$sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));