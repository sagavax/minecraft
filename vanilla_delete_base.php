<?php 

include("includes/dbconnect.php");

//delete all notes regarding the base
$base_id = $_POST['base_id'];
$delete_notes = "DELETE from vanila_base_notes WHERE base_id = $base_id";
$result = mysqli_query($link, $delete_notes) or die("MySQLi ERROR: " . mysqli_error($link));

//delete base infor
$delete_base = "DELETE from vanila_suradnice WHERE base_id = $base_id";
$result = mysqli_query($link, $delete_base) or die("MySQLi ERROR: " . mysqli_error($link));

 $diary_text="Zakladna s id <b>$base_id</n> bola vymazana";
 $create_record="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
 $result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));